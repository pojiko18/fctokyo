<?php
session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$e_id =$_GET["id"];
$u_id =$_SESSION["id"];


//DB接続
$pdo = dbcon();


// イベントidの取得
$sql = "SELECT * FROM event WHERE e_id=:e_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':e_id', $e_id, PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  //１データのみ抽出の場合はwhileループで取り出さない
  $row = $stmt->fetch();
}

//◆参加したイベントとイベント詳細をJOINさせて取得
$sql_e = "SELECT * FROM event_list LEFT JOIN event ON event_list.event_id = event.e_id WHERE user_id=:u_id AND e_id=:e_id ";

$stmt_e = $pdo->prepare($sql_e);
$stmt_e->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$stmt_e->bindValue(':e_id', $e_id, PDO::PARAM_INT);
$status_e = $stmt_e->execute();

//データ表示
if($status_e==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_e = $stmt_e->errorInfo();
  exit("ErrorQuery:".$error_e[2]);

} else {
  $row_e = $stmt_e->fetch();
}

//◆参加したイベントとユーザー詳細をJOINさせて取得
$sql_sanka = "SELECT * FROM event_list LEFT JOIN users ON event_list.user_id = users.user_id WHERE event_id=:e_id ";

$stmt_sanka = $pdo->prepare($sql_sanka);
$stmt_sanka->bindValue(':e_id', $e_id, PDO::PARAM_INT);
$status_sanka = $stmt_sanka->execute();

//データ表示
$sanka_event="";
$sanka_count =0;

if($status_sanka ==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_sanka = $stmt_sanka->errorInfo();
  exit("ErrorQuery:".$error_sanka[2]);

} else {
  while( $sanka = $stmt_sanka->fetch(PDO::FETCH_ASSOC)){ 
      // $sanka_event .= $sanka["user_name"].'<br>';←これで名前取ってこれる
      if($u_id != $sanka["user_id"]){
      $sanka_event .= '<a href="./user_page.php?id='.$sanka["user_id"].'">'.$sanka["user_name"].'</a><br>';
      }else{
      $sanka_event .= $sanka["user_name"].'<br>';
      }

      // 人数カウント
      $sanka_count +=  1;
  }
}


//◆bbsとユーザー詳細をJOINさせて取得
$sql_bbs = "SELECT * FROM event_bbs LEFT JOIN users ON event_bbs.user_id = users.user_id WHERE event_id=:e_id ";

$stmt_bbs = $pdo->prepare($sql_bbs);
$stmt_bbs->bindValue(':e_id', $e_id, PDO::PARAM_INT);
$status_bbs = $stmt_bbs->execute();

//データ表示
$bbs_view = "";

if($status_bbs ==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_bbs = $stmt_bbs->errorInfo();
  exit("ErrorQuery:".$error_bbs[2]);

} else {
  while( $bbs = $stmt_bbs->fetch(PDO::FETCH_ASSOC)){ 
    $bbs_view .= '<div><img src="upload/'.$bbs["img"].'" width="100"></div>';
    $bbs_view .= '<a href="./user_page.php?id='.$bbs["user_id"].'">'.$bbs["user_name"].'</a>:';
    $bbs_view .= $bbs["comment"].'<br>';
    $bbs_view .= $bbs["time"].'</div>';

  }
}



?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>イベント詳細ページ</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <link rel="stylesheet" href="css/range.css">
  
  <!-- <link href="./css/main.css" rel="stylesheet"> -->
  <link href="./css/select.css" rel="stylesheet">
  <link href="./css/login.css" rel="stylesheet">
  <link href="./css/style_sp.css" rel="stylesheet">
  <!-- モーダル用 ↓↓↓-->
<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">


<body id="main">
<!-- Head[Start] -->
<?php
include("l_header.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
    <!-- ポップアップ
    <div class="popup" id="js-popup">
      <div class="popup-inner">
        <div class="close-btn" id="js-close-btn"><i class="fas fa-times"></i></div>
        <a href="#"><img src="./upload/20210320064558b7d5b9411bdddf35e9f01edc9eb941d5.jpg" alt="ポップアップ画像"></a>
      </div>
      <div class="black-background" id="js-black-bg"></div>
    </div> 
  参照：https://tech-dig.jp/js-modal/
  -->
<!-- 日程入れる -->
<section>

  <h2><?=$row["title"]?></h2>
  <h3>詳細</h3>
  <p><?=$row["year"]?>年<?=$row["month"]?>月<?=$row["day"]?>日</p>
  <p><?=$row["time"]?></p>
  <p><?=$row["place"]?></p>
  <p><?=$row["contents"]?></p>


</section>


<section>
<!-- 合言葉入れるところ -->
      <?php if($row_e == true){ ?>
          <div>チェックイン済みです</div>
          
      <?php }else{ ?>
        <form method="post" action="aikotoba_act.php"  class="form">
        <dl class="form-inner">
            <dt class="form-title">合言葉</dt>
            <dd class="form-item"><input type="text" name="aikotoba"></dd>
            <input type="hidden" name="e_id" value="<?=$row["e_id"]?>">
            <input type="hidden" name="u_id" value="<?=$u_id?>">
            <input type="hidden" name="point" value="<?=$row["point"]?>">
        </dl>
        <p class="btn-c">
            <input type="submit" value="送信する" class="btn" id="js-show-popup">
        </p>
      </form>
      <?php } ?>


</section>

<!-- 人数と名前表示 -->
<section>
<h3>参加者一覧</h3>
<div>参加数：<?=$sanka_count?></div>
<div>参加者：<?=$sanka_event?></div>
</section>

<!-- 時間あればチャット入れる -->
<section>
  <h3 id="bbs">メッセージ</h3>
  <form method="post" action="bbs.php"  class="form">
    <textarea name="bbs" rows="3" placeholder="メッセージを入力"></textarea>
    <input type="hidden" name="e_id" value="<?=$row["e_id"]?>">
    <input type="hidden" name="u_id" value="<?=$u_id?>">
    <div class="submit">
      <input type="submit" value="送信">
    </div>
  </form>

  <div><?=$bbs_view?></div>
</section>





<!-- Main[End] -->
<?php
include("y_footer.php");
?>





</body>
</html>
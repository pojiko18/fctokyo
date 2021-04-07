<?php
session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$id =$_GET["id"];
$o_id =$_SESSION["id"];

//DB接続
$pdo = dbcon();


// ◆イベント情報の取得
$sql = "SELECT * FROM event WHERE e_id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
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
$sql_e = "SELECT * FROM event_list LEFT JOIN event ON event_list.event_id = event.e_id WHERE e_id=:e_id ";

$stmt_e = $pdo->prepare($sql_e);
$stmt_e->bindValue(':e_id', $id, PDO::PARAM_INT);
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
$stmt_sanka->bindValue(':e_id', $id, PDO::PARAM_INT);
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
      $sanka_event .= '<a href="./user_page.php?id='.$sanka["user_id"].'">'.$sanka["user_name"].'</a><br>';      

      // 人数カウント
      $sanka_count +=  1;
  }
}

//◆bbsとユーザー詳細をJOINさせて取得
$sql_bbs = "SELECT * FROM event_bbs LEFT JOIN users ON event_bbs.user_id = users.user_id WHERE event_id=:e_id ";

$stmt_bbs = $pdo->prepare($sql_bbs);
$stmt_bbs->bindValue(':e_id', $id, PDO::PARAM_INT);
$status_bbs = $stmt_bbs->execute();

//データ表示
$bbs_view = "";

if($status_bbs ==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_bbs = $stmt_bbs->errorInfo();
  exit("ErrorQuery:".$error_bbs[2]);

} else {
  while( $bbs = $stmt_bbs->fetch(PDO::FETCH_ASSOC)){ 
    
    $bbs_view .= '<li class="media mb-4"><img src="upload/'.$bbs["img"].'" width="100">';
    $bbs_view .= '<div class="media-body"><a href="./user_page.php?id='.$bbs["user_id"].'">'.$bbs["user_name"].'</a>:';
    $bbs_view .= $bbs["comment"].'<br>';
    $bbs_view .= $bbs["time"].'</div></li>';

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
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="./css/index.css" rel="stylesheet">
  <link href="./css/select.css" rel="stylesheet">
  <link href="./css/login.css" rel="stylesheet">
  <link href="./css/style_sp.css" rel="stylesheet">

</head>
<body id="main">
<!-- Head[Start] -->
<?php
include("l_header.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->

<!-- 日程入れる -->
<section>
  <div><?php if($row["img"]==NULL|| $row["img"]== 1|| $row["img"]== 2){ ?> 
            <div><img src="./upload/noimg.png" alt="" width="300"></div>
            <?php }else{?> 
            <div><img src="upload/<?=$row["img"]?>" width="300" name="upfile"></div>
            <?php } ?></div>
  <h3><?=$row["title"]?></h3>
  <p><?=$row["year"]?>年<?=$row["month"]?>月<?=$row["day"]?>日</p>
  <p><?=$row["time"]?></p>
  <p><?=$row["place"]?></p>
  <p><?=$row["contents"]?></p>


</section>


<!-- 人数と名前表示 -->
<section>
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

  <ul class="list-unstyled"><?=$bbs_view?></ul>
</section>






<!-- Main[End] -->
<?php
include("footer.php");
?>



</body>
</html>
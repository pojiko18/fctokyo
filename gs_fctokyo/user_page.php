<?php
session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$u_id='';
  if (isset($_GET['id'])) {
    $u_id=(int)$_GET['id'];
  }


//DB接続
$pdo = dbcon();

//◆ユーザー情報の取得
$sql = "SELECT * FROM users WHERE user_id=:u_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
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
$sql_e = "SELECT * FROM event_list LEFT JOIN event ON event_list.event_id = event.e_id WHERE user_id=:u_id ";

$stmt_e = $pdo->prepare($sql_e);
$stmt_e->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$status_e = $stmt_e->execute();

//データ表示
$view_event="";
$point_count=0;

if($status_e==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_e = $stmt_e->errorInfo();
  exit("ErrorQuery:".$error_e[2]);

} else {
  // var_dump($stmt_e);
    while( $res_eventlist = $stmt_e->fetch(PDO::FETCH_ASSOC)){ 
      $view_event .= '<div class="box"><a href="y_event_detail.php?id='.$res_eventlist["e_id"].'" target="_blank" rel="noopener noreferrer"><button>';
      $view_event .= '<h3>'.$res_eventlist["title"].'</h3>';
      $view_event .= '<p>'.$res_eventlist["year"].'年'.$res_eventlist["month"].'月'.$res_eventlist["day"].'日</p>';
      $view_event .= '<p>＞詳細</p>';
      $view_event .= '</button></a></div>';

      $point_count +=  $res_eventlist["point"];
  }
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ユーザーページ</title>
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

<!-- 自己紹介 -->
<section>
<div><?=$row["user_name"]?>さん</div>
<div><img src="upload/<?=$row["img"]?>" width="100"></div>



<div>獲得ポイント数：<?=$point_count?></div>
<h2>自己紹介文</h2>
<div>生年月日　：<?=$row["year"]?>年<?=$row["month"]?>月<?=$row["day"]?>日</div>
<div>居住地　　：<?=$row["address"]?></div>
<div>自己紹介　：<?=$row["text"]?></div>
</section>

<!-- イベント履歴 -->
<section>
<h2>イベント参加履歴</h2>
<div><?=$view_event?></div>

</section>


<!-- Main[End] -->
<?php
include("y_footer.php");
?>
</body>
</html>

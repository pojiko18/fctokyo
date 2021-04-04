<?php
session_start();
include("./funcs.php");
loginCheck();

$pdo = dbcon();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM event  ORDER BY e_id DESC");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
  

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<div class="box"><a href="event_detail.php?id='.$res["e_id"].'" target="_blank" rel="noopener noreferrer"><button>';
    $view .= '<img src="upload/'.$res["img"].'" width="300">';
    $view .= '<h3>'.$res["title"].'</h3>';
    $view .= '<p>'.$res["year"].'年'.$res["month"].'月'.$res["day"].'日</p>';
    $view .= '<p>＞詳細</p>';
    $view .= '</button></a></div>';
    
  }

}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>イベント一覧</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <link rel="stylesheet" href="css/range.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- <link href="css/index.css" rel="stylesheet"> -->
  <link href="./css/select.css" rel="stylesheet">
  <link href="./css/login.css" rel="stylesheet">
  <link href="./css/style_sp.css" rel="stylesheet">
</head>
<body class="main">
    
<!-- Head[Start] -->
<?php
include("l_header.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
<h2>イベント一覧</h2>
<div><?=$view?></div>
<!-- Main[End] -->
<?php
include("footer.php");
?>
</body>
</html>

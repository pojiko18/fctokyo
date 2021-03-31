<?php 

session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$id =$_SESSION["id"];

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
    $view .= '<div class="box"><a href="y_event_detail.php?id='.$res["e_id"].'" target="_blank" rel="noopener noreferrer"><button>';
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
    <meta charset="UTF-8">
    <title>ログイン後のページ</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="./css/login.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="./css/style_sp.css" rel="stylesheet">
    
</head>
<body>

<!-- Head[Start] -->

<?php
include("l_header.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
<p>ユーザーのイベント一覧ページ</p>
<div><?=$view?></div>

<br>
<?php
include("y_footer.php");
?>
</body>
</html>






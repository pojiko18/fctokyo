<?php 

session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$id =$_SESSION["id"];

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
<a href="./logout.php">ログアウト</a>
</body>
</html>






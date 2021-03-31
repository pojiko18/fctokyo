<?php
session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得

$e_id =$_SESSION["id"];

//DB接続
$pdo = dbcon();

//２．データ登録SQL作成
$sql = "SELECT * FROM event WHERE  e_id=:e_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':e_id', $e_id);
$res = $stmt->execute();

// //SQL実行時にエラーがある場合
if($res==false){
  $error = $stmt->errorInfo();
  return("QueryError:".$error[2]);
}else {
  $row = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>チェックイン完了</title>
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



<h2>チェックイン完了しました</h2>

<div>
    <button>コインを受け取る</button>
</div>
<a href="y_event_detail.php?id="<?=$row["e_id"]?>">イベントページに戻る</a>

<!-- Main[End] -->
<?php
include("y_footer.php");
?>
</body>
</html>

<?php 

session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$id =$_SESSION["id"];

//DB接続
$pdo = dbcon();

//ユーザー情報の取得
$sql = "SELECT * FROM owner WHERE o_id=:id";
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


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ダッシュボード</title>
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

<div><?=$row["o_name"]?>さん、こんにちは</div><br>
<a href="./event.php" target="_blank" rel="noopener noreferrer"><button>イベント作成</button></a>
<a href="./event_list.php" target="_blank" rel="noopener noreferrer"><button>イベント一覧</button></a>
<a href="./owner_reg.php" target="_blank" rel="noopener noreferrer"><button>スタッフ登録</button></a>





<?php
include("footer.php");
?>
</body>
</html>






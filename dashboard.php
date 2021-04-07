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

<?php
$title = "ダッシュボード";
include("include/header_owner.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="container">
    <div class="card form-register mt-5">
        <div class="card-header">
            <h3 class="h3 font-weight-normal text-center"><?=$row["o_name"]?>さん、こんにちは</h3>
        </div>
        <div class="card-body">
          <ul class="list-unstyled">
            <li class="mb-3"><a href="./event.php" rel="noopener noreferrer" class="btn btn-primary btn-block">イベント作成</a></li>
            <li class="mb-3"><a href="./event_list.php" rel="noopener noreferrer" class="btn btn-primary btn-block">イベント一覧</a></li>
            <li class="mb-3"><a href="./owner_reg.php" rel="noopener noreferrer" class="btn btn-primary btn-block">スタッフ登録</a></li>
          </ul>
        </div>
    </div>
</div>
<?php
include("include/footer_owner.php");
?>





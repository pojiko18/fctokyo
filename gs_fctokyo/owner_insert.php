<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST["name"]) || $_POST["name"]=="" ||
  !isset($_POST["lid"]) || $_POST["lid"]=="" ||
  !isset($_POST["lpw"]) || $_POST["lpw"]=="" 
  // !isset($_POST["image"]) || $_POST["image"]==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$name = $_POST["name"];
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];





//2. DB接続します(エラー処理追加)
include("funcs.php");
$pdo = dbcon();


//３．データ登録SQL作成
$sql = "INSERT INTO owner(o_id, o_name,  o_pass,o_flg, indate )
VALUES(NULL, :o_name,  :o_pass, 0, sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':o_name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':o_pass', $lid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)


$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  //５．login.phpへリダイレクト
  header("Location: owner_login.php"); //半角スペースを入れる
  exit;

}
?>
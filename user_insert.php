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
$icon = "kaonasi-icon.JPG";




//2. DB接続します(エラー処理追加)
include("funcs.php");
$pdo = dbcon();


//３．データ登録SQL作成
$sql = "INSERT INTO users(user_id, user_name, email, pass,year,month,day,address, img,text,life_flg, indate )
VALUES(NULL, :user_name, :email, :pass,NULL,NULL,NULL,NULL,:img,NULL ,0, sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email', $lid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pass', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':img', $icon, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  //５．login.phpへリダイレクト
  header("Location: login.php"); //半角スペースを入れる
  exit;

}
?>
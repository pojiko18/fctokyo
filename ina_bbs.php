<?php
session_start();

$id =$_POST["id"];
$u_id =$_POST["u_id"];


$bbs =$_POST["bbs"];

// 1. 接続します
include("funcs.php");
$pdo = dbcon();

//蝗活情報
$sql = "SELECT * FROM inakatsu WHERE  id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id);
$res = $stmt->execute();

// //SQL実行時にエラーがある場合
if($res==false){
  $error = $stmt->errorInfo();
  return("QueryError:".$error[2]);
}else {
  $row = $stmt->fetch();
}



//BBSのデータ登録SQL作成
$sql_bbs = "INSERT INTO ina_bbs(ina_id,user_id, comment,  indate,del_flg )
VALUES( :ina_id, :user_id, :comment, sysdate(),1)";
$stmt_bbs = $pdo->prepare($sql_bbs);
$stmt_bbs->bindValue(':ina_id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt_bbs->bindValue(':user_id', $u_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt_bbs->bindValue(':comment', $bbs, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status_bbs = $stmt_bbs->execute();

//４．データ登録処理後
if($status_bbs==false){
  $error = $stmt_bbs->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  header("Location: inakatsu_detail.php?id=".$row["id"]."#bbs");
}

?>
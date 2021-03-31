<?php
session_start();

$e_id =$_POST["e_id"];
$u_id =$_POST["u_id"];


$bbs =$_POST["bbs"];

// 1. 接続します
include("funcs.php");
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



//BBSのデータ登録SQL作成
$sql_bbs = "INSERT INTO event_bbs(event_id,user_id, comment,  time,del_flg )
VALUES( :event_id, :user_id, :comment, sysdate(),1)";
$stmt_bbs = $pdo->prepare($sql_bbs);
$stmt_bbs->bindValue(':event_id', $e_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt_bbs->bindValue(':user_id', $u_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt_bbs->bindValue(':comment', $bbs, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status_bbs = $stmt_bbs->execute();

//４．データ登録処理後
if($status_bbs==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  header("Location: y_event_detail.php?id=".$row["e_id"]."#bbs");
}

?>


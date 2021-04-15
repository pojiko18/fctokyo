<?php
session_start();

$e_id =$_POST["e_id"];
$u_id =$_POST["u_id"];
$point =$_POST["point"];
$team =$_POST["team"];


// 1. 接続します
include("funcs.php");
$pdo = dbcon();


// イベント情報を取得する
$sql_event = "SELECT * FROM event WHERE  e_id=:e_id";
$stmt_event = $pdo->prepare($sql_event);
$stmt_event->bindValue(':e_id', $e_id);
$res_event = $stmt_event->execute();

// //SQL実行時にエラーがある場合
if($res_event==false){
  $error = $stmt_event->errorInfo();
  return("QueryError:".$error[2]);
}else {
  $row_event = $stmt_event->fetch();
}




$sql="INSERT INTO event_list(user_id, event_id,team_id,point,indate)
VALUES(:user_id,:event_id,:team,:point, sysdate())" ; 
$stmt=$pdo->prepare($sql);
$stmt -> bindValue(':user_id', $u_id, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
$stmt -> bindValue(':event_id', $e_id, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
$stmt -> bindValue(':team', $team, PDO::PARAM_INT);
$stmt -> bindValue(':point', $point, PDO::PARAM_INT);
$status = $stmt -> execute();


//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  //５．login.phpへリダイレクト
  // echo '<h2>チェックインしました！</h2><div>'.$row_event["point"].'ポイントを獲得しました！<div>';
  // header("refresh:5;url=y_event_detail.php?id=".$row_event["e_id"]);
      include("include/header.php");
      $view = '';
      $view .= '<div class="container my-5">';
      $view .= '<h2 class="text-center">チェックインしました！</h2>';
      $view .= '<div class="d-flex justify-content-center align-self-center mb-2 user-point">';
      $view .= '<img src="./img/fcpoint.svg"
      width="30" height="30" class="mr-2" alt="ポイント">'.$row_event["point"].'ポイントを獲得しました！';
      $view .= '<br><small>（3秒後にイベントページに戻ります）</small></div>';
      $view .= '</div>';
      echo $view;
      header("refresh:3;url=y_event_detail.php?id=".$row_event["e_id"]);


}       

?>
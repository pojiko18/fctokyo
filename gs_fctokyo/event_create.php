<?php
session_start();
include("./funcs.php");
loginCheck();

//1. POSTデータ取得
$title = $_POST["title"];
$year = $_POST["year"];
$month = $_POST["month"];
$day = $_POST["day"];
$time = $_POST["time"];
$place = $_POST["place"];
$contents = $_POST["contents"];
$password = $_POST["password"];
$point = $_POST["point"];
$id =$_SESSION["id"];

if($title==""){
    echo 'タイトルを入力してください';
    echo '<a href="event.php">▶▶▶イベント作成ページへ戻る</a><br>';
}
if($password==""){
    echo '合言葉を設定してください';
    echo '<a href="event.php">▶▶▶イベント作成ページへ戻る</a><br>';
}

//２、 DB接続します
$pdo = dbcon();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO event(o_id,   title,year,month,day,time,place,contents,password,point)
VALUES(:o_id   ,:title,:year,:month,:day,:time,:place,:contents,:password,:point)");
// $stmt = $pdo->prepare("INSERT INTO gs_wb_table(want_name,want_url,want_com,rating2,indate)VALUES(:want_name,:want_url,:want_com,:rating2,sysdate())");

//バインド変数を作ってセキュリティーを強化させる
// $stmt->bindValue(':e_id',  PDO::PARAM_INT);  
$stmt->bindValue(':o_id',$id,  PDO::PARAM_INT);  
$stmt->bindValue(':title', $title, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':year', $year, PDO::PARAM_INT); 
$stmt->bindValue(':month', $month, PDO::PARAM_INT); 
$stmt->bindValue(':day', $day, PDO::PARAM_INT);  
$stmt->bindValue(':time', $time, PDO::PARAM_STR);  
$stmt->bindValue(':place', $place, PDO::PARAM_STR);   
$stmt->bindValue(':contents', $contents, PDO::PARAM_STR); 
$stmt->bindValue(':password', $password, PDO::PARAM_STR); 
$stmt->bindValue(':point', $point, PDO::PARAM_INT);

//--実行する
$status = $stmt->execute(); //結果：false＝エラー




//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo(); //-- エラー取得の関数→配列で戻してくる
  exit("SQLError:".$error[2]);
}else{

// ５．index.phpへリダイレクト
//---Lは大文字で、:のあとには半角スペースあける
header("Location: event_list.php");
exit();

}
?>

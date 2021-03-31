<?php
session_start();

// ＝＝＝＝＝＝自己紹介の変更＝＝＝＝＝＝
$email = $_POST["email"];
$year = $_POST["year"];
$month = $_POST["month"];
$day = $_POST["day"];
$pref = $_POST["pref"];

$text = $_POST["text"];
$id =$_POST["id"];


//２、 DB接続します

//$pdoの情報を呼び出してあげる
include("./funcs.php");
$pdo = dbcon();

// 画像
$upfile = fileUpload("upfile","upload/");



//３．データ登録SQL作成
$sql = "UPDATE users SET email=:email,year=:year,month=:month,day=:day,address=:pref,img=:img,text=:text WHERE user_id=:id";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':email', $email, PDO::PARAM_STR);  
$stmt->bindValue(':year', $year, PDO::PARAM_INT);  
$stmt->bindValue(':month', $month, PDO::PARAM_INT);
$stmt->bindValue(':day', $day, PDO::PARAM_INT);
$stmt->bindValue(':pref', $pref, PDO::PARAM_STR); 
$stmt->bindValue(':img', $upfile, PDO::PARAM_STR); 
$stmt->bindValue(':text', $text, PDO::PARAM_STR); 
$stmt->bindValue(':id', $id, PDO::PARAM_INT); 
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
header("Location: mypage.php");
exit();

}




?>

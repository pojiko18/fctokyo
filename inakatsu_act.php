<?php
session_start();
include("funcs.php");
loginCheck();

$u_id =$_SESSION["id"];


$img = "";

//FileUpload処理
if (!isset($_FILES['upfile']['error']) || !is_int($_FILES['upfile']['error']) 
|| !isset($_POST["file_upload_flg"]) || $_POST["file_upload_flg"]!="1") {
echo 'パラメータが不正です';

}else{
    $lat = $_POST["lat"];
    $lon = $_POST["lon"];
    
    
    $name = $_POST["name"];
    $url = $_POST["url"];
    $kansou = $_POST["kansou"];

    //2. DB接続します(エラー処理追加)
    $pdo = dbcon();

    // 画像
    $upfile = fileUpload("upfile","upload/");


    //３．データ登録SQL作成
    $sql = "INSERT INTO inakatsu (user_id, name, img_shop,lat,lon, url, kansou,indate_ina )
    VALUES(:u_id, :name, :img,:lat,:lon, :url, :kansou,  sysdate())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':lat', $lat);
    $stmt->bindValue(':lon', $lon);
    $stmt->bindValue(':img', $upfile, PDO::PARAM_STR); 
    $stmt->bindValue(':u_id', $u_id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':name', $name, PDO::PARAM_STR); 
    $stmt->bindValue(':url', $url, PDO::PARAM_STR);  
    
    $stmt->bindValue(':kansou', $kansou, PDO::PARAM_STR);  
    
    $status = $stmt->execute();
    
    if($status==false){
      echo "SQLエラー";
      $error = $stmt->errorInfo();
      exit("QueryError:".$error[2]);
    
    }else{
    echo "登録完了！";
    header("Location: inakatsu.php");
    }

} 

        



// ★★今までのやつ
// //1. POSTデータ取得
// $name = $_POST["name"];
// $url = $_POST["url"];
// $nemu = $_POST["nemu"];
// $price = $_POST["price"];
// $kansou = $_POST["kansou"];
// $rating = $_POST["rating"];

// //2. DB接続します(エラー処理追加)
// $pdo = dbcon();

// // 画像
// $upfile = fileUpload("upfile","upload/");

// //３．データ登録SQL作成
// $sql = "INSERT INTO inakatsu(user_id, name, img_shop, url, nemu,price,kansou,rating ,indate )
// VALUES(:u_id, :name, :img, :url, :nemu, :price,:kansou, :rating, sysdate())";
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':u_id', $u_id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':name', $name, PDO::PARAM_STR); 
// $stmt->bindValue(':img', $upfile, PDO::PARAM_STR);  
// $stmt->bindValue(':url', $url, PDO::PARAM_STR);  
// $stmt->bindValue(':nemu', $nemu, PDO::PARAM_STR);  
// $stmt->bindValue(':price', $price, PDO::PARAM_STR);  
// $stmt->bindValue(':kansou', $kansou, PDO::PARAM_STR);  
// $stmt->bindValue(':rating', $rating, PDO::PARAM_STR);  

// $status = $stmt->execute();

// //４．データ登録処理後
// if($status==false){
//   //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
//   $error = $stmt->errorInfo();
//   exit("QueryError:".$error[2]);

// }else{
//   //５．login.phpへリダイレクト
//   header("Location: inakatsu.php"); //半角スペースを入れる
//   exit;

// }
?>
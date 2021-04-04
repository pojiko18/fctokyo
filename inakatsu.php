<?php 

session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$id =$_SESSION["id"];


$pdo = dbcon();

//◆蝗活データとユーザー情報をJOINさせて取得
$stmt = $pdo->prepare("SELECT * FROM inakatsu LEFT JOIN users ON inakatsu.user_id = users.user_id ");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<div class="col-lg-4 col-md-6"><div class="card mb-4">';
    $view .= '<a href="inakatsu_detail.php?id='.$res["id"].'" rel="noopener noreferrer">';
    $view .= '<img class="card-img-top" src="upload/'.$res["img_shop"].'" width="100%" height="180px">';
    $view .= '<div class="card-body">';
    $view .= '<h3 class="card-title">'.$res["name"].'</h3>';
    $view .= '<p class="card-text"><i class="fas fa-calendar-alt"></i>投稿者： '.$res["user_name"].'</p>';
    $view .= '<p>おすすめ度：'.$res["rating"].'</p>';
    $view .= '<p class="card-text"><button class="btn btn-primary btn-block">詳しく見る</button></p>';
    $view .= '</div>';
    $view .= '</a></div></div>';
    
  }

}
?>


<?php
$title = "イベント一覧";
include("include/header.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="container mt-4">
    <h1>蝗活　一覧</h1>
    <p><a href="./inakatsu_create.php">作成はこちらから</a></p>
    <div class="row"><?=$view?></div>
</div>

<?php
include("include/footer.php");
?>
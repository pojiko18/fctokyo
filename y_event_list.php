<?php 

session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$id =$_SESSION["id"];

$pdo = dbcon();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM event  ORDER BY e_id DESC");
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
      if($res["img"]==NULL|| $res["img"]== 1|| $res["img"]== 2){
        $event_img = "./img/noimg.jpg";
      }
      else{
        $event_img = './upload/'.$res["img"];
      }
    $view .= '<div class="col-lg-4 col-md-6"><div class="card mb-4">';
    $view .= '<a href="y_event_detail.php?id='.$res["e_id"].'" rel="noopener noreferrer">';
    $view .= '<img class="card-img-top" src="'.$event_img.'" width="100%" height="180px">';
    $view .= '<div class="card-body">';
    $view .= '<h3 class="card-title">'.$res["title"].'</h3>';
    $view .= '<p class="card-text"><i class="fas fa-calendar-alt"></i> '.$res["year"].'年'.$res["month"].'月'.$res["day"].'日</p>';
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
<h1>イベント一覧</h1>
<div class="row"><?=$view?></div>
</div>

<?php
include("include/footer.php");
?>






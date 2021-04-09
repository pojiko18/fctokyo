<?php
session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$id =$_GET["id"];
$u_id =$_SESSION["id"];


//DB接続
$pdo = dbcon();


// ◆蝗活データの取得
$sql = "SELECT * FROM inakatsu WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  //１データのみ抽出の場合はwhileループで取り出さない
  $row = $stmt->fetch();
}

//◆蝗活データとユーザー情報をJOINさせて取得
$sql_e = "SELECT * FROM inakatsu LEFT JOIN users ON inakatsu.user_id = users.user_id WHERE  id=:id ";

$stmt_e = $pdo->prepare($sql_e);
$stmt_e->bindValue(':id', $id, PDO::PARAM_INT);
$status_e = $stmt_e->execute();

//データ表示
if($status_e==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_e = $stmt_e->errorInfo();
  exit("ErrorQuery:".$error_e[2]);

} else {
  $row_e = $stmt_e->fetch();
}


//◆bbsとユーザー詳細をJOINさせて取得
$sql_bbs = "SELECT * FROM ina_bbs LEFT JOIN users ON ina_bbs.user_id = users.user_id WHERE ina_id=:id ";

$stmt_bbs = $pdo->prepare($sql_bbs);
$stmt_bbs->bindValue(':id', $id, PDO::PARAM_INT);
$status_bbs = $stmt_bbs->execute();

//データ表示
$bbs_view = "";

if($status_bbs ==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_bbs = $stmt_bbs->errorInfo();
  exit("ErrorQuery:".$error_bbs[2]);

} else {
  while( $bbs = $stmt_bbs->fetch(PDO::FETCH_ASSOC)){ 
    if($bbs["img"]==NULL|| $bbs["img"]== 1|| $bbs["img"]== 2){
        $bbs_img = "./img/userimg.jpg";
      }
      else{
          $bbs_img = './upload/'.$bbs["img"];
      }
  
      $bbs_view .= '<li class="media bbs-box"><img src="'.$bbs_img.'" width="30" class="mr-2 user-icon">';
      $bbs_view .= '<div class="media-body bbs-text-box"><p class="bbs-name"><a href="./user_page.php?id='.$bbs["user_id"].'">'.$bbs["user_name"].'</a></p>';
      $bbs_view .= '<p class="bbs-comment">'.nl2br($bbs["comment"]).'</p>';
      $bbs_view .= '<p class="bbs-time">'.$bbs["indate"].'</p></div></li>';
  }
}


?>

<?php
$title = "蝗活　お店詳細ページ";
$addhead ='<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">';
include("include/header.php");
?>


<div class="event-detail-box">
    <div class="container">
        <!-- Main[Start] -->

        <!-- 日程入れる -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div><img src="upload/<?=$row["img_shop"]?>" width="100%" class="event-main-img" name="upfile">
                    </div>
                    <div class="card-body event-detail-overview">
                        <h2 class="card-title"><?=$row["name"]?></h2>
                        <p>投稿者：<a href="./user_page.php?id=<?=$row_e["user_id"]?>"><?=$row_e["user_name"]?>さん</a></p>
                        <p>投稿日：<?=$row_e["indate_ina"]?></p>
                        <p>お店の情報（URL）:
                            <a href=" <?=$row["url"]?>" target="_blank" rel="noopener noreferrer"><?=$row["url"]?></a>
                        </p>

                        <p>感想：<?=$row["kansou"]?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- 時間あればチャット入れる -->
                <div class="card">
                    <div class="card-header" id="bbs">メッセージ</div>

                    <div class="card-body">
                        <form method="post" action="ina_bbs.php" class="form">
                            <textarea name="bbs" rows="3" placeholder="メッセージを入力" class="form-control mb-3"></textarea>
                            <input type="hidden" name="id" value="<?=$row["id"]?>">
                            <input type="hidden" name="u_id" value="<?=$row["user_id"]?>">
                            <div class="submit card-text">
                                <input type="submit" value="送信" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                    <?php if($bbs_view){ ?>
                    <div class="card-footer bkgd-white">
                        <ul class="list-unstyled mb-0"><?=$bbs_view?></ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div><!-- event-text-box -->

<!-- Main[End] -->
<?php
include("include/footer.php");
?>
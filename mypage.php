<?php
session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$u_id =$_SESSION["id"];


//DB接続
$pdo = dbcon();

//◆ユーザー情報の取得
$sql = "SELECT * FROM users WHERE user_id=:u_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
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


//◆参加したイベントとイベント詳細をJOINさせて取得
$sql_e = "SELECT * FROM event_list LEFT JOIN event ON event_list.event_id = event.e_id WHERE user_id=:u_id ";

$stmt_e = $pdo->prepare($sql_e);
$stmt_e->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$status_e = $stmt_e->execute();

//データ表示
$view_event="";
$point_count=0;

if($status_e==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_e = $stmt_e->errorInfo();
  exit("ErrorQuery:".$error_e[2]);

} else {
  // var_dump($stmt_e);
    while( $res_eventlist = $stmt_e->fetch(PDO::FETCH_ASSOC)){ 
      $view_event .= '<a href="y_event_detail.php?id='.$res_eventlist["e_id"].'" class="user-eventlist-box" rel="noopener noreferrer">';
      $view_event .= '<div class="media">';
      $event_img = $res_eventlist["img"];
      if($res_eventlist["img"]==NULL|| $res_eventlist["img"]== 1|| $res_eventlist["img"]== 2){
        $event_img = "noimg.png";
      }
      $view_event .= '<img src="upload/'. $event_img. '" width="100" class="mr-3 user-eventlist-img" name="upfile">';
      $view_event .= '<div class="media-body">';
      $view_event .= '<h4 class="media-title mb-1">'.$res_eventlist["title"].'</h4>';
      $view_event .= '<p class="user-eventlist-day">'.$res_eventlist["year"].'年'.$res_eventlist["month"].'月'.$res_eventlist["day"].'日</p>';
      $view_event .= '</div></div></a>';

      $point_count +=  $res_eventlist["point"];
  }
}
?>

<?php
$title = "メンバー";
include("include/header.php");
?>

<!-- Head[End] -->

<!-- Main[Start] -->

<div class="user-main">
    <div class="container">
        <!-- 自己紹介 -->
        <div class="text-center mt-5 mb-3 user-top">
            <!-- アイコン画像を表示させる（未登録：カオナシ） -->
            <?php if($row["img"]==NULL || $row["img"]== 1|| $row["img"]== 2){ ?>
            <div><img src="./upload/kaonasi-icon.JPG" alt="" width="100" class="user-icon mb-3"></div>
            <?php }else{?>
            <div><img src="upload/<?=$row["img"]?>" width="100" class="user-icon mb-3"></div>
            <?php } ?>

            <h2><?=$row["user_name"]?></h2>
            <div class="d-flex justify-content-center align-self-center mb-2 user-point"><img src="./img/fcpoint.svg" width="30" height="30" class="mr-2" alt="ポイント"> <?=$point_count?></div>
            <div><a href="./mypage_edit.php?id=<?=$row["user_id"]?>">編集</a></div>
        </div>
    </div>
</div>

<div class="user-detail-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">自己紹介</h3>
                        <p class="card-text"><i class="fas fa-birthday-cake fa-fw"></i><?=$row["year"]?>年<?=$row["month"]?>月<?=$row["day"]?>日</p>
                        <p class="card-text"><i class="fas fa-home fa-fw"></i><?=$row["address"]?></p>
                        <p class="card-text"><?=$row["text"]?></p>
                    </div>
                </div>
            </div>

            <!-- イベント履歴 -->
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title mb-0">イベント参加履歴</h3>
                    </div>
                    <div class="card-body">
                        <div><?=$view_event?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main[End] -->

<?php
include("include/footer.php");
?>
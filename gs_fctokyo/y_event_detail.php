<?php
session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$e_id =$_GET["id"];
$u_id =$_SESSION["id"];


//DB接続
$pdo = dbcon();


// イベントidの取得
$sql = "SELECT * FROM event WHERE e_id=:e_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':e_id', $e_id, PDO::PARAM_INT);
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
$sql_e = "SELECT * FROM event_list LEFT JOIN event ON event_list.event_id = event.e_id WHERE user_id=:u_id AND e_id=:e_id ";

$stmt_e = $pdo->prepare($sql_e);
$stmt_e->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$stmt_e->bindValue(':e_id', $e_id, PDO::PARAM_INT);
$status_e = $stmt_e->execute();

//データ表示
if($status_e==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_e = $stmt_e->errorInfo();
  exit("ErrorQuery:".$error_e[2]);

} else {
  $row_e = $stmt_e->fetch();
}

//◆参加したイベントとユーザー詳細をJOINさせて取得
$sql_sanka = "SELECT * FROM event_list LEFT JOIN users ON event_list.user_id = users.user_id WHERE event_id=:e_id ";

$stmt_sanka = $pdo->prepare($sql_sanka);
$stmt_sanka->bindValue(':e_id', $e_id, PDO::PARAM_INT);
$status_sanka = $stmt_sanka->execute();

//データ表示
$sanka_event="";
$sanka_count =0;

if($status_sanka ==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_sanka = $stmt_sanka->errorInfo();
  exit("ErrorQuery:".$error_sanka[2]);

} else {
  while( $sanka = $stmt_sanka->fetch(PDO::FETCH_ASSOC)){ 
      // $sanka_event .= $sanka["user_name"].'<br>';←これで名前取ってこれる
      if($u_id != $sanka["user_id"]){
      $sanka_event .= '<li><a href="./user_page.php?id='.$sanka["user_id"].'">'.$sanka["user_name"].'</li>';
      }else{
      $sanka_event .= '<li>'.$sanka["user_name"].'</li>';
      }

      // 人数カウント
      $sanka_count +=  1;
  }
}


//◆bbsとユーザー詳細をJOINさせて取得
$sql_bbs = "SELECT * FROM event_bbs LEFT JOIN users ON event_bbs.user_id = users.user_id WHERE event_id=:e_id ";

$stmt_bbs = $pdo->prepare($sql_bbs);
$stmt_bbs->bindValue(':e_id', $e_id, PDO::PARAM_INT);
$status_bbs = $stmt_bbs->execute();

//データ表示
$bbs_view = "";

if($status_bbs ==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_bbs = $stmt_bbs->errorInfo();
  exit("ErrorQuery:".$error_bbs[2]);

} else {
  while( $bbs = $stmt_bbs->fetch(PDO::FETCH_ASSOC)){ 
    $bbs_view .= '<div><img src="upload/'.$bbs["img"].'" width="100"></div>';
    $bbs_view .= '<a href="./user_page.php?id='.$bbs["user_id"].'">'.$bbs["user_name"].'</a>:';
    $bbs_view .= $bbs["comment"].'<br>';
    $bbs_view .= $bbs["time"].'</div>';

  }
}



?>

<?php
$title = "イベント詳細";
$addhead ='<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">';
include("include/header.php");
?>

<div class="event-main">
    <div class="event-main-box">
        <?php if($row["img"]==NULL|| $row["img"]== 1|| $row["img"]== 2){ ?>
        <div><img src="./upload/noimg.png" alt="" width="100%" class="event-main-img"></div>
        <?php }else{?>
        <div><img src="upload/<?=$row["img"]?>" width="100%" class="event-main-img" name="upfile"></div>
        <?php } ?>
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-9">
                    <h2 class="event-detail-title"><?=$row["title"]?></h2>
                </div>
                <?php if($row_e == true){ ?>
                <div class="col-lg-3 text-lg-right">
                    <p class="checkin"><i class="fas fa-check"></i> チェックイン済み</p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="event-detail-box">
    <div class="container">
        <!-- Main[Start] -->
        <!-- ポップアップ
    <div class="popup" id="js-popup">
      <div class="popup-inner">
        <div class="close-btn" id="js-close-btn"><i class="fas fa-times"></i></div>
        <a href="#"><img src="./upload/20210320064558b7d5b9411bdddf35e9f01edc9eb941d5.jpg" alt="ポップアップ画像"></a>
      </div>
      <div class="black-background" id="js-black-bg"></div>
    </div> 
  参照：https://tech-dig.jp/js-modal/
  -->
        <!-- 日程入れる -->
        <div class="row">
            <div class="col-lg-12">

            </div>
        </div>


        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body event-detail-overview">
                        <h3 class="card-title">詳細</h3>
                        <p class="card-text"><i class="fas fa-calendar-alt"></i>
                            <?=$row["year"]?>年<?=$row["month"]?>月<?=$row["day"]?>日
                            <?=$row["time"]?></p>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i> <?=$row["place"]?></p>
                        <p class="card-text"><?=$row["contents"]?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- 合言葉入れるところ -->
                <?php if($row_e != true){ ?>
                <div class="card">
                    <div class="card-header">合言葉</div>
                    <div class="card-body">
                        <form method="post" action="aikotoba_act.php" class="form">
                            <div class="form-group">
                                <label for="aikotoba">参加希望の方は合言葉を入力してください。</label>
                                <input type="text" id="aikotoba" name="aikotoba" class="lform-control">
                            </div>
                            <input type="hidden" name="e_id" value="<?=$row["e_id"]?>">
                            <input type="hidden" name="u_id" value="<?=$u_id?>">
                            <input type="hidden" name="point" value="<?=$row["point"]?>">
                            <p class="card-text">
                                <input type="submit" value="送信する" class="btn btn-primary btn-block" id="js-show-popup">
                            </p>
                        </form>
                    </div>
                </div>
                <?php } ?>

                <!-- 人数と名前表示 -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">参加者数 <?=$sanka_count?></h3>
                        <div class="card-text">
                            <ul><?=$sanka_event?></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- 時間あればチャット入れる -->
                <section>
                    <h3 id="bbs">メッセージ</h3>
                    <form method="post" action="bbs.php" class="form">
                        <textarea name="bbs" rows="3" placeholder="メッセージを入力"></textarea>
                        <input type="hidden" name="e_id" value="<?=$row["e_id"]?>">
                        <input type="hidden" name="u_id" value="<?=$u_id?>">
                        <div class="submit">
                            <input type="submit" value="送信">
                        </div>
                    </form>

                    <div><?=$bbs_view?></div>
                </section>
            </div>
        </div>

    </div>
</div><!-- event-text-box -->

<!-- Main[End] -->
<?php
include("include/footer.php");
?>
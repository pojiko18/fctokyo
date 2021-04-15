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
      $sanka_event .= '<li><a href="./user_page.php?id='.$sanka["user_id"].'">'.$sanka["user_name"].'</a></li>';
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
    if($bbs["img"]==NULL|| $bbs["img"]== 1|| $bbs["img"]== 2){
      $bbs_img = "./img/userimg.jpg";
    }
    else{
        $bbs_img = './upload/'.$bbs["img"];
    }

    $bbs_view .= '<li class="media bbs-box"><img src="'.$bbs_img.'" width="30" class="mr-2 user-icon">';
    $bbs_view .= '<div class="media-body bbs-text-box"><p class="bbs-name"><a href="./user_page.php?id='.$bbs["user_id"].'">'.$bbs["user_name"].'</a></p>';
    $bbs_view .= '<p class="bbs-comment">'.nl2br($bbs["comment"]).'</p>';
    $bbs_view .= '<p class="bbs-time">'.$bbs["time"].'</p></div></li>';

  }
}

// 試合会場の取得
$sql_team = "SELECT * FROM event 
LEFT JOIN team ON event.team_id = team.team_id WHERE e_id=:e_id ";
$stmt_team = $pdo->prepare($sql_team);
$stmt_team->bindValue(':e_id', $e_id, PDO::PARAM_INT);
$status_team = $stmt_team->execute();


$team_view ="";
if($status_team==false) {
  //execute（SQL実行時にエラーがある場合）
  $error_team = $stmt_team->errorInfo();
  exit("ErrorQuery:".$error_team[2]);

} else {
  $row_team = $stmt_team->fetch();

}
?>

<?php
$title = "イベント詳細";
include("include/header.php");
?>

<script>
function test() {
    navigator.geolocation.getCurrentPosition(test2);
}
var lat = "";
var lon = "";

function test2(position) {
    lat = position.coords.latitude;
    lon = position.coords.longitude;

    var date = new Date(position.timestamp);

    console.log(lat);
    console.log(lon);
    if (lat > <?=$row_team["lat"]?> - 0.01 && lat < <?=$row_team["lat"]?> + 0.01 && lon >
        <?=$row_team["lon"]?> - 0.01 && lon < <?=$row_team["lon"]?> + 0.01) {
        var form = document.createElement('form');
        var request = document.createElement('input');
        var request2 = document.createElement('input');
        var request3 = document.createElement('input');
        var request4 = document.createElement('input');

        form.method = 'POST';
        form.action = './stadium_act.php';

        request.type = 'hidden'; //入力フォームが表示されないように
        request.name = 'e_id';
        request.value = '<?=$row["e_id"]?>';

        request2.type = 'hidden'; //入力フォームが表示されないように
        request2.name = 'u_id';
        request2.value = '<?=$u_id?>';

        request3.type = 'hidden'; //入力フォームが表示されないように
        request3.name = 'point';
        request3.value = '<?=$row["point"]?>';

        request4.type = 'hidden'; //入力フォームが表示されないように
        request4.name = 'team';
        request4.value = '<?=$row["team_id"]?>';

        form.appendChild(request);
        form.appendChild(request2);
        form.appendChild(request3);
        form.appendChild(request4);

        document.body.appendChild(form);

        form.submit();
    } else {
        $(".ng").addClass("d-block").removeClass("d-none").html(
            "正しくチェックインできませんでした。<br>GPSを起動してください。<br>または場所を変えて再度お試しください。");
    }
}
</script>

<div class="event-main">
    <div class="event-main-box">
        <?php if($row["img"]==NULL|| $row["img"]== 1|| $row["img"]== 2){ ?>
        <div><img src="./img/noimg.jpg" alt="" width="100%" class="event-main-img"></div>
        <?php }else{?>
        <div><img src="upload/<?=$row["img"]?>" width="100%" class="event-main-img" name="upfile"></div>
        <?php } ?>
        <div class="container py-4">
            <h2 class="event-detail-title"><?=$row["title"]?></h2>
        </div>
    </div>
</div>

<div class="event-detail-box">
    <div class="container">
        <!-- Main[Start] -->

        <!-- 日程入れる -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body event-detail-overview">
                        <h3 class="card-title">詳細</h3>
                        <p class="card-text"><i class="fas fa-calendar-alt fa-fw"></i>
                            <?=$row["year"]?>年<?=$row["month"]?>月<?=$row["day"]?>日
                            <?=$row["time"]?></p>
                        <p class="card-text"><i class="fas fa-map-marker-alt fa-fw"></i> <?=$row["place"]?></p>
                        <p class="card-text"><?=$row["contents"]?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- ポイントゲット済み -->
                <?php if( $row_e == true ){ ?>
                <div class="card border-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-self-center user-point">
                            <img src="./img/fcpoint.svg" width="30" height="30" class="mr-2" alt="ポイント">
                            <?php echo $row_e["point"]; ?>ポイントゲットしました！
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="card border-danger">
                    <div class="card-header">
                        <div class="d-flex justify-content-center align-self-center user-point">
                            <img src="./img/fcpoint.svg" width="30" height="30" class="mr-2" alt="ポイント"> ポイントゲット
                        </div>
                    </div>

                    <!-- ココにスタジアムチェックイン入れる -->
                    <div class="card-body">
                        <!-- きちんとチェックインできなかった人への注意書きを表示 -->
                        <div class="ng alert alert-danger d-none"></div>
                        <p class="card-text mb-4 pb-4 border-bottom">
                            <input type="submit" value="スタジアムチェックインする" class="btn btn-danger btn-block"
                                id="js-show-popup" onclick="test()">
                        </p>

                        <!-- 合言葉入れるところ -->
                        <form method="post" action="aikotoba_act.php" class="form needs-validation" novalidate>
                            <div class="form-group">
                                <label for="aikotoba">リモートで参加の方は合言葉を入力してください。</label>
                                <input type="text" id="aikotoba" name="aikotoba" class="form-control" required>
                                <div class="invalid-feedback">
                                    合言葉を入力してください。
                                </div>
                            </div>
                            <input type="hidden" name="e_id" value="<?=$row["e_id"]?>">
                            <input type="hidden" name="u_id" value="<?=$u_id?>">
                            <input type="hidden" name="point" value="<?=$row["point"]?>">
                            <p class="card-text">
                                <input type="submit" value="送信する" class="btn btn-danger btn-block" id="js-show-popup">
                            </p>
                        </form>
                        <script>
                        // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (function() {
                            'use strict';
                            window.addEventListener('load', function() {
                                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                var forms = document.getElementsByClassName('needs-validation');
                                // Loop over them and prevent submission
                                var validation = Array.prototype.filter.call(forms, function(form) {
                                    form.addEventListener('submit', function(event) {
                                        if (form.checkValidity() === false) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                        form.classList.add('was-validated');
                                    }, false);
                                });
                            }, false);
                        })();
                        </script>
                    </div>
                </div>
                <?php } ?>

                <!-- 人数と名前表示 -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">参加者数 <?=$sanka_count?></h3>
                        <div class="card-text">
                            <ul class="list-unstyled"><?=$sanka_event?></ul>
                        </div>
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
                        <form method="post" action="bbs.php" class="form">
                            <textarea name="bbs" rows="3" placeholder="メッセージを入力" class="form-control mb-3"></textarea>
                            <input type="hidden" name="e_id" value="<?=$row["e_id"]?>">
                            <input type="hidden" name="u_id" value="<?=$u_id?>">
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
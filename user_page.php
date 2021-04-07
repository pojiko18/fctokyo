<?php
session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$u_id='';
  if (isset($_GET['id'])) {
    $u_id=(int)$_GET['id'];
  }


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
      $view_event .= '<div class="box"><a href="y_event_detail.php?id='.$res_eventlist["e_id"].'" target="_blank" rel="noopener noreferrer"><button>';
      $view_event .= '<h3>'.$res_eventlist["title"].'</h3>';
      $view_event .= '<p>'.$res_eventlist["year"].'年'.$res_eventlist["month"].'月'.$res_eventlist["day"].'日</p>';
      $view_event .= '<p>＞詳細</p>';
      $view_event .= '</button></a></div>';

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

<div class="container">
    <!-- 自己紹介 -->
    <div class="text-center">
    <div><img src="upload/<?=$row["img"]?>" width="100" class="user-icon"></div>
    <div><?=$row["user_name"]?>さん</div>
    <div>獲得ポイント数：<?=$point_count?></div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">自己紹介</h3>
                <p class="card-text">生年月日　：<?=$row["year"]?>年<?=$row["month"]?>月<?=$row["day"]?>日</p>
                <p class="card-text">居住地　　：<?=$row["address"]?></p>
                <p class="card-text">自己紹介　：<?=$row["text"]?></p>
              </div>
            </div>
        </div>

        <!-- イベント履歴 -->
        <div class="col-lg-7">
            <div class="card">
                <h2>イベント参加履歴</h2>
                <div><?=$view_event?></div>
            </div>
        </div>
    </div>
        <!-- Main[End] -->
<?php
include("include/footer.php");
?>
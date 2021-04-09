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
$view_map="";
$i=0;
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
    $view .= '<p class="card-text"><button class="btn btn-primary btn-block">詳しく見る</button></p>';
    $view .= '</div>';
    $view .= '</a></div></div>';

    // 蝗活マップ
    if($i==0){
      //ループ初回のみ、ここを処理
        $view_map .= '"'.$res['img_shop'].','.$res['lat'].','.$res['lon'].','.$res['name'].','.$res['user_name'].','.$res['id'].','.$res['indate_ina'].'"';
    }else{
      //ループ2回めからこちらを処理
        $view_map .=',"'.$res['img_shop'].','.$res['lat'].','.$res['lon'].','.$res['name'].','.$res['user_name'].','.$res['id'].','.$res['indate_ina'].'"';
    }
    $i++;
    
    
  }
}
?>


<?php
$title = "蝗活";
include("include/header.php");
?>
<!-- Head[End] -->
<style>
p {
    color: white
}

.map_area {
    position: relative;
    height: 500px;
    padding: 20px;
}

.myMap {
    width: 95%;
}

.myMapimg {
    width: 100%
}
</style>
<!-- Main[Start] -->
<div class="container mt-4">
    <h1>蝗活　一覧</h1>
    <p><a href="./inakatsu_create.php">作成はこちらから</a></p>

    <div class="map_area">
        <div class="myMap"></div>
    </div>
    <div>赤いピンをクリックすると画像が見れます。<br>また画像をクリックすると詳細ページに移動します。</div>
    <br>
    <div class="row"><?=$view?></div>
</div>

<?php
include("include/footer.php");
?>

<script
    src="https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AlifJJNQU2HLjuz8pM4tLSBcX6htivoXsVYYMYxnUvQc1555Qk5MyGxfaCkEY14P"
    async defer></script>
<script src="./js/js copy/BmapQuery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.1.1/firebase.js"></script>

<script>
//******************************************************************
//MAP       参照：https://mapapi.org/
//******************************************************************


function GetMap() {

    const map = new Bmap(".myMap");

    // 味スタを中心に日本地図が見えるように
    map.startMap(35.664346828736, 139.52727071587, "load", 5);

    const options = new Array(<?=$view_map?>);

    console.log(options);

    //複数ピン処理
    for (var i = 0; i < options.length; i++) {
        //point配列をスプリット
        var locations = options[i];
        var gpoint = locations.split(",");

        options[i] = {
            "lat": gpoint[1],
            "lon": gpoint[2],
            "title": '' + gpoint[3] + '',
            "pinColor": "#ff0000",
            "height": 300,
            "width": 320,
            "description": gpoint[4] + '<a href="inakatsu_detail.php?id=' +
                gpoint[5] + '" rel="noopener noreferrer"><img src="upload/' + gpoint[0] + '" width="150"></a>',
            "show": false
        };
    }

    map.infoboxLayers(options, true);

}
</script>
</body>

</html>
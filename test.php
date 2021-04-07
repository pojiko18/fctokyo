<?php
//★Point: XSS
function view($val){
  return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}
//1. 接続します
$pdo = new PDO('mysql:dbname=gs_fctokyo;host=localhost', 'root', 'root');

//2. DB文字コードを指定
$stmt = $pdo->query('SET NAMES utf8');

//３．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM inakatsu ORDER BY indate_ina DESC");

//４．SQL実行
$flag = $stmt->execute();



//データ表示
$view_map="";
$i=0;
if($flag==false){
    $view = "SQLエラー";
}else{
    while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){

// var_dump( $res["id"]);
    

    if($i==0){
      //ループ初回のみ、ここを処理
        $view_map .= '"'.$res['img'].','.$res['lat'].','.$res['lon'].','.$res['input_date'].'"';
    }else{
      //ループ2回めからこちらを処理
        $view_map .=',"'.$res['img'].','.$res['lat'].','.$res['lon'].','.$res['input_date'].'"';
    }
    $i++;
    }


}


// var_dump($res);

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MAP表示デモ</title>
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
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body id="main">

    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="#">画像一覧</a></div>
        </nav>
    </header>
    <!-- Head[End] -->


    <!-- IMG_LIST[Start] -->
    <div class="container-fluid">
        <!-- Main[Start] -->
        <div class="map_area">
            <div class="myMap"></div>

        </div>
        <!-- Main[End] -->
        <!-- // ★画像を大きくするやつ -->
        <!-- <div><input id="img_width_range" type="range" step="10" max="400" min="50" value="200"></div> -->
    </div>
    <!-- IMG_LIST[END] -->

    <!-- Javascript -->

    <script
        src="https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AlifJJNQU2HLjuz8pM4tLSBcX6htivoXsVYYMYxnUvQc1555Qk5MyGxfaCkEY14P"
        async defer></script>
    <script src="./js/js copy/BmapQuery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase.js"></script>
    <script>
    // ★画像を大きくするやつ
    // $("#img_width_range").on("change", function() {
    //     $(".myMap div a>img").css("width", $(this).val() + "px");
    // });

    //******************************************************************
    //MAP       参照：https://mapapi.org/
    //******************************************************************


    function GetMap() {

        const map = new Bmap(".myMap");

        // 味スタを中心に日本地図が見えるように
        map.startMap(35.664346828736, 139.52727071587, "load", 4);

        const options = new Array(<?=$view_map?>);

        //複数ピン処理
        for (var i = 0; i < options.length; i++) {
            //point配列をスプリット
            var locations = options[i];
            var gpoint = locations.split(",");

            options[i] = {
                "lat": gpoint[1],
                "lon": gpoint[2],
                "title": "",
                "pinColor": "#ff0000",
                "height": 300,
                "width": 320,
                "description": '<img src="' + gpoint[0] + '" width="100">',
                "show": false
            };
        }

        map.infoboxLayers(options, true);

    }
    </script>
</body>

</html>
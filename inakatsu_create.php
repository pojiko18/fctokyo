<?php
session_start();
include("funcs.php");
loginCheck();
$u_id =$_SESSION["id"];

?>

<style>
.geocode {
    font-size: 120%;
}
</style>

<?php
$title = "蝗活　報告作成ページ";
include("include/header.php");
?>
<div class="container">
<div class="card my-5">
    <div class="card-header">蝗活 作成</div>
    
    <div class="card-body">
        <p class="card-text mb-4">紹介したいお店の情報を入力して登録してください。</p>
        <form method="post" action="inakatsu_act.php" enctype="multipart/form-data" id="send_file">
            <div class="form-group">
                <label for="myfile">画像選択</label>
                <input type="file" id="myfile" accept="image/*" name="upfile" class="form-control mb-2">
                <img id="img1" style="width:300px;height:300px;" class="d-none" />
            </div>
            <div class="form-group">
                <label for="name">お店の名前</label>
                <input type="text" name="name" id="name" class="rediTextForm form-control">
                </div>
            <div class="form-group">
                <label for="address">お店の住所</label>
                
                <input type="text" id="address" value="東京都" name="address" class="form-control">
                <!-- <button id="get">地図で確認する</button> -->
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lon" id="lon">

                <small class="card-text text-muted my-2">GPSを起動させ、マップをクリックするとその場所の住所が出てきます。住所をコピーし入力欄にペーストすることができます。</small>
                <div class="geocode"></div>
                <div id="myMap" style="width:auto;height: 300px;"></div>

            </div>
            <div class="form-group">
                <label for="url">お店の情報（URL）</label>
                <input type="text" id="url" name="url" class="rediTextForm form-control">
                <a href="https://www.gnavi.co.jp/" target="_blank" rel="noopener noreferrer">＞ぐるなびでリンクを探す</a>
                </div>
            <div class="form-group">
                <label for="kansou">感想</label>
                <textArea name="kansou" id="kansou" rows="5" cols="55" class="form-control"></textArea>
            </div>
                <input type="hidden" name="file_upload_flg" value="1">
                <!-- <input type="file" accept="image/*" capture="camera" id="image_file" value="" name="upfile"
                    style="opacity:0;">
                <input type="hidden" name="file_upload_flg" value="1"> -->
            <p class="btn-c">
                <input type="submit" value="作成する" class="btn btn-primary">
            </p>
        </form>
    </div>
</div>
</div>

    <!-- Javascript -->
    <script
        src="https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AlifJJNQU2HLjuz8pM4tLSBcX6htivoXsVYYMYxnUvQc1555Qk5MyGxfaCkEY14P"
        async defer></script>
    <script src="./js/js copy/BmapQuery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase.js"></script>

    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script>
    // ★画像のアップロード
    $(function() {
        $('#myfile').change(function(e) {
            //ファイルオブジェクトを取得する
            var file = e.target.files[0];
            var reader = new FileReader();

            //画像でない場合は処理終了
            if (file.type.indexOf("image") < 0) {
                alert("画像ファイルを指定してください。");
                return false;
            }

            //アップロードした画像を設定する
            reader.onload = (function(file) {
                return function(e) {
                    $("#img1").attr("src", e.target.result);
                    $("#img1").attr("title", file.name);
                    $("#img1").addClass("d-block").removeClass("d-none");
                };
            })(file);
            reader.readAsDataURL(file);

        });
    });

    /**
     * Geolocation（緯度・経度）
     */
    // var lat = "";
    // var lon = "";
    // navigator.geolocation.watchPosition( //getCurrentPosition :or: watchPosition
    //     // 位置情報の取得に成功した時の処理
    //     function(position) {
    //         try {
    //             lat = position.coords.latitude; //緯度
    //             lon = position.coords.longitude; //経度
    //             // $("#lat").val(lat);
    //             // $("#lon").val(lon);
    //             // $("#status").html("緯度・経度、取得完了");

    //             // console.log(lat);
    //             // console.log(lon);
    //         } catch (error) {
    //             console.log("getGeolocation: " + error);
    //         }
    //     },
    //     // 位置情報の取得に失敗した場合の処理
    //     function(error) {
    //         var e = "";
    //         if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
    //             e = "位置情報が許可されてません";
    //         }
    //         if (error.code == 2) { //2＝現在地を特定できない
    //             e = "現在位置を特定できません";
    //         }
    //         if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
    //             e = "位置情報を取得する前にタイムアウトになりました";
    //         }
    //         $("#status").html("エラー：" + e);

    //     }, {
    //         // 位置情報取得オプション
    //         enableHighAccuracy: true, //より高精度な位置を求める
    //         maximumAge: 20000, //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
    //         timeout: 10000 //10秒以内に現在地情報を取得できなければ、処理を終了
    //     }
    // );

    //------------------------------------------------------------------------
    //MAP
    //------------------------------------------------------------------------
    // 現在地を中心に地図を表示させ、クリックした場所の住所を特定する

    // function GetMap() {

    //     const map = new Bmap("#myMap");
    //     map.startMap(lat, lon, "load", 15);

    //     // 現在地の住所を取る
    //     const location = map.setLocation(lat, lon);
    //     //const location = map.getCenter(); //MapCenter
    //     map.reverseGeocode(location, function(data) {
    //         // console.log(data);
    //         document.querySelector(".geocode").innerHTML = data;
    //     });
    //     // クリックしたところの住所を取る
    //     map.onGeocode("click", function(clickPoint) {
    //         map.reverseGeocode(clickPoint.location, function(data) {
    //             console.log(data);
    //             document.querySelector(".geocode").innerHTML = data;
    //         });
    //     });
    //     // //検索モジュール指定
    //     // Microsoft.Maps.loadModule('Microsoft.Maps.Search', function() {
    //     //     //searchManagerインスタンス化（Geocode,ReverseGeocodeが使用可能になる）
    //     //     searchManager = new Microsoft.Maps.Search.SearchManager(map);
    //     //     //Geocode：住所から検索
    //     //     geocodeQuery(document.getElementById("address").value);
    //     // });

    // }

    // // // ★住所から緯度経度割り出す！
    let map; //MapObject用
    let searchManager; //SearchObject用

    function GetMap() {
        //Map生成
        map = new Microsoft.Maps.Map('#myMap', {
            zoom: 15,
            mapTypeId: Microsoft.Maps.MapTypeId.load
        });
        //検索モジュール指定
        Microsoft.Maps.loadModule('Microsoft.Maps.Search', function() {
            //searchManagerインスタンス化（Geocode,ReverseGeocodeが使用可能になる）
            searchManager = new Microsoft.Maps.Search.SearchManager(map);
            //Geocode：住所から検索
            geocodeQuery(document.getElementById("address").value);
        });
    }

    // /**
    //  * 住所の入力が行われた時の処理
    //  */
    window.addEventListener('DOMContentLoaded', function(){
        // input要素を取得
        var input_name = document.getElementById("address");
        
        // 住所の入力変更が起きたら緯度経度取得
        input_name.addEventListener("change",function(){
                geocodeQuery(this.value);
                console.log("Change action");
                console.log(this.value);
                console.log(document.getElementById("address").value);
        });
    });

    // /**
    //  * 住所から緯度経度を取得
    //  * @param query [住所文字列]
    //  */
    function geocodeQuery(query) {
        if (searchManager) {
            //住所から緯度経度を検索
            searchManager.geocode({
                where: query, //検索文字列
                callback: function(r) { //検索結果を"( r )" の変数で取得
                    //最初の検索取得結果をMAPに表示
                    if (r && r.results && r.results.length > 0) {
                        //Pushpinを立てる
                        const pin = new Microsoft.Maps.Pushpin(r.results[0].location);
                        map.entities.push(pin);
                        //map表示位置を再設定
                        map.setView({
                            bounds: r.results[0].bestView
                        });
                        //取得た緯度経度をh1要素にJSON文字列にして表示
                        // console.log(r.results[0].location);

                        console.log(r.results[0].location.latitude);
                        console.log(r.results[0].location.longitude);

                        document.getElementById("lat").value = JSON.stringify(r.results[0].location
                            .latitude);
                        document.getElementById("lon").value = JSON.stringify(r.results[0].location
                            .longitude);
                    }
                },
                errorCallback: function(e) {

                    console.log("見つかりません");
                }
            });
        }
    }
    </script>

    <!-- マップ参考：https://mapapi.org/ -->

<?php
include("include/footer.php");
?>
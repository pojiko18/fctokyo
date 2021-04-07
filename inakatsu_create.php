<?php
session_start();
include("funcs.php");
loginCheck();
$u_id =$_SESSION["id"];

?>



<body>


    <?php
    $title = "蝗活　報告作成ページ";
    $addhead ='<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">';
    include("include/header.php");
?>

    <!-- ここに現在地の緯度経度を取る -->
    <!-- <div id="status"></div> -->

    <form method="post" action="inakatsu_act.php" enctype="multipart/form-data" id="send_file">
        <dl class="form-inner">
            <dt class="form-title">画像選択</dt>
            <dd class="form-item"><input type="file" id="myfile" accept="image/*" capture="camera" name="upfile">
                <img id="img1" style="width:300px;height:300px;" />
            <dt class="form-title">お店の名前</dt>
            <dd class="form-item"><input type="text" name="name" class="rediTextForm"></dd>
            <dt class="form-title">お店の情報（URL）</dt>
            <dd class="form-item"><input type="text" name="url" class="rediTextForm"></dd>
            <dt class="form-title">画像のメニュー名（商品名）</dt>
            <dd class="form-item"><input type="text" name="nemu" class="rediTextForm"></dd>

            <dt class="form-title">値段</dt>
            <dd class="form-item"><input type="text" name="price" class="rediTextForm"></dd>

            <dt class="form-title">感想</dt>
            <dd class="form-item"><textArea name="kansou" rows="5" cols="55"></textArea></label></dd>
            <dt class="form-title">おすすめ度</dt>
            <dd class="form-item">
                <input type="radio" name="rating" value="★"><i></i>
                <input type="radio" name="rating" value="★★"><i></i>
                <input type="radio" name="rating" value="★★★"><i></i>
                <input type="radio" name="rating" value="★★★★"><i></i>
                <input type="radio" name="rating" value="★★★★★"><i></i>
            </dd>
            <input type="hidden" id="lat" name="lat">
            <input type="hidden" id="lon" name="lon">
            <input type="hidden" name="file_upload_flg" value="1">
            <!-- <input type="file" accept="image/*" capture="camera" id="image_file" value="" name="upfile"
                style="opacity:0;">
            <input type="hidden" name="file_upload_flg" value="1"> -->
        </dl>
        <p class="btn-c">
            <input type="submit" value="作成する" class="submit">
        </p>
    </form>
    </div>


    <?php
include("footer.php");
?>

    <!-- Javascript -->
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script>
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
                };
            })(file);
            reader.readAsDataURL(file);

        });
    });



    /**
     * Geolocation（緯度・経度）
     */
    navigator.geolocation.watchPosition( //getCurrentPosition :or: watchPosition
        // 位置情報の取得に成功した時の処理
        function(position) {
            try {
                var lat = position.coords.latitude; //緯度
                var lon = position.coords.longitude; //経度
                $("#lat").val(lat);
                $("#lon").val(lon);
                $("#status").html("緯度・経度、取得完了");

                console.log(lat);
                console.log(lon);
            } catch (error) {
                console.log("getGeolocation: " + error);
            }
        },
        // 位置情報の取得に失敗した場合の処理
        function(error) {
            var e = "";
            if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
                e = "位置情報が許可されてません";
            }
            if (error.code == 2) { //2＝現在地を特定できない
                e = "現在位置を特定できません";
            }
            if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
                e = "位置情報を取得する前にタイムアウトになりました";
            }
            $("#status").html("エラー：" + e);

        }, {
            // 位置情報取得オプション
            enableHighAccuracy: true, //より高精度な位置を求める
            maximumAge: 20000, //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
            timeout: 10000 //10秒以内に現在地情報を取得できなければ、処理を終了
        }
    );
    </script>
</body>
<?php
session_start();
include("funcs.php");
loginCheck();

?>

<body>


    <?php
$title = "蝗活　報告作成ページ";
$addhead ='<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">';
include("include/header.php");
?>


    <form method="post" action="inakatsu_act.php" class="form" enctype="multipart/form-data">
        <h2>イベント作成</h2>
        <div class="loginField">
            <dl class="form-inner">
                <dt class="form-title">お店の名前</dt>
                <dd class="form-item"><input type="text" name="name" class="rediTextForm">

                <dt class="form-title">サムネイル画像</dt>
                <dd class="form-item">
                    <!-- 画像を入れる -->
                    <input type="file" accept="image/*" capture="camera" name="upfile">
                    <p>※プレビューはでません</p>
                </dd>
                <br>
                <dt class="form-title">お店の情報（URL）</dt>
                <dd class="form-item"><input type="text" name="url" class="rediTextForm">
                <dt class="form-title">画像のメニュー名（商品名）</dt>
                <dd class="form-item"><input type="text" name="nemu" class="rediTextForm">

                <dt class="form-title">値段</dt>
                <dd class="form-item"><input type="text" name="price" class="rediTextForm">

                <dt class="form-title">感想</dt>
                <dd class="form-item"><textArea name="kansou" rows="5" cols="55"></textArea></label>
                <dt class="form-title">おすすめ度</dt>
                <dd class="form-item">
                    <div class="star-rating">
                        <input type="radio" name="rating" value="★"><i></i>
                        <input type="radio" name="rating" value="★★"><i></i>
                        <input type="radio" name="rating" value="★★★"><i></i>
                        <input type="radio" name="rating" value="★★★★"><i></i>
                        <input type="radio" name="rating" value="★★★★★"><i></i>
                    </div>
                </dd>
            </dl>
            <p class="btn-c">
                <input type="submit" value="作成する" class="btn">
            </p>
        </div>
    </form>

    <?php
include("footer.php");
?>
</body>
<?php 

session_start();
include("funcs.php");
//loginCheck();

//GETでid値を取得
//$id =$_SESSION["id"];

?>

<?php
$title = "FC共闘";
include("include/header.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="main" id="main">
    <!-- Main Section-->
    <div class="hero-section">
        <div class="container nopadding">
            <div class="col-md-12">
                <div class="hero-content text-center">
                    <h1 class="wow fadeInUp" data-wow-delay="0.1s">クラブと<br class="pc-none">サポーターが<br>
                        <span class="text-danger text-shadow-white">共</span>に<span class="text-danger text-shadow-white">闘</span>う<br class="pc-none">新たる世界へ</h1>
                    <p><a href="reg.php" class="btn btn-danger btn-block btn-lg wow fadeInUp">新規会員登録</a></p>
                    <p><a href="login.php" class="btn btn-outline-danger btn-block btn-lg wow fadeInUp">ログイン</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("include/footer.php");
?>
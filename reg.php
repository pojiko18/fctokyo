<?php
$title = "新規会員登録";
include("include/header.php");
?>

<!-- Main[Start] -->
<div class="container">
    <div class="card form-register my-5">
        <div class="card-header">
            <h1 class="h3 font-weight-normal text-center">新規会員登録</h1>
        </div>
        <div class="card-body">
            <form method="post" action="user_insert.php" enctype="multipart/form-data" class="form">
                <div class="form-group">
                    <label for="reg-name" class="form-title">ユーザー名</label>
                    <input type="text" name="name" class="form-control rediTextForm" id="reg-name">
                </div>
                <div class="form-group">
                    <label for="reg-mail" class="form-title">メールアドレス</label>
                    <input type="text" name="lid" class="form-control rediTextForm" id="reg-mail">
                </div>
                <div class="form-group">
                    <label for="reg-password" class="form-title">パスワード（6文字以上 半角英数字）</label>
                    <input type="password" name="lpw" class="form-control rediTextForm" minlength="6"
                        pattern="[a-zA-Z0-9]+" id="reg-password">
                </div>
                <p class="btn-c">
                    <input type="submit" value="登録" class="btn btn-primary btn-block">
                </p>
                <!-- <div class="center"><a href="login.php">▶ログイン画面に戻る</a></div> -->
            </form>
        </div>
    </div>
</div>
<!-- Main[End] -->
<?php
include("include/footer.php");
?>
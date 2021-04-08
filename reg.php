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
            <form method="post" action="user_insert.php" enctype="multipart/form-data" class="form needs-validation" novalidate>
                <div class="form-group">
                    <label for="reg-name" class="form-title">ユーザー名</label>
                    <input type="text" name="name" class="form-control rediTextForm" id="reg-name" required>
                    <div class="invalid-feedback">
                        ユーザー名を入力してください。
                    </div>
                </div>
                <div class="form-group">
                    <label for="reg-mail" class="form-title">メールアドレス</label>
                    <input type="text" name="lid" class="form-control rediTextForm" id="reg-mail" required>
                    <div class="invalid-feedback">
                        メールアドレスを入力してください。
                    </div>
                </div>
                <div class="form-group">
                    <label for="reg-password" class="form-title">パスワード（6文字以上 半角英数字）</label>
                    <input type="password" name="lpw" class="form-control rediTextForm" minlength="6"
                        pattern="[a-zA-Z0-9]+" id="reg-password" required>
                    <div class="invalid-feedback">
                        パスワードを入力してください。
                    </div>
                </div>
                <p class="btn-c">
                    <input type="submit" value="登録" class="btn btn-primary btn-block">
                </p>
                <!-- <div class="center"><a href="login.php">▶ログイン画面に戻る</a></div> -->
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
</div>
<!-- Main[End] -->
<?php
include("include/footer.php");
?>
<?php
$title = "運営ログイン";
include("include/header_owner.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="container">
    <div class="card form-register mt-5">
        <div class="card-header">
            <h1 class="h3 font-weight-normal text-center">スタッフ ログイン</h1>
        </div>
        <div class="card-body">
            <form method="post" action="owner_login_act.php" class="form form-signin">

                <label for="lid" class="sr-only">ID</label>
                <input type="text" name="lid" class="rediTextForm form-control" placeholder="ID">
                <label for="lpw" class="sr-only">パスワード</label>
                <input type="password" name="lpw" class="rediTextForm form-control mb-4" placeholder="パスワード"
                    minlength="6" pattern="[a-zA-Z0-9]+">
                <p>
                    <input type="submit" name="login" value="ログインする" id="btn" class="btn btn-lg btn-primary btn-block">
                </p>
            </form>
        </div>
    </div>
</div>

<!-- Main[End] -->
<?php
include("include/footer_owner.php");
?>
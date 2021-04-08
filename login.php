<?php
session_start();
$err =$_SESSION;

$_SESSION = array();
session_destroy();
?>

<?php
$title = "ログイン";
include("include/header.php");
?>


<!-- Main[Start] -->
<div class="container">
    <div class="card form-register my-5">
        <div class="card-header">
            <h1 class="h3 font-weight-normal text-center">ログイン</h1>
        </div>
        <div class="card-body">

            <form method="post" action="login_act.php" class="form form-signin">
                <?php if(isset($err['lid'])): ?>
                <p class="alert alert-danger"><?php echo $err['lid']; ?></p>
                <?php endif; ?>
                <?php if(isset($err['lpw'])): ?>
                <p class="alert alert-danger"><?php echo $err['lpw']; ?></p>
                <?php endif; ?>
                <label for="lid" class="sr-only">ID / メールアドレス</label>
                <input type="text" name="lid" class="lid form-control" placeholder="ID または メールアドレス">
                <label for="lpw" class="sr-only">パスワード</label>
                <input type="password" name="lpw" class="lpw form-control mb-4" placeholder="パスワード" minlength="6"
                    pattern="[a-zA-Z0-9]+">
                <p>
                    <input type="submit" name="login" value="ログインする" id="btn" class="btn btn-lg btn-primary btn-block">
                </p>
            </form>

        </div>
    </div>
</div>

<!-- Main[End] -->
<?php
include("include/footer.php");
?>
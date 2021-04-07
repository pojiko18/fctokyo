<?php
$title = "スタッフ登録";
include("include/header_owner.php");
?>


<!-- Head[End] -->

<!-- Main[Start] -->
<div class="container">
    <div class="card my-5">
        <div class="card-header">スタッフ登録</div>

        <div class="card-body">
            <form method="post" action="owner_insert.php" enctype="multipart/form-data" class="form staff-edit">
                <div class="form-group">
                    <label for="form-staff-name">ユーザー名</label>
                    <input id="form-staff-name" type="text" name="name" class="rediTextForm form-control">
                </div>
                <div class="form-group">
                    <label for="form-staff-id">ID</label>
                    <input id="form-staff-id" type="text" name="lid" class="rediTextForm form-control">
                </div>
                <div class="form-group">
                    <label for="form-staff-password">パスワード（6文字以上 半角英数字）</label>
                    <input id="form-staff-password" type="password" name="lpw" class="rediTextForm form-control"
                        minlength="6" pattern="[a-zA-Z0-9]+">
                </div>
                <p class="btn-c">
                    <input type="submit" value="登録" class="btn btn-primary">
                </p>
            </form>
        </div>
    </div>

</div>
<?php
include("include/footer_owner.php");
?>
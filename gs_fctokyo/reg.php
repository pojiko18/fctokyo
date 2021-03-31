<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
 <link rel="stylesheet" href="css/range.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- <link href="css/index.css" rel="stylesheet"> -->
  <link href="./css/select.css" rel="stylesheet">
  <link href="./css/login.css" rel="stylesheet">
  <link href="./css/style_sp.css" rel="stylesheet">
  <title>会員登録</title>
</head>
<body class="loginBody">

<!-- Head[Start] -->
<?php
include("l_header.php");
?>


<!-- Head[End] -->

<!-- Main[Start] -->
<div class="loginTitle">
  

<form method="post" action="user_insert.php" enctype="multipart/form-data" class="form">
<h2>ユーザー登録</h2>
  <div class="rediJumbotron">
    <dl class="form-inner">
      <dt class="form-title">ユーザー名</dt>
      <dd class="form-item"><input type="text" name="name" class="rediTextForm"></dd>
      <dt class="form-title">メールアドレス</dt>
      <dd class="form-item"><input type="text" name="lid" class="rediTextForm"></dd>
      <dt class="form-title">パスワード（6文字以上 半角英数字）</dt>
      <dd class="form-item"><input   type="password" name="lpw" class="rediTextForm" minlength="6" pattern="[a-zA-Z0-9]+"></dd>
    </dl>
    <p class="btn-c">
      <input type="submit" value="登録" class="btn">
    </p>
  </div>
<!-- <div class="center"><a href="login.php">▶ログイン画面に戻る</a></div> -->
</form>

</div>
<!-- Main[End] -->
<footer>created by pojico18 of G'sACADEMIY UNIT_SAPPORO_DEV1</footer>


</body>
</html>
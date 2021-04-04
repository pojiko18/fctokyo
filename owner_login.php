
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
 <link rel="stylesheet" href="css/range.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- <link href="css/index.css" rel="stylesheet"> -->
  <link href="./css/select.css" rel="stylesheet">
  <link href="./css/login.css" rel="stylesheet">
  <link href="./css/style_sp.css" rel="stylesheet">
<title>運営ログイン</title>
</head>
<body class="loginBody">

<!-- Head[Start] -->
<?php
include("l_header.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="loginTitle">
  <form method="post" action="owner_login_act.php"  class="form">
  <h2>スタッフ ログイン</h2>
    <div class="loginField">
      <dl class="form-inner">
        <dt class="form-title">ID / メードアドレス</dt>
        <dd class="form-item"><input type="text" name="lid" class="rediTextForm"></dd>
        <dt class="form-title">パスワード（6文字以上 半角英数字）</dt>
        <dd class="form-item"><input   type="password" name="lpw" class="rediTextForm" minlength="6" pattern="[a-zA-Z0-9]+"></dd>
      </dl>
      <p class="btn-c">
        <input type="submit" value="ログインする" class="btn">
      </p>
    </div>
  </form>

<!-- Main[End] -->
</div>
<footer>created by pojico18 of G'sACADEMIY UNIT_SAPPORO_DEV1</footer>

</body>
</html>



<?php
session_start();
$err =$_SESSION;

$_SESSION = array();
session_destroy();
?>

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
<title>ログイン</title>
</head>
<body class="loginBody">

<!-- Head[Start] -->
<?php
include("l_header.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div class="loginTitle">
  <form method="post" action="login_act.php"  class="form">
  <h2>ログイン</h2>
    <div class="loginField">
      <dl class="form-inner">
        <dt class="form-title">ID / メードアドレス</dt>
        <dd class="form-item"><input type="text" name="lid" class="lid"></dd>
        <?php if(isset($err['lid'])): ?>
        <p><?php echo $err['lid']; ?></p>
        <?php endif; ?>
        <dt class="form-title">パスワード（6文字以上 半角英数字）</dt>
        <dd class="form-item"><input   type="password" name="lpw" class="lpw" minlength="6" pattern="[a-zA-Z0-9]+"></dd>
        <?php if(isset($err['lpw'])): ?>
        <p><?php echo $err['lpw']; ?></p>
        <?php endif; ?>
      </dl>
      <p class="btn-c">
        <input type="submit" name="login" value="ログインする" id="btn">
      </p>
    </div>
  </form>

<!-- Main[End] -->
</div>
<footer>created by pojico18 of G'sACADEMIY UNIT_SAPPORO_DEV1</footer>


    
</script>

</body>
</html>




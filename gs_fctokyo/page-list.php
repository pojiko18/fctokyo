

<?php
$title = "ページ一覧";
include("include/header.php");
?>
<div class="container">
    <h1>ページ一覧</h1>

    <h2>ゲスト</h2>
    <ul>
        <li><a href="index.php">トップページ</a></li>
        <li><a href="reg.php">新規会員登録</a></li>
    </ul>

    <h2>ユーザー</h2>
    <ul>
        <li><a href="login.php">ログイン</a></li>
        <li><a href="y_event_list.php">イベントリスト</a></li>
        <li><a href="y_event_detail.php">イベント詳細</a></li>
        <li><a href="mypage.php">マイページ</a></li>
        <li><a href="mypage_edit.php">マイページ編集</a></li>
    </ul>

    <h2>オーナー</h2>
    <ul>
        <li><a href="owner_login.php">ログイン</a></li>
        <li><a href="event.php">イベント</a></li>
        <li><a href="dashboard.php">ダッシュボード</a></li>
        <li><a href="event_create.php">イベント作成</a></li>
        <li><a href="user_insert.php">スタッフ登録</a></li>
    </ul>
</div>
    
<?php
include("include/footer.php");
?>
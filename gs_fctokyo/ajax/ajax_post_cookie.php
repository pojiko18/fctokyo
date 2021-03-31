<?php
//ajax_post_cookie.php

//POSTパラメータを取得
$id   = $_POST["id"];
$mode = $_POST["mode"];
$type = $_POST["type"];

//echo "<div>あああああ</div><div>いいいいい</div><div>ううううう</div>";

$json = '[
    {
      "id":"'.$id.'",
      "mode":"'.$mode.'",
      "type":"'.$type.'"
    },
    {
     "id":"'.$id.'",
     "mode":"'.$mode.'",
     "type":"'.$type.'"
    }
]';

//作成したJSON文字列をリクエストしたファイルに返す
echo $json;
exit;
?>

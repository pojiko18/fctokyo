<?php
session_start();
include("funcs.php");
loginCheck();

//GETでid値を取得
$id =$_SESSION["id"];

//DB接続
$pdo = dbcon();

//SELECT * FROM gs_an_table WHERE id=:id;
$sql = "SELECT * FROM users WHERE user_id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  //１データのみ抽出の場合はwhileループで取り出さない
  $row = $stmt->fetch();
}


?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>マイページ編集</title>
 <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="./css/login.css" rel="stylesheet">
    <link href="./css/style_sp.css" rel="stylesheet">
    
</head>
<body>

<!-- Head[Start] -->
<?php
include("l_header.php");
?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <form action="mypage_update.php" method="post" enctype="multipart/form-data">
        <div id="status"><?=$row["user_name"]?>さんの編集フォーム</div>

        <dl class="form-inner">
            <dt class="form-title">アイコン画像</dt>
            <dd class="form-item">
            <!-- 画像を入れる -->
            <?php if($row["img"]==NULL|| $row["img"]== 1|| $row["img"]== 2){ ?> 
            <div><img src="./upload/kaonasi-icon.JPG" alt="" width="100"></div>
            <?php }else{?> 
            <div><img src="upload/<?=$row["img"]?>" width="100" name="upfile"></div>
            <?php } ?>

            <input type="file" accept="image/*" capture="camera" name="upfile">
            </dd>
            <br>
            <dt class="form-title">メールアドレス</dt>
            <dd class="form-item">
            <input type="text" name="email" class="book_input" value="<?=$row["email"]?>"><br>
            </dd>
            <!-- <input type="date" id="start" name="birthday"
            value="1990-01-01"
            min="1900-01-01" max="2100-12-31"> -->
        
            <label>生年月日</label>
            <select name="year">
            <?php if($row["year"] == 0){
                birthdayLoop('1920', date('Y'), $year);}else{
                birthdayLoop($row["year"], date('Y'), $year);
            } ?> 
            </select>年
            <select name="month">
            <?php if($row["month"] == 0){
                birthdayLoop('1', 12, $month);}else{
                birthdayLoop($row["month"],12, $month);
                }?> 
            </select>月
            <select name="day">
            <?php if($row["day"] == 0){
                birthdayLoop('1',31, $day);}
                else {
                birthdayLoop($row["day"],31, $day);
                } ?> 
            </select>日
            <dt class="form-title">居住地</dt>
            <dd class="form-item">
                <select name="pref">
                    <option value="" selected>
                    <?php if($row["address"] == NULL){
                        echo "選択してください</option>";
                    }else{
                        echo 
                        $row["address"];
                    }?>
                    
                    <option value="北海道">北海道</option>
                    <option value="青森県">青森県</option>
                    <option value="岩手県">岩手県</option>
                    <option value="宮城県">宮城県</option>
                    <option value="秋田県">秋田県</option>
                    <option value="山形県">山形県</option>
                    <option value="福島県">福島県</option>
                    <option value="茨城県">茨城県</option>
                    <option value="栃木県">栃木県</option>
                    <option value="群馬県">群馬県</option>
                    <option value="埼玉県">埼玉県</option>
                    <option value="千葉県">千葉県</option>
                    <option value="東京都">東京都</option>
                    <option value="神奈川県">神奈川県</option>
                    <option value="新潟県">新潟県</option>
                    <option value="富山県">富山県</option>
                    <option value="石川県">石川県</option>
                    <option value="福井県">福井県</option>
                    <option value="山梨県">山梨県</option>
                    <option value="長野県">長野県</option>
                    <option value="岐阜県">岐阜県</option>
                    <option value="静岡県">静岡県</option>
                    <option value="愛知県">愛知県</option>
                    <option value="三重県">三重県</option>
                    <option value="滋賀県">滋賀県</option>
                    <option value="京都府">京都府</option>
                    <option value="大阪府">大阪府</option>
                    <option value="兵庫県">兵庫県</option>
                    <option value="奈良県">奈良県</option>
                    <option value="和歌山県">和歌山県</option>
                    <option value="鳥取県">鳥取県</option>
                    <option value="島根県">島根県</option>
                    <option value="岡山県">岡山県</option>
                    <option value="広島県">広島県</option>
                    <option value="山口県">山口県</option>
                    <option value="徳島県">徳島県</option>
                    <option value="香川県">香川県</option>
                    <option value="愛媛県">愛媛県</option>
                    <option value="高知県">高知県</option>
                    <option value="福岡県">福岡県</option>
                    <option value="佐賀県">佐賀県</option>
                    <option value="長崎県">長崎県</option>
                    <option value="熊本県">熊本県</option>
                    <option value="大分県">大分県</option>
                    <option value="宮崎県">宮崎県</option>
                    <option value="鹿児島県">鹿児島県</option>
                    <option value="沖縄県">沖縄県</option>
                </select>
            </dd>
        </dl>
        <dt class="form-title">自己紹介</dt>
        <dd class="form-item">
            <textArea name="text" rows="4" cols="40"><?=$row["text"]?></textArea>
        </dd>
        <input type="hidden" name="id" value="<?=$row["user_id"]?>">
        <div class="submit">
            <input type="submit" value="変更">
        </div>
    </form>
</div>

<footer>created by pojico18 of G'sACADEMIY UNIT_SAPPORO_DEV1</footer>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
//登録ボタンをクリック
$("#btn").on("click",function() {
    //axiosでAjax送信
    //Ajax（非同期通信）
    const params = new URLSearchParams();
    params.append('email',  $("#email").val());
    params.append('year', $("#year").val());
    params.append('text',$("#text").val());

    //axiosでAjax送信
    axios.post('insert.php',params).then(function (response) {
        //console.log(typeof response.data);//通信OK
        if(response.data==true){
        document.querySelector("#status").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);//通信Error
    }).then(function () {
        console.log("Last");//通信OK/Error後に処理を必ずさせたい場合
    });
});
</script>
</body>
</html>
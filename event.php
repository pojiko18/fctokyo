<?php
session_start();
include("funcs.php");
loginCheck();

?>
<?php
$title = "イベント作成";
include("include/header_owner.php");
?>
<div class="container">
    <div class="card my-5">
        <div class="card-header">イベント作成</div>

        <div class="card-body">
            <form method="post" action="event_create.php" class="form event-edit" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="form-event-title">イベント タイトル</label>
                    <input id="form-event-title" type="text" name="title" class="rediTextForm form-control">
                </div>
                <div class="form-group">
                    <label for="form-event-image">サムネイル画像</label>
                    <!-- 画像を入れる -->
                    <input id="form-event-image" type="file" accept="image/*" capture="camera" name="upfile"
                        class="form-control-file" aria-describedby="imageHelpBlock">
                        <small id="imageHelpBlock" class="form-text text-muted">
                    ※800px x 480px の画像を使用すると綺麗に表示されます。<br>
                    ※この画面ではプレビューは表示されません</small>
                </div>
                <div class="form-group">
                    <label for="form-event-day">開催日</label><br>
                    <select id="form-event-day" name="year">
                        <option value="">-</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                    </select>年

                    <select name="month">
                        <option value="">-</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>月

                    <select name="day">
                        <option value="">-</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>日

                </div>
                <div class="form-group">
                    <label class="form-event-time">時間</label>
                    <input id="form-event-time" type="text" name="time" class="rediTextForm form-control">
                </div>
                <div class="form-group">
                    <label for="form-event-place" class="form-title">場所</label>
                    <input id="form-event-place" type="text" name="place" class="rediTextForm form-control">
                </div>
                <div class="form-group">
                    <label for="form-event-contents">内容</label>
                    <textArea id="form-event-contents" name="contents" rows="5" cols="55" class="form-control"></textArea></label>
                </div>
                <div class="form-group">
                    <label for="form-event-password">合言葉</label>
                    <input id="form-event-password" type="text" name="password" class="rediTextForm form-control">
                </div>
                <div class="form-group">
                    <label for="form-event-point">ポイント数</label>
                    <input id="form-event-point" aria-describedby="pointHelpBlock" type="text" name="point" class="rediTextForm form-control">
                    <small id="pointHelpBlock" class="form-text text-muted">
                    <strong>ポイント数目安</strong><br>
                    試合スタジアム観戦：100p<br>
                    試合オンライン観戦：50p<br>
                    有料イベント：50p<br>
                    無料イベント：10p<br>
                    </small>
                </div>
                <p class="btn-c">
                    <input type="submit" value="作成する" class="btn btn-primary">
                </p>
        </div>
        </form>
    </div>
</div>

</div>
<?php
include("include/footer_owner.php");
?>
<?php
session_start();
include("funcs.php");
loginCheck();

?>
<body>
  <?php
include("l_header.php");
?>
<div>ポイント数目安</div>
<p>試合スタジアム観戦：100ｐ</p>
<p>試合オンライン観戦：50ｐ</p>
<p>有料イベント：50ｐ</p>
<p>無料イベント10ｐ</p>


<form method="post" action="event_create.php"  class="form">
  <h2>イベント作成</h2>
    <div class="loginField">
      <dl class="form-inner">
        <dt class="form-title">イベント タイトル</dt>
        <dd class="form-item"><input type="text" name="title" class="rediTextForm">
        
      
    <dt class="form-title">開催日</dt>
    <dd class="form-item">
        <select name="year">
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
            </select>　年

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
            </select>　月

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
            </select>　日
        <p>カレンダー</p>
            <input type="date" name="calendar" max="9999-12-31">
    </dd>
    <dt class="form-title">時間</dt>
    <dd class="form-item"><input type="text" name="time" class="rediTextForm">
    <dt class="form-title">場所</dt>
    <dd class="form-item"><input type="text" name="place" class="rediTextForm">
    <dt class="form-title">内容</dt>
    <dd class="form-item"><textArea name="contents" rows="5" cols="55"></textArea></label>
    <dt class="form-title">合言葉</dt>
    <dd class="form-item"><input type="text" name="password" class="rediTextForm">
    <dt class="form-title">ポイント数</dt>
    <dd class="form-item"><input type="text" name="point" class="rediTextForm">
    </dl>
      <p class="btn-c">
        <input type="submit" value="作成する" class="btn">
      </p>
    </div>
  </form>

<?php
include("footer.php");
?>
</body>
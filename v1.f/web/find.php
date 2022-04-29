<?php

$html = <<< HEREDOC
<h2>查詢 (包含在中英文片名裡的資料)</h2>
<form method="post" action="find_by.php">
    <p>
      片名：<input type="text" name="key" size="10" required>
      <input type="submit" value="查詢">
    </p>
</form>
<p>&nbsp;</p>

<hr />

<p>&nbsp;</p>
<h2>待看影片</h2>
<p><a href="list_by.php?type=REMARK&key=待看">列出待看的影片 (remark 欄位中有『待看』字樣)</a></p>
<p>&nbsp;</p>

<hr />

<h2>查看特定的主題</h2>
<p>(即 tag_note 以!開頭，由網站管理員自己設定)</p>
<p>
| <a href="list_by.php?type=TOPIC&key=奧斯卡最佳影片">奧斯卡最佳影片 
| <a href="list_by.php?type=TOPIC&key=奧斯卡最佳導演">奧斯卡最佳導演</a>
|
</p>
<p>
| <a href="list_by.php?type=TOPIC&key=漫威">漫威</a>
| <a href="list_by.php?type=TOPIC&key=007">007</a>
|
</p>
<p>
| <a href="list_by.php?type=TOPIC&key=名偵探柯南">名偵探柯南</a>
| <a href="list_by.php?type=TOPIC&key=皮克斯">皮克斯</a>
| <a href="list_by.php?type=TOPIC&key=迪士尼">迪士尼</a>
|
</p>
<p>&nbsp;</p>
<hr />

<h2>各種統計</h2>
<a href="stat_by.php?type=STAT1">統計YEAR</a>
<a href="stat_by.php?type=STAT2">統計AREA</a> 
<a href="stat_by.php?type=STAT3">統計RATE</a> 

<h2>各種統計 (包含圖表顯示)</h2>
<a href="stat_by_year.php">年度圖表</a>
<a href="stat_by_area.php">地區圖表</a>
<a href="stat_by_rate.php">評分圖表</a>
<p>&nbsp;</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=h1, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>我看過的電影</h1>
<p><a href="list_all.php">list_all.php 列出資料 (全部)</a></p>
<p><a href="list_page.php">list_page.php 列出資料 (分頁)---可用在前台網頁</a></p>
<p><a href="all_cast.php">all_cast.php 列出所有的人員</a>---可用在前台網頁</p>
<p><a href="all_note.php">all_cast.php 列出所有的標籤</a>---可用在前台網頁</p>

<h2>以下必須指定傳入參數</h2>
<p><a href="list_by_cast.php">list_by_cast.php 列出某人員的資料 (傳入參數 cast)</a></p>
<p><a href="list_by_note.php">list_by_note.php 列出某標籤的資料 (傳入參數 note)</a></p>

<h2>將多支類似程式合併一起</h2>
<p><a href="list_by.php">list_by.php 列出某某某資料</a> (傳入 type 及 key)---可用在前台網頁</p>
<ul>
    <li><a href="list_by.php?type=YEAR&key=2022">YEAR 列出某年度</a></li>
    <li><a href="list_by.php?type=AREA&key=台">AREA 列出某國家</a></li>
    <li><a href="list_by.php?type=RATE&key=10">RATE 列出某評分</a></li>
    <li><a href="list_by.php?type=DIRECT&key=李安">DIRECT 列出某導演</a></li>
    <li><a href="list_by.php?type=PLAYER&key=王淨">PLAYER 列出某演員</a></li>
    <li><a href="list_by.php?type=SERIAL&key=蝙蝠俠">SERIAL 列出某系列</a></li>
    <li><a href="list_by.php?type=TOPIC&key=奧斯卡最佳影片">TOPIC 列出某主題</a></li>
    <li><a href="list_by.php?type=NOTE&key=時空穿越">NOTE 列出某標籤</a></li>
</ul>

<hr/>

<h2>工具程式</h2>
<ul>
    <li><a href="get_omdb.php?imdb=tt6710474">OMDB API</a></li>
    <li><a href="batch_get_omdb_poster.php">batch_get_omdb_poster.php 批次抓 OMDB 的圖並存檔</a> (執行後要等一陣子才會回應)</li>
</ul>

</body>
</html>
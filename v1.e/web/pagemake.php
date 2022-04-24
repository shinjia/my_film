<?php

function pagemake($content='', $head='', $js_after='')
{  
  $html = <<< HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>基本資料庫系統</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="style.css" rel="stylesheet">

{$head}
</head>
<body>

<div class="container">
  <div class="header">
    <h1>我的看電影資料</h1>
  </div>
  
  <div class="nav">     
      <a href="index.php" target="_top">首頁</a>
      <a href="page.php?code=note2">說明</a> 
      <a href="list_page.php">資料列表</a> 
      <a href="all_cast.php">所有人員</a> 
      <a href="all_note.php">所有標籤</a> 
      <a href="find.php">查詢</a> 
      <br/>
          <a href="stat_by.php?type=STAT1">統計YEAR</a>
          <a href="stat_by.php?type=STAT2">統計AREA</a> 
          <a href="stat_by.php?type=STAT3">統計RATE</a> 
      <a href="stat_by_year.php">年度圖表</a>
      <a href="stat_by_area.php">地區圖表</a>
      <a href="stat_by_rate.php">評分圖表</a>
   </div>
  
   <div class="main">
    {$content}
   </div>

   <div class="footer">
     <p>版權聲明</p>
   </div>

</div>

{$js_after}
</body>
</html>  
HEREDOC;

echo $html;
}

?>
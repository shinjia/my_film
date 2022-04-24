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

<style type="text/css">
* {
  margin: 0px;
}

div.container {
  padding: 10px;
  margin: 0 auto;
  width: 760px;
}

div#header {
  padding: 10px;
  background-color: #AAEEAA; 
}

div#nav {
  padding: 10px;
  background-color: #FFAA33; 
}


div#main {
  padding: 10px;
  background-color: #33AAFF; 
}

div#footer {
  padding: 10px;
  background-color: #AAAA33; 
  text-align: center;
}

</style>

{$head}
</head>
<body>

<div class="container">
   <div id="header">
      <h1>我的電影</h1>
   </div>
  
   <div id="nav">     
      | <a href="index.php" target="_top">首頁</a>
      | <a href="page.php?code=note">說明</a> 
      | <a href="list_page.php">資料列表</a> 
      | <a href="all_cast.php">所有人員</a> 
      | <a href="all_note.php">所有標籤</a> 
      | <a href="find.php">查詢</a> 
      | <br/>
      | 統計
          [<a href="stat_by.php?type=STAT1">YEAR</a>] 
          [<a href="stat_by.php?type=STAT2">AREA</a>] 
          [<a href="stat_by.php?type=STAT3">RATE</a>] 
      | <a href="stat_by_year.php">年度圖表</a>
      | <a href="stat_by_area.php">地區圖表</a>
      | <a href="stat_by_rate.php">評分圖表</a>
      |
   </div>
  
   <div id="main">
    {$content}
   </div>

   <div id="footer">
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
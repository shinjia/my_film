<?php
$html = <<< HEREDOC
<h2>各種統計</h2>
<a href="stat_by.php?type=STAT1">統計YEAR</a>
<a href="stat_by.php?type=STAT2">統計AREA</a> 
<a href="stat_by.php?type=STAT3">統計RATE</a> 

<h2>各種統計 (包含圖表顯示)</h2>
<a href="stat_by_year.php">年度圖表</a>
<a href="stat_by_area.php">地區圖表</a>
<a href="stat_by_rate.php">評分圖表</a>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
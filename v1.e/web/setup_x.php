<?php
$numpp = isset($_GET['numpp']) ? $_GET['numpp'] : 12;
$showtype = isset($_GET['showtype']) ? $_GET['showtype'] : 1;

setcookie('numpp', $numpp, time()+86400*30);
setcookie('showtype', $showtype, time()+86400*30);

$html = <<< HEREDOC
<h2>設定完成</h2>
<p>每頁顯示筆數：{$numpp}</p>
<p>顯示風格：{$showtype}</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
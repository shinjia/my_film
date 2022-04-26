<?php
$numpp = isset($_GET['numpp']) ? $_GET['numpp'] : 12;

setcookie('numpp', $numpp, time()+86400*30);

$html = <<< HEREDOC
<h2>設定完成</h2>
<p>每頁顯示筆數：{$numpp}</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
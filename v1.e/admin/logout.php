<?php
session_start();

unset($_SESSION["usertype"]);
unset($_SESSION["usercode"]);


$html = <<< HEREDOC
已登出
<BR><a href="index.php">按此處回首頁</a>

HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>
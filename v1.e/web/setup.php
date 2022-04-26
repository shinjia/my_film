<?php

$html = <<< HEREDOC
<form method="get" action="setup_x.php">
<p>設定頁顯示筆數：<input type="text" name="numpp"></p>
<p><input type="submit" value="Setup"></p>

</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
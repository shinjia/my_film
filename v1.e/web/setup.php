<?php

$html = <<< HEREDOC
<form method="get" action="setup_x.php">
<p>
設定頁顯示筆數：<input type="text" name="numpp">
<input type="submit" value="Setup">
</p>

<p>
設定顯示風格：
<input type="radio" name="showtype" value="1"> 海報
<input type="radio" name="showtype" value="2"> 精簡
<input type="submit" value="Setup">
</p>

</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
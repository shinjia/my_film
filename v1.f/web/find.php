<?php

$html = <<< HEREDOC
<form method="post" action="find_by.php">
    <p>
      片名：<input type="text" name="key" size="10" required>
      <input type="submit" value="查詢">
    </p>
</form>
<p>&nbsp;</p>

<hr />

<p>&nbsp;</p>
<p><a href="list_by.php?type=REMARK&key=待看">列出待看的影片</a></p>
<p>&nbsp;</p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
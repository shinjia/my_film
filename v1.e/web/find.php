<?php

$html = <<< HEREDOC
<form method="post" action="find_by.php">
    <p>
      片名：<input type="text" name="key" size="10" required>
      <input type="submit" value="查詢">
    </p>
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
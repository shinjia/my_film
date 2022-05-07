<?php

$html = <<< HEREDOC
<h1>管理者登入</h1>
<form name="form1" method="post" action="login_check.php">
帳號：<input type="text"     name="usercode" size="10"><br>
密碼：<input type="password" name="password" size="10">
<br>
<input type="submit" value="登入">
</form>
<HR>
<p>注意：此範例之帳號及密碼定義在『user_password.txt』內，且密碼經過md5()函式的編碼保護。</p>
HEREDOC;


include 'pagemake.php';
pagemake($html, '');
?>
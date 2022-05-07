<?php
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = DEF_LOGIN_ADMIN;
$ss_usercode = isset($_POST["usercode"]) ? $_POST["usercode"] : "";
$ss_password = isset($_POST["password"]) ? $_POST["password"] : "";


// 假設用戶資料 (資料存於文字檔)
// 可自行定義存檔的格式
$file_password = "user_password.txt";   // 存帳號及密碼的文字檔
$a_chk_list = file($file_password);


// 會員檢查，注意格式
$chk_string  = "!" . $ss_usercode . "#" . md5($ss_password) . "@" . $ss_usertype;
$chk_string .= "\n";   // 用file讀入的資料後面會多出符號 (Windows:\n; Linux: \r\n)

$valid = false; 
if(in_array($chk_string, $a_chk_list))
{
   $valid = true;
   $_SESSION["usertype"] = DEF_LOGIN_ADMIN;
   $_SESSION["usercode"] = $ss_usercode;
}
else
{
   $_SESSION["usertype"] = "";
   $_SESSION["usercode"] = "";
}


if($valid)
{
   $msg = $ss_usercode . ' 你好，歡迎光臨！ ';
}
else
{
   $msg = '登入錯誤';
}



$html = <<< HEREDOC
<p>{$msg}</p>
<br><br>
<br>
HEREDOC;


include 'pagemake.php';
pagemake($html, '');
?>
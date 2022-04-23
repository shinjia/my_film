<?php
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = isset($_SESSION["usertype"]) ? $_SESSION["usertype"] : "";
$ss_usercode = isset($_SESSION["usercode"]) ? $_SESSION["usercode"] : "";


if($ss_usertype!=DEF_LOGIN_ADMIN)
{
   header("Location: error.php");
   exit;
}

//*****以上是權限控管 *****




$html = <<< HEREDOC
<h2>資料管理系統</h2>
<p><a href="list_page.php">分頁列表</a></p>
<hr>

<h2>工具程式</h2>
<ul>
    <li><a href="check_data_poster.php">check_data_poster.php 檢查沒有圖檔的記錄</a></li>
</ul>

<h2>測試網頁</h2>
<p>
<br><a href="login.php">重新登入</a>
<br><a href="logout.php">登出</a>
</p>

<p></p>
HEREDOC;


include 'pagemake.php';
pagemake($html, '');
?>
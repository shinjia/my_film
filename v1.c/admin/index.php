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
<h2>資料管理系統─PDO-STH版本</h2>
<p><a href="list_page.php">分頁列表</a></p>
<p><a href="manage.php?op=LIST_PAGE">分頁列表 (manage.php 全集中一支程式之寫法)</a></p>
<hr>
<p><a href="find.php">查詢姓名 (全部顯示版本)</a></p>
<p><a href="findp.php">查詢姓名 (分頁顯示版本)</a></p>
<hr>




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
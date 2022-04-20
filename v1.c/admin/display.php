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



$uid = isset($_GET['uid']) ? $_GET['uid'] : 0;

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM film WHERE uid=? ";

$sth = $pdo->prepare($sqlstr);
$sth->bindValue(1, $uid, PDO::PARAM_INT);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   if($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $uid = $row['uid'];
      $filmyear = convert_to_html($row['filmyear']);
      $pub_date = convert_to_html($row['pub_date']);
      $title_c  = convert_to_html($row['title_c']);
      $title_e  = convert_to_html($row['title_e']);
      $area     = convert_to_html($row['area']);
      $rate     = convert_to_html($row['rate']);
      $key_wiki = convert_to_html($row['key_wiki']);
      $key_imdb = convert_to_html($row['key_imdb']);
      $key_dban = convert_to_html($row['key_dban']);
      $key_note = convert_to_html($row['key_note']);
      $tag_cast = convert_to_html($row['tag_cast']);
      $tag_note = convert_to_html($row['tag_note']);
      $remark   = convert_to_html($row['remark']);
   
      $data = <<< HEREDOC
      <table class="table">
         <tr><th>年度</th><td>{$filmyear}</td></tr>
         <tr><th>首映日</th><td>{$pub_date}</td></tr>
         <tr><th>片名</th><td>{$title_c}</td></tr>
         <tr><th>英名片名</th><td>{$title_e}</td></tr>
         <tr><th>國家</th><td>{$area}</td></tr>
         <tr><th>評分</th><td>{$rate}</td></tr>
         <tr><th>key_Wiki</th><td>{$key_wiki}</td></tr>
         <tr><th>key_IMDb</th><td>{$key_imdb}</td></tr>
         <tr><th>key_豆瓣</th><td>{$key_dban}</td></tr>
         <tr><th>key_筆記</th><td>{$key_note}</td></tr>
         <tr><th>tag_人員</th><td>{$tag_cast}</td></tr>
         <tr><th>tag_主題</th><td>{$tag_note}</td></tr>
         <tr><th>備註</th><td>{$remark}</td></tr>
      </table>
HEREDOC;
   }
   else
   {
 	   $data = '查不到相關記錄！';
   }
}
else

{
   // 無法執行 query 指令時
   $data = error_message('display');
}


$html = <<< HEREDOC
<button class="btn btn-primary" onclick="location.href='list_page.php';">返回列表</button>
{$data}
HEREDOC;
 
include 'pagemake.php';
pagemake($html, '');
?>
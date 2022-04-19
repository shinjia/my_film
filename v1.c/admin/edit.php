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
      <form action="edit_save.php" method="post">
      <table>
         <tr><th>年度</th><td><input type="text" name="filmyear" value="{$filmyear}"></td></tr>
         <tr><th>首映日期</th><td><input type="text" name="pub_date" value="{$pub_date}"></td></tr>
         <tr><th>片名</th><td><input type="text" name="title_c" value="{$title_c}"></td></tr>
         <tr><th>英文片名</th><td><input type="text" name="title_e" value="{$title_e}"></td></tr>
         <tr><th>國家</th><td><input type="text" name="area" value="{$area}"></td></tr>
         <tr><th>評分</th><td><input type="text" name="rate" value="{$rate}"></td></tr>
         <tr><th>key-維基</th><td><input type="text" name="key_wiki" value="{$key_wiki}"></td></tr>
         <tr><th>key-IMDb</th><td><input type="text" name="key_imdb" value="{$key_imdb}"></td></tr>
         <tr><th>key-豆瓣</th><td><input type="text" name="key_dban" value="{$key_dban}"></td></tr>
         <tr><th>key-筆記</th><td><input type="text" name="key_note" value="{$key_note}"></td></tr>
         <tr><th>tag-人員</th><td><input type="text" name="tag_cast" value="{$tag_cast}"></td></tr>
         <tr><th>tag-note</th><td><input type="text" name="tag_note" value="{$tag_note}"></td></tr>
         <tr><th>備註</th><td><input type="text" name="remark" value="{$remark}"></td></tr>
      </table>
      <p>
        <input type="hidden" name="uid" value="{$uid}">
        <input type="submit" value="送出">
      </p>
      </form>
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
   $data = error_message('edit');
}


$html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>修改資料</h2>
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>
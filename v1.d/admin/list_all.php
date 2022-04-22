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


// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM film ";

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   $total_rec = $sth->rowCount();
   $data = '';
   while($row = $sth->fetch(PDO::FETCH_ASSOC))
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
    
      $data .= <<< HEREDOC
       <tr>
          <td>{$filmyear}</td>
          <td>{$pub_date}</td>
          <td>{$title_c}</td>
          <td>{$title_e}</td>
          <td>{$area}</td>
          <td>{$rate}</td>
          <td>{$remark}</td>
          <td><a href="display.php?uid={$uid}">詳細</a></td>
          <td><a href="edit.php?uid={$uid}">修改</a></td>
          <td><a href="delete.php?uid={$uid}" onClick="return confirm('確定要刪除嗎？');">刪除</a></td>
       </tr>
HEREDOC;
   }
   
   $html = <<< HEREDOC
   <h2 align="center">共有 {$total_rec} 筆記錄</h2>
   <table border="1" align="center">
      <tr>
         <th>年度</th>
         <th>首映日</th>
         <th>片名</th>
         <th>英名片名</th>
         <th>國家</th>
         <th>評分</th>
         <th>備註</th>
         <th colspan="3" align="center"><a href="add.php">新增記錄</a></th>
      </tr>
      {$data}
   </table>
HEREDOC;
}
else
{
   // 無法執行 query 指令時
   $html = error_message('list_all');
}


include 'pagemake.php';
pagemake($html, '');
?>
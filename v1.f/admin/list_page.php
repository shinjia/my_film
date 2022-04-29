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



// 含分頁之資料列表

$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 15;  // 每頁的筆數

// 連接資料庫
$pdo = db_open(); 

$tmp_start = ($page-1) * $numpp;  // 擷取記錄之起始位置

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM film ";
$sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;

// 執行SQL及處理結果
$data = '';
$sth = $pdo->query($sqlstr);
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
   
   // 海報圖檔
   $str_poster = '';
   $filename_poster = '../images_poster/' . $key_imdb . '.jpg';
   if(!empty($key_imdb))
   {
      if(file_exists($filename_poster))
      {
         $str_poster = '<img src="' . $filename_poster . '" style="width:60px;">';
      }
      else
      {
         $str_poster = '<a href="get_omdb_poster.php?imdb=' . $key_imdb . '" target="_blank">取得圖檔</a>';
      }
   }
   else
   {
      $str_poster = '無imdb';
   }

   $data .= <<< HEREDOC
   <tr>
      <td>{$pub_date}</td>
      <td><a href="display.php?uid={$uid}" 
            class="btn btn-sm btn-secondary" 
            data-bs-toggle="tooltip"
            data-bs-placement="right"
            title="{$title_e}">{$title_c}</a></td>
      <td>{$area}</td>
      <td>{$rate}</td>
      <td>{$str_poster}</td>
      <td>{$remark}</td>
      <!--
      <td><a href="display.php?uid=$uid" class="btn btn-sm btn-info">詳細</a></td>
      -->
      <td>
         <a href="edit.php?uid=$uid" class="btn btn-sm btn-warning">修改</a>
         <a href="delete.php?uid=$uid" class="btn btn-sm btn-danger" onClick="return confirm('確定要刪除嗎？');">刪除</a>
      </td>
   </tr>
HEREDOC;
}

// ------ 分頁處理開始 -------------------------------------
// 
// 取得分頁所需之資訊 (總筆數、總頁數、擷取記錄之起始位置)
$sqlstr = "SELECT count(*) as total_rec FROM film ";
$sth = $pdo->query($sqlstr);
if($row = $sth->fetch(PDO::FETCH_ASSOC))
{
   $total_rec = $row["total_rec"];
}
$total_page = ceil($total_rec / $numpp);  // 計算總頁數


// 處理分頁之超連結：上一頁、下一頁、第一首、最後頁
$lnk_pageprev = '?page=' . (($page==1)?(1):($page-1));
$lnk_pagenext = '?page=' . (($page==$total_page)?($total_page):($page+1));
$lnk_pagehead = '?page=1';
$lnk_pagelast = '?page=' . $total_page;

// 處理各頁之超連結：列出所有頁數 (暫未用到，保留供參考)
$lnk_pagelist = '';
for($i=1; $i<=$page-1; $i++)
{ $lnk_pagelist .= '<a href="?page='.$i.'">'.$i.'</a> '; }
$lnk_pagelist .= '[' . $i . '] ';
for($i=$page+1; $i<=$total_page; $i++)
{ $lnk_pagelist .= '<a href="?page='.$i.'">'.$i.'</a> '; }

// 處理各頁之超連結：下拉式跳頁選單
$lnk_pagegoto  = '<form method="GET" action="" style="margin:0;">';
$lnk_pagegoto .= '<select name="page" onChange="submit();">';
for($i=1; $i<=$total_page; $i++)
{
   $is_current = (($i-$page)==0) ? ' SELECTED' : '';
   $lnk_pagegoto .= '<option' . $is_current . '>' . $i . '</option>';
}
$lnk_pagegoto .= '</select>';
$lnk_pagegoto .= '</form>';

// 將各種超連結組合成HTML顯示畫面
$ihc_navigator  = <<< HEREDOC
<table border="0" align="center">
 <tr>
  <td>頁數：{$page} / {$total_page} &nbsp;&nbsp;&nbsp;</td>
  <td>
  <a href="{$lnk_pagehead}">第一頁</a> 
  <a href="{$lnk_pageprev}">上一頁</a> 
  <a href="{$lnk_pagenext}">下一頁</a> 
  <a href="{$lnk_pagelast}">最末頁</a> &nbsp;&nbsp;
  </td>
 <td>移至頁數：</td>
 <td>{$lnk_pagegoto}</td>
</tr>
</table>
HEREDOC;
// ------ 分頁處理結束 -------------------------------------


$html = <<< HEREDOC
<h2 align="center">共有 $total_rec 筆記錄</h2>
{$ihc_navigator}
<table class="table table-hover">
   <tr>
      <th>首映日</th>
      <th>片名</th>
      <th>國家</th>
      <th>評分</th>
      <th>圖檔</th>
      <th>備註</th>
      <th><a href="add.php" class="btn btn-sm btn-primary">新增記錄</a></th>
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>
<?php
// 含分頁之資料列表
include '../common/config.php';
include '../common/utility.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'X';
$key = isset($_GET['key']) ? $_GET['key'] : 'X*&^*';
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 12;  // 每頁的筆數
$numpp = isset($_COOKIE['numpp']) ? $_COOKIE['numpp'] : $numpp;
$numpp = isset($_GET['numpp']) ? $_GET['numpp'] : $numpp;

/* 依據 type 會有不同結果的變數 */
$title_type = '';  // 標題
$sql_where = "";  // 查詢子句

switch($type)
{
   case 'DIRECT' :  // 導演
      $title_type = '導演『' . $key . '』的電影';
      $sql_where = "WHERE tag_cast LIKE '%@@" . $key . "%' ";
      break;

   case 'PLAYER' :  // 演員
      $title_type = '演員『' . $key . '』的電影';
      $sql_where = "WHERE tag_cast LIKE '%@" . $key . "%' ";
      break;

   case 'YEAR' :  // 年度
      $title_type = '年度『' . $key . '』的電影';
      $sql_where = "WHERE filmyear = '" . $key . "' ";
      break;

   case 'AREA' :  // 國家
      $title_type = '國家為『' . $key . '』的電影';
      $sql_where = "WHERE area = '" . $key . "' ";
      break;

   case 'RATE' :  // 評分
      $title_type = '評分為『' . $key . '』的電影';
      $sql_where = "WHERE rate = '" . $key . "' ";
      break;

   case 'SERIAL' :  // 系列
      $title_type = '關於『' . $key . '』系列的電影';
      $sql_where = "WHERE tag_note LIKE '%##" . $key . "%' ";
      break;

   case 'TOPIC' :  // 主題
      $title_type = '關於『' . $key . '』主題的電影';
      $sql_where = "WHERE tag_note LIKE '%!" . $key . "%' ";
      break;

   case 'NOTE' :  // 標籤
      $title_type = '標籤有『' . $key . '』的電影';
      $sql_where = "WHERE tag_note LIKE '%#" . $key . "%' ";
      break;
   
   default:
      $title_type = '電影清單';
      $sql_where = "WHERE FALSE ";

}


// 連接資料庫
$pdo = db_open(); 

$tmp_start = ($page-1) * $numpp;  // 擷取記錄之起始位置

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM film ";
$sqlstr .= $sql_where;
$sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;

include 'process_data.php';  // 會得到 $data 內容

// ------ 分頁處理開始 -------------------------------------
// 
// 取得分頁所需之資訊 (總筆數、總頁數、擷取記錄之起始位置)
$sqlstr = "SELECT count(*) as total_rec FROM film ";
$sqlstr .= $sql_where;

$sth = $pdo->query($sqlstr);
if($row = $sth->fetch(PDO::FETCH_ASSOC))
{
   $total_rec = $row["total_rec"];
}
$total_page = ceil($total_rec / $numpp);  // 計算總頁數


// 處理分頁之超連結：上一頁、下一頁、第一首、最後頁
$lnk_pageprev = '?type=' . $type . '&key=' . $key . '&page=' . (($page==1)?(1):($page-1));
$lnk_pagenext = '?type=' . $type . '&key=' . $key . '&page=' . (($page==$total_page)?($total_page):($page+1));
$lnk_pagehead = '?type=' . $type . '&key=' . $key . '&page=1';
$lnk_pagelast = '?type=' . $type . '&key=' . $key . '&page=' . $total_page;

// 處理各頁之超連結：列出所有頁數 (暫未用到，保留供參考)
$lnk_pagelist = '';
for($i=1; $i<=$page-1; $i++)
{ $lnk_pagelist .= '<a href="?type=' . $type . '&key=' . $key . '&page='.$i.'">'.$i.'</a> '; }
$lnk_pagelist .= '[' . $i . '] ';
for($i=$page+1; $i<=$total_page; $i++)
{ $lnk_pagelist .= '<a href="?type=' . $type . '&key=' . $key . '&page='.$i.'">'.$i.'</a> '; }

// 處理各頁之超連結：下拉式跳頁選單
$lnk_pagegoto  = '<form method="GET" action="" style="margin:0;">';
$lnk_pagegoto .= '<select name="page" onChange="submit();">';
for($i=1; $i<=$total_page; $i++)
{
   $is_current = (($i-$page)==0) ? ' SELECTED' : '';
   $lnk_pagegoto .= '<option' . $is_current . '>' . $i . '</option>';
}
$lnk_pagegoto .= '</select>';
$lnk_pagegoto .= '<input type="hidden" name="type" value="' . $type . '">';
$lnk_pagegoto .= '<input type="hidden" name="key" value="' . $key . '">';
$lnk_pagegoto .= '</form>';

// 將各種超連結組合成HTML顯示畫面
$ihc_navigator  = <<< HEREDOC
<table border="0" style="margin-left: auto; margin-right: auto;">
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

if($total_page==1)
{
   $ihc_navigator = '';
}


$html = <<< HEREDOC
<h2 align="center">{$title_type}</h2>
<p align="center">共有 $total_rec 筆記錄</p>
{$ihc_navigator}
{$data}
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>

<?php
// 含分頁之資料列表
include '../common/config.php';
include '../common/utility.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'X';
$key = isset($_GET['key']) ? $_GET['key'] : 'X*&^*';
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 15;  // 每頁的筆數

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


echo $sql_where;

// 連接資料庫
$pdo = db_open(); 

$tmp_start = ($page-1) * $numpp;  // 擷取記錄之起始位置

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM film ";
$sqlstr .= $sql_where;
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
   
   // 處理更多的顯示
   $str_google = '<a href="https://www.google.com/search?q=' . $title_c . '" target="_blank">Google</a>';
   $str_wiki = (empty($key_wiki))?'':('<a href="https://zh.wikipedia.org/wiki/' . $key_wiki . '" target="_blank">Wiki</a>');
   $str_imdb = (empty($key_imdb))?'':('<a href="https://www.imdb.com/title/' . $key_imdb . '/" target="_blank">IMDb</a>');
   $str_dban = (empty($key_dban))?'':('<a href="https://movie.douban.com/subject/' . $key_dban . '/" target="_blank">豆瓣</a>');
   $str_note = (empty($key_note))?'':('<a href="https://hackmd.io/' . $key_note . '" target="_blank">HackMD</a>');

   $data .= <<< HEREDOC
     <tr>
      <td>{$filmyear}</td>
      <td>{$pub_date}</td>
      <td nowrap><a href="display.php?uid={$uid}">{$title_c}</a></td>
      <td>{$title_e}</td>
      <td>{$area}</td>
      <td>{$rate}</td>
      <!--
      <td>{$str_google}</td>
      <td>{$str_wiki}</td>
      <td>{$str_imdb}</td>
      <td>{$str_dban}</td>
      <td>{$str_note}</td>
      <td>{$remark}</td>
      -->
    </tr>
HEREDOC;
}

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
$lnk_pageprev = '?key=' . $key . '&page=' . (($page==1)?(1):($page-1));
$lnk_pagenext = '?key=' . $key . '&page=' . (($page==$total_page)?($total_page):($page+1));
$lnk_pagehead = '?key=' . $key . '&page=1';
$lnk_pagelast = '?key=' . $key . '&page=' . $total_page;

// 處理各頁之超連結：列出所有頁數 (暫未用到，保留供參考)
$lnk_pagelist = '';
for($i=1; $i<=$page-1; $i++)
{ $lnk_pagelist .= '<a href="?key=' . $key . '&page='.$i.'">'.$i.'</a> '; }
$lnk_pagelist .= '[' . $i . '] ';
for($i=$page+1; $i<=$total_page; $i++)
{ $lnk_pagelist .= '<a href="?key=' . $key . '&page='.$i.'">'.$i.'</a> '; }

// 處理各頁之超連結：下拉式跳頁選單
$lnk_pagegoto  = '<form method="GET" action="" style="margin:0;">';
$lnk_pagegoto .= '<select name="page" onChange="submit();">';
for($i=1; $i<=$total_page; $i++)
{
   $is_current = (($i-$page)==0) ? ' SELECTED' : '';
   $lnk_pagegoto .= '<option' . $is_current . '>' . $i . '</option>';
}
$lnk_pagegoto .= '</select>';
$lnk_pagegoto .= '<input type="hidden" name="key" value="' . $key . '">';
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
<h2 align="center">{$title_type}</h2>
<p align="center">共有 $total_rec 筆記錄</p>
{$ihc_navigator}
<table border="1" align="center">   
   <tr>
      <th>年度</th>
      <th>首映日</th>
      <th>片名</th>
      <th>英名片名</th>
      <th>國家</th>
      <th>評分</th>
      <!--
      <th>Google</th>
      <th>Wiki</th>
      <th>IMDb</th>
      <th>豆瓣</th>
      <th>筆記</th>
      <th>備註</th>
      -->
   </tr>
{$data}
</table>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>

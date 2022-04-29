<?php
// 含分頁之資料列表
include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$cc_numpp = isset($_COOKIE['cc_numpp']) ? $_COOKIE['cc_numpp'] : DEF_CC_NUMPP;
$cc_order = isset($_COOKIE['cc_order']) ? $_COOKIE['cc_order'] : DEF_CC_ORDER;
$cc_style = isset($_COOKIE['cc_style']) ? $_COOKIE['cc_style'] : DEF_CC_STYLE;
$cc_watch = isset($_COOKIE['cc_watch']) ? $_COOKIE['cc_watch'] : DEF_CC_WATCH;

$key = isset($_POST['key']) ? $_POST['key'] : 'X*&^*';
$type = 'FIND';
$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = $cc_numpp;  // 每頁的筆數

$title_type = '片名包含『' . $key . '』的電影';
$sql_where = "WHERE title_c LIKE '%" . $key . "%' OR title_e LIKE '%" . $key . "%' " ;

// 連接資料庫
$pdo = db_open(); 

$tmp_start = ($page-1) * $numpp;  // 擷取記錄之起始位置

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM film ";
$sqlstr .= $sql_where;
$sqlstr .= " ORDER BY pub_date ";
$sqlstr .= ($cc_order=='NEW') ? "DESC" : "";
$sqlstr .= " LIMIT " . $tmp_start . "," . $numpp;

// Part1: 顯示風格
$file_data = 'process_data.php';  // 預設
switch($cc_style)
{
   case '1':
      $file_data = 'process_data1.php';
      break;

   case '2':
      $file_data = 'process_data2.php';
      break;

   case '3':
      $file_data = 'process_data3.php';
      break;

   case '4':
      $file_data = 'process_data4.php';
      break;

   default:
}

include $file_data;


// Part2: 處理分頁
$file_page = 'process_page.php';  // 預設
include $file_page;


// Parr3: 處理Boby
$file_body = 'process_body.php';  // 預設
switch($cc_style)
{
   case '1' :
   case '2' :
   case '4' :
      $file_body = 'process_body.php';
      break;
      
   case '3' :
      $file_body = 'process_body3.php';
      break;
}
include $file_body;


// 處理要不要顯示最近瀏覽的項目
$div_watch = <<< HEREDOC
<div class="extra">
 <h2>最近瀏覽項目</h2>
 <div id="recent_view"></div>
</div>
HEREDOC;

if($cc_watch=='Y')
{
   // 需要互動的 Javascript
   $js_after = '<script src="recent.js"></script>';
}
else
{
   $js_after = '';
   $div_watch = '';
}


include 'pagemake.php';
pagemake($html, '', $js_after, $div_watch);
?>

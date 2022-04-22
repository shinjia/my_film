<?php
// 含分頁之資料列表
include '../common/config.php';
include '../common/utility.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;   // 目前的頁碼

$numpp = 10;  // 每頁的筆數

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
      <td><a href="display.php?uid={$uid}" onclick="save_view({$uid},'{$title_c}');">{$title_c}</a></td>
      <td><button onclick="save_view({$uid},'{$title_c}');">{$title_c}</button></td>
      <td>{$area}</td>
      <td>{$rate}</td>
      <td><a href="display_omdb.php?imdb={$key_imdb}">{$key_imdb}</a></td>
      <td><a href="display_omdb_js.php?uid={$uid}">{$key_imdb}</a></td>
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
<table border="1" align="center">   
   <tr>
      <th>年度</th>
      <th>首映日</th>
      <th>片名</th>
      <th>測試最近瀏覽</th>
      <th>國家</th>
      <th>評分</th>
      <th>OMDB(法一)</th>
      <th>OMDB(法二)</th>
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

<h2>最近瀏覽項目</h2>
<div id="recent_view"></div>

<script>
function show_all()
{
	var str = '';
	for(idx in data.items)
	{
		item_one = data.items[idx];

		uid     = item_one.uid;
		title_c = item_one.title_c;

		// str += '<input type="button" value="刪" onclick="remove('+idx+');"> ';
		str += uid + ', ' + title_c + '<br />';
	}
	document.getElementById('recent_view').innerHTML = str;
}

function retrieve_view()
{
   data = JSON.parse(localStorage.recent_view);
   show_all();
}

function save_view(_uid, _title_c)
{
   var dataObject = { uid: _uid, title_c: _title_c };

   // 先檢查是否已存在
   var found = false;
	for(idx in data.items)
	{
		item_one = data.items[idx];
      if(item_one.uid==_uid) found = true;
   }

   if(!found)
   {
      // 超過數量則移除一項
      if(data.items.length>=data_max)
      {
         data.items.shift();
      }

      // Put the object into storage
      data.items.push(dataObject);

      var str1 = JSON.stringify(data);
      localStorage.setItem('recent_view', str1);
   }
   show_all();
}
</script>

<script>
var data_max = 6;
var data = {items: []};
retrieve_view();
</script>

HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>
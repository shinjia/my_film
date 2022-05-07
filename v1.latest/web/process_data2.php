<?php
/**********************************
這支程式被下列程式引入
- list_page.php
- list_by.php 
- find_by.php
**********************************/

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
   $str_rate = '⭐ (' . $rate . ')';

   // 處理外部連結的顯示
   // 文字超連結
   /*
   $str_google = '<a href="https://www.google.com/search?q=' . $title_c . '" target="_blank">Google</a>';
   $str_wiki = (empty($key_wiki))?'':('<a href="https://zh.wikipedia.org/wiki/' . $key_wiki . '" target="_blank">Wiki</a>');
   $str_imdb = (empty($key_imdb))?'':('<a href="https://www.imdb.com/title/' . $key_imdb . '/" target="_blank">IMDb</a>');
   $str_dban = (empty($key_dban))?'':('<a href="https://movie.douban.com/subject/' . $key_dban . '/" target="_blank">豆瓣</a>');
   $str_note = (empty($key_note))?'':('<a href="https://hackmd.io/' . $key_note . '" target="_blank">HackMD</a>');
   */
   // 圖片超連結
   $str_google = '<a href="https://www.google.com/search?q=' . $title_c . '" target="_blank"><img src="../images/icon_google.jpg"></a>';
   $str_wiki = (empty($key_wiki))?'':('<a href="https://zh.wikipedia.org/wiki/' . $key_wiki . '" target="_blank"><img src="../images/icon_wiki.jpg"></a>');
   $str_imdb = (empty($key_imdb))?'':('<a href="https://www.imdb.com/title/' . $key_imdb . '/" target="_blank"><img src="../images/icon_imdb.jpg"></a>');
   $str_dban = (empty($key_dban))?'':('<a href="https://movie.douban.com/subject/' . $key_dban . '/" target="_blank"><img src="../images/icon_dban.jpg"></a>');
   $str_note = (empty($key_note))?'':('<a href="https://hackmd.io/' . $key_note . '" target="_blank"><img src="../images/icon_note.jpg"></a>');

   // 海報圖檔
   $str_poster = '';
   $filename_poster = '../images_poster/' . $key_imdb . '.jpg';
   if(file_exists($filename_poster))
   {
      $str_poster = $filename_poster;
      // $str_poster = '<img src="' . $filename_poster . '" style="width:60px;">';
   }
   else
   {
      $str_poster = '../images_poster/00_default.jpg';
   }
   
   // 處理單筆顯示的連結
   $url_display = 'display.php?uid=' . $uid;


   $data .= <<< HEREDOC
   
<div style="display:inline-block; border: 1px solid gray; padding: 0px 0px 10px 0px; margin:5px; 10px; border-radius:4px; overflow:hidden;">
<a href="{$url_display}" onclick="save_view({$uid}, '{$title_c}');">
  <img src="{$str_poster}" style="width:150px; height:200px;";>
  </a>
  <br/>
  {$title_c}<br/>
  {$filmyear}, {$area}, {$str_rate}

</div>
HEREDOC;
}

?>
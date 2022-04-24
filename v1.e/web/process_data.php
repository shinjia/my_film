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
   $str_rate = str_repeat('⭐', $rate) . ' (' . $rate . ')';

   $str_google = '<a href="https://www.google.com/search?q=' . $title_c . '" target="_blank">Google</a>';
   $str_wiki = (empty($key_wiki))?'':('<a href="https://zh.wikipedia.org/wiki/' . $key_wiki . '" target="_blank">Wiki</a>');
   $str_imdb = (empty($key_imdb))?'':('<a href="https://www.imdb.com/title/' . $key_imdb . '/" target="_blank">IMDb</a>');
   $str_dban = (empty($key_dban))?'':('<a href="https://movie.douban.com/subject/' . $key_dban . '/" target="_blank">豆瓣</a>');
   $str_note = (empty($key_note))?'':('<a href="https://hackmd.io/' . $key_note . '" target="_blank">HackMD</a>');

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
   
   // 處理欄位：tag_cast
   $a_item = explode(' ', $tag_cast);

   $ary = array();
   foreach($a_item as $one)
   {
      if(isset($ary[$one]))
      {
         $ary[$one]++;
      }
      else
      {
         $ary[$one] = 1;
      }
   }

   $str_direct = '';
   $str_player = '';
   foreach($ary as $k=>$value)
   {
      if(substr($k,0,2)=='@@')
      {
         $name = substr($k,2);
         $str_direct .= '<a href="list_by.php?type=DIRECT&key=' . $name . '">' . $name . '</a> ';
      }
      else if(substr($k,0,1)=='@')
      {
         $name = substr($k,1);
         $str_player .= '<a href="list_by.php?type=PLAYER&key=' . $name . '">' . $name . '</a> ';
      }
   }
   $str_cast = $str_direct . '<br>' . $str_player;


   // 處理欄位：tag_note
   $ary = array();
   $a_item = explode(' ', $tag_note);
   foreach($a_item as $one)
   {
      if(isset($ary[$one]))
      {
         $ary[$one]++;
      }
      else
      {
         $ary[$one] = 1;
      }
   }

   $str_type1 = '';  // ## 開頭的系列 (SERIAL)
   $str_type2 = '';  // # 開頭的系列 (NOTE)
   $str_type3 = '';  // ! 開頭的特定主題 (TOPIC)
   foreach($ary as $k=>$value)
   {
      if(substr($k, 0, 2)=='##')
      {
         $name = substr($k,2);
         $str_type1 .= '<a href="list_by.php?type=SERIAL&key=' . $name . '">' . $name . '</a> ';
      }
      elseif(substr($k, 0, 1)=='#')
      {
         $name = substr($k,1);
         $str_type2 .= '<a href="list_by.php?type=NOTE&key=' . $name . '">' . $name . '</a> ';
      }
      elseif(substr($k, 0, 1)=='!')
      {
         $name = substr($k,1);
         $str_type3 .= '<a href="list_by.php?type=TOPIC&key=' . $name . '">' . $name . '</a> ';
      }
   }

   $str_tagnote = $str_type1 . $str_type2;  // str_type3 不顯示


   // 處理單筆顯示的連結
   $url_display = 'display.php?uid=' . $uid;


   $data .= <<< HEREDOC
   
<div class="card">
<div class="card-img" style="background-image:url({$str_poster});">
   <div class="overlay">
      <div class="overlay-content">
         <h2>{$pub_date}</h2>
         <p></p>
         <a class="hover" href="{$url_display}" onclick="save_view({$uid}, '{$title_c}');">查看內容</a>
         <p><hr/></p>
         <p>{$str_cast}</p>
         <p><hr/></p>
         <p>{$str_tagnote}</p>
      </div>
   </div>
</div>
<div class="card-content">
   <a href="{$url_display}" onclick="save_view({$uid}, '{$title_c}');">
      <h2>{$title_c}</h2>
      <p>{$title_e}</p>
      <p>{$filmyear}, {$area}, {$str_rate}</p>
   </a>
</div>
</div>

HEREDOC;
}

?>
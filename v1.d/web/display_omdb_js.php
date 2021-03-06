<?php
include '../common/config.php';
include '../common/utility.php';

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
   

      // 處理更多的顯示
      $str_google = '<a href="https://www.google.com/search?q=' . $title_c . '" target="_blank">Google</a>';
      $str_wiki = (empty($key_wiki))?'':('<a href="https://zh.wikipedia.org/wiki/' . $key_wiki . '" target="_blank">'.$key_wiki.'</a>');
      $str_imdb = (empty($key_imdb))?'':('<a href="https://www.imdb.com/title/' . $key_imdb . '/" target="_blank">'.$key_imdb.'</a>');
      $str_dban = (empty($key_dban))?'':('<a href="https://movie.douban.com/subject/' . $key_dban . '/" target="_blank">'.$key_dban.'</a>');
      $str_note = (empty($key_note))?'':('<a href="https://hackmd.io/' . $key_note . '" target="_blank">HackMD</a>');


      // 加入相關的連結
      $url_filmyear = 'list_by.php?type=YEAR&key=' . $filmyear;
      $url_area = 'list_by.php?type=AREA&key=' . $area;
      
      // ****** BEGIN: 處理 tag_cast ******
      $a_item = explode(' ', $tag_cast);

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

      // 顯示部分
      $str_direct = '';
      $str_player = '';
      foreach($ary as $key=>$value)
      {
         if(substr($key,0,2)=='@@')
         {
            $name = substr($key,2);

            // $str_direct .= $name;
            $str_direct .= '<a href="list_by.php?type=DIRECT&key=' . $name . '">' . $name . '</a>&nbsp;&nbsp;&nbsp; ';
         }
         else
         {
            $name = substr($key,1);

            // $str_player .= $name;
            $str_player .= '<a href="list_by.php?type=PLAYER&key=' . $name . '">' . $name . '</a>&nbsp;&nbsp;&nbsp; ';
         }
      }
      // ****** END: 處理 tag_note ******


      // ****** BEGIN: 處理 tag_note ******
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

      // 處理顯示的部分
      $str_note = '';
      $str_type1 = '';  // ## 開頭的系列
      $str_type2 = '';  // ! 開頭的特定主題
      foreach($ary as $key=>$value)
      {
         if(substr($key, 0, 2)=='##')
         {
            $name = substr($key,2);         
            // $str_type1 .= $name;
            $str_type1 .= '<a href="list_by.php?type=SERIAL&key=' . $name . '">' . $name . '</a> ';
         }
         elseif(substr($key, 0, 1)=='#')
         {
            $name = substr($key,1);
            // $str_note .= $name;
            $str_note .= '<a href="list_by.php?type=NOTE&key=' . $name . '">' . $name . '</a> ';
         }
         elseif(substr($key, 0, 1)=='!')
         {
            $name = substr($key,1);
            // $str_type2 .= $name;
            $str_type2 .= '<a href="list_by.php?type=TOPIC&key=' . $name . '">' . $name . '</a> ';
         }
      }
      // ****** END: 處理 tag_note ******

      // 網頁顯示
      $data = <<< HEREDOC
      <button onclick="show_omdb('{$key_imdb}');">Get OMDB</button>
      <div id="message">message</div>
      <div id="showarea">showarea</div>

      <hr>
       <table border="1">
         <tr><th>年度</th><td><a href="{$url_filmyear}">{$filmyear}</a></td></tr>
         <tr><th>首映日</th><td>{$pub_date}</td></tr>
         <tr><th>片名</th><td>{$title_c}</td></tr>
         <tr><th>英名片名</th><td>{$title_e}</td></tr>
         <tr><th>國家</th><td><a href="{$url_area}">{$area}</a></td></tr>
         <tr><th>評分</th><td>{$rate}</td></tr>
         <tr><th>Google</th><td>{$str_google}</td></tr>
         <tr><th>key_Wiki</th><td>{$str_wiki}</td></tr>
         <tr><th>key_IMDb</th><td>{$str_imdb}</td></tr>
         <tr><th>key_豆瓣</th><td>{$str_dban}</td></tr>
         <tr><th>key_筆記</th><td>{$key_note}</td></tr>
         <tr><th>tag_人員</th><td>{$tag_cast}</td></tr>
         <tr><th>(*)導演：</th><td>{$str_direct}</td></tr>
         <tr><th>(*)演員：</th><td>{$str_player}</td></tr>
         <tr><th>tag_主題</th><td>{$tag_note}</td></tr>
         <tr><th>(*)SERIAL：</th><td>{$str_type1}</td></tr>
         <tr><th>(*)TOPIC：</th><td>{$str_type2}</td></tr>
         <tr><th>(*)NOTE：</th><td>{$str_note}</td></tr>
         <tr><th>備註</th><td>{$remark}</td></tr>
       </table>
HEREDOC;

/*
$data = <<< HEREDOC
<table>
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
*/
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
<button onclick="location.href='list_page.php';">返回列表</button>
<h2>顯示資料</h2>
{$data}

HEREDOC;


$js_after = <<< HEREDOC
/* jquery.js */
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
function show_omdb(imdb)
{
  url = url = 'http://localhost/myweb/my_film/test/api_omdb.php?imdb=' + imdb;
console.log(url);
  $.ajax({
    dataType: "json",
    url: url,
    success: function(data){
      $('#message').html('資料已成功讀取');
      console.log(data);
      func_show(data);
    },
    complete: function(){
      // $('#message').html('資料讀取完畢');
    },  
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      console.log(XMLHttpRequest.status);
      console.log(XMLHttpRequest.readyState);
      console.log(textStatus);
      $('#message').html('資料讀取發生錯誤');
    },
  }); // end of ajax()
}


var func_show = function(obj)
{
  // 處理 Rate 的資料
  var str_rate = '';
  if (typeof obj.Ratings !== 'undefined')
  {
    $.each(obj.Ratings, function(i, item){
      str_rate += '<li>';
      str_rate += item.Source;
      str_rate += ' -----> ';
      str_rate += item.Value;
      str_rate += '</li>';
    });
  }
  // 取得各欄位的資料
  var str = '';
  str += '<h2>Title: ' + obj.Title + '</h2>';
  str += '<p>Plot: ' + obj.Plot  +  '</p>';
  
  str += '<h3>Rate</h3>';  
  str += str_rate;
  
  str += '<p><img src="' + obj.Poster  +  '" /></p>';

  $('#showarea').html( str );
};
</script>

<script>
    // show_omdb('{$key_imdb}');
</script>
HEREDOC;


include 'pagemake.php';
pagemake($html, '', $js_after);
?>
<?php
include '../common/config.php';
include '../common/utility.php';

$max_records = 20;  // 設定最大的筆數
$dir = __DIR__ . "\\..\\images_poster";

$fi = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
$cnt_before = iterator_count($fi);

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT key_imdb FROM film ";

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   $total_rec = $sth->rowCount();
   $data = '';
   $cnt = 0;
   while($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $key_imdb = $row['key_imdb'];

      $img = '../images_poster/' . $key_imdb . '.jpg';
      if(!empty($key_imdb) && !file_exists($img))
      {
        $cnt ++;
        if($cnt>$max_records)
        {
            break;
        }
      
        // 取得海報圖檔      
        $imdb = $key_imdb;

        $api_key = 'fd33b597';
        $url = 'http://www.omdbapi.com/?i=' . $imdb . '&apikey=' . $api_key;

        $json_str = file_get_contents($url);
        $ary = json_decode($json_str, TRUE);
        $poster = $ary['Poster'];

        // 存檔
        $filename_poster = '../images_poster/' . $imdb . '.jpg';
        file_put_contents($filename_poster, file_get_contents($poster));
      }
   }
   
   
    $fi = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
    $cnt_after = iterator_count($fi);
    $cnt_change = $cnt_after - $cnt_before;

   $html = <<< HEREDOC
<p>設定一次擷取最大筆數：{$max_records}</p>
<p>資料庫內總筆數：{$total_rec}</p>
<p>cnt_before: {$cnt_before}</p>
<p>cnt_after: {$cnt_after}</p>
<p>此次新增圖檔數量: {$cnt_change}</p>

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

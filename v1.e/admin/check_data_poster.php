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
$sqlstr = "SELECT * FROM film ";

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
      $uid = $row['uid'];

      $filmyear = convert_to_html($row['filmyear']);
      $pub_date = convert_to_html($row['pub_date']);
      $title_c  = convert_to_html($row['title_c']);
      $key_imdb = convert_to_html($row['key_imdb']);

      $img = '../images_poster/' . $key_imdb . '.jpg';
      
      $str1 = '';
      $str2 = '';
      if(empty($key_imdb))
      {
         $str1 = '沒有 IMDb 值';
      }
      else if(!file_exists($img))
      {
         // $str2 = '沒有圖檔';
         $str2 = '<a href="get_omdb_poster.php?imdb=' . $key_imdb . '" class="btn btn-sm btn-danger">取得圖檔</a>';         
      }

      if($str1!='' || $str2!='')
      {
        $data .= <<< HEREDOC
       <tr>
          <td>{$pub_date}</td>
          <td>{$title_c}</td>
          <td>{$str1} {$str2}</td>
       </tr>
HEREDOC;
      }
   }

   $html = <<< HEREDOC
   <h2>列出不一致的資料</h2>
    <p>資料庫內總筆數：{$total_rec}</p>
    <p>圖檔總數量：{$cnt_before}</p>

    <table class="table table-hover">
        {$data}
    </table>

    <p></p>
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

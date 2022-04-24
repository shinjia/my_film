<?php
include '../common/config.php';
include '../common/utility.php';

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT tag_cast FROM film WHERE tag_cast != '' ";

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
   // 成功執行 query 指令
   $total_rec = $sth->rowCount();
   $data = '';
   $ary = array();
   while($row = $sth->fetch(PDO::FETCH_ASSOC))
   {
      $tag_cast = $row['tag_cast'];

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
   }
   
   ksort($ary);
   /*
   echo '<pre>';
   print_r($ary);
   echo '</pre>';
   */

   $str_direct = '';
   $str_player = '';
   foreach($ary as $key=>$value)
   {
      if(substr($key,0,2)=='@@')
      {
         $name = substr($key,2);

         $str_direct .= '<li>';
         // $str_direct .= $name;
         $str_direct .= '<a href="list_by.php?type=DIRECT&key=' . $name . '">' . $name . '</a> ';
         $str_direct .= ' (' . $value . ') ';
         $str_direct .= '</li>';
      }
      else
      {
         $name = substr($key,1);

         $str_player .= '<li>';
         // $str_player .= $name;
         $str_player .= '<a href="list_by.php?type=PLAYER&key=' . $name . '">' . $name . '</a> ';
         $str_player .= ' (' . $value . ') ';
         $str_player .= '</li>';
      }
   }


   $html = <<< HEREDOC
   <table>
      <tr>
         <td style="vertical-align:top; width: 50%;">
            <h3>導演</h3>
            <ul>
            {$str_direct}
            </ul>
         </td>
         <td style="vertical-align:top; width: 50%;">
            <h3>演員</h3>
            <ul>
            {$str_player}
            </ul>
         </td>
      </tr>
   </table>
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
<?php
include '../common/config.php';
include '../common/utility.php';

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT tag_note FROM film WHERE tag_note != '' ";

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
      $tag_note = $row['tag_note'];
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
   }
   
   ksort($ary);
   /*
   echo '<pre>';
   print_r($ary);
   echo '</pre>';
   */

   $str_type1 = '';  // ## 開頭的系列 (SERIAL)
   $str_type2 = '';  // # 開頭的系列 (NOTE)
   $str_type3 = '';  // ! 開頭的特定主題 (TOPIC)
   foreach($ary as $key=>$value)
   {
      if(substr($key, 0, 2)=='##')
      {
         $name = substr($key,2);         
         $str_type1 .= '<li>';
         // $str_type1 .= $name;
         $str_type1 .= '<a href="list_by.php?type=SERIAL&key=' . $name . '">' . $name . '</a> ';
         $str_type1 .= ' (' . $value . ') ';
         $str_type1 .= '</li>';
      }
      elseif(substr($key, 0, 1)=='#')
      {
         $name = substr($key,1);
         $str_type2 .= '<li>';
         // $str_note .= $name;
         $str_type2 .= '<a href="list_by.php?type=NOTE&key=' . $name . '">' . $name . '</a> ';
         $str_type2 .= ' (' . $value . ') ';
         $str_type2 .= '</li>';
      }
      elseif(substr($key, 0, 1)=='!')
      {
         $name = substr($key,1);
         $str_type3 .= '<li>';
         // $str_type3 .= $name;
         $str_type3 .= '<a href="list_by.php?type=TOPIC&key=' . $name . '">' . $name . '</a> ';
         $str_type3 .= ' (' . $value . ') ';
         $str_type3 .= '</li>';
      }
   }


   $html = <<< HEREDOC
   <table>
      <tr>
         <td style="vertical-align:top; width:33%;">
            <h3>一般標籤</h3>
            <ul>
            {$str_type2}
            </ul>
         </td>
         <td style="vertical-align:top; width:33%;">
            <h3>系列</h3>
            <ul>
            {$str_type1}
            </ul>
         </td>
         <td style="vertical-align:top; width:33%;">
            <h3>特定主題</h3>
            <ul>
            {$str_type3}
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
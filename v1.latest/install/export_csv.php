<?php
include '../common/config.php';

$file_csv = 'output.csv';

header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=' . $file_csv);  
$output = fopen("php://output", "w"); 


fputcsv($output, array('filmyear', 'pub_date', 'title_c', 'title_e', 
'area', 'rate', 'key_wiki', 'key_imdb', 'key_dban', 'key_note', 
'x1', 'x2', 'x3', 'x4', 'x5', 'tag_cast', 'tag_note', 'remark'));  


// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "SELECT * FROM film ORDER BY pub_date DESC ";

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
    // 成功執行 query 指令
    $total_rec = $sth->rowCount();
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        unset($row['uid']);  // remove uid field
        
        fputcsv($output, $row);  
    }
}
else
{
    $msg = 'Error!';
}

fclose($output);  

?>
<?php
include '../common/config.php';
include '../common/utility.php';

// 連接資料庫
$pdo = db_open();

$sqlstr  = 'SELECT filmyear, count(*) AS tot FROM film ';
$sqlstr .= ' GROUP BY filmyear ';
$sqlstr .= ' ORDER BY filmyear DESC ';

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
    // 成功執行 query 指令
    $total_rec = $sth->rowCount();
    $data = '';
    
    while($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $filmyear = $row['filmyear'];
        $tot  = $row['tot'];

        $data .= <<< HEREDOC
        <tr>
            <td><a href="list_by.php?type=YEAR&key={$filmyear}">{$filmyear}</td>
            <td>{$tot}</td>
            <td><img src="images/red.jpg" style="width:{$tot}%; height:14px;"></td>
        </tr>
HEREDOC;
        
    }

    $html = <<< HEREDOC
    <h2>各年度數量統計</h2>
    <table border="1">
        <tr>
            <td>年度</td>
            <td>數量</td>
            <td style="width:400px;">長度</td>
        </tr>
        {$data}
    </table>
    
HEREDOC;
}
else
{
    // 無法執行 query 指令時
    $html = error_message('all_stat');
}

include 'pagemake.php';
pagemake($html, '');
?>
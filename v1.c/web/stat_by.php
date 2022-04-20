<?php
include '../common/config.php';
include '../common/utility.php';

$type = isset($_GET['type']) ? $_GET['type'] : ''; 

switch($type)
{
    case 'STAT1' :  // 列出各年度的數量
        $sqlstr = 'SELECT filmyear as field1, count(*) as tot FROM film GROUP BY filmyear DESC';
        $str_title = '各年度數量統計';
        $str_field = '年度';
        $url_prefix = 'list_by.php?type=YEAR&key=';
        break;

    case 'STAT2' :  // 列出各國的數量
        $sqlstr = 'SELECT area as field1, count(*) AS tot FROM film GROUP BY area ORDER BY tot DESC';
        $str_title = '各國家數量統計';
        $str_field = '國家';
        $url_prefix = 'list_by.php?type=AREA&key=';
        break;

    case 'STAT3' :  // 列出各種評分的數量
        $sqlstr = 'SELECT rate as field1, count(*) AS tot FROM film GROUP BY rate ORDER BY rate DESC';
        $str_title = '各評分數量統計';
        $str_field = '評分';
        $url_prefix = 'list_by.php?type=RATE&key=';
        break;

    default: 
        header('index.php');
        exit;
}


// 連接資料庫
$pdo = db_open();

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
    // 成功執行 query 指令
    $total_rec = $sth->rowCount();
    $data = '';
    while($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $field1 = $row['field1'];
        $tot    = $row['tot'];

        $data .= <<< HEREDOC
        <tr>
            <td><a href="{$url_prefix}{$field1}">{$field1}</td>
            <td>{$tot}</td>
        </tr>
HEREDOC;
    }

    $html = <<< HEREDOC
    <h2>{$str_title}</h2>
    <table border="1">
        <tr>
            <td>{$str_field}</td>
            <td>數量</td>
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
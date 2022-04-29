<?php
include '../common/config.php';
include '../common/utility.php';

// 連接資料庫
$pdo = db_open();

$sqlstr  = 'SELECT area, count(*) AS tot FROM film ';
$sqlstr .= ' GROUP BY area ';
// $sqlstr .= ' HAVING tot>5 ';
$sqlstr .= ' ORDER BY tot DESC ';

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
    // 成功執行 query 指令
    $total_rec = $sth->rowCount();
    $data = '';
    
    // 做出繪圖需要的內容
    $a_data = array();
    $a_text = array();

    while($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $area = $row['area'];
        $tot  = $row['tot'];

        $data .= <<< HEREDOC
        <tr>
            <td><a href="list_by.php?type=AREA&key={$area}">{$area}</td>
            <td>{$tot}</td>
        </tr>
HEREDOC;
        
        // 處理繪圖的資料 (用陣列的方式)
        if($tot>5)
        {
          array_push($a_text, $area);
          array_push($a_data, $tot);
        }
    }

    $html = <<< HEREDOC
    <h2>統計圖表 (Chart.js)</h2>
    <canvas id="myChart" width="400" height="200" style="background-color:white;"></canvas>

    <h2>各地區數量統計</h2>
    <table border="1">
        <tr>
            <td>地區</td>
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


// 處理繪圖的資料 (陣列轉為字串)
$str_text = "['" . implode("','", $a_text) . "']";  // 字串需要含引號
$str_data = "[" . implode(",", $a_data) . "]";
// echo $str_text;
// echo $str_data;

$js_after = <<< HEREDOC
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {$str_text},
        datasets: [{
            label: '地區影片數量',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: {$str_data},
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
HEREDOC;


include 'pagemake.php';
pagemake($html, '', $js_after);
?>
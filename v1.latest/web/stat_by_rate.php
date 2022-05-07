<?php
include '../common/config.php';
include '../common/utility.php';

// 連接資料庫
$pdo = db_open();

$sqlstr = 'SELECT rate, count(*) AS tot FROM film GROUP BY rate ORDER BY rate DESC';

$sth = $pdo->prepare($sqlstr);

// 執行SQL及處理結果
if($sth->execute())
{
    // 成功執行 query 指令
    $total_rec = $sth->rowCount();
    $data = '';
    // 做出繪圖需要的內容
    $data_chart = '';

    while($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $rate = $row['rate'];
        $tot  = $row['tot'];

        $data .= <<< HEREDOC
        <tr>
            <td><a href="list_by.php?type=RATE&key={$rate}">{$rate}</td>
            <td>{$tot}</td>
        </tr>
HEREDOC;
        
        $data_chart .= "['{$rate}', {$tot}],";
    }    
    // 將最後一個逗號移除
    $data_chart = rtrim($data_chart, ',');  // 移除最後一個逗號

// echo $data_chart;

    $html = <<< HEREDOC
    <h2>統計圖表 (Google Chart)</h2>
    <div id="piechart" style="width: 700px; height: 500px;"></div>

    <h2>各評分數量統計</h2>
    <table border="1">
        <tr>
            <td>評分</td>
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


$head = <<< HEREDOC
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['評分', '數量'],
      {$data_chart}
    ]);

    var options = {
      title: '電影評分比例分配圖'
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }
</script>
HEREDOC;


include 'pagemake.php';
pagemake($html, $head);
?>
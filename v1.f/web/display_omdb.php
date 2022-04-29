<?php
$imdb = isset($_GET['imdb']) ? $_GET['imdb'] : 'x';

$api_key = 'fd33b597';
$url = 'http://www.omdbapi.com/?i=' . $imdb . '&apikey=' . $api_key;

$json_str = file_get_contents($url);
//echo $json_str;

$ary = json_decode($json_str, TRUE);
//echo '<pre>';
//print_r($ary);
//echo '</pre>';

// 取得所需的資料 (最好先加上檢查)
$title  = $ary['Title'];
$plot   = $ary['Plot'];
$poster = $ary['Poster'];

/*
$rate0_title = $ary['Ratings'][0]['Source'];
$rate0_value = $ary['Ratings'][0]['Value'];
$rate1_title = $ary['Ratings'][1]['Source'];
$rate1_value = $ary['Ratings'][1]['Value'];
$rate2_title = $ary['Ratings'][2]['Source'];
$rate2_value = $ary['Ratings'][2]['Value'];
*/
$str_rate = '<ul>';
if(isset($ary['Ratings']))
{
    foreach($ary['Ratings'] as $a_one)
    {
        $str_rate .= '<li>';
        $str_rate .= $a_one['Source'];
        $str_rate .= ' -----> ';
        $str_rate .= $a_one['Value'];
        $str_rate .= '</li>';
    }
}
$str_rate .= '</ul>';


$html = <<< HEREDOC
<button onclick="location.href='list_page.php';">返回列表</button>
<h2>{$title}</h2>
<p>{$plot}</p>
<hr/>
<h3>Rate</h3>
<p>{$str_rate}</p>

<p><img src="{$poster}"></p>
HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
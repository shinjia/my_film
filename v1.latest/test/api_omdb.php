<?php
$imdb = isset($_GET['imdb']) ? $_GET['imdb'] : 'x';

$api_key = 'fd33b597';
$url = 'http://www.omdbapi.com/?i=' . $imdb . '&apikey=' . $api_key;

$json_str = file_get_contents($url);
// echo $json_str;

$ary = json_decode($json_str, TRUE);


// 設置允許其他域名訪問
header('Access-Control-Allow-Origin:*');  
// 設置允許的響應類型
header('Access-Control-Allow-Methods:POST, GET');  
// 設置允許的響應頭
header('Access-Control-Allow-Headers:x-requested-with,content-type'); 


echo $json_str;
//echo '<pre>';
//print_r($ary);
//echo '</pre>';

//$poster = $ary['Poster'];
//echo '<img src="' . $poster . '">';
?>
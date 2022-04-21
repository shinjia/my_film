<?php
$imdb = isset($_GET['imdb']) ? $_GET['imdb'] : 'x';

$api_key = 'fd33b597';
$url = 'http://www.omdbapi.com/?i=' . $imdb . '&apikey=' . $api_key;

$json_str = file_get_contents($url);
echo $json_str;

$ary = json_decode($json_str, TRUE);
echo '<pre>';
print_r($ary);
echo '</pre>';

$poster = $ary['Poster'];
echo '<img src="' . $poster . '">';
?>
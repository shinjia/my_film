<?php
$imdb = isset($_GET['imdb']) ? $_GET['imdb'] : 'x';

$api_key = 'fd33b597';
$url = 'http://www.omdbapi.com/?i=' . $imdb . '&apikey=' . $api_key;

$json_str = file_get_contents($url);
$ary = json_decode($json_str, TRUE);
$poster = $ary['Poster'];

$filename_poster = '../images_poster/' . $imdb . '.jpg';
file_put_contents($filename_poster, file_get_contents($poster));

echo '<p>檢視下方圖片，取得後已自動存檔。</p>';
echo '<img src="' . $poster . '">';
?>
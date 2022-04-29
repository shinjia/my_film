<?php
    $apiKey = 'AIzaSyBfKGKUxVOYxrro6LtDfOmTVbY3BH6ANbU';
    $text = 'Hello world!';
    $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&source=en&target=zh-TW';

    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);                 
    $responseDecoded = json_decode($response, true);
    curl_close($handle);
echo '<pre>';
print_r($responseDecoded);
echo '</pre>';
    echo 'Source: ' . $text . '<br>';
    echo 'Translation: ' . $responseDecoded['data']['translations'][0]['translatedText'];
?>
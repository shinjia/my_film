<?php
include '../common/define.php';

$refer = isset($_POST['refer']) ? $_POST['refer'] : 'index.php';  // 呼叫 setup.php 程式之前頁

$cc_numpp = isset($_POST['cc_numpp']) ? $_POST['cc_numpp'] : DEF_CC_NUMPP;
$cc_order = isset($_POST['cc_order']) ? $_POST['cc_order'] : DEF_CC_ORDER;
$cc_style = isset($_POST['cc_style']) ? $_POST['cc_style'] : DEF_CC_STYLE;
$cc_watch = isset($_POST['cc_watch']) ? $_POST['cc_watch'] : '';

setcookie('cc_numpp', $cc_numpp, time()+86400*30);
setcookie('cc_order', $cc_order, time()+86400*30);
setcookie('cc_style', $cc_style, time()+86400*30);
setcookie('cc_watch', $cc_watch, time()+86400*30);

// 顯示『cc_order』的選項值及文字
$str_order = "(" . $cc_order. ") ";
$str_order .= isset($a_cc_order[$cc_order])?$a_cc_order[$cc_order]:'';

// 顯示『cc_style』的選項值及文字
$str_style = "(" . $cc_style. ") ";
$str_style .= isset($a_cc_style[$cc_style])?$a_cc_style[$cc_style]:'';

// 顯示『cc_watch』的核選值及文字
$str_watch = "(" . $cc_watch . ") ";
$str_watch = isset($a_cc_watch[$cc_watch]) ? $a_cc_watch[$cc_watch] : "*無勾選*";
        


$html = <<< HEREDOC
<h2>設定完成</h2>
<p>每頁顯示筆數：{$cc_numpp}</p>
<p>排序：{$str_order}</p>
<p>顯示風格：{$str_style}</p>
<p>是否顯示最新瀏覽：{$str_watch}</p>

<div style="line-hieght:20px;">&nbsp;</div>
<hr />
<div style="line-hieght:20px;">&nbsp;</div>

<p>這頁面是教學考量暫時保留，供查看設定的結果</p>
<p>
可以在 PHP 內直接導向到之前進入設定的頁面<br/>
<a href="{$refer}">{$refer}</a>
</p>
HEREDOC;

header('location: ' . $refer);

include 'pagemake.php';
pagemake($html);
?>
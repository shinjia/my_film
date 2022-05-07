<?php

$html = <<< HEREDOC
<h1>電影資料暫存區 Storage</h1>

<h2>已選取的影片</h2>
<div id="display" style="background-color: #CCCC00;"></div>


<hr />
<p>注意：暫存區要搭配顯示風格為 3 (表格式) 才能測試</p>
<hr />
<p>

<h2>清除項目</h2>
<input type="button" value="Clear" id="btn_clear">

<h2>顯示項目</h2>
<p><a href="javascript:show_content();">列出各筆資料</a></p>
HEREDOC;

$js_after = '
<script src="storage_core.js"></script>
<script src="storage_show.js"></script>
';

include 'pagemake.php';
pagemake($html, '', $js_after);
?>
<?php

$html = <<< HEREDOC
<button onclick="history.back();">返回</button>
<h2>新增資料</h2>
<form action="add_save.php" method="post">
<table>
   <tr><th>年度</th><td><input type="text" name="filmyear" value=""></td></tr>
   <tr><th>首映日期</th><td><input type="text" name="pub_date" value=""></td></tr>
   <tr><th>片名</th><td><input type="text" name="title_c" value=""></td></tr>
   <tr><th>英文片名</th><td><input type="text" name="title_e" value=""></td></tr>
   <tr><th>國家</th><td><input type="text" name="area" value=""></td></tr>
   <tr><th>評分</th><td><input type="text" name="rate" value=""></td></tr>
   <tr><th>key-維基</th><td><input type="text" name="key_wiki" value=""></td></tr>
   <tr><th>key-IMDb</th><td><input type="text" name="key_imdb" value=""></td></tr>
   <tr><th>key-豆瓣</th><td><input type="text" name="key_dban" value=""></td></tr>
   <tr><th>key-筆記</th><td><input type="text" name="key_note" value=""></td></tr>
   <tr><th>tag-人員</th><td><input type="text" name="tag_cast" value=""></td></tr>
   <tr><th>tag-note</th><td><input type="text" name="tag_note" value=""></td></tr>
   <tr><th>備註</th><td><input type="text" name="remark" value=""></td></tr>
</table>
<p><input type="submit" value="新增"></p>
</form>
HEREDOC;

include 'pagemake.php';
pagemake($html, '');
?>
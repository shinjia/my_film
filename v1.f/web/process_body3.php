<?php

$html = <<< HEREDOC
<h2 align="center">{$title_type}</h2>
<p align="center">共有 $total_rec 筆記錄</p>
{$ihc_navigator}

<div style="width:50%; margin:auto;">
<table border="1" align="center">
   <tr>
      <th>首映日</th>
      <th>片名</th>
      <th>英名片名</th>
      <th>國家</th>
      <th>評分</th>
      <th>Google</th>
      <th>Wiki</th>
      <th>IMDb</th>
      <th>豆瓣</th>
      <th>筆記</th>
      <th>備註</th>
      <th colspan="2">OMDB API</th>
   </tr>
{$data}
</table>
</div>
HEREDOC;


?>
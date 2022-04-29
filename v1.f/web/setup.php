<?php
include '../common/define.php';

$refer = $_SERVER['HTTP_REFERER'];  // 呼叫此程式之前頁

$cc_numpp = isset($_COOKIE['cc_numpp']) ? $_COOKIE['cc_numpp'] : DEF_CC_NUMPP;
$cc_order = isset($_COOKIE['cc_order']) ? $_COOKIE['cc_order'] : DEF_CC_ORDER;
$cc_style = isset($_COOKIE['cc_style']) ? $_COOKIE['cc_style'] : DEF_CC_STYLE;
$cc_watch = isset($_COOKIE['cc_watch']) ? $_COOKIE['cc_watch'] : DEF_CC_WATCH;

// 處理『cc_order』的 RADIO 選項
$str_order = '';
foreach($a_cc_order as $k=>$value)
{
    $str1 = ($cc_order==$k) ? 'checked' : '';
    $str_order .= '<input type="radio" name="cc_order" value="' . $k . '" ' . $str1 . '>' . $value;
    $str_order .= '&nbsp;&nbsp;&nbsp;&nbsp;';
}

// 顯示『cc_style』的 Select..Option 選項
$str_style = '<select name="cc_style">';
foreach($a_cc_style as $k=>$value)
{
    $str1 = ($cc_style==$k) ? 'selected' : '';
    $str_style .= '<option value="' . $k . '" ' . $str1 . '>' . $value . '</option>';
}
$str_style .= '</select>';

// 處理『watch』的 Checkbox 選項
$str_watch = '';
foreach($a_cc_watch as $k=>$value)
{
    $str1 = (isset($a_cc_watch[$cc_watch])) ? 'checked' : '';
    $str_watch = '<input type="checkbox" name="cc_watch" value="' . $k . '"' . $str1 . '/>' . $value;
}



$html = <<< HEREDOC
<h2>設定</h2>
<form method="post" action="setup_x.php">

<div style="width:80%; margin:auto;">
<!--
<table style="padding:10px;">
    <tr>
        <th align="right">單頁顯示筆數：</th>
        <td align="left"><input type="text" name="cc_numpp" size="3"></td>
    </tr>
    <tr>
        <th align="right">排序：</th>
        <td align="left">
            <input type="radio" name="cc_order" value="NEW"> 由新到舊
            <input type="radio" name="cc_order" value="OLD"> 由舊到新
        </td>
    </tr>
    <tr>
        <th align="right">顯示風格：</th>
        <td align="left">
            <select name="cc_style">
                <option value="1">大海報</option>
                <option value="2">小海報</option>
                <option value="3">表格</option>
                <option value="4">精簡清單</option>
            </select>
        </td>
    </tr>
    <tr>
        <th align="right">顯示最新瀏覽項目：</th>
        <td align="left">
            <input type="checkbox" name="cc_watch" value="Y"> 是
        </td>
    </tr>
    <tr>
        <td colspan="2">
            </p>&nbsp;</p>
            <input type="submit" value="儲存">
        </td>
    </tr>
</table>
-->

<table style="padding:10px;">
    <tr>
        <th align="right">單頁顯示筆數：</th>
        <td align="left"><input type="text" name="cc_numpp" size="3" value="{$cc_numpp}"></td>
    </tr>
    <tr>
        <th align="right">排序：</th>
        <td align="left">
            {$str_order}
        </td>
    </tr>
    <tr>
        <th align="right">顯示風格：</th>
        <td align="left">
            {$str_style}
        </td>
    </tr>
    <tr>
        <th align="right">顯示最新瀏覽項目：</th>
        <td align="left">
            {$str_watch}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            </p>&nbsp;</p>
            <input type="submit" value="儲存">
        </td>
    </tr>
</table>

</div>

<input type="hidden" name="refer" value="{$refer}">
</form>

HEREDOC;

include 'pagemake.php';
pagemake($html);
?>
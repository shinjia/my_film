<?php
session_start();

include '../common/config.php';
include '../common/utility.php';
include '../common/define.php';

$ss_usertype = isset($_SESSION["usertype"]) ? $_SESSION["usertype"] : "";
$ss_usercode = isset($_SESSION["usercode"]) ? $_SESSION["usercode"] : "";


if($ss_usertype!=DEF_LOGIN_ADMIN)
{
   header("Location: error.php");
   exit;
}

//*****以上是權限控管 *****



// 接受外部表單傳入之變數
$uid = isset($_POST['uid']) ? $_POST['uid'] : '';

$filmyear = isset($_POST['filmyear']) ? $_POST['filmyear'] : '';
$pub_date = isset($_POST['pub_date']) ? $_POST['pub_date'] : '';
$title_c  = isset($_POST['title_c']) ? $_POST['title_c'] : '';
$title_e  = isset($_POST['title_e']) ? $_POST['title_e'] : '';
$area     = isset($_POST['area'])    ? $_POST['area'] : '';
$rate     = isset($_POST['rate'])    ? $_POST['rate'] : '';
$key_wiki = isset($_POST['key_wiki']) ? $_POST['key_wiki'] : '';
$key_imdb = isset($_POST['key_imdb']) ? $_POST['key_imdb'] : '';
$key_dban = isset($_POST['key_dban']) ? $_POST['key_dban'] : '';
$key_note = isset($_POST['key_note']) ? $_POST['key_note'] : '';
$tag_cast = isset($_POST['tag_cast']) ? $_POST['tag_cast'] : '';
$tag_note = isset($_POST['tag_note']) ? $_POST['tag_note'] : '';
$remark   = isset($_POST['remark'])   ? $_POST['remark']   : '';

// 連接資料庫
$pdo = db_open();

// 寫出 SQL 語法
$sqlstr = "UPDATE film SET filmyear=:filmyear, pub_date=:pub_date, title_c=:title_c, title_e=:title_e, area=:area, rate=:rate, key_wiki=:key_wiki, key_imdb=:key_imdb, key_dban=:key_dban, key_note=:key_note, tag_cast=:tag_cast, tag_note=:tag_note, remark=:remark WHERE uid=:uid ";

$sth = $pdo->prepare($sqlstr);
$sth->bindParam(':filmyear', $filmyear, PDO::PARAM_STR);
$sth->bindParam(':pub_date', $pub_date, PDO::PARAM_STR);
$sth->bindParam(':title_c' , $title_c , PDO::PARAM_STR);
$sth->bindParam(':title_e' , $title_e , PDO::PARAM_STR);
$sth->bindParam(':area'    , $area    , PDO::PARAM_STR);
$sth->bindParam(':rate'    , $rate    , PDO::PARAM_INT);
$sth->bindParam(':key_wiki', $key_wiki, PDO::PARAM_STR);
$sth->bindParam(':key_imdb', $key_imdb, PDO::PARAM_STR);
$sth->bindParam(':key_dban', $key_dban, PDO::PARAM_STR);
$sth->bindParam(':key_note', $key_note, PDO::PARAM_STR);
$sth->bindParam(':tag_cast', $tag_cast, PDO::PARAM_STR);
$sth->bindParam(':tag_note', $tag_note, PDO::PARAM_STR);
$sth->bindParam(':remark'  , $remark  , PDO::PARAM_STR);
$sth->bindParam(':uid'     , $uid     , PDO::PARAM_INT);

// 執行SQL及處理結果
if($sth->execute())
{
   $url_display = 'display.php?uid=' . $uid;
   header('Location: ' . $url_display);
}
else
{
   echo print_r($pdo->errorInfo()) . '<br />' . $sqlstr; exit; // 此列供開發時期偵錯用
   header('Location: error.php');
}
?>
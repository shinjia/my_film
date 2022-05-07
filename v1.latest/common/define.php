<?php

define('URL_ROOT', 'http://localhost/myweb/my_film/');  // 網站根目錄

// 用於系統檢查 (如uid,chk)
define('SYSTEM_CODE', 'FLM');

// 登入權限檢查的判斷條件，不同的系統要改名稱
define('DEF_LOGIN_ADMIN', 'FLM_ADMIN');   // 登入檢查，ADMIN
define('DEF_LOGIN_MEMBER', 'FLM_MEMBER');   // 登入檢查，MEMBER

// 畫面上顯示的資訊
define('MASTER_COMPANY_NAME', '怪博士');   // 公司名稱
define('MASTER_COMPANY_EMAIL', 'shinjia168@gmail.comm');   // 公司信箱


// 設定的變數 (使用 Cookie)
define('DEF_CC_NUMPP', 12);     // 單頁顯示筆數
define('DEF_CC_ORDER', 'NEW');  // 排序，依時間 (NEW/OLD)
define('DEF_CC_STYLE', '1');    // 顯示設計風格 (1/2/3/4)
define('DEF_CC_WATCH', '');    // 顯示最新瀏覽 (注意：Checkbox放遠都是設成空白)

// 設定『cc_order』的值域選項
$a_cc_order = array(
    "NEW"=>"由新到舊" ,
    "OLD"=>"由舊到新" );

// 設定『cc_style』的值域選項
$a_cc_style = array(
    "1"=>"大海報",
    "2"=>"小海報",
    "3"=>"表格",
    "4"=>"精簡清單");

// 設定『cc_watch』的值域選項
$a_cc_watch = array(
    "Y"=>"要顯示" );

?>
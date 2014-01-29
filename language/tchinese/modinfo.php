<?php
include_once XOOPS_ROOT_PATH."/modules/tadtools/language/{$xoopsConfig['language']}/modinfo_common.php";

define('_MI_TADEVALUA_NAME','評鑑檔案管理');
define('_MI_TADEVALUA_AUTHOR','tad');
define('_MI_TADEVALUA_CREDITS','');
define('_MI_TADEVALUA_DESC','此模組用來生成各種評鑑頁面');
define('_MI_TADEVALUA_AUTHOR_WEB','Tad 教材網');
define("_MI_TADEVALUA_ADMENU1", "評鑑管理");
define("_MI_TADEVALUA_ADMENU1_DESC", "評鑑管理");
define("_MI_TADEVALUA_BNAME1","評鑑列表");
define("_MI_TADEVALUA_BDESC1","評鑑列表(tad_evaluation_list)");
define("_MI_TADEVALUA_IGNORED","不匯入的檔案");
define("_MI_TADEVALUA_IGNORED_DESC","一些系統檔案不想匯入的可在此設定，請以「;」隔開");
define("_MI_TADEVALUA_USE_TAB","把第一層指標設為頁籤");
define("_MI_TADEVALUA_USE_TAB_DESC","若指標很多，可將第一層指標（目錄）設為頁籤");
define("_MI_TADEVALUA_OS_CHARSET","主機檔案系統的中文編碼");
define("_MI_TADEVALUA_OS_CHARSET_DESC","一般來說，Windows為Big5，Linux為UTF-8，但仍有例外，故請自行設定，不確定的可選 Auto 自動判斷。");

?>
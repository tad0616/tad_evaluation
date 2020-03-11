<?php
xoops_loadLanguage('modinfo_common', 'tadtools');
define('_MI_TADEVALUA_NAME', '評鑑檔案管理');
define('_MI_TADEVALUA_AUTHOR', 'tad');
define('_MI_TADEVALUA_CREDITS', 'Michael Beck');
define('_MI_TADEVALUA_DESC', '此模組用來生成各種評鑑頁面');
define('_MI_TADEVALUA_AUTHOR_WEB', 'Tad 教材網');
define('_MI_TADEVALUA_ADMENU1', '評鑑管理');
define('_MI_TADEVALUA_ADMENU1_DESC', '評鑑管理');
define('_MI_TADEVALUA_BNAME1', '評鑑列表');
define('_MI_TADEVALUA_BDESC1', '評鑑列表(tad_evaluation_list)');
define('_MI_TADEVALUA_IGNORED', '不匯入的檔案');
define('_MI_TADEVALUA_IGNORED_DESC', '一些系統檔案不想匯入的可在此設定，請以「;」隔開');
define('_MI_TADEVALUA_USE_TAB', '把第一層指標設為頁籤');
define('_MI_TADEVALUA_USE_TAB_DESC', '若指標很多，可將第一層指標（目錄）設為頁籤');
define('_MI_TADEVALUA_OS_CHARSET', '主機檔案系統的中文編碼');
define('_MI_TADEVALUA_OS_CHARSET_DESC', '一般來說，Windows為Big5，Linux為UTF-8，但仍有例外，故請自行設定，不確定的可選 Auto 自動判斷。');
define('_MI_TADEVALUA_USE_GOOGLE_DOC', '使用Google閱讀器直接開啟檔案');
define('_MI_TADEVALUA_USE_GOOGLE_DOC_DESC', '如此可以直接線上觀看檔案內容，無須下載');
define('_MI_TADEVALUA_CSS_SETUP', '各階層的外觀樣式設定');
define('_MI_TADEVALUA_CSS_SETUP_DESC', '一行是一組設定，每一行格式為：「.level1{font-size:100%;color:blue;....}」，第一層為「.level1」，第二層為「.level2」...依此類推。');

define('_MI_TADEVALUA_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADEVALUA_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_TADEVALUA_BACK_2_ADMIN', '管理');

//help
define('_MI_TADEVALUA_HELP_OVERVIEW', '概要');

define('_MI_TADEVALUA_USE_OFFICE_VIEWER', 'MS Office文件使用線上檢視器');
define('_MI_TADEVALUA_USE_OFFICE_VIEWER_DESC', '是否針對MS Office文件格式使用線上檢視器');

<?php

$modversion = [];
global $xoopsConfig;

//---模組基本資訊---//
$modversion['name'] = _MI_TADEVALUA_NAME;
// $modversion['version'] = '2.7';
$modversion['version'] = $_SESSION['xoops_version'] >= 20511 ? '3.0.0-Stable' : '3.0';
$modversion['description'] = _MI_TADEVALUA_DESC;
$modversion['author'] = _MI_TADEVALUA_AUTHOR;
$modversion['credits'] = _MI_TADEVALUA_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GPL see LICENSE';
$modversion['image'] = 'images/logo.png';
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2022-06-21';
$modversion['module_website_url'] = 'https://tad0616.net';
$modversion['module_website_name'] = _MI_TADEVALUA_AUTHOR_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://tad0616.net';
$modversion['author_website_name'] = _MI_TADEVALUA_AUTHOR_WEB;
$modversion['min_php'] = 5.4;
$modversion['min_xoops'] = '2.5';

//---paypal資訊---//
$modversion['paypal'] = [
    'business' => 'tad0616@gmail.com',
    'item_name' => 'Donation : ' . _MI_TAD_WEB,
    'amount' => 0,
    'currency_code' => 'USD',
];

//---安裝設定---//
$modversion['onInstall'] = 'include/onInstall.php';
$modversion['onUpdate'] = 'include/onUpdate.php';
$modversion['onUninstall'] = 'include/onUninstall.php';

//---搜尋設定---//
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.php';
$modversion['search']['func'] = 'tad_evaluation_search';

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1; //---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'] = [
    'tad_evaluation',
    'tad_evaluation_files',
    'tad_evaluation_cate',
];

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/main.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---樣板設定---//
$modversion['templates'] = [
    ['file' => 'tad_evaluation_admin.tpl', 'description' => 'tad_evaluation_admin.tpl'],
    ['file' => 'tad_evaluation_index.tpl', 'description' => 'tad_evaluation_index.tpl'],
];

//---區塊設定---//
$modversion['blocks'] = [
    ['file' => 'tad_evaluation_list.php', 'name' => _MI_TADEVALUA_BNAME1, 'description' => _MI_TADEVALUA_BDESC1, 'show_func' => 'tad_evaluation_list', 'template' => 'tad_evaluation_block_list.tpl'],
];

$modversion['config'] = [
    ['name' => 'ignored', 'title' => '_MI_TADEVALUA_IGNORED', 'description' => '_MI_TADEVALUA_IGNORED_DESC', 'formtype' => 'textarea', 'valuetype' => 'text', 'default' => 'Thumbs.db'],
    ['name' => 'os_charset', 'title' => '_MI_TADEVALUA_OS_CHARSET', 'description' => '_MI_TADEVALUA_OS_CHARSET_DESC', 'formtype' => 'select', 'valuetype' => 'text', 'default' => 'Auto', 'options' => ['Auto' => 'Auto', 'UTF-8' => 'UTF-8', 'Big5' => 'Big5']],
    ['name' => 'css_setup', 'title' => '_MI_TADEVALUA_CSS_SETUP', 'description' => '_MI_TADEVALUA_CSS_SETUP_DESC', 'formtype' => 'textarea', 'valuetype' => 'text', 'default' => '.level1{font-size:125%;color:#800040;line-height:150%;} .level2{font-size:112.5%;color:#00274F;line-height:150%;} .level3{font-size:100%;color:#003737;line-height:150%;} .level4{font-size:87.5%;color:#542929;line-height:150%;} .level5{font-size:75%;color:#000000;line-height:150%;}'],
];

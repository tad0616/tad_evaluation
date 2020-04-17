<?php

$modversion = [];

//---模組基本資訊---//
$modversion['name'] = _MI_TADEVALUA_NAME;
$modversion['version'] = '2.23';
$modversion['description'] = _MI_TADEVALUA_DESC;
$modversion['author'] = _MI_TADEVALUA_AUTHOR;
$modversion['credits'] = _MI_TADEVALUA_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GPL see LICENSE';
$modversion['image'] = 'images/logo.png';
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2020/03/14';
$modversion['module_website_url'] = 'https://tad0616.net';
$modversion['module_website_name'] = _MI_TADEVALUA_AUTHOR_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://tad0616.net';
$modversion['author_website_name'] = _MI_TADEVALUA_AUTHOR_WEB;
$modversion['min_php'] = 5.4;
$modversion['min_xoops'] = '2.5';

//---paypal資訊---//
$modversion['paypal'] = [];
$modversion['paypal']['business'] = 'tad0616@gmail.com';
$modversion['paypal']['item_name'] = 'Donation :' . _MI_TADEVALUA_AUTHOR;
$modversion['paypal']['amount'] = 0;
$modversion['paypal']['currency_code'] = 'USD';

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
$modversion['tables'][1] = 'tad_evaluation';
$modversion['tables'][2] = 'tad_evaluation_files';
$modversion['tables'][3] = 'tad_evaluation_cate';

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/main.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---樣板設定---//
$i = 0;
$modversion['templates'][$i]['file'] = 'tad_evaluation_adm_main.tpl';
$modversion['templates'][$i]['description'] = 'tad_evaluation_adm_main.tpl';

$i++;
$modversion['templates'][$i]['file'] = 'tad_evaluation_index.tpl';
$modversion['templates'][$i]['description'] = 'tad_evaluation_index.tpl';

//---區塊設定---//
$i = 0;
$modversion['blocks'][$i]['file'] = 'tad_evaluation_list.php';
$modversion['blocks'][$i]['name'] = _MI_TADEVALUA_BNAME1;
$modversion['blocks'][$i]['description'] = _MI_TADEVALUA_BDESC1;
$modversion['blocks'][$i]['show_func'] = 'tad_evaluation_list';
$modversion['blocks'][$i]['template'] = 'tad_evaluation_block_list.tpl';

$i = 1;
$modversion['config'][$i]['name'] = 'ignored';
$modversion['config'][$i]['title'] = '_MI_TADEVALUA_IGNORED';
$modversion['config'][$i]['description'] = '_MI_TADEVALUA_IGNORED_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'Thumbs.db';

$i++;
$modversion['config'][$i]['name'] = 'os_charset';
$modversion['config'][$i]['title'] = '_MI_TADEVALUA_OS_CHARSET';
$modversion['config'][$i]['description'] = '_MI_TADEVALUA_OS_CHARSET_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'Auto';
$modversion['config'][$i]['options'] = ['Auto' => 'Auto', 'UTF-8' => 'UTF-8', 'Big5' => 'Big5'];

$i++;
$modversion['config'][$i]['name'] = 'use_google_doc';
$modversion['config'][$i]['title'] = '_MI_TADEVALUA_USE_GOOGLE_DOC';
$modversion['config'][$i]['description'] = '_MI_TADEVALUA_USE_GOOGLE_DOC_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';

$i++;
$modversion['config'][$i]['name'] = 'css_setup';
$modversion['config'][$i]['title'] = '_MI_TADEVALUA_CSS_SETUP';
$modversion['config'][$i]['description'] = '_MI_TADEVALUA_CSS_SETUP_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.level1{font-size:125%;color:#800040;line-height:150%;}
.level2{font-size:112.5%;color:#00274F;line-height:150%;}
.level3{font-size:100%;color:#003737;line-height:150%;}
.level4{font-size:87.5%;color:#542929;line-height:150%;}
.level5{font-size:75%;color:#000000;line-height:150%;}';

$i++;
$modversion['config'][$i]['name'] = 'use_office_viewer';
$modversion['config'][$i]['title'] = '_MI_TADEVALUA_USE_OFFICE_VIEWER';
$modversion['config'][$i]['description'] = '_MI_TADEVALUA_USE_OFFICE_VIEWER_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';

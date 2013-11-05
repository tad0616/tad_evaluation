<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2013-10-23
// $Id:$
// ------------------------------------------------------------------------- //

$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_TADEVALUA_NAME;
$modversion['version']	= '1.21';
$modversion['description'] = _MI_TADEVALUA_DESC;
$modversion['author'] = _MI_TADEVALUA_AUTHOR;
$modversion['credits']	= _MI_TADEVALUA_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license']		= 'GPL see LICENSE';
$modversion['image']		= "images/logo.png";
$modversion['dirname'] = basename(dirname(__FILE__));


//---模組狀態資訊---//
$modversion['status_version'] = '1.21';
$modversion['release_date'] = '2013-11-05';
$modversion['module_website_url'] = 'http://tad0616.net';
$modversion['module_website_name'] = _MI_TADEVALUA_AUTHOR_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://tad0616.net';
$modversion['author_website_name'] = _MI_TADEVALUA_AUTHOR_WEB;
$modversion['min_php']= 5.2;
$modversion['min_xoops']='2.5';


//---paypal資訊---//
$modversion ['paypal'] = array();
$modversion ['paypal']['business'] = 'tad0616@gmail.com';
$modversion ['paypal']['item_name'] = 'Donation :'. _MI_TADEVALUA_AUTHOR;
$modversion ['paypal']['amount'] = 0;
$modversion ['paypal']['currency_code'] = 'USD';

//---安裝設定---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";


//---搜尋設定---//
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.php";
$modversion['search']['func'] = "tad_evaluation_search";


//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "tad_evaluation";
$modversion['tables'][2] = "tad_evaluation_files";
$modversion['tables'][3] = "tad_evaluation_cate";

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/main.php";
$modversion['adminmenu'] = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;


//---樣板設定---//
$i=0;
$modversion['templates'][$i]['file'] = 'tad_evaluation_adm_main.html';
$modversion['templates'][$i]['description'] = 'tad_evaluation_adm_main.html';

$i++;
$modversion['templates'][$i]['file'] = 'tad_evaluation_index.html';
$modversion['templates'][$i]['description'] = 'tad_evaluation_index.html';

//---區塊設定---//
$i=0;
$modversion['blocks'][$i]['file'] = "tad_evaluation_list.php";
$modversion['blocks'][$i]['name'] = _MI_TADEVALUA_BNAME1;
$modversion['blocks'][$i]['description'] = _MI_TADEVALUA_BDESC1;
$modversion['blocks'][$i]['show_func'] = "tad_evaluation_list";
$modversion['blocks'][$i]['template'] = "tad_evaluation_block_tad_evaluation_list.html";

$modversion['config'][1]['name']    = 'ignored';
$modversion['config'][1]['title']   = '_MI_TADEVALUA_IGNORED';
$modversion['config'][1]['description'] = '_MI_TADEVALUA_IGNORED_DESC';
$modversion['config'][1]['formtype']    = 'textarea';
$modversion['config'][1]['valuetype']   = 'text';
$modversion['config'][1]['default'] = 'Thumbs.db';

$modversion['config'][2]['name']    = 'use_tab';
$modversion['config'][2]['title']   = '_MI_TADEVALUA_USE_TAB';
$modversion['config'][2]['description'] = '_MI_TADEVALUA_USE_TAB_DESC';
$modversion['config'][2]['formtype']    = 'yesno';
$modversion['config'][2]['valuetype']   = 'int';
$modversion['config'][2]['default'] = '1';

$modversion['config'][3]['name']    = 'os_charset';
$modversion['config'][3]['title']   = '_MI_TADEVALUA_OS_CHARSET';
$modversion['config'][3]['description'] = '_MI_TADEVALUA_OS_CHARSET_DESC';
$modversion['config'][3]['formtype']    = 'select';
$modversion['config'][3]['valuetype']   = 'text';
$modversion['config'][3]['default'] = 'Auto';
$modversion['config'][3]['options'] = array('Auto'=>'Auto','UTF-8'=>'UTF-8','Big5'=>'Big5');


?>
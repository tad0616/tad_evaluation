<?php

$modversion = array();

//---模組基本資訊---//
$modversion['name']        = _MI_TADEVALUA_NAME;
$modversion['version']     = '1.81';
$modversion['description'] = _MI_TADEVALUA_DESC;
$modversion['author']      = _MI_TADEVALUA_AUTHOR;
$modversion['credits']     = _MI_TADEVALUA_CREDITS;
$modversion['help']        = 'page=help';
$modversion['license']     = 'GPL see LICENSE';
$modversion['image']       = "images/logo.png";
$modversion['dirname']     = basename(dirname(__FILE__));

//---模組狀態資訊---//
$modversion['release_date']        = '2015-07-12';
$modversion['module_website_url']  = 'http://tad0616.net';
$modversion['module_website_name'] = _MI_TADEVALUA_AUTHOR_WEB;
$modversion['module_status']       = 'release';
$modversion['author_website_url']  = 'http://tad0616.net';
$modversion['author_website_name'] = _MI_TADEVALUA_AUTHOR_WEB;
$modversion['min_php']             = 5.2;
$modversion['min_xoops']           = '2.5';

//---paypal資訊---//
$modversion['paypal']                  = array();
$modversion['paypal']['business']      = 'tad0616@gmail.com';
$modversion['paypal']['item_name']     = 'Donation :' . _MI_TADEVALUA_AUTHOR;
$modversion['paypal']['amount']        = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---安裝設定---//
$modversion['onInstall']   = "include/onInstall.php";
$modversion['onUpdate']    = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---搜尋設定---//
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = "include/search.php";
$modversion['search']['func'] = "tad_evaluation_search";

//---啟動後台管理界面選單---//
$modversion['system_menu']      = 1; //---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1]        = "tad_evaluation";
$modversion['tables'][2]        = "tad_evaluation_files";
$modversion['tables'][3]        = "tad_evaluation_cate";

//---管理介面設定---//
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/main.php";
$modversion['adminmenu']  = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---樣板設定---//
$i                                          = 0;
$modversion['templates'][$i]['file']        = 'tad_evaluation_adm_main.html';
$modversion['templates'][$i]['description'] = 'tad_evaluation_adm_main.html';

$i++;
$modversion['templates'][$i]['file']        = 'tad_evaluation_adm_main_b3.html';
$modversion['templates'][$i]['description'] = 'tad_evaluation_adm_main_b3.html';

$i++;
$modversion['templates'][$i]['file']        = 'tad_evaluation_index.html';
$modversion['templates'][$i]['description'] = 'tad_evaluation_index.html';

$i++;
$modversion['templates'][$i]['file']        = 'tad_evaluation_index_b3.html';
$modversion['templates'][$i]['description'] = 'tad_evaluation_index_b3.html';

//---區塊設定---//
$i                                       = 0;
$modversion['blocks'][$i]['file']        = "tad_evaluation_list.php";
$modversion['blocks'][$i]['name']        = _MI_TADEVALUA_BNAME1;
$modversion['blocks'][$i]['description'] = _MI_TADEVALUA_BDESC1;
$modversion['blocks'][$i]['show_func']   = "tad_evaluation_list";
$modversion['blocks'][$i]['template']    = "tad_evaluation_block_list.html";

$modversion['config'][1]['name']        = 'ignored';
$modversion['config'][1]['title']       = '_MI_TADEVALUA_IGNORED';
$modversion['config'][1]['description'] = '_MI_TADEVALUA_IGNORED_DESC';
$modversion['config'][1]['formtype']    = 'textarea';
$modversion['config'][1]['valuetype']   = 'text';
$modversion['config'][1]['default']     = 'Thumbs.db';

$modversion['config'][2]['name']        = 'os_charset';
$modversion['config'][2]['title']       = '_MI_TADEVALUA_OS_CHARSET';
$modversion['config'][2]['description'] = '_MI_TADEVALUA_OS_CHARSET_DESC';
$modversion['config'][2]['formtype']    = 'select';
$modversion['config'][2]['valuetype']   = 'text';
$modversion['config'][2]['default']     = 'Auto';
$modversion['config'][2]['options']     = array('Auto' => 'Auto', 'UTF-8' => 'UTF-8', 'Big5' => 'Big5');

$modversion['config'][3]['name']        = 'use_google_doc';
$modversion['config'][3]['title']       = '_MI_TADEVALUA_USE_GOOGLE_DOC';
$modversion['config'][3]['description'] = '_MI_TADEVALUA_USE_GOOGLE_DOC_DESC';
$modversion['config'][3]['formtype']    = 'yesno';
$modversion['config'][3]['valuetype']   = 'int';
$modversion['config'][3]['default']     = '0';

$modversion['config'][4]['name']        = 'css_setup';
$modversion['config'][4]['title']       = '_MI_TADEVALUA_CSS_SETUP';
$modversion['config'][4]['description'] = '_MI_TADEVALUA_CSS_SETUP_DESC';
$modversion['config'][4]['formtype']    = 'textarea';
$modversion['config'][4]['valuetype']   = 'text';
$modversion['config'][4]['default']     = '.level1{font-size:20px;color:#800040;line-height:150%;}
.level2{font-size:18px;color:#00274F;line-height:150%;}
.level3{font-size:16px;color:#003737;line-height:150%;}
.level4{font-size:14px;color:#542929;line-height:150%;}
.level5{font-size:12px;color:#000000;line-height:150%;}';

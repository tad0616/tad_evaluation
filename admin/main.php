<?php
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_evaluation_adm_main.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
/*-----------功能函數區--------------*/

////tad_evaluation編輯表單
function tad_evaluation_form($evaluation_sn = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsUser;
    //include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
    //include_once(XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php");

    //抓取預設值
    if (!empty($evaluation_sn)) {
        $DBV = get_tad_evaluation($evaluation_sn);
    } else {
        $DBV = [];
    }

    //預設值設定

    //設定「evaluation_sn」欄位預設值
    $evaluation_sn = !isset($DBV['evaluation_sn']) ? $evaluation_sn : $DBV['evaluation_sn'];
    $xoopsTpl->assign('evaluation_sn', $evaluation_sn);

    //設定「evaluation_title」欄位預設值
    $evaluation_title = !isset($DBV['evaluation_title']) ? null : $DBV['evaluation_title'];
    $xoopsTpl->assign('evaluation_title', $evaluation_title);

    //設定「evaluation_description」欄位預設值
    $evaluation_description = !isset($DBV['evaluation_description']) ? '' : $DBV['evaluation_description'];
    $xoopsTpl->assign('evaluation_description', $evaluation_description);

    //設定「evaluation_enable」欄位預設值
    $evaluation_enable = !isset($DBV['evaluation_enable']) ? '1' : $DBV['evaluation_enable'];
    $xoopsTpl->assign('evaluation_enable', $evaluation_enable);

    //設定「evaluation_uid」欄位預設值
    $user_uid = ($xoopsUser) ? $xoopsUser->getVar('uid') : '';
    $evaluation_uid = !isset($DBV['evaluation_uid']) ? $user_uid : $DBV['evaluation_uid'];
    $xoopsTpl->assign('evaluation_uid', $evaluation_uid);

    //設定「evaluation_date」欄位預設值
    $evaluation_date = !isset($DBV['evaluation_date']) ? date('Y-m-d H:i:s') : $DBV['evaluation_date'];
    $xoopsTpl->assign('evaluation_date', $evaluation_date);

    $op = (empty($evaluation_sn)) ? 'insert_tad_evaluation' : 'update_tad_evaluation';
    //$op="replace_tad_evaluation";

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    //評鑑說明
    $ck = new CkEditor('tad_evaluation', 'evaluation_description', $evaluation_description);
    $ck->setHeight(100);
    $editor = $ck->render();

    $xoopsTpl->assign('evaluation_description_editor', $editor);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('now_op', 'tad_evaluation_form');
    $xoopsTpl->assign('next_op', $op);
}

//新增資料到tad_evaluation中
function insert_tad_evaluation()
{
    global $xoopsDB, $xoopsUser, $xoopsModuleConfig;

    //取得使用者編號
    $uid = ($xoopsUser) ? $xoopsUser->getVar('uid') : '';

    $myts = \MyTextSanitizer::getInstance();
    $_POST['evaluation_title'] = $myts->addSlashes($_POST['evaluation_title']);
    $_POST['evaluation_description'] = $myts->addSlashes($_POST['evaluation_description']);

    $sql = 'insert into `' . $xoopsDB->prefix('tad_evaluation') . "`
  (`evaluation_title` , `evaluation_description` , `evaluation_enable` , `evaluation_uid` , `evaluation_date`)
  values('{$_POST['evaluation_title']}' , '{$_POST['evaluation_description']}' , '{$_POST['evaluation_enable']}' , '{$uid}' , '" . date('Y-m-d H:i:s', xoops_getUserTimestamp(time())) . "')";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $evaluation_sn = $xoopsDB->getInsertId();

    $_POST['evaluation_title'] = change_charset($_POST['evaluation_title'], false);

    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$_POST['evaluation_title']}");

    return $evaluation_sn;
}

//更新tad_evaluation某一筆資料
function update_tad_evaluation($evaluation_sn = '')
{
    global $xoopsDB, $xoopsUser, $xoopsModuleConfig;
    $evaluation = get_tad_evaluation($evaluation_sn);

    //取得使用者編號
    $uid = ($xoopsUser) ? $xoopsUser->getVar('uid') : '';

    $myts = \MyTextSanitizer::getInstance();
    $_POST['evaluation_title'] = $myts->addSlashes($_POST['evaluation_title']);
    $_POST['evaluation_description'] = $myts->addSlashes($_POST['evaluation_description']);

    $sql = 'update `' . $xoopsDB->prefix('tad_evaluation') . "` set
   `evaluation_title` = '{$_POST['evaluation_title']}' ,
   `evaluation_description` = '{$_POST['evaluation_description']}' ,
   `evaluation_enable` = '{$_POST['evaluation_enable']}' ,
   `evaluation_uid` = '{$uid}' ,
   `evaluation_date` = '" . date('Y-m-d H:i:s', xoops_getUserTimestamp(time())) . "'
  where `evaluation_sn` = '$evaluation_sn'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $_POST['evaluation_title'] = change_charset($_POST['evaluation_title'], false);
    $evaluation['evaluation_title'] = change_charset($evaluation['evaluation_title'], false);

    if (is_dir(XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$evaluation['evaluation_title']}")) {
        if ($evaluation['evaluation_title'] != $_POST['evaluation_title']) {
            rename(XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$evaluation['evaluation_title']}", XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$_POST['evaluation_title']}");
        }
    } else {
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$_POST['evaluation_title']}");
    }

    return $evaluation_sn;
}

//列出所有tad_evaluation資料
function list_tad_evaluation()
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_evaluation') . '` ORDER BY evaluation_date DESC';

    //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = Utility::getPageBar($sql, 20, 10);
    $bar = $PageBar['bar'];
    $sql = $PageBar['sql'];
    $total = $PageBar['total'];

    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_content = [];
    $i = 0;
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $evaluation_sn , $evaluation_title , $evaluation_description , $evaluation_enable , $evaluation_uid , $evaluation_date
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $uid_name = \XoopsUser::getUnameFromId($evaluation_uid, 1);
        if (empty($uid_name)) {
            $uid_name = \XoopsUser::getUnameFromId($evaluation_uid, 0);
        }

        $all_content[$i]['evaluation_sn'] = $evaluation_sn;
        $all_content[$i]['evaluation_title'] = $evaluation_title;
        $all_content[$i]['evaluation_description'] = $evaluation_description;
        $all_content[$i]['evaluation_enable'] = $evaluation_enable;
        $all_content[$i]['evaluation_uid'] = $uid_name;
        $all_content[$i]['evaluation_date'] = $evaluation_date;
        $all_content[$i]['evaluation_path'] = XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$evaluation_title}/";

        $all_content[$i]['evaluation_cates'] = get_evaluation_count($evaluation_sn, 'tad_evaluation_cate');
        $all_content[$i]['evaluation_files'] = get_evaluation_count($evaluation_sn, 'tad_evaluation_files');
        $i++;
    }

    //刪除確認的JS

    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('isAdmin', $isAdmin);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('now_op', 'list_tad_evaluation');
}

//刪除tad_evaluation某筆資料資料
function delete_tad_evaluation($evaluation_sn = '')
{
    global $xoopsDB, $isAdmin;
    delete_tad_evaluation_cate($evaluation_sn, true);
    $sql = 'delete from `' . $xoopsDB->prefix('tad_evaluation') . "` where `evaluation_sn` = '{$evaluation_sn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

//以流水號秀出某筆tad_evaluation資料內容
function show_one_tad_evaluation($evaluation_sn = '')
{
    global $xoopsDB, $xoopsTpl, $isAdmin, $xoopsModuleConfig, $xoTheme;

    if (empty($evaluation_sn)) {
        return;
    }
    $evaluation_sn = (int) $evaluation_sn;

    $sql = 'select * from `' . $xoopsDB->prefix('tad_evaluation') . "` where `evaluation_sn` = '{$evaluation_sn}' ";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $all = $xoopsDB->fetchArray($result);

    //以下會產生這些變數： $evaluation_sn , $evaluation_title , $evaluation_description , $evaluation_enable , $evaluation_uid , $evaluation_date
    foreach ($all as $k => $v) {
        $$k = $v;
    }

    $uid_name = \XoopsUser::getUnameFromId($evaluation_uid, 1);
    if (empty($uid_name)) {
        $uid_name = \XoopsUser::getUnameFromId($evaluation_uid, 0);
    }

    $_SESSION['dir_count2'] = $_SESSION['file_count2'] = 0;
    $db_files = db_files(true, false, 'edit', $evaluation_sn);
    $xoopsTpl->assign('dir_count2', $_SESSION['dir_count2']);
    $xoopsTpl->assign('file_count2', $_SESSION['file_count2']);
    //die(var_dump($db_files));
    $xoopsTpl->assign('db_files', $db_files);
    $xoopsTpl->assign('evaluation_sn', $evaluation_sn);
    $xoopsTpl->assign('evaluation_title', $evaluation_title);
    $xoopsTpl->assign('evaluation_description', $evaluation_description);
    $xoopsTpl->assign('evaluation_enable', $evaluation_enable);
    $xoopsTpl->assign('uid_name', $uid_name);
    $xoopsTpl->assign('evaluation_date', $evaluation_date);

    $xoopsTpl->assign('now_op', 'show_one_tad_evaluation');
    $xoopsTpl->assign('title', $evaluation_title);
    $xoopsTpl->assign('evaluation_path', XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$evaluation_title}/");

    $evaluation_title = change_charset($evaluation_title, false);

    $dir = XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$evaluation_title}/";

    $all_files = directory_list($dir);

    $_SESSION['dir_count'] = $_SESSION['file_count'] = $_SESSION['pass_count'] = 0;
    $all = array_to_dir($all_files);

    $xoopsTpl->assign('all_files', $all);
    $xoopsTpl->assign('dir_count', $_SESSION['dir_count']);
    $xoopsTpl->assign('file_count', $_SESSION['file_count']);
    $xoopsTpl->assign('pass_count', $_SESSION['pass_count']);

    $FancyBox = new FancyBox(".evaluation_fancy_{$evaluation_sn}");
    $FancyBox->render();
}

//把陣列轉為目錄
function array_to_dir($all_files, $of_cate_sn = 0, $level = 0)
{
    global $xoopsModuleConfig;
    //忽略不匯入的檔案
    $ignored = explode(';', $xoopsModuleConfig['ignored']);

    $os = (PATH_SEPARATOR === ':') ? 'linux' : 'win';
    $all = '';
    $left = $level * 20;
    if (empty($level)) {
        $_SESSION['cate_sn'] = 1;
        $_SESSION['file_sn'] = 0;
        $_SESSION['i'] = 0;
    } else {
        $_SESSION['cate_sn']++;
    }
    $level++;

    foreach ($all_files as $dir_name => $files) {
        $_SESSION['i']++;
        $i = $_SESSION['i'];
        if (is_array($files)) {
            $dir_name = change_charset($dir_name, true);
            $dir_name = in_array($dir_name, $ignored) ? "<del>{$dir_name}</del>" : $dir_name;

            $_SESSION['dir_count']++;

            $all .= "
              <div style='margin-left:{$left}px'>
              <label class='checkbox inline'>
                <i class=\"icon-folder-open\"></i>
                {$dir_name}
              </label>
              </div>";
            $all .= array_to_dir($files, $_SESSION['cate_sn'], $level);
        } else {
            $files = change_charset($files, true);

            if (!empty($level)) {
                $_SESSION['file_sn']++;
            }

            if (in_array($files, $ignored) or '~$' === mb_substr($files, 0, 2)) {
                $files = "<del>{$files}</del>";
                $_SESSION['pass_count']++;
            } else {
                $_SESSION['file_count']++;
            }

            $all .= "
              <div style='margin-left:{$left}px;color:blue'>
              <label class='checkbox inline'>
              <i class=\"icon-file\"></i>
              {$files}
              </label>
              </div>";
        }
    }

    return $all;
}

/*
//匯入檔案
function tad_evaluation_import($evaluation_sn=""){
global $xoopsDB , $xoopsTpl , $isAdmin;

delete_tad_evaluation_cate($evaluation_sn,false);

$myts = \MyTextSanitizer::getInstance();

foreach($_POST['cates'] as $i=>$cate_data){
list($cate_sn,$of_cate_sn,$cate_title)=explode(";", $cate_data);
$cate_title=$myts->addSlashes($cate_title);
save_tad_evaluation_cate($evaluation_sn,$cate_title,$cate_sn,$of_cate_sn);
}

foreach($_POST['files'] as $i=>$file_data){
list($file_sn,$cate_sn,$file_name)=explode(";", $file_data);
$file_name=$myts->addSlashes($file_name);
save_tad_evaluation_files($evaluation_sn,$file_name,$file_sn,$cate_sn);
}
}
 */

//匯入檔案
function tad_evaluation_import($evaluation_sn = '')
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    $evaluation = get_tad_evaluation($evaluation_sn);
    delete_tad_evaluation_cate($evaluation_sn, false);

    $evaluation_title = change_charset($evaluation['evaluation_title'], false);
    $dir = XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$evaluation_title}/";

    $all_files = directory_list($dir);

    dir_to_db($evaluation_sn, $all_files);
}

//把陣列直接存入資料庫
function dir_to_db($evaluation_sn, $all_files, $of_cate_sn = 0, $level = 0)
{
    global $xoopsModuleConfig;

    $myts = \MyTextSanitizer::getInstance();
    //忽略不匯入的檔案
    $ignored = explode(';', $xoopsModuleConfig['ignored']);

    $os = (PATH_SEPARATOR === ':') ? 'linux' : 'win';
    $all = '';
    $left = $level * 20;
    if (empty($level)) {
        $_SESSION['cate_sn'] = 1;
        $_SESSION['file_sn'] = 0;
    } else {
        $_SESSION['cate_sn']++;
    }
    $level++;

    foreach ($all_files as $dir_name => $files) {
        if (is_array($files)) {
            $dir_name = change_charset($dir_name, true);
            if (!in_array($dir_name, $ignored)) {
                $cate_title = $myts->addSlashes($dir_name);
                save_tad_evaluation_cate($evaluation_sn, $cate_title, $_SESSION['cate_sn'], $of_cate_sn);

                dir_to_db($evaluation_sn, $files, $_SESSION['cate_sn'], $level);
            }
        } else {
            $files = change_charset($files, true);

            if (!empty($level)) {
                $_SESSION['file_sn']++;
            }

            if (!in_array($files, $ignored) and '~$' !== mb_substr($files, 0, 2)) {
                $file_name = $myts->addSlashes($files);
                save_tad_evaluation_files($evaluation_sn, $file_name, $_SESSION['file_sn'], $of_cate_sn);
            }
        }
    }
}

//匯入檔案
function save_tad_evaluation_cate($evaluation_sn, $cate_title, $cate_sn, $of_cate_sn)
{
    global $xoopsDB, $xoopsUser;
    $sql = 'insert into `' . $xoopsDB->prefix('tad_evaluation_cate') . "`
  (`cate_sn` , `of_cate_sn` , `cate_title` , `cate_desc` , `cate_sort` , `cate_enable` , `evaluation_sn`)
  values('{$cate_sn}','{$of_cate_sn}' , '{$cate_title}' , '' , '{$cate_sn}' , '1' , '{$evaluation_sn}')";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

//新增資料到tad_evaluation_files中
function save_tad_evaluation_files($evaluation_sn, $file_name, $file_sn, $cate_sn)
{
    global $xoopsDB, $xoopsUser, $xoopsModuleConfig;
    $evaluation = get_tad_evaluation($evaluation_sn);

    $real_evaluation_title = change_charset($evaluation['evaluation_title'], false);
    $real_file_name = change_charset($file_name, false);

    $file_src = XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$real_evaluation_title}/{$real_file_name}";

    $type = mime_content_type($file_src);
    $size = (int) filesize($file_src);

    $filepart = explode('.', $file_name);
    foreach ($filepart as $ff) {
        $ext = $ff;
    }

    $end = (mb_strlen($ext) + 1) * -1;
    $file_desc = mb_substr($file_name, 0, $end);

    $sql = 'insert into `' . $xoopsDB->prefix('tad_evaluation_files') . "`
  (`file_sn` , `cate_sn` , `evaluation_sn` , `file_name` , `file_size` , `file_type` , `file_desc` , `file_enable` , `file_sort`)
  values('{$file_sn}' , '{$cate_sn}' , '{$evaluation_sn}' , '{$file_name}' , '{$size}' , '{$type}' , '{$file_desc}' , '1' , '{$file_sn}')";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

//刪除某評鑑的所有分類
function delete_tad_evaluation_cate($evaluation_sn = '', $del_file = false)
{
    global $xoopsDB, $isAdmin, $xoopsModuleConfig;

    $evaluation = get_tad_evaluation($evaluation_sn);

    $real_evaluation_title = change_charset($evaluation['evaluation_title'], false);

    $dirname = XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$real_evaluation_title}";

    if ($del_file) {
        Utility::delete_directory($dirname);
    }

    $sql = 'delete from `' . $xoopsDB->prefix('tad_evaluation_cate') . "` where `evaluation_sn` = '{$evaluation_sn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $sql = 'delete from `' . $xoopsDB->prefix('tad_evaluation_files') . "` where `evaluation_sn` = '{$evaluation_sn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

//列出目錄檔案
function directory_list($directory_base_path = '')
{
    $myts = \MyTextSanitizer::getInstance();

    $directory_base_path = $myts->addSlashes($directory_base_path);

    $directory_base_path = rtrim($directory_base_path, '/') . '/';

    $result_list = [];

    $allfile = glob($directory_base_path . '*');
    // die(var_export($allfile));
    foreach ($allfile as $filename) {
        $filename = $myts->addSlashes($filename);
        $basefilename = str_replace($directory_base_path, '', $filename);

        if (is_dir($filename)) {
            $result_list[$basefilename] = directory_list($filename);
        } else {
            $ext = mb_strtolower(array_pop(explode('.', $filename)));
            $len = mb_strlen($ext);
            if ($len > 0 and $len <= 4) {
                $result_list[] = $basefilename;
            } else {
                $result_list[$basefilename] = directory_list($filename);
            }
        }
    }

    return $result_list;
}

if (!function_exists('mime_content_type')) {
    function mime_content_type($filename)
    {
        $mime_types = [
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ];

        $ext = mb_strtolower(array_pop(explode('.', $filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);

            return $mimetype;
        }

        return 'application/octet-stream';
    }
}
/*-----------執行動作判斷區----------*/
require_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$evaluation_sn = system_CleanVars($_REQUEST, 'evaluation_sn', 0, 'int');
$file_sn = system_CleanVars($_REQUEST, 'file_sn', 0, 'int');
$cate_sn = system_CleanVars($_REQUEST, 'cate_sn', 0, 'int');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    //替換資料
    case 'replace_tad_evaluation':
        replace_tad_evaluation();
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //新增資料
    case 'insert_tad_evaluation':
        $evaluation_sn = insert_tad_evaluation();
        header("location: {$_SERVER['PHP_SELF']}?evaluation_sn=$evaluation_sn");
        exit;

    //更新資料
    case 'update_tad_evaluation':
        update_tad_evaluation($evaluation_sn);
        header("location: {$_SERVER['PHP_SELF']}?evaluation_sn=$evaluation_sn");
        exit;

    //更新資料
    case 'tad_evaluation_form':
        tad_evaluation_form();
        break;
    //刪除資料
    case 'delete_tad_evaluation':
        delete_tad_evaluation($evaluation_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //匯入檔案
    case 'tad_evaluation_import':
        tad_evaluation_import($evaluation_sn);
        header("location: {$_SERVER['PHP_SELF']}?evaluation_sn=$evaluation_sn");
        exit;

    //預設動作
    default:
        if (empty($evaluation_sn)) {
            list_tad_evaluation();
        } else {
            tad_evaluation_form($evaluation_sn);
            show_one_tad_evaluation($evaluation_sn);
        }
        break;
        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('isAdmin', true);
$xoTheme->addStylesheet('modules/tadtools/css/font-awesome/css/font-awesome.css');

require_once __DIR__ . '/footer.php';

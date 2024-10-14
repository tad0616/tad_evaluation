<?php
use Xmf\Request;
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
require __DIR__ . '/header.php';
$xoopsOption['template_main'] = 'tad_evaluation_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$evaluation_sn = Request::getInt('evaluation_sn');
$file_sn = Request::getInt('file_sn');
$cate_sn = Request::getInt('cate_sn');

switch ($op) {
    //輸入表格
    case 'tad_evaluation_form':
        tad_evaluation_form($evaluation_sn);
        break;

    //刪除資料
    case 'delete_tad_evaluation':
        delete_tad_evaluation($evaluation_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //預設動作
    default:
        if (empty($evaluation_sn)) {
            list_tad_evaluation();
            $op = 'list_tad_evaluation';
        } elseif (!empty($file_sn)) {
            show_file($evaluation_sn, $cate_sn, $file_sn);
            $op = 'show_file';
        } else {
            show_tad_evaluation($evaluation_sn);
            $op = 'show_tad_evaluation';
        }
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu, false, $interface_icon));
require_once XOOPS_ROOT_PATH . '/footer.php';

/*-----------功能函數區--------------*/

//列出所有tad_evaluation資料
function list_tad_evaluation()
{
    global $xoopsDB, $xoopsTpl;

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_evaluation') . '` WHERE `evaluation_enable`=? ORDER BY `evaluation_date` DESC';
    $result = Utility::query($sql, 's', ['1']) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_content = [];
    $i = 0;
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $evaluation_enable = (1 == $evaluation_enable) ? _YES : _NO;
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
        $all_content[$i]['evaluation_cates'] = get_evaluation_count($evaluation_sn, 'tad_evaluation_cate');
        $all_content[$i]['evaluation_files'] = get_evaluation_count($evaluation_sn, 'tad_evaluation_files');
        $i++;
    }

    //刪除確認的JS
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('now_op', 'list_tad_evaluation');
    if ($_SESSION['tad_evaluation_adm']) {
        $SweetAlert = new SweetAlert();
        $SweetAlert->render("delete_tad_evaluation_func", "index.php?op=delete_tad_evaluation&evaluation_sn=", 'evaluation_sn');
    }
}

//以流水號秀出某筆tad_evaluation資料內容
function show_tad_evaluation($evaluation_sn = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $xoTheme;

    if (empty($evaluation_sn)) {
        return;
    }
    $evaluation_sn = (int) $evaluation_sn;

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_evaluation') . '` WHERE `evaluation_sn` = ?';
    $result = Utility::query($sql, 'i', [$evaluation_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

    $all = $xoopsDB->fetchArray($result);

    foreach ($all as $k => $v) {
        $$k = $v;
    }

    $evaluation_enable = (1 == $evaluation_enable) ? _YES : _NO;
    $uid_name = \XoopsUser::getUnameFromId($evaluation_uid, 1);
    if (empty($uid_name)) {
        $uid_name = \XoopsUser::getUnameFromId($evaluation_uid, 0);
    }

    $xoopsTpl->assign('evaluation_sn', $evaluation_sn);
    $xoopsTpl->assign('evaluation_title', "<a href='{$_SERVER['PHP_SELF']}?evaluation_sn={$evaluation_sn}'>{$evaluation_title}</a>");
    $xoopsTpl->assign('evaluation_description', $evaluation_description);
    $xoopsTpl->assign('evaluation_enable', $evaluation_enable);
    $xoopsTpl->assign('evaluation_uid', $uid_name);
    $xoopsTpl->assign('evaluation_date', $evaluation_date);
    $xoopsTpl->assign('evaluation_cates', get_evaluation_count($evaluation_sn, 'tad_evaluation_cate'));
    $xoopsTpl->assign('evaluation_files', get_evaluation_count($evaluation_sn, 'tad_evaluation_files'));

    $xoopsTpl->assign('now_op', 'show_tad_evaluation');
    $xoopsTpl->assign('title', $evaluation_title);

    // $xoopsTpl->assign('db_files' , db_files(false,false,'show',$evaluation_sn));
    $xoopsTpl->assign('db_files', db_files(false, false, 'show', $evaluation_sn));
    $xoopsTpl->assign('level_css', $xoopsModuleConfig['css_setup']);

    $FancyBox = new FancyBox(".evaluation_fancy_{$evaluation_sn}");
    $FancyBox->render(false);

    $xoTheme->addStylesheet('modules/tadtools/css/iconize.css');
}

//顯示檔案內容
function show_file($evaluation_sn, $cate_sn, $file_sn)
{
    global $xoopsDB, $xoopsTpl;

    $evaluation = get_tad_evaluation($evaluation_sn);
    $cate_path = get_tad_evaluation_cate_path($evaluation_sn, $cate_sn);
    $file = get_tad_evaluation_files($evaluation_sn, $cate_sn, $file_sn);
    $real_url = XOOPS_URL . "/uploads/tad_evaluation/{$evaluation['evaluation_title']}/{$cate_path}/{$file['file_name']}";
    header("location: $real_url");
    exit;
}

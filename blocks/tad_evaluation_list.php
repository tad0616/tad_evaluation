<?php
use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

//區塊主函式 (評鑑列表(tad_evaluation_list))
function tad_evaluation_list()
{
    global $xoopsDB, $xoTheme;
    $xoTheme->addStylesheet('modules/tadtools/css/vertical_menu.css');

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_evaluation') . '` WHERE `evaluation_enable`=? ORDER BY `evaluation_date` DESC LIMIT 0,10';
    $result = Utility::query($sql, 's', ['1']) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_content = [];
    $i = 0;
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $evaluation_sn , $evaluation_title , $evaluation_description , $evaluation_enable , $evaluation_uid , $evaluation_date
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $all_content[$i]['evaluation_sn'] = $evaluation_sn;
        $all_content[$i]['evaluation_title'] = $evaluation_title;
        $all_content[$i]['evaluation_description'] = $evaluation_description;
        $all_content[$i]['evaluation_uid'] = $uid_name;
        $all_content[$i]['evaluation_date'] = $evaluation_date;
        $i++;
    }

    return $all_content;
}

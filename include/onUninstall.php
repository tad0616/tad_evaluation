<?php

function xoops_module_uninstall_tad_evaluation(&$module)
{
    global $xoopsDB;
    $date = date('Ymd');

    rename(XOOPS_ROOT_PATH . '/uploads/tad_evaluation', XOOPS_ROOT_PATH . "/uploads/tad_evaluation_bak_{$date}");

    return true;
}

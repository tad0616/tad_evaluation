<?php
use XoopsModules\Tadtools\Utility;
require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
error_reporting(0);
$xoopsLogger->activated = false;

$cate_sn_Array = $_REQUEST['cate_sn-'];
$sort = 1;
foreach ($cate_sn_Array as $cate_sn) {
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_evaluation_cate') . '` SET `cate_sort`=? WHERE `cate_sn`=?';
    Utility::query($sql, 'ii', [$sort, $cate_sn]) or die(_MA_TADEVALUA_EVALUATION_SAVE_SORT_FAIL . ' (' . $sql . ')');

    $sort++;
}

$file_sn_Array = $_REQUEST['file_sn-'];
$sort = 1;
foreach ($file_sn_Array as $file_sn) {
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_evaluation_files') . '` SET `file_sort`=? WHERE `file_sn`=?';
    Utility::query($sql, 'ii', [$sort, $file_sn]) or die(_MA_TADEVALUA_EVALUATION_SAVE_SORT_FAIL . ' (' . $sql . ')');

    $sort++;
}

echo _MA_TADEVALUA_EVALUATION_SAVE_SORT_OK . ' (' . date('Y-m-d H:i:s') . "){$log}";

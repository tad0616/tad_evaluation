<?php
require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
$cate_sn_Array = $_REQUEST['cate_sn-'];
$sort = 1;
foreach ($cate_sn_Array as $cate_sn) {
    $sql = 'update ' . $xoopsDB->prefix('tad_evaluation_cate') . " set `cate_sort`='{$sort}' where `cate_sn`='{$cate_sn}'";
    $xoopsDB->queryF($sql) or die(_MA_TADEVALUA_EVALUATION_SAVE_SORT_FAIL . ' (' . $sql . ')');
    $sort++;
}

$file_sn_Array = $_REQUEST['file_sn-'];
$sort = 1;
foreach ($file_sn_Array as $file_sn) {
    $sql = 'update ' . $xoopsDB->prefix('tad_evaluation_files') . " set `file_sort`='{$sort}' where `file_sn`='{$file_sn}'";

    $xoopsDB->queryF($sql) or die(_MA_TADEVALUA_EVALUATION_SAVE_SORT_FAIL . ' (' . $sql . ')');
    $sort++;
}

echo _MA_TADEVALUA_EVALUATION_SAVE_SORT_OK . ' (' . date('Y-m-d H:i:s') . "){$log}";

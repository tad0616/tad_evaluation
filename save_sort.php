<?php
include_once "../../mainfile.php";
$sort = 1;
foreach ($_POST['cate'] as $cate_sn) {
  $sql="update ".$xoopsDB->prefix("tad_evaluation_cate")." set `cate_sort`='{$sort}' where `cate_sn`='{$cate_sn}'";
  $xoopsDB->queryF($sql) or die(_MD_TADEVALUA_EVALUATION_SAVE_SORT_FAIL." (".date("Y-m-d H:i:s").")");
  $sort++;
}

$sort = 1;
foreach ($_POST['file'] as $file_sn) {
  $sql="update ".$xoopsDB->prefix("tad_evaluation_files")." set `file_sort`='{$sort}' where `file_sn`='{$file_sn}'";
  $xoopsDB->queryF($sql) or die(_MD_TADEVALUA_EVALUATION_SAVE_SORT_FAIL." (".date("Y-m-d H:i:s").")");
  $sort++;
}
echo _MD_TADEVALUA_EVALUATION_SAVE_SORT_OK." (".date("Y-m-d H:i:s").")";
?>
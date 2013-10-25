<?php
include_once "header.php";
include_once "../function.php";

$evaluation_sn=intval($_GET['evaluation_sn']);
$evaluation=get_tad_evaluation($evaluation_sn);
$dirname=$evaluation['evaluation_title'];

$os=(PATH_SEPARATOR==':')?"linux":"win";
if($os=="win" and _CHARSET!="Big5")$dirname=iconv(_CHARSET, "Big5", $dirname);

if(file_exists(XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$dirname}.zip")){
  unlink(XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$dirname}.zip");
}

$FromDir=XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$dirname}";


$msg=shell_exec("zip -r -j ".XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$dirname}.zip $FromDir");

if(file_exists(XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$dirname}.zip")){
  header("location:".XOOPS_URL."/uploads/tad_evaluation/{$dirname}.zip");
}else{
  include_once('../class/pclzip.lib.php');
  $zipfile = new PclZip(XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$dirname}.zip");
  $v_list = $zipfile->create($FromDir,PCLZIP_OPT_REMOVE_PATH,XOOPS_ROOT_PATH."/uploads/tad_evaluation");

  if ($v_list == 0) {
    die("Error : ".$zipfile->errorInfo(true));
  }else{
    if($os=="win" and _CHARSET!="Big5")$dirname=iconv("Big5", _CHARSET, $dirname);
    header("location:".XOOPS_URL."/uploads/tad_evaluation/{$dirname}.zip");
  }
}

exit;


?>

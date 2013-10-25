<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2013-10-23
// $Id:$
// ------------------------------------------------------------------------- //

//引入TadTools的函式庫
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php")){
 redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php";


/********************* 自訂函數 *********************/

//以流水號取得某筆tad_evaluation資料
function get_tad_evaluation($evaluation_sn=""){
  global $xoopsDB;
  if(empty($evaluation_sn))return;
  $sql = "select * from `".$xoopsDB->prefix("tad_evaluation")."` where `evaluation_sn` = '{$evaluation_sn}'";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  $data=$xoopsDB->fetchArray($result);
  return $data;
}

//以流水號取得某筆tad_evaluation_files資料
function get_tad_evaluation_files($evaluation_sn="",$cate_sn="",$file_sn=""){
  global $xoopsDB;
  if(empty($file_sn))return;
  //
  //`file_sn`, `cate_sn`, `evaluation_sn`, `file_name`, `file_size`, `file_type`, `file_desc`, `file_enable`, `file_sort`
  $sql = "select * from `".$xoopsDB->prefix("tad_evaluation_files")."` where `evaluation_sn` = '{$evaluation_sn}' and `cate_sn` = '{$cate_sn}' and `file_sn` = '{$file_sn}'";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  $data=$xoopsDB->fetchArray($result);
  return $data;
}

//以流水號實際目錄資料
function get_tad_evaluation_cate_path($evaluation_sn="",$cate_sn=""){
  global $xoopsDB;
  if(empty($cate_sn))return;
  //`cate_sn`, `of_cate_sn`, `cate_title`, `cate_desc`, `cate_sort`, `cate_enable`, `evaluation_sn`
  $sql = "select cate_title,of_cate_sn from `".$xoopsDB->prefix("tad_evaluation_cate")."` where `evaluation_sn` = '{$evaluation_sn}' and `cate_sn` = '{$cate_sn}'";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  list($cate_title,$of_cate_sn)=$xoopsDB->fetchRow($result);
  if(!empty($of_cate_sn)){
    $cate_title=get_tad_evaluation_cate_path($evaluation_sn,$of_cate_sn)."/{$cate_title}";
  }
  return $cate_title;
}


//讀出資料庫中的檔案結構
function db_files($admin_tool=false,$icon=true,$evaluation_sn,$of_cate_sn=0,$level=0){
  global $xoopsDB , $xoopsTpl , $isAdmin;

  if(empty($evaluation_sn))return;
  $pull=$admin_tool?"<img src='".XOOPS_URL."/modules/tadtools/treeTable/images/updown_s.png' style='cursor: s-resize;margin:0px 4px;' alt='"._MD_TADEVALUA_EVALUATION_PULL_TO_SORT."' title='"._MD_TADEVALUA_EVALUATION_PULL_TO_SORT."'>":"";
  $cate_icon=$icon?"<i class=\"icon-folder-open\"></i>":"";
  $file_icon=$icon?"<i class=\"icon-file\"></i>":"";

  $img_ext=array("png","jpg","jpeg","gif");
  $iframe_ext=array("svg","swf");
  $video_ext=array("3gp","mp3","mp4");

  $os=(PATH_SEPARATOR==':')?"linux":"win";
  $all="";
  $left=$level * 20;
  $file_left=$left+20;
  $level++;

  $evaluation=get_tad_evaluation($evaluation_sn);


  $sql = "select * from `".$xoopsDB->prefix("tad_evaluation_cate")."` where `evaluation_sn` = '{$evaluation_sn}' and `of_cate_sn`='$of_cate_sn' order by cate_sort";
  $result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  //`cate_sn`, `of_cate_sn`, `cate_title`, `cate_desc`, `cate_sort`, `cate_enable`, `evaluation_sn`
  while($data=$xoopsDB->fetchArray($result)){
    foreach($data as $k=>$v){
      $$k=$v;
    }
    $all.="
    <div style='margin:6px 0px 6px {$left}px;font-size:12pt;' id='cate_{$cate_sn}'>
      {$pull}
      {$cate_icon}
      {$cate_title}
    </div>";


    $cate_path=get_tad_evaluation_cate_path($evaluation_sn,$cate_sn);


    $sql = "select * from `".$xoopsDB->prefix("tad_evaluation_files")."` where `evaluation_sn` = '{$evaluation_sn}' and `cate_sn`='$cate_sn' order by file_sort";
    $result2 = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
    while($data=$xoopsDB->fetchArray($result2)){
      foreach($data as $k=>$v){
        $$k=$v;
      }

      $filepart=explode('.',$file_name);
      foreach($filepart as $ff){
        $ext=strtolower($ff);
      }

      if(in_array($ext,$img_ext)){
        $other="rel=\"gallery{$cate_sn}\"";
        $href=XOOPS_URL."/uploads/tad_evaluation/{$evaluation['evaluation_title']}/{$cate_path}/{$file_name}";
      }elseif(in_array($ext,$iframe_ext)){
        $other="data-fancybox-type=\"iframe\"";
        $href=XOOPS_URL."/uploads/tad_evaluation/{$evaluation['evaluation_title']}/{$cate_path}/{$file_name}";
      }elseif(in_array($ext,$video_ext)){
        $other="data-fancybox-type=\"iframe\"";
        $url=XOOPS_URL."/uploads/tad_evaluation/{$evaluation['evaluation_title']}/{$cate_path}/{$file_name}";
        $href="player.php?id=evaluation_player_{$evaluation_sn}&file={$url}";

      }else{
        $other="data-fancybox-type=\"iframe\"";
        $href=XOOPS_URL."/modules/tad_evaluation/index.php?evaluation_sn={$evaluation_sn}&cate_sn={$cate_sn}&file_sn={$file_sn}&file_name={$file_name}";
      }

      $all.="
      <div style='margin:6px 0px 6px {$file_left}px;font-size:12pt;' id='file_{$file_sn}'>
        {$pull}
        {$file_icon}
        <a class=\"evaluation_fancy_{$evaluation_sn} iconize\" $other href=\"{$href}\">{$file_desc}</a>
      </div>";
    }
    $all.=db_files($admin_tool,$icon,$evaluation_sn,$cate_sn,$level);
  }


  return $all;
}

?>
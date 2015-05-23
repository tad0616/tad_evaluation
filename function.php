<?php
//引入TadTools的函式庫
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php")){
 redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php";


/********************* 自訂函數 *********************/

//轉換編碼 （_CHARSET在後面時，$OS2Web為true，預設）
function change_charset($str,$OS2Web=true){
  global $xoopsModuleConfig;
  if($xoopsModuleConfig['os_charset']=="Auto"){
    $os_charset=(PATH_SEPARATOR==':')?"UTF-8":"Big5";
  }else{
    $os_charset=$xoopsModuleConfig['os_charset'];
  }

  if($os_charset != _CHARSET){
    $str=$OS2Web?iconv($os_charset, _CHARSET, $str):iconv(_CHARSET, $os_charset, $str);
  }

  if($OS2Web and $os_charset=="Big5" and _CHARSET=="UTF-8"){
    $str=stripslashes($str);
  }
  return $str;
}

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
  global $xoopsDB,$xoopsModuleConfig;
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
function db_files($admin_tool=false,$icon=true,$mode='show',$evaluation_sn,$of_cate_sn=0,$level=0){
  global $xoopsDB , $xoopsTpl , $isAdmin ,$xoopsModuleConfig;

  if(empty($evaluation_sn))return;

  $myts =& MyTextSanitizer::getInstance();
  $old_level=$level;

  $start=0;
  $treeID=$evaluation_sn;

  if($old_level==$start and $mode=="edit"){

    //後台編輯模式
    if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/treetable.php")){
      redirect_header("index.php",3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH."/modules/tadtools/treetable.php";
    $treetable=new treetable(false , "cate_sn" , "of_cate_sn" , "#treetbl{$treeID}" , "save_drag.php" , ".folder" , "#save_msg" , true , ".sort", "save_sort.php" , "#save_msg");
    $treetable_code=$treetable->render();

    $data="
    $treetable_code
    <div id='save_msg' style='float:right;'></div>
    <table id='treetbl{$treeID}'>
    <tbody class='sort'>";
  }elseif($old_level==$start and $mode=="show"){
    //前台編輯模式
    if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/treetable.php")){
      redirect_header("index.php",3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH."/modules/tadtools/treetable.php";
    $treetable=new treetable(true , "cate_sn" , "of_cate_sn" , "#treetbl{$treeID}",NULL,NULL,NULL,false);
    $treetable_code=$treetable->render();

    $data="
    $treetable_code
    <table id='treetbl{$treeID}'>
    <tbody class='sort'>";
  }else{
    $data="";
  }


  $pull=$admin_tool?"<img src='".XOOPS_URL."/modules/tadtools/treeTable/images/updown_s.png' style='cursor: s-resize;margin:0px 4px;' alt='"._MA_TADEVALUA_EVALUATION_PULL_TO_SORT."' title='"._MA_TADEVALUA_EVALUATION_PULL_TO_SORT."'>":"";
  $cate_icon=$icon?"<i class=\"icon-folder-open\"></i>":"";
  $file_icon=$icon?"<i class=\"icon-file\"></i>":"";


  $left=$level * 20;
  $file_left=$left+20;
  $level++;
  $h=$level+1;

  $evaluation=get_tad_evaluation($evaluation_sn);

  $data.=get_cate_files($evaluation_sn,0);

  $sql = "select * from `".$xoopsDB->prefix("tad_evaluation_cate")."` where `evaluation_sn` = '{$evaluation_sn}' and `of_cate_sn`='$of_cate_sn' order by cate_sort";
  //die($sql);
  $result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  //`cate_sn`, `of_cate_sn`, `cate_title`, `cate_desc`, `cate_sort`, `cate_enable`, `evaluation_sn`
  while($all=$xoopsDB->fetchArray($result)){
    foreach($all as $k=>$v){
      $$k=$v;
    }

    $class=(empty($of_cate_sn))?"":"class='child-of-cate_sn-_{$of_cate_sn}'";

    $title=$cate_title;

    $title=$myts->addSlashes($title);

    $parent=empty($of_cate_sn)?"":"data-tt-parent-id='$of_cate_sn'";

    $_SESSION['dir_count2']++;
    $data.="
    <tr data-tt-id='{$cate_sn}' $parent id='cate_sn-_{$cate_sn}' $class style='letter-spacing: 0em;'>
      <td style='padding:5px 0px;' class='level{$level}'>
        {$pull}{$cate_icon}{$title}
      </td>
    </tr>";

    $data.=get_cate_files($evaluation_sn,$cate_sn);


    $data.=db_files($admin_tool,$icon,$mode,$evaluation_sn,$cate_sn,$level);
  }

  if($old_level==$start){
    $data.="
    </tbody>
    </table>";
  }

  return $data;
}


//抓取目錄下的檔案
function get_cate_files($evaluation_sn="",$cate_sn=""){
  global $xoopsDB,$xoopsModuleConfig;

  $myts =& MyTextSanitizer::getInstance();


  $evaluation=get_tad_evaluation($evaluation_sn);
  $img_ext=array("png","jpg","jpeg","gif");
  $iframe_ext=array("svg","swf");
  $video_ext=array("3gp","mp3","mp4","flv");


  $cate_path=get_tad_evaluation_cate_path($evaluation_sn,$cate_sn);

  $sql = "select * from `".$xoopsDB->prefix("tad_evaluation_files")."` where `evaluation_sn` = '{$evaluation_sn}' and `cate_sn`='$cate_sn' order by file_sort";
//die($sql);
  $data="";
  $result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  while($all=$xoopsDB->fetchArray($result)){
    foreach($all as $k=>$v){
      $$k=$v;
    }

    $filepart=explode('.',$file_name);
    foreach($filepart as $ff){
      $ext=strtolower($ff);
    }

    $cate_path=$myts->addSlashes($cate_path);
    $file_name=$myts->addSlashes($file_name);

    if(in_array($ext,$img_ext)){
      $other="rel=\"gallery{$cate_sn}\" target='_blank'";
      $href=XOOPS_URL."/uploads/tad_evaluation/{$evaluation['evaluation_title']}/{$cate_path}/{$file_name}#.{$ext}";
    }elseif(in_array($ext,$video_ext)){
      $other="data-fancybox-type=\"iframe\"";
      $url=XOOPS_URL."/uploads/tad_evaluation/{$evaluation['evaluation_title']}/{$cate_path}/{$file_name}";
      $href="player.php?id=evaluation_player_{$evaluation_sn}&file={$url}&ext=.{$ext}";
    }elseif(in_array($ext,$iframe_ext)){
      $other="data-fancybox-type=\"iframe\"";
      $href=XOOPS_URL."/uploads/tad_evaluation/{$evaluation['evaluation_title']}/{$cate_path}/{$file_name}#.{$ext}";
    }elseif($xoopsModuleConfig['use_google_doc']==0){
      $other="target='_blank'";
      $href=XOOPS_URL."/uploads/tad_evaluation/{$evaluation['evaluation_title']}/{$cate_path}/{$file_name}#.{$ext}";
    }else{
      $other="data-fancybox-type=\"iframe\"";
      $file_name=strtolower($file_name);
      $href=XOOPS_URL."/modules/tad_evaluation/index.php?evaluation_sn={$evaluation_sn}&cate_sn={$cate_sn}&file_sn={$file_sn}&file_name={$file_name}";
    }

    $class=(empty($cate_sn))?"":"class='child-of-cate_sn-_{$cate_sn}'";

    $file_desc=$myts->addSlashes($file_desc);
    $_SESSION['file_count2']++;
    $data.="
    <tr data-tt-id='file_{$file_sn}' data-tt-parent-id='$cate_sn' id='file_sn-_{$file_sn}' $class style='letter-spacing: 0em;'>
      <td style='font-size:11pt;padding:5px 0px;'>
        <a class=\"evaluation_fancy_{$evaluation_sn} iconize\" $other href=\"{$href}\" style='font-weight:normal;'>{$file_desc}</a>
      </td>
    </tr>";
  }

  return $data;
}

//以流水號秀出某筆tad_evaluation資料數
function get_evaluation_count($evaluation_sn,$tbl){
  global $xoopsDB;

  if(empty($evaluation_sn)){
    return;
  }else{
    $evaluation_sn=intval($evaluation_sn);
  }

  $sql = "select count(*) from `".$xoopsDB->prefix($tbl)."` where `evaluation_sn` = '{$evaluation_sn}' ";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  list($count)=$xoopsDB->fetchRow($result);
  return $count;
}

?>
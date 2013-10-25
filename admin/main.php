<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2013-10-23
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_evaluation_adm_main.html";
include_once "header.php";
include_once "../function.php";

/*-----------功能函數區--------------*/

////tad_evaluation編輯表單
function tad_evaluation_form($evaluation_sn=""){
  global $xoopsDB , $xoopsTpl;
  //include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
  //include_once(XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php");

  //抓取預設值
  if(!empty($evaluation_sn)){
    $DBV=get_tad_evaluation($evaluation_sn);
  }else{
    $DBV=array();
  }

  //預設值設定


  //設定「evaluation_sn」欄位預設值
  $evaluation_sn=!isset($DBV['evaluation_sn'])?$evaluation_sn:$DBV['evaluation_sn'];
  $xoopsTpl->assign('evaluation_sn' , $evaluation_sn);

  //設定「evaluation_title」欄位預設值
  $evaluation_title=!isset($DBV['evaluation_title'])?null:$DBV['evaluation_title'];
  $xoopsTpl->assign('evaluation_title' , $evaluation_title);

  //設定「evaluation_description」欄位預設值
  $evaluation_description=!isset($DBV['evaluation_description'])?"":$DBV['evaluation_description'];
  $xoopsTpl->assign('evaluation_description' , $evaluation_description);

  //設定「evaluation_enable」欄位預設值
  $evaluation_enable=!isset($DBV['evaluation_enable'])?"1":$DBV['evaluation_enable'];
  $xoopsTpl->assign('evaluation_enable' , $evaluation_enable);

  //設定「evaluation_uid」欄位預設值
  $user_uid=($xoopsUser)?$xoopsUser->getVar('uid'):"";
  $evaluation_uid=!isset($DBV['evaluation_uid'])?$user_uid:$DBV['evaluation_uid'];
  $xoopsTpl->assign('evaluation_uid' , $evaluation_uid);

  //設定「evaluation_date」欄位預設值
  $evaluation_date=!isset($DBV['evaluation_date'])?date("Y-m-d H:i:s"):$DBV['evaluation_date'];
  $xoopsTpl->assign('evaluation_date' , $evaluation_date);

  $op=(empty($evaluation_sn))?"insert_tad_evaluation":"update_tad_evaluation";
  //$op="replace_tad_evaluation";

  if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
    redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
  include_once TADTOOLS_PATH."/formValidator.php";
  $formValidator= new formValidator("#myForm",true);
  $formValidator_code=$formValidator->render();


    //評鑑說明
    if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/ck.php")){
      redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50" , 3 , _TAD_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH."/modules/tadtools/ck.php";
    $ck=new CKEditor("tad_evaluation","evaluation_description",$evaluation_description);
    $ck->setHeight(400);
  $editor=$ck->render();
    $xoopsTpl->assign('evaluation_description_editor' , $editor);
  $xoopsTpl->assign('action' , $_SERVER["PHP_SELF"]);
  $xoopsTpl->assign('formValidator_code' , $formValidator_code);
  $xoopsTpl->assign('now_op' , 'tad_evaluation_form');
  $xoopsTpl->assign('next_op' , $op);

}



//新增資料到tad_evaluation中
function insert_tad_evaluation(){
  global $xoopsDB,$xoopsUser;

  //取得使用者編號
  $uid=($xoopsUser)?$xoopsUser->getVar('uid'):"";

  $myts =& MyTextSanitizer::getInstance();
  $_POST['evaluation_title']=$myts->addSlashes($_POST['evaluation_title']);
  $_POST['evaluation_description']=$myts->addSlashes($_POST['evaluation_description']);


  $sql = "insert into `".$xoopsDB->prefix("tad_evaluation")."`
  (`evaluation_title` , `evaluation_description` , `evaluation_enable` , `evaluation_uid` , `evaluation_date`)
  values('{$_POST['evaluation_title']}' , '{$_POST['evaluation_description']}' , '{$_POST['evaluation_enable']}' , '{$uid}' , '".date("Y-m-d H:i:s",xoops_getUserTimestamp(time()))."')";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  //取得最後新增資料的流水編號
  $evaluation_sn = $xoopsDB->getInsertId();

  $os=(PATH_SEPARATOR==':')?"linux":"win";
  if($os=="win" and _CHARSET!="Big5")$_POST['evaluation_title']=iconv(_CHARSET, "Big5", $_POST['evaluation_title']);
  mk_dir(XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$_POST['evaluation_title']}");

  return $evaluation_sn;
}

//更新tad_evaluation某一筆資料
function update_tad_evaluation($evaluation_sn=""){
  global $xoopsDB,$xoopsUser;

  //取得使用者編號
  $uid=($xoopsUser)?$xoopsUser->getVar('uid'):"";

  $myts =& MyTextSanitizer::getInstance();
  $_POST['evaluation_title']=$myts->addSlashes($_POST['evaluation_title']);
  $_POST['evaluation_description']=$myts->addSlashes($_POST['evaluation_description']);


  $sql = "update `".$xoopsDB->prefix("tad_evaluation")."` set
   `evaluation_title` = '{$_POST['evaluation_title']}' ,
   `evaluation_description` = '{$_POST['evaluation_description']}' ,
   `evaluation_enable` = '{$_POST['evaluation_enable']}' ,
   `evaluation_uid` = '{$uid}' ,
   `evaluation_date` = '".date("Y-m-d H:i:s",xoops_getUserTimestamp(time()))."'
  where `evaluation_sn` = '$evaluation_sn'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  $os=(PATH_SEPARATOR==':')?"linux":"win";
  if($os=="win")$_POST['evaluation_title']=iconv(_CHARSET, "Big5", $_POST['evaluation_title']);
  mk_dir(XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$_POST['evaluation_title']}");
  return $evaluation_sn;
}

//列出所有tad_evaluation資料
function list_tad_evaluation(){
  global $xoopsDB , $xoopsTpl , $isAdmin;

  $sql = "select * from `".$xoopsDB->prefix("tad_evaluation")."` order by evaluation_date desc";

  //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
  $PageBar=getPageBar($sql,20,10);
  $bar=$PageBar['bar'];
  $sql=$PageBar['sql'];
  $total=$PageBar['total'];

  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  $all_content="";
  $i=0;
  while($all=$xoopsDB->fetchArray($result)){
    //以下會產生這些變數： $evaluation_sn , $evaluation_title , $evaluation_description , $evaluation_enable , $evaluation_uid , $evaluation_date
    foreach($all as $k=>$v){
      $$k=$v;
    }

    $evaluation_enable=($evaluation_enable==1)? _YES : _NO;
    $uid_name=XoopsUser::getUnameFromId($evaluation_uid,1);
    if(empty($uid_name))$uid_name=XoopsUser::getUnameFromId($evaluation_uid,0);

    $all_content[$i]['evaluation_sn']=$evaluation_sn;
    $all_content[$i]['evaluation_title']=$evaluation_title;
    $all_content[$i]['evaluation_description']=$evaluation_description;
    $all_content[$i]['evaluation_enable']=$evaluation_enable;
    $all_content[$i]['evaluation_uid']=$uid_name;
    $all_content[$i]['evaluation_date']=$evaluation_date;
    $all_content[$i]['evaluation_path']=XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$evaluation_title}/";
    $i++;
  }

  //刪除確認的JS

  $xoopsTpl->assign('bar' , $bar);
  $xoopsTpl->assign('action' , $_SERVER['PHP_SELF']);
  $xoopsTpl->assign('isAdmin' , $isAdmin);
  $xoopsTpl->assign('all_content' , $all_content);
  $xoopsTpl->assign('now_op' , 'list_tad_evaluation');
}



//刪除tad_evaluation某筆資料資料
function delete_tad_evaluation($evaluation_sn=""){
  global $xoopsDB , $isAdmin;
  delete_tad_evaluation_cate($evaluation_sn);
  $sql = "delete from `".$xoopsDB->prefix("tad_evaluation")."` where `evaluation_sn` = '{$evaluation_sn}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

//以流水號秀出某筆tad_evaluation資料內容
function show_one_tad_evaluation($evaluation_sn=""){
  global $xoopsDB , $xoopsTpl , $isAdmin;

  if(empty($evaluation_sn)){
    return;
  }else{
    $evaluation_sn=intval($evaluation_sn);
  }

  $sql = "select * from `".$xoopsDB->prefix("tad_evaluation")."` where `evaluation_sn` = '{$evaluation_sn}' ";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  $all=$xoopsDB->fetchArray($result);

  //以下會產生這些變數： $evaluation_sn , $evaluation_title , $evaluation_description , $evaluation_enable , $evaluation_uid , $evaluation_date
  foreach($all as $k=>$v){
    $$k=$v;
  }


  $evaluation_enable=($evaluation_enable==1)? _YES : _NO;
  $uid_name=XoopsUser::getUnameFromId($evaluation_uid,1);
  if(empty($uid_name))$uid_name=XoopsUser::getUnameFromId($evaluation_uid,0);

  $xoopsTpl->assign('db_files',db_files(true,false,$evaluation_sn));
  $xoopsTpl->assign('evaluation_sn',$evaluation_sn);
  $xoopsTpl->assign('evaluation_title',"<a href='{$_SERVER['PHP_SELF']}?evaluation_sn={$evaluation_sn}'>{$evaluation_title}</a>");
  $xoopsTpl->assign('evaluation_description',$evaluation_description);
  $xoopsTpl->assign('evaluation_enable',$evaluation_enable);
  $xoopsTpl->assign('uid_name',$uid_name);
  $xoopsTpl->assign('evaluation_date',$evaluation_date);

  $xoopsTpl->assign('now_op' , 'show_one_tad_evaluation');
  $xoopsTpl->assign('title' , $evaluation_title);
  $xoopsTpl->assign('evaluation_path' , XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$evaluation_title}/");

  $os=(PATH_SEPARATOR==':')?"linux":"win";
  if($os=="win" and _CHARSET!="Big5")$evaluation_title=iconv(_CHARSET, "Big5", $evaluation_title);
  $dir=XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$evaluation_title}/";

  $all_files=directory_list($dir);
  $all=array_to_dir($all_files);

  $xoopsTpl->assign('all_files' , $all);
  $xoopsTpl->assign('jquery' , get_jquery(true));

}



//把陣列轉為目錄
function array_to_dir($all_files,$of_cate_sn=0,$level=0){
  $os=(PATH_SEPARATOR==':')?"linux":"win";
  $all="";
  $left=$level * 20;
  if(empty($level)){
    $_SESSION['cate_sn']=1;
    $_SESSION['file_sn']=0;
    $_SESSION['i']=0;
  }else{
    $_SESSION['cate_sn']++;
  }
  $level++;


  foreach($all_files as $dirname=>$files){
    $_SESSION['i']++;
    $i=$_SESSION['i'];
    if(is_array($files)){
      if($os=="win" and _CHARSET!="Big5")$dirname=iconv("Big5", _CHARSET, $dirname);
      $all.="<div style='margin-left:{$left}px'>
      <label class='checkbox inline'>
      <input name='cate_sn[$i]' type='hidden' value='{$_SESSION['cate_sn']}'>
      <input name='of_cate_sn[$i]' type='hidden' value='{$of_cate_sn}'>
      <input name='cate_title[$i]' type='checkbox' value='{$dirname}' checked>
      <i class=\"icon-folder-open\"></i>
      {$dirname}
      </label>
      </div>";
      $all.=array_to_dir($files,$_SESSION['cate_sn'],$level);
    }else{
      if($os=="win" and _CHARSET!="Big5")$files=iconv("Big5", _CHARSET, $files);
      if(!empty($level)){
        $_SESSION['file_sn']++;
      }

      $all.="
      <div style='margin-left:{$left}px'>
      <label class='checkbox inline'>
      <input name='file_sn[$i]' type='hidden' value='{$_SESSION['file_sn']}'>
      <input name='cate_sn[$i]' type='hidden' value='{$of_cate_sn}'>
      <input name='file_name[$i]' type='checkbox' value='{$files}' checked>
      <i class=\"icon-file\"></i>
      {$files}
      </label>
      </div>";
    }
  }
  return $all;
}


//匯入檔案
function tad_evaluation_import($evaluation_sn=""){
  global $xoopsDB , $xoopsTpl , $isAdmin;

  delete_tad_evaluation_cate($evaluation_sn);

  $myts =& MyTextSanitizer::getInstance();

  foreach($_POST['cate_title'] as $i=>$cate_title){
    $cate_title=$myts->addSlashes($cate_title);
    save_tad_evaluation_cate($evaluation_sn,$cate_title,$_POST['cate_sn'][$i],$_POST['of_cate_sn'][$i]);
  }

  foreach($_POST['file_name'] as $i=>$file_name){
    $file_name=$myts->addSlashes($file_name);
    save_tad_evaluation_files($evaluation_sn,$file_name,$_POST['file_sn'][$i],$_POST['cate_sn'][$i]);
  }

}


//匯入檔案
function save_tad_evaluation_cate($evaluation_sn,$cate_title,$cate_sn,$of_cate_sn){
  global $xoopsDB,$xoopsUser;
  $sql = "insert into `".$xoopsDB->prefix("tad_evaluation_cate")."`
  (`cate_sn` , `of_cate_sn` , `cate_title` , `cate_desc` , `cate_sort` , `cate_enable` , `evaluation_sn`)
  values('{$cate_sn}','{$of_cate_sn}' , '{$cate_title}' , '' , '{$cate_sn}' , '1' , '{$evaluation_sn}')";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

//新增資料到tad_evaluation_files中
function save_tad_evaluation_files($evaluation_sn,$file_name,$file_sn,$cate_sn){
  global $xoopsDB,$xoopsUser;
  $evaluation=get_tad_evaluation($evaluation_sn);
  $os=(PATH_SEPARATOR==':')?"linux":"win";
  if($os=="win" and _CHARSET!="Big5"){
    $real_evaluation_title=iconv(_CHARSET, "Big5", $evaluation['evaluation_title']);
    $real_file_name=iconv(_CHARSET, "Big5", $file_name);
  }else{
    $real_evaluation_title=$evaluation['evaluation_title'];
    $real_file_name=$file_name;
  }
  $file_src=XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$real_evaluation_title}/{$real_file_name}";

  $type=mime_content_type($file_src);
  $size=filesize($file_src);

  $filepart=explode('.',$file_name);
  foreach($filepart as $ff){
    $ext=$ff;
  }

  $end=(strlen($ext)+1)*-1;
  $file_desc=substr($file_name, 0, $end);

  $sql = "insert into `".$xoopsDB->prefix("tad_evaluation_files")."`
  (`file_sn` , `cate_sn` , `evaluation_sn` , `file_name` , `file_size` , `file_type` , `file_desc` , `file_enable` , `file_sort`)
  values('{$file_sn}' , '{$cate_sn}' , '{$evaluation_sn}' , '{$file_name}' , '{$size}' , '{$type}' , '{$file_desc}' , '1' , '{$file_sn}')";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

}




//刪除某評鑑的所有分類
function delete_tad_evaluation_cate($evaluation_sn=""){
  global $xoopsDB , $isAdmin;

  $evaluation=get_tad_evaluation($evaluation_sn);
  $os=(PATH_SEPARATOR==':')?"linux":"win";
  if($os=="win" and _CHARSET!="Big5"){
    $real_evaluation_title=iconv(_CHARSET, "Big5", $evaluation['evaluation_title']);
  }else{
    $real_evaluation_title=$evaluation['evaluation_title'];
  }
  $dirname=XOOPS_ROOT_PATH."/uploads/tad_evaluation/{$real_evaluation_title}";

  delete_directory($dirname);


  $sql = "delete from `".$xoopsDB->prefix("tad_evaluation_cate")."` where `evaluation_sn` = '{$evaluation_sn}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  $sql = "delete from `".$xoopsDB->prefix("tad_evaluation_files")."` where `evaluation_sn` = '{$evaluation_sn}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}


//刪除目錄
function delete_directory($dirname) {
  if (is_dir($dirname))
    $dir_handle = opendir($dirname);
  if (!$dir_handle)
    return false;
  while($file = readdir($dir_handle)) {
    if ($file != "." && $file != "..") {
      if (!is_dir($dirname."/".$file))
        unlink($dirname."/".$file);
      else
        delete_directory($dirname.'/'.$file);
    }
  }
  closedir($dir_handle);
  rmdir($dirname);
  return true;
}


function directory_list($directory_base_path, $filter_dir = false, $filter_files = false, $exclude = ".|..|.DS_Store|.svn", $recursive = true){
  $directory_base_path = rtrim($directory_base_path, "/") . "/";

  if (!is_dir($directory_base_path)){
    error_log(__FUNCTION__ . "File at: $directory_base_path is not a directory.");
    return false;
  }

  $result_list = array();
  $exclude_array = explode("|", $exclude);

  if (!$folder_handle = opendir($directory_base_path)) {
    error_log(__FUNCTION__ . "Could not open directory at: $directory_base_path");
    return false;
  }else{
    while(false !== ($filename = readdir($folder_handle))) {
      if(!in_array($filename, $exclude_array)) {
          if(is_dir($directory_base_path . $filename . "/")) {
            if($recursive && strcmp($filename, ".")!=0 && strcmp($filename, "..")!=0 ){ // prevent infinite recursion
              error_log($directory_base_path . $filename . "/");
              $result_list[$filename] = directory_list("$directory_base_path$filename/", $filter_dir, $filter_files, $exclude, $recursive);
            }elseif(!$filter_dir){
              $result_list[] = $filename;
            }
        }elseif(!$filter_files){
          $result_list[] = $filename;
        }
      }
    }
    closedir($folder_handle);
    return $result_list;
  }
}

if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

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
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}
/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];
$evaluation_sn=empty($_REQUEST['evaluation_sn'])?"":intval($_REQUEST['evaluation_sn']);
$file_sn=empty($_REQUEST['file_sn'])?"":intval($_REQUEST['file_sn']);
$cate_sn=empty($_REQUEST['cate_sn'])?"":intval($_REQUEST['cate_sn']);


switch($op){
  /*---判斷動作請貼在下方---*/

    //替換資料
    case "replace_tad_evaluation":
    replace_tad_evaluation();
    header("location: {$_SERVER['PHP_SELF']}");
    break;

    //新增資料
    case "insert_tad_evaluation":
    $evaluation_sn=insert_tad_evaluation();
    header("location: {$_SERVER['PHP_SELF']}?evaluation_sn=$evaluation_sn");
    break;

    //更新資料
    case "update_tad_evaluation":
    update_tad_evaluation($evaluation_sn);
    header("location: {$_SERVER['PHP_SELF']}");
    break;

    //輸入表格
    case "tad_evaluation_form":
    tad_evaluation_form($evaluation_sn);
    break;

    //刪除資料
    case "delete_tad_evaluation":
    delete_tad_evaluation($evaluation_sn);
    header("location: {$_SERVER['PHP_SELF']}");
    break;

    //匯入檔案
    case "tad_evaluation_import":
    tad_evaluation_import($evaluation_sn);
    header("location: {$_SERVER['PHP_SELF']}?evaluation_sn=$evaluation_sn");
    break;


    //預設動作
    default:
    if(empty($evaluation_sn)){
      list_tad_evaluation();
      //$main.=tad_evaluation_form($evaluation_sn);
    }else{
      show_one_tad_evaluation($evaluation_sn);
    }
    break;


  /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("isAdmin" , true);
include_once 'footer.php';
?>
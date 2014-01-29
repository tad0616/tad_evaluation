<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = "tad_evaluation_index.html";
include_once XOOPS_ROOT_PATH."/header.php";

/*-----------功能函數區--------------*/

//列出所有tad_evaluation資料
function list_tad_evaluation(){
  global $xoopsDB , $xoopsTpl , $isAdmin;

  $sql = "select * from `".$xoopsDB->prefix("tad_evaluation")."` where evaluation_enable='1' order by evaluation_date desc";

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
    $all_content[$i]['evaluation_cates']=get_evaluation_count($evaluation_sn,'tad_evaluation_cate');
    $all_content[$i]['evaluation_files']=get_evaluation_count($evaluation_sn,'tad_evaluation_files');
    $i++;
  }

  //刪除確認的JS
  $xoopsTpl->assign('action' , $_SERVER['PHP_SELF']);
  $xoopsTpl->assign('isAdmin' , $isAdmin);
  $xoopsTpl->assign('all_content' , $all_content);
  $xoopsTpl->assign('now_op' , 'list_tad_evaluation');
}

//以流水號秀出某筆tad_evaluation資料內容
function show_one_tad_evaluation($evaluation_sn=""){
  global $xoopsDB , $xoopsTpl , $isAdmin ,$xoopsModuleConfig;

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

  $xoopsTpl->assign('evaluation_sn',$evaluation_sn);
  $xoopsTpl->assign('evaluation_title',"<a href='{$_SERVER['PHP_SELF']}?evaluation_sn={$evaluation_sn}'>{$evaluation_title}</a>");
  $xoopsTpl->assign('evaluation_description',$evaluation_description);
  $xoopsTpl->assign('evaluation_enable',$evaluation_enable);
  $xoopsTpl->assign('evaluation_uid',$uid_name);
  $xoopsTpl->assign('evaluation_date',$evaluation_date);
  $xoopsTpl->assign('evaluation_cates',get_evaluation_count($evaluation_sn,'tad_evaluation_cate'));
  $xoopsTpl->assign('evaluation_files',get_evaluation_count($evaluation_sn,'tad_evaluation_files'));

  $xoopsTpl->assign('now_op' , 'show_one_tad_evaluation');
  $xoopsTpl->assign('title' , $evaluation_title);

 // $xoopsTpl->assign('db_files' , db_files(false,false,'show',$evaluation_sn));
  $xoopsTpl->assign('db_files' , db_files(false,false,'show',$evaluation_sn));


}

//顯示檔案內容
function show_file($evaluation_sn,$cate_sn,$file_sn){
  global $xoopsDB , $xoopsTpl , $isAdmin;

  $evaluation=get_tad_evaluation($evaluation_sn);
  $cate_path=get_tad_evaluation_cate_path($evaluation_sn,$cate_sn);
  $file=get_tad_evaluation_files($evaluation_sn,$cate_sn,$file_sn);
  $real_url=XOOPS_URL."/uploads/tad_evaluation/{$evaluation['evaluation_title']}/{$cate_path}/{$file['file_name']}";
  $url=urlencode($real_url);
  $main="<iframe style='width:100%;height:100%;border: none;' src='http://docs.google.com/viewer?url={$url}&embedded=true'></iframe>";
  die($main);
}

/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];
$evaluation_sn=empty($_REQUEST['evaluation_sn'])?"":intval($_REQUEST['evaluation_sn']);
$file_sn=empty($_REQUEST['file_sn'])?"":intval($_REQUEST['file_sn']);
$cate_sn=empty($_REQUEST['cate_sn'])?"":intval($_REQUEST['cate_sn']);


switch($op){

  //輸入表格
  case "tad_evaluation_form":
  tad_evaluation_form($evaluation_sn);
  break;

  //刪除資料
  case "delete_tad_evaluation":
  delete_tad_evaluation($evaluation_sn);
  header("location: {$_SERVER['PHP_SELF']}");
  break;

  //預設動作
  default:
  if(empty($evaluation_sn)){
    list_tad_evaluation();
  }elseif(!empty($file_sn)){
    show_file($evaluation_sn,$cate_sn,$file_sn);
  }else{
    show_one_tad_evaluation($evaluation_sn);
  }
  break;

}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
$xoopsTpl->assign( "isAdmin" , $isAdmin) ;
include_once XOOPS_ROOT_PATH.'/footer.php';
?>
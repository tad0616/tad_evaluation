<?php
include "../../mainfile.php";
//$str="直接以Big5格式的程式用Big5中文編碼資料夾<br>";

$form="UTF-8";
$char="UTF-8";
//echo $str;
$str="{$form}程式建立{$char}資料夾";


$dir=XOOPS_ROOT_PATH."/uploads/tad_evaluation/";
$str=iconv($form,$char,$str);
//$dir=str_replace("/","\\",$dir);
mk_dir("{$dir}{$str}");

// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
          if(substr($file,0,1)==".")continue;
            echo "<h3>現在讀取目錄：{$file}（編碼：".mb_detect_encoding($file)."）</h3>";
            $tab = array( "UTF-8" , 'Big5');
            $chain = "";
            foreach ($tab as $i)            {
              $chain .= " {$i} = ".iconv($i, $char, $file)."<br>";
            }

            echo $chain."<br>";
        }
        closedir($dh);
    }
}


  function mk_dir($dir=""){
    //若無目錄名稱秀出警告訊息
    if(empty($dir))die("無目錄");
    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
      umask(000);
      //若建立失敗秀出警告訊息
      if(!mkdir($dir, 0777)){
        die("無法建立 {$dir}");
      }
    }
  }

?>
<?php
include "../../mainfile.php";
echo "中文編碼檢測<br>";
echo ini_get('display_errors')."<br>";

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

echo ini_get('display_errors')."<br>";

$dir=XOOPS_ROOT_PATH."/uploads/tad_evaluation/";


// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            echo "filename: $file : filetype: " . filetype($dir . $file) . "<br>";


            echo "{$file}:".mb_detect_encoding($file)."<br>";

            $tab = array("ISO-8859-1" , "ISO-8859-5" , "ISO-8859-6" , "ISO-8859-7" , "ISO-8859-11" , "ISO-8859-15" , "ISO/IEC 646" , "CP737" , "CP850" , "CP852" , "CP855" , "CP857" , "CP858" , "CP860" , "CP861" , "CP863" , "CP865" , "CP866" , "CP869" , "Windows-1250" , "Windows-1251" , "Windows-1252" , "Windows-1253" , "Windows-1254" , "Windows-1255" , "Windows-1256" , "Windows-1257" , "Windows-1258" , "GB 2312" , "EUC" , "GBK" , "HKSCS" , "CCCII" , "CNS 11643" , "GB 18030" , "ISO/IEC 2022" , "Shift JIS" , "KOI8-R" , "KOI8-U" , "KOI7" , "MIK" , "Unicode" , "UTF-7" , "UTF-8" , "UTF-16" , "UTF-32",'ATARIST', 'Big5');
            $chain = "";
            foreach ($tab as $i)
                {
                        $chain .= " {$i} = ".iconv($i, 'UTF-8', $file)."<br>";

                }

            echo $chain."<br>";
        }
        closedir($dh);
    }
}




?>
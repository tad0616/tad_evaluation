<?php
//區塊主函式 (評鑑列表(tad_evaluation_list))
function tad_evaluation_list($options)
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    $sql = "select * from `" . $xoopsDB->prefix("tad_evaluation") . "` where evaluation_enable='1' order by evaluation_date desc limit 0,10";

    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    $all_content = "";
    $i           = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： $evaluation_sn , $evaluation_title , $evaluation_description , $evaluation_enable , $evaluation_uid , $evaluation_date
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $evaluation_enable = ($evaluation_enable == 1) ? _YES : _NO;
        $uid_name          = XoopsUser::getUnameFromId($evaluation_uid, 1);
        if (empty($uid_name)) {
            $uid_name = XoopsUser::getUnameFromId($evaluation_uid, 0);
        }

        $all_content[$i]['evaluation_sn']          = $evaluation_sn;
        $all_content[$i]['evaluation_title']       = $evaluation_title;
        $all_content[$i]['evaluation_description'] = $evaluation_description;
        $all_content[$i]['evaluation_enable']      = $evaluation_enable;
        $all_content[$i]['evaluation_uid']         = $uid_name;
        $all_content[$i]['evaluation_date']        = $evaluation_date;
        $i++;
    }

    return $all_content;
}

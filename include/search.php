<?php
//搜尋程式

function tad_evaluation_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    if (get_magic_quotes_gpc()) {
        foreach ($queryarray as $k => $v) {
            $arr[$k] = addslashes($v);
        }
        $queryarray = $arr;
    }
    $sql = 'SELECT a.`file_sn`,a.`evaluation_sn`,a.`file_name`,b.`evaluation_date`, b.`evaluation_uid` FROM ' . $xoopsDB->prefix('tad_evaluation_files') . ' AS a LEFT JOIN ' . $xoopsDB->prefix('tad_evaluation') . " AS b ON a.evaluation_sn = b.evaluation_sn WHERE b.evaluation_enable='1'";
    if (0 != $userid) {
        $sql .= ' AND b.evaluation_uid=' . $userid . ' ';
    }
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((a.`file_name` LIKE '%{$queryarray[0]}%'  OR b.`evaluation_description` LIKE '%{$queryarray[0]}%' )";
        for ($i = 1; $i < $count; $i++) {
            $sql .= " $andor ";
            $sql .= "(a.`file_name` LIKE '%{$queryarray[$i]}%' OR  b.`evaluation_description` LIKE '%{$queryarray[$i]}%' )";
        }
        $sql .= ') ';
    }
    $sql .= 'ORDER BY  b.`evaluation_date` DESC';
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret = [];
    $i = 0;
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[$i]['image'] = 'images/application_form_edit.png';
        $ret[$i]['link'] = 'index.php?evaluation_sn=' . $myrow['evaluation_sn'];
        $ret[$i]['title'] = $myrow['file_name'];
        $ret[$i]['time'] = strtotime($myrow['evaluation_date']);
        $ret[$i]['uid'] = $myrow['evaluation_uid'];
        $i++;
    }

    return $ret;
}

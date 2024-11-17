<?php
//判斷是否對該模組有管理權限
if (!isset($tad_evaluation_adm)) {
    $tad_evaluation_adm = isset($xoopsUser) && \is_object($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TADEVALUA_SMNAME1] = 'index.php';
$interface_icon[_MD_TADEVALUA_SMNAME1] = 'fa-file-text-o';

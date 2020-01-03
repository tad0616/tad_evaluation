<?php

require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';

$evaluation_sn = (int) $_GET['evaluation_sn'];
$evaluation = get_tad_evaluation($evaluation_sn);
$dirname = $evaluation['evaluation_title'];
$dirname = change_charset($dirname, false);
if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$dirname}.zip")) {
    unlink(XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$dirname}.zip");
}

$FromDir = XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$dirname}";

$msg = shell_exec('zip -r -j ' . XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$dirname}.zip $FromDir");

if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$dirname}.zip")) {
    header('location:' . XOOPS_URL . "/uploads/tad_evaluation/{$dirname}.zip");
} else {
    require XOOPS_ROOT_PATH . '/modules/tad_evaluation/class/pclzip.lib.php';
    $zipfile = new PclZip(XOOPS_ROOT_PATH . "/uploads/tad_evaluation/{$dirname}.zip");
    $v_list = $zipfile->create($FromDir, PCLZIP_OPT_REMOVE_PATH, XOOPS_ROOT_PATH . '/uploads/tad_evaluation');

    if (0 == $v_list) {
        die('Error : ' . $zipfile->errorInfo(true));
    }
    $dirname = change_charset($dirname, true);
    header('location:' . XOOPS_URL . "/uploads/tad_evaluation/{$dirname}.zip");
}

exit;

<?php
include "header.php";
$jquery = get_jquery();
if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/jwplayer.php")) {
    redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/jwplayer.php";
$jw     = new JwPlayer($_GET['id'], $_GET['file'], XOOPS_URL . "/modules/tad_evaluation/images/music.jpg", "100%", "100%");
$player = $jw->render();
die("{$jquery}{$player}");

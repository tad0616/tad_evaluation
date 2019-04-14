<?php
require __DIR__ . '/header.php';
$jquery = get_jquery();
if (!file_exists(XOOPS_ROOT_PATH . '/modules/tadtools/jwplayer_new.php')) {
    redirect_header('index.php', 3, _MA_NEED_TADTOOLS);
}
require_once XOOPS_ROOT_PATH . '/modules/tadtools/jwplayer_new.php';
$jw = new JwPlayer($_GET['id'], $_GET['file'], XOOPS_URL . '/modules/tad_evaluation/images/music.jpg');
$player = $jw->render();
die("{$jquery}{$player}");

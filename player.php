<?php
use XoopsModules\Tadtools\JwPlayer;
use XoopsModules\Tadtools\Utility;
require __DIR__ . '/header.php';
Utility::get_jquery();

$jw = new JwPlayer($_GET['id'], $_GET['file'], XOOPS_URL . '/modules/tad_evaluation/images/music.jpg');
$player = $jw->render();
die("{$jquery}{$player}");

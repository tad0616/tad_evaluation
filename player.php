<?php
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tadtools\VideoJs;
require __DIR__ . '/header.php';
Utility::get_jquery();

$VideoJs = new VideoJs($_GET['id'], $_GET['file'], XOOPS_URL . '/modules/tad_evaluation/images/music.jpg');
$player = $VideoJs->render();
die("{$jquery}{$player}");

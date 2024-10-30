<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tadtools\VideoJs;
require __DIR__ . '/header.php';
$xoopsLogger->activated = false;
Utility::get_jquery();

$id = Request::getString('id');
$file = Request::getString('file');
$VideoJs = new VideoJs($id, $file, XOOPS_URL . '/modules/tad_evaluation/images/music.jpg');
$player = $VideoJs->render();
die("{$jquery}{$player}");

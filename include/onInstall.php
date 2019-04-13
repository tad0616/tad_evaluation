<?php

use XoopsModules\Tad_evaluation\Utility;

include dirname(__DIR__) . '/preloads/autoloader.php';

function xoops_module_install_tad_evaluation(&$module)
{
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_evaluation');

    return true;
}

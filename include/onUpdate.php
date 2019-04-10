<?php

use XoopsModules\Tad_evaluation\Utility;

function xoops_module_update_tad_evaluation(&$module, $old_version)
{
    global $xoopsDB;

    Utility::chk_tad_evaluation_block();

    return true;
}


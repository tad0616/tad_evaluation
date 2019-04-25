<?php

use XoopsModules\Tad_evaluation\Update;

function xoops_module_update_tad_evaluation(&$module, $old_version)
{
    global $xoopsDB;

    Update::chk_tad_evaluation_block();

    return true;
}

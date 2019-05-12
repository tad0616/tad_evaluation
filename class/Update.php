<?php

namespace XoopsModules\Tad_evaluation;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Update
{
    //檢查某欄位是否存在
    public static function chk_chk1()
    {
        global $xoopsDB;
        $sql = 'SELECT count(*) FROM ' . $xoopsDB->prefix('tadtools_setup') . " WHERE tt_theme='for_tad_embed_theme'";
        $result = $xoopsDB->query($sql);
        list($counter) = $xoopsDB->fetchRow($result);
        if (empty($counter)) {
            return true;
        }

        return false;
    }

    //執行更新
    public static function go_update1()
    {
        global $xoopsDB;
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('tadtools_setup') . " (`tt_theme`, `tt_use_bootstrap`, `tt_bootstrap_color`, `tt_theme_kind`) VALUES ('for_tad_embed_theme', '0',  'bootstrap3', 'html'),";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL, 3, mysql_error());

        return true;
    }

    //刪除錯誤的重複欄位及樣板檔
    public static function chk_tad_evaluation_block()
    {
        global $xoopsDB;
        //die(var_export($xoopsConfig));
        include XOOPS_ROOT_PATH . '/modules/tad_evaluation/xoops_version.php';

        //先找出該有的區塊以及對應樣板
        foreach ($modversion['blocks'] as $i => $block) {
            $show_func = $block['show_func'];
            $tpl_file_arr[$show_func] = $block['template'];
            $tpl_desc_arr[$show_func] = $block['description'];
        }

        //找出目前所有的樣板檔
        $sql = 'SELECT bid,name,visible,show_func,template FROM `' . $xoopsDB->prefix('newblocks') . "`
        WHERE `dirname` = 'tad_evaluation' ORDER BY `func_num`";
        $result = $xoopsDB->query($sql);
        while (list($bid, $name, $visible, $show_func, $template) = $xoopsDB->fetchRow($result)) {
            //假如現有的區塊和樣板對不上就刪掉
            if ($template != $tpl_file_arr[$show_func]) {
                $sql = 'delete from ' . $xoopsDB->prefix('newblocks') . " where bid='{$bid}'";
                $xoopsDB->queryF($sql);

                //連同樣板以及樣板實體檔案也要刪掉
                $sql = 'delete from ' . $xoopsDB->prefix('tplfile') . ' as a
            left join ' . $xoopsDB->prefix('tplsource') . "  as b on a.tpl_id=b.tpl_id
            where a.tpl_refid='$bid' and a.tpl_module='tad_evaluation' and a.tpl_type='block'";
                $xoopsDB->queryF($sql);
            } else {
                $sql = 'update ' . $xoopsDB->prefix('tplfile') . "
            set tpl_file='{$template}' , tpl_desc='{$tpl_desc_arr[$show_func]}'
            where tpl_refid='{$bid}'";
                $xoopsDB->queryF($sql);
            }
        }
    }
}

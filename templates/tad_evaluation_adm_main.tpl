<div class="container-fluid">
    <!--列出所有資料-->
    <{if $all_content}>
        <{if $smarty.session.tad_evaluation_adm}>
            <script type="text/javascript">
            function delete_tad_evaluation_func(evaluation_sn){
                var sure = window.confirm("<{$smarty.const._TAD_DEL_CONFIRM}>");
                if (!sure)  return;
                location.href="<{$action}>?op=delete_tad_evaluation&evaluation_sn=" + evaluation_sn;
            }
            </script>
        <{/if}>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                <th>
                    <!--評鑑名稱-->
                    <{$smarty.const._MA_TADEVALUA_EVALUATION_TITLE}>
                </th>
                <th nowrap>
                    <!--是否啟用-->
                    <{$smarty.const._MA_TADEVALUA_EVALUATION_ENABLE}>
                </th>
                <th nowrap>
                    <!--建立者-->
                    <{$smarty.const._MA_TADEVALUA_EVALUATION_UID}>
                </th>
                <th>
                    <!--建立日期-->
                    <{$smarty.const._MA_TADEVALUA_EVALUATION_DATE}>
                </th>
                <th>
                    <!--路徑-->
                    <{$smarty.const._MA_TADEVALUA_EVALUATION_PATH}>
                </th>
                <{if $smarty.session.tad_evaluation_adm}>
                    <th>
                    <{$smarty.const._TAD_FUNCTION}>
                    </th>
                    <{/if}>
                </tr>
            </thead>

            <tbody>
            <{foreach from=$all_content item=data}>
                <tr>
                <td nowrap><a href="main.php?evaluation_sn=<{$data.evaluation_sn}>"><{$data.evaluation_title}></a></td>
                <td nowrap>
                    <{if $data.evaluation_enable=='1'}><{$smarty.const._YES}><{else}><{$smarty.const._NO}><{/if}>
                    <i class="fa fa-folder-open"></i> <{$data.evaluation_cates}>
                    <i class="fa fa-file-text-o"></i> <{$data.evaluation_files}>
                </td>
                <td nowrap><{$data.evaluation_uid}></td>
                <td nowrap><{$data.evaluation_date}></td>
                <td><a href="main.php?evaluation_sn=<{$data.evaluation_sn}>"><{$data.evaluation_path}></a></td>

                <{if $smarty.session.tad_evaluation_adm}>
                <td nowrap>
                    <a href="zip.php?evaluation_sn=<{$data.evaluation_sn}>" class="btn btn-mini btn-success"><{$smarty.const._MA_TADEVALUA_EVALUATION_EXPORT}></a>
                    <a href="javascript:delete_tad_evaluation_func(<{$data.evaluation_sn}>);" class="btn btn-mini btn-danger"><{$smarty.const._TAD_DEL}></a>
                    <a href="<{$action}>?evaluation_sn=<{$data.evaluation_sn}>" class="btn btn-mini btn-warning"><{$smarty.const._TAD_EDIT}></a>
                </td>
                <{/if}>
                </tr>
            <{/foreach}>
            </tbody>
        </table>


        <{if $smarty.session.tad_evaluation_adm}>
            <div class="text-right">
                <a href="<{$action}>?op=tad_evaluation_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
            </div>
        <{/if}>

        <{$bar}>
    <{elseif $now_op=="list_tad_evaluation"}>
        <div class="jumbotron text-center">
            <{if $smarty.session.tad_evaluation_adm}>
                <a href="<{$action}>?op=tad_evaluation_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
            <{/if}>
        </div>
    <{/if}>

    <!--顯示某一筆資料-->
    <{if $now_op=="show_one_tad_evaluation" or $now_op=="tad_evaluation_form"}>
        <form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal role="form">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADEVALUA_EVALUATION_TITLE}>
                </label>
                <div class="col-sm-4">
                    <input type="text" name="evaluation_title" id="evaluation_title" class="form-control" value="<{$evaluation_title}>" placeholder="<{$smarty.const._MA_TADEVALUA_EVALUATION_TITLE}>">
                </div>
                <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADEVALUA_EVALUATION_ENABLE}>
                </label>
                <div class="col-sm-4">
                    <div class="form-check-inline radio-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="evaluation_enable" value="1" <{if $evaluation_enable=='1'}>checked<{/if}>>
                            <{$smarty.const._YES}>
                        </label>
                    </div>
                    <div class="form-check-inline radio-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="evaluation_enable" value="0" <{if $evaluation_enable=='0'}>checked<{/if}>>
                            <{$smarty.const._NO}>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <{$evaluation_description_editor}>
                </div>
            </div>

            <div class="text-center" style="margin: 30px auto;">
                <!--評鑑編號-->
                <input type='hidden' name="evaluation_sn" value="<{$evaluation_sn}>">
                <input type="hidden" name="op" value="<{$next_op}>">
                <{if $evaluation_sn}>
                    <a href="../index.php?evaluation_sn=<{$evaluation_sn}>" class="btn btn-success"><{$smarty.const._MA_TADEVALUA_EVALUATION_VIEW}></a>
                <{/if}>
                <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
            </div>
        </form>

        <{if $evaluation_sn}>
            <div class="well card card-body bg-light m-1">
                <div class="row">
                    <{if $all_files}>
                        <div class="col-sm-6">
                            <i class="fa fa-folder-open"></i> <{$dir_count}>
                            <i class="fa fa-file-text-o"></i> <{$file_count}>
                            <i class="fa fa-trash-o"></i> <{$pass_count}>

                            <form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data">
                                <input type="hidden" name="op" value="tad_evaluation_import">
                                <input type="hidden" name="evaluation_sn" value="<{$evaluation_sn}>">
                                <{$all_files}>

                                <div class="text-center">
                                <button type="submit" class="btn btn-primary"><{$smarty.const._MA_TADEVALUA_EVALUATION_IMPORT}></button>
                                </div>
                            </form>
                        </div>
                    <{else}>
                        <div class="col-sm-6 jumbotron text-center">
                            <{$smarty.const._MA_TADEVALUA_EVALUATION_IMPORT_PATH}><br>
                            <div style="color:blue;"><{$evaluation_path}></div>
                        </div>
                    <{/if}>

                    <{if $all_files}>
                        <div class="col-sm-6" id='sort'>

                        <form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data">
                            <i class="fa fa-folder-open"></i> <{$dir_count2}>
                            <i class="fa fa-file-text-o"></i> <{$file_count2}>
                            <{$db_files}>
                            <div class="text-center">
                            <input type="hidden" name="op" value="save_tad_evaluation">
                            <input type="hidden" name="evaluation_sn" value="<{$evaluation_sn}>">

                            <!--button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button-->
                            </div>
                        </form>
                        </div>
                    <{else}>
                        <div class="col-sm-6 jumbotron text-center">
                        <{$smarty.const._MA_TADEVALUA_EVALUATION_IMPORT_FILES}>
                        </div>
                    <{/if}>
                </div>
            </div>
            <div id="save_msg"></div>
        <{/if}>
    <{/if}>
</div>
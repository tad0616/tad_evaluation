<div class="container-fluid">
    <!--列出所有資料-->
    <{if $all_content|default:false}>
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
                <th>
                <{$smarty.const._TAD_FUNCTION}>
                </th>
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

                <td nowrap>
                    <a href="zip.php?evaluation_sn=<{$data.evaluation_sn}>" class="btn btn-mini btn-success"><i class="fa fa-download" aria-hidden="true"></i> <{$smarty.const._MA_TADEVALUA_EVALUATION_EXPORT}></a>
                    <a href="javascript:delete_tad_evaluation_func(<{$data.evaluation_sn}>);" class="btn btn-mini btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></a>
                    <a href="main.php?evaluation_sn=<{$data.evaluation_sn}>" class="btn btn-mini btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <{$smarty.const._TAD_EDIT}></a>
                </td>
                </tr>
            <{/foreach}>
            </tbody>
        </table>


            <div class="text-right text-end">
                <a href="main.php?op=tad_evaluation_form" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> <{$smarty.const._TAD_ADD}></a>
            </div>

        <{$bar|default:''}>
    <{else}>
        <h3><{$smarty.const._MD_TADEVALUA_EVALUATION_EMPTY}></h3>
        <div class="jumbotron bg-light p-5 rounded-lg m-3 text-center">
                <a href="main.php?op=tad_evaluation_form" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> <{$smarty.const._TAD_ADD}></a>

        </div>
    <{/if}>

</div>
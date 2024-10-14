<form action="<{$action|default:''}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal role="form">
    <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label text-sm-right control-label">
        <{$smarty.const._MA_TADEVALUA_EVALUATION_TITLE}>
        </label>
        <div class="col-sm-4">
            <input type="text" name="evaluation_title" id="evaluation_title" class="form-control" value="<{$evaluation_title|default:''}>" placeholder="<{$smarty.const._MA_TADEVALUA_EVALUATION_TITLE}>">
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

    <div class="form-group row mb-3">
        <div class="col-sm-12">
            <{$evaluation_description_editor|default:''}>
        </div>
    </div>

    <div class="text-center" style="margin: 30px auto;">
        <!--評鑑編號-->
        <input type='hidden' name="evaluation_sn" value="<{$evaluation_sn|default:''}>">
        <input type="hidden" name="op" value="<{$next_op|default:''}>">
        <{if $evaluation_sn|default:false}>
            <a href="../index.php?evaluation_sn=<{$evaluation_sn|default:''}>" class="btn btn-success"><{$smarty.const._MA_TADEVALUA_EVALUATION_VIEW}></a>
        <{/if}>
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
    </div>
</form>

<{if $evaluation_sn|default:false}>
    <div class="well card card-body bg-light m-1">
        <div class="row">
            <{if $all_files|default:false}>
                <div class="col-sm-6">
                    <i class="fa fa-folder-open"></i> <{$dir_count|default:''}>
                    <i class="fa fa-file-text-o"></i> <{$file_count|default:''}>
                    <i class="fa fa-trash-o"></i> <{$pass_count|default:''}>

                    <form action="<{$action|default:''}>" method="post" id="myForm" enctype="multipart/form-data">
                        <input type="hidden" name="op" value="tad_evaluation_import">
                        <input type="hidden" name="evaluation_sn" value="<{$evaluation_sn|default:''}>">
                        <{$all_files|default:''}>

                        <div class="text-center">
                        <button type="submit" class="btn btn-primary"><{$smarty.const._MA_TADEVALUA_EVALUATION_IMPORT}></button>
                        </div>
                    </form>
                </div>
            <{else}>
                <div class="col-sm-6">
                    <div class="jumbotron bg-light p-5 rounded-lg m-3">
                        <{$smarty.const._MA_TADEVALUA_EVALUATION_IMPORT_PATH}><br>
                        <div style="color:blue;"><{$evaluation_path|default:''}></div>
                    </div>
                </div>
            <{/if}>

            <{if $all_files|default:false}>
                <div class="col-sm-6" id='sort'>

                <form action="<{$action|default:''}>" method="post" id="myForm" enctype="multipart/form-data">
                    <i class="fa fa-folder-open"></i> <{$dir_count2|default:''}>
                    <i class="fa fa-file-text-o"></i> <{$file_count2|default:''}>
                    <{$db_files|default:''}>
                    <div class="text-center">
                    <input type="hidden" name="op" value="save_tad_evaluation">
                    <input type="hidden" name="evaluation_sn" value="<{$evaluation_sn|default:''}>">

                    <!--button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button-->
                    </div>
                </form>
                </div>
            <{else}>
                <div class="col-sm-6"></div>
                    <div class="jumbotron bg-light p-5 rounded-lg m-3">
                        <{$smarty.const._MA_TADEVALUA_EVALUATION_IMPORT_FILES}>
                    </div>
                </div>
            <{/if}>
        </div>
    </div>
    <div id="save_msg"></div>
<{/if}>
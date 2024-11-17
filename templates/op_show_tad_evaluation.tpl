
<h1><{$evaluation_title|default:''}></h1>
<{if $cate_count|default:false}>
    <a href="#" onclick="jQuery('#treetbl<{$evaluation_sn|default:''}>').treetable('expandAll'); return false;" onkeypress="jQuery('#treetbl<{$evaluation_sn|default:''}>').treetable('expandAll'); return false;" class="btn btn-outline-primary btn-sm btn-xs"><{$smarty.const._MD_TADEVALUA_EXPAND_ALL}></a>
    <a href="#" onclick="jQuery('#treetbl<{$evaluation_sn|default:''}>').treetable('collapseAll'); return false;" onkeypress="jQuery('#treetbl<{$evaluation_sn|default:''}>').treetable('collapseAll'); return false;" class="btn btn-outline-primary btn-sm btn-xs"><{$smarty.const._MD_TADEVALUA_COLLAPSE_ALL}></a>
<{/if}>
<div class="well card card-body bg-light m-1">

    <{if $db_files|default:false}>
        <div>
        <{$db_files|default:''}>
        </div>
    <{else}>
        <div class="jumbotron bg-light p-5 rounded-lg m-3">
        <{$smarty.const._MD_TADEVALUA_EVALUATION_EMPTY}>
        </div>
    <{/if}>
</div>


<{if $tad_evaluation_adm|default:false}>
    <div class="text-right text-end">
        <a href="admin/main.php?evaluation_sn=<{$evaluation_sn|default:''}>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <{$smarty.const._TAD_EDIT}></a>
    </div>
<{/if}>
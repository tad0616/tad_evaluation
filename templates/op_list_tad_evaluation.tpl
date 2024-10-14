<{if $level_css|default:false}>
  <style>
    <{$level_css|default:''}>
  </style>
<{/if}>

<!--列出所有資料-->
<{if $all_content|default:false}>

  <{foreach from=$all_content item=data}>

      <div class="well card card-body bg-light m-1">
        <h2><a href='index.php?evaluation_sn=<{$data.evaluation_sn}>'><{$data.evaluation_title}></a></h2>
        <div style="font-size:75%;color:gray;text-align:right;">
          <{$data.evaluation_date}>
          <i class="icon-folder-open"></i> <{$data.evaluation_cates}>
          <i class="icon-file"></i> <{$data.evaluation_files}>
        </div>
      </div>

  <{/foreach}>

  <{if $smarty.session.tad_evaluation_adm|default:false}>
  <div style="text-align:right;">
    <a href="admin/main.php?op=tad_evaluation_form" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> <{$smarty.const._TAD_ADD}></a>
  </div>
  <{/if}>

<{else}>
  <h3><{$smarty.const._MD_TADEVALUA_EVALUATION_EMPTY}></h3>
  <div class="jumbotron bg-light p-5 rounded-lg m-3">
    <{if $smarty.session.tad_evaluation_adm|default:false}>
      <a href="admin/main.php?op=tad_evaluation_form" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> <{$smarty.const._TAD_ADD}></a>
    <{/if}>
  </div>
<{/if}>

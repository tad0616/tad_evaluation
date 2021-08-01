<{if $block}>
    <ul class="vertical_menu">
        <{foreach from=$block item=evaluation}>
            <li>
                <a href="<{$xoops_url}>/modules/tad_evaluation/index.php?evaluation_sn=<{$evaluation.evaluation_sn}>"><{$evaluation.evaluation_title}></a>
            </li>
        <{/foreach}>
    </ul>
<{/if}>
<?php $view = get_view(); ?>
<fieldset>
    <div class="field">
        <div class="two columns alpha">
            <label for="simple_search_tweaks_browse_empty_query"><?php echo __('Empty query browse'); ?></label>
        </div>
        <div class="inputs five columns omega">
            <?php echo $view->formRadio('simple_search_tweaks_browse_empty_query', get_option('simple_search_tweaks_browse_empty_query'), null, array(0 => __('No thanks'), 1 => __('Yes please'))); ?>
            <p class="explanation"><?php echo __('If a user submits the simple search form without entering any keywords, the standard behaviour returns 0 search results. Enabling this will instead show all search results, just like browsing.'); ?></p>
        </div>
    </div>
    <div class="field">
        <div class="two columns alpha">
            <label for="simple_search_tweaks_collection_filter"><?php echo __('Filter by collection'); ?></label>
        </div>
        <div class="inputs five columns omega">
            <?php echo $view->formRadio('simple_search_tweaks_collection_filter', get_option('simple_search_tweaks_collection_filter'), null, array(0 => __('No thanks'), 1 => __('Yes please'))); ?>
            <p class="explanation"><?php echo __("The standard simple search form does not support limiting by collection. Enabling this will enable filtering by collection. You will need to add a collection field to your theme's search form template."); ?></p>
        </div>
    </div>
</fieldset>

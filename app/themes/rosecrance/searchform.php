<?php

/**
 * Default search form.
 *
 * @package Rosecrance
 */

use Rosecrance\App\Fields\Util;

?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_home_url(); ?>">
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="<?php _e('Search', 'rosecrance') ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php _e('Search for:', 'rosecrance') ?>" />
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    <?php echo Util::getIconHTML('search'); ?>
                </button>
            </div>
        </div>
    </div>
</form>
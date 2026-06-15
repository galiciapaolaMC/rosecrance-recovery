<?php

/**
 * The template part for displaying a message that posts cannot be found.
 *
 * @package Rosecrance
 */

use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$options_search = Options::getSiteOptions();
$search_text = ACF::getField('search-text', $options_search);
$search_link = ACF::getField('search-link', $options_search);
?>

<section class="no-results">
    <div class="uk-margin">
        <div class="search-page__top-banner">
            <div class="uk-container uk-container-large">
                <h1 class="search-page__headline hdg hdg--1"><?php _e('Search Rosecrance', 'rosecrance'); ?></h1>
            </div>
        </div>

        <div class="search-page__results">
            <div class="uk-container uk-container-large">
                <div class="search-form__container">
                    <div class="uk-grid uk-grid-small" uk-grid>
                        <div class="uk-width-1-1 search-form-container">
                            <form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_home_url(); ?>">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="<?php __('Search', 'rosecrance'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php __('Search for:', 'rosecrance'); ?>" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                                <?php _e('Search', 'rosecrance'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="no-results__top-message">
                    <p><?php _e('Hmmm... We couldn’t find any matches for your search', 'rosecrance'); ?></p>
                </div>

                <div class="no-results__bottom-message">
                    <?php echo apply_filters('the_content', $search_text); ?>

                    <?php if ($search_link) :
                        echo Util::getButtonHTML($search_link, ['class' => 'btn btn-primary', 'icon-end' => 'arrow-right-dark']);
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
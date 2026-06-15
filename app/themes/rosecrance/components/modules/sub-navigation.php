<?php

/**
 * ACF Module: Sub Navigation
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$activate_subnav = ACF::getField('activate-sub-navigation', $data, 'active');

if ($activate_subnav === 'inactive') {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);

?>
<!-- uk-sticky="offset: 140" -->
<section class="module sub-navigation uk-position-z-index" id="<?php echo esc_html($row_id); ?>" uk-sticky="offset: 150;">
    <div class="uk-container">
        <div class="slider-wrapper" uk-slider="center: true">
            <div class="uk-position-relative">
                <div class="uk-slider-container uk-light">
                    <ul class="sub-navigation-wrapper uk-slider-items uk-child-width-auto">
                    </ul>
                </div>

                <button class="uk-position-center-left uk-position-small uk-hidden-hover" uk-slidenav-previous uk-slider-item="previous"></button>
                <button class="uk-position-center-right uk-position-small uk-hidden-hover" uk-slidenav-next uk-slider-item="next"></button>
            </div>
        </div>
    </div>
</section>
 
<?php

/**
 * ACF Module: Image Slider
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$items = ACF::getRowsLayout('slider-items', $data);

if (!$items) {
    return;
}

$show_indicators = ACF::getField('show-slider-indicators', $data, 'false');
$slider_autoplay = ACF::getField('slider-autoplay', $data, 'false');

if ($slider_autoplay === 'false') {
    $autoplay = 'autoplay: false;';
} else {
    $autoplay = 'autoplay: true; autoplay-interval: 5000;';
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module image-slider" id="<?php echo esc_html($row_id); ?>">
    <div uk-slideshow="animation: fade; draggable: false; <?php echo esc_attr($autoplay); ?>">

        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

            <ul class="uk-slideshow-items">
                <?php
                foreach ($items as $item) {
                    $image_mobile = Media::getAttachmentSrcByID(ACF::getField('mobile-image', $item));
                    $image_desktop = Media::getAttachmentSrcByID(ACF::getField('desktop-image', $item));

                    if (empty($image_mobile)) {
                        $image_mobile = $image_desktop;
                    }

                    printf(
                        '<li>
                            <div class="uk-visible@m uk-position-center image-container" style="background-image:url(%1$s);"></div>
                            <div class="uk-hidden@m uk-position-center image-container" style="background-image:url(%2$s);"></div>
                        </li>',
                        esc_url($image_desktop),
                        esc_url($image_mobile)
                    );
                }
                ?>
            </ul>

        </div>

        <?php if ($show_indicators === 'true') { ?>
            <div class="slider-indicators">
                <ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-margin"></ul>
            </div>
        <?php } ?>

        <?php if ($slider_autoplay === 'true') { ?>
            <div class="slider-buttons">
                <button class="slider-pause" aria-label="<?php _e('Pause Button', 'rosecrance'); ?>">
                    <?php echo Util::getIconHTML('pause'); ?>
                </button>

                <button class="slider-play" aria-label="<?php _e('Play Button', 'rosecrance'); ?>">
                    <?php echo Util::getIconHTML('play'); ?>
                </button>
            </div>
        <?php } ?>
    </div>
</section>
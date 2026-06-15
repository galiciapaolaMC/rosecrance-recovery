<?php
/**
 * ACF Module: Media
 *
 * @global $data
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Media;
use Rosecrance\App\Fields\Util;

$media_type = ACF::getField('media-type', $data);
$images = ACF::getRowsLayout('slider-images', $data);
$video_link = ACF::getField('video', $data);
$show_indicators = ACF::getField('show-slider-indicators', $data, 'false');
$slider_autoplay = ACF::getField('slider-autoplay', $data, 'false');

if (!$media_type) {
    return;
}

if ($slider_autoplay === 'false') {
    $autoplay = 'autoplay: false;';
} else {
    $autoplay = 'autoplay: true; autoplay-interval: 5000;';
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<div class="module media" id="<?php echo esc_attr($row_id); ?>">
    <div class="uk-container uk-container-large">
        <?php if ($media_type === 'video') { ?>
            <div class="media-video__container">
                <iframe class="media-video__content" src="<?php echo esc_url($video_link); ?>"></iframe>
            </div>
        <?php } else { ?> 
            <div uk-slideshow="animation: fade; draggable: false; <?php echo esc_attr($autoplay); ?>" class="media-image__container">
                <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                    <ul class="uk-slideshow-items">
                        <?php
                        foreach ($images as $image) { 
                            if (!empty($image['mobile-image'])) {
                                $desktop_url = Media::getAttachmentByID($image['desktop-image'])->url;
                                $mobile_url = Media::getAttachmentByID($image['mobile-image'])->url; ?>

                                <li>
                                    <div class="desktop-image uk-visible@m" style="background-image: url('<?php echo esc_url($desktop_url); ?>');"></div>
                                    <div class="mobile-image uk-hidden@m" style="background-image: url('<?php echo esc_url($mobile_url); ?>');"></div>
                                </li>
                            <?php } else {
                                $desktop_url = Media::getAttachmentByID($image['desktop-image'])->url; ?>

                                <li>
                                    <div class="desktop-image uk-visible@m" style="background-image: url('<?php echo esc_url($desktop_url); ?>');"></div>
                                </li>
                            <?php }
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
        <?php } ?>
    </div>
</div>

<?php

/**
 * ACF Module: Large Resource Hero
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$media_class = 'resource-hero--media-'.$media_type;
$is_announcement_bar_visible = ACF::getField('show-announcement-bar', $data);
$anouncement_bar_text = ACF::getField('announcement-bar-text', $data);

?>

<?php if ($is_announcement_bar_visible === '1') { ?>
    <div class="resource-hero__announcement"><?php echo apply_filters('the_content', $anouncement_bar_text); ?></div>
<?php } ?>

<section class="module resource-hero large-resource-hero <?php echo esc_attr($media_class); ?>" id="<?php echo esc_html($row_id); ?>">
    <div class="large-resource-hero__wrapper image-<?php echo esc_attr($image_size); ?>">
        <div class="large-resource-hero__content-wrapper">
            <div class="large-resource-hero__section large-resource-hero__section--top">
                <div class="uk-container uk-container-medium">  
                    <?php if (!is_null($subhead)) { ?>
                        <p class="large-resource-hero__eyebrow"><?php echo esc_html($subhead); ?> </p>
                    <?php } ?>

                    <h1 class="large-resource-hero__heading"><?php echo esc_html($heading)?></h1>

                    <div class="large-resource-hero__content">
                        <?php echo apply_filters('the_content', $content); ?>
                    </div>
                </div>
            </div>

            <div class="large-resource-hero__section large-resource-hero__section--middle image-<?php echo esc_attr($image_size); ?>">
                <?php 
                if($media_type == 'video' && $video_type == 'link') { ?>
                    <div class="large-resource-hero__media-bg large-resource-hero__media-bg--video">
                        <iframe class="large-resource-hero__video large-resource-hero__video--iframe" src="<?php echo esc_url($video_link); ?>"></iframe>
                    </div>
                <?php
                } else if($media_type == 'video' && $video_type == 'file') {
                    $attachment_video = Media::getAttachmentByID($video_file_id); 
                ?>  
                    <div class="large-resource-hero__media-bg large-resource-hero__media-bg--video">
                        <video class="large-resource-hero__video video-file" src="<?php echo esc_html($attachment_video->url); ?>" controls playsinline type="video/mp4" uk-video="autoplay: false"></video>
                    </div>
                <?php
                } else if ($media_type == 'image') {
                ?>
                    <div class="large-resource-hero__media-bg large-resource-hero__media-bg--desktop uk-visible@m">
                        <div class="large-resource-hero__media image-<?php echo esc_attr($image_size); ?>" <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'image-configuration_main-image-settings'); ?>></div>
                    </div>
                    <div class="large-resource-hero__media-bg large-resource-hero__media-bg--mobile uk-hidden@m">
                        <div class="large-resource-hero__media"  <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'image-configuration_main-mobile-image-settings'); ?>></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
 
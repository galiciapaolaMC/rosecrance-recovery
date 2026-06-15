<?php

/**
 * ACF Module: Media Hero
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$eyebrow = ACF::getField('content-container-hero-configuration_eyebrow-text', $data, null);
$content = ACF::getField('content', $data, null);
$content_color = ACF::getField('content-color', $data, 'primary-dark');
$background_type = ACF::getField('content-container-hero-configuration_background-type', $data, 'image-background');

$is_announcement_bar_visible = ACF::getField('show-announcement-bar', $data);
$anouncement_bar_text = ACF::getField('announcement-bar-text', $data);

?>

<?php if ($is_announcement_bar_visible === '1') { ?>
    <div class="hero__announcement"><?php echo apply_filters('the_content', $anouncement_bar_text); ?></div>
  <?php } ?>

<section class="module hero content-container-hero" id="<?php echo esc_html($row_id); ?>">
    <?php if ($background_type === 'image-background') { ?>
      <div class="content-container-hero__bg-container content-container-hero__bg-container--mobile"<?php echo Util::getAgnosticInlineBackgroundStyles($data, 'content-container-hero-configuration_mobile-background'); ?>></div>
      <div class="content-container-hero__bg-container content-container-hero__bg-container--desktop"<?php echo Util::getAgnosticInlineBackgroundStyles($data, 'content-container-hero-configuration_desktop-background'); ?>></div>
    <?php } else { 
      $video_file_desktop_id = ACF::getField('content-container-hero-configuration_desktop-video', $data);
      $attachment_desktop_video = Media::getAttachmentByID($video_file_desktop_id); 
      $desktop_video_overly_opacity = ACF::getField('content-container-hero-configuration_desktop-video-options_overlay-opacity', $data, '0');
      $desktop_opacity_class = 'video-overlay--opacity-' . $desktop_video_overly_opacity;
      $video_file_mobile_id = ACF::getField('content-container-hero-configuration_mobile-video', $data); 
      $attachment__mobile_video = Media::getAttachmentByID($video_file_mobile_id);
      $mobile_video_overlay_opacity = ACF::getField('content-container-hero-configuration_desktop-video-options_overlay-opacity', $data, '0');
      $mobile_opacity_class = 'video-overlay--opacity-' . $mobile_video_overlay_opacity;
      ?>
      
      <div class="content-container-hero__bg-container content-container-hero__bg-container--mobile">
        <div class="content-container-hero__overlay-container">
          <video class="video-file" src="<?php echo esc_html($attachment_desktop_video->url); ?>" muted loop playsinline type="video/mp4" uk-video="autoplay: true"></video>
          <?php if ($mobile_video_overlay_opacity !== '0') { ?>
            <div class="video-overlay <?php echo esc_attr($mobile_opacity_class); ?>"></div>
          <?php } ?>
        </div>
      </div>
      <div class="content-container-hero__bg-container content-container-hero__bg-container--desktop">
        <div class="content-container-hero__overlay-container">
          <video class="video-file" src="<?php echo esc_html($attachment__mobile_video->url); ?>" muted loop playsinline type="video/mp4" uk-video="autoplay: true"></video>
          <?php if ($desktop_video_overly_opacity !== '0') { ?>
            <div class="video-overlay <?php echo esc_attr($desktop_opacity_class); ?>"></div>
          <?php } ?>
        </div>
      </div>
    <?php } ?>

    <div class="uk-container uk-container-medium">
      <div class="content-container-hero__content-wrapper">
        <div class="content-container-hero__section content-container-hero__section--left">
            <?php if (!is_null($eyebrow)) { ?>
                <p class="content-container-hero__eyebrow"><?php echo esc_html($eyebrow); ?> </p>
            <?php } ?>
            <h1 class="content-container-hero__heading"><?php echo esc_html($heading)?></h1>
        </div>
        <?php if (!empty($content)) { ?>
          <div class="content-container-hero__section content-container-hero__section--right background-<?php echo esc_attr($content_color); ?>">
              <?php echo apply_filters('the_content', $content); ?>
          </div>
        <?php } ?>
      </div>
    </div>
</section>
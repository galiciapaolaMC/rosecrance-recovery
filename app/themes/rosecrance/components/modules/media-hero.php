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

$cta = ACF::getField('media-hero-configuration_cta', $data, null);
$content = ACF::getField('content', $data, null);
$background_type = ACF::getField('media-hero-configuration_background-type', $data, 'animated-background');
$eyebrow_text = ACF::getField('media-hero-configuration_eyebrow-text', $data, null);
$gradient_background = ACF::getField('media-hero-configuration_gradient-background', $data, 'inactive');
$cta_color = ACF::getField('media-hero-configuration_cta-color', $data, 'primary-orange');
$eyebrow_class = '';
$gradient_class = ($gradient_background === 'active') ? 'media-hero__bg-container--has-gradient' : '';

if (!is_null($eyebrow_text)) {
  $eyebrow_class = 'media-hero__section--has-eyebrow';
}

$is_announcement_bar_visible = ACF::getField('show-announcement-bar', $data);
$anouncement_bar_text = ACF::getField('announcement-bar-text', $data);

?>

<?php if ($is_announcement_bar_visible === '1') { ?>
  <div class="hero__announcement"><?php echo apply_filters('the_content', $anouncement_bar_text); ?></div>
<?php } ?>

<section class="module hero media-hero" id="<?php echo esc_html($row_id); ?>">
  <div class="media-hero__wrapper">
      <div class="media-hero__bg-container <?php echo esc_attr($gradient_class); ?>"></div>
      <div class="uk-container uk-container-medium">
        <div class="content-container-hero__content-wrapper">
          <div class="media-hero__section media-hero__section--left">
              <?php if (!is_null($eyebrow_text)) { ?>
                <p class="media-hero__eyebrow"><?php echo esc_html($eyebrow_text)?></p>
              <?php } ?>
              <h1 class="media-hero__heading"><?php echo esc_html($heading)?></h1>
              <?php if (!empty($content)) { ?>
                <div class="media-hero__content">
                  <?php echo apply_filters('the_content', $content); ?>
                </div>
              <?php } ?>
              <?php
              if (!is_null($cta)) { 
                  if ($cta_color === 'primary-orange') {
                      $primary_cta_options = ['class' => 'btn btn-primary hero__cta', 'icon-end' => 'arrow-right-dark'];
                  } 
                  
                  if ($cta_color === 'primary-blue') {
                      $primary_cta_options = ['class' => 'btn btn-blue hero__cta', 'icon-end' => 'arrow-right-white'];

                  }

                  if ($cta_color === 'primary') {
                      $primary_cta_options = ['class' => 'btn btn-secondary hero__cta', 'icon-end' => 'arrow-right-white'];

                  }

                  if ($cta_color === 'white') {
                      $primary_cta_options = ['class' => 'btn btn-white hero__cta', 'icon-end' => 'arrow-right-dark'];

                  }

                  echo Util::getButtonHTML($cta, $primary_cta_options);
              }
              ?>
          </div>
          <div class="media-hero__section media-hero__section--right <?php echo esc_attr($eyebrow_class); ?> <?php echo esc_attr($gradient_class); ?>">
            <?php if ($background_type === 'animated-background') { ?>
              <div class="media-hero__media-bg media-hero__media-bg--desktop uk-visible@m" <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'media-hero-configuration_animated-bg-settings'); ?>>
                  <div class="media-hero__media" <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'media-hero-configuration_main-image-settings'); ?>></div>
              </div>
              <div class="media-hero__media-bg media-hero__media-bg--mobile uk-hidden@m" <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'media-hero-configuration_animated-mobile-bg-settings'); ?>>
                  <div class="media-hero__media"  <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'media-hero-configuration_main-mobile-image-settings'); ?>></div>
              </div>
            <?php } else { 
              $video_file_desktop_id = ACF::getField('media-hero-configuration_desktop-video', $data);
              $attachment_desktop_video = Media::getAttachmentByID($video_file_desktop_id); 
              $video_file_mobile_id = ACF::getField('media-hero-configuration_mobile-video', $data); 
              $attachment__mobile_video = Media::getAttachmentByID($video_file_mobile_id);  ?>

              <div class="media-hero__media-bg media-hero__media-bg--desktop uk-visible@m">
                <video class="video-file" src="<?php echo esc_html($attachment_desktop_video->url); ?>" muted loop playsinline type="video/mp4" uk-video="autoplay: true"></video>
                <div class="media-hero__media" <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'media-hero-configuration_main-image-settings'); ?>></div>
              </div>
              <div class="media-hero__media-bg media-hero__media-bg--mobile uk-hidden@m">
                <video class="video-file" src="<?php echo esc_html($attachment__mobile_video->url); ?>" muted loop playsinline type="video/mp4" uk-video="autoplay: true"></video>
                <div class="media-hero__media" <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'media-hero-configuration_main-image-settings'); ?>></div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
</section>
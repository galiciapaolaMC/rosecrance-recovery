<?php

/**
 * ACF Module: Home Hero
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$hero_type = ACF::getField('hero-type', $data);

$video_id = ACF::getField('video-background', $data);
$attachment_video = Media::getAttachmentByID($video_id);

$image_id = ACF::getField('image-background', $data);
$attachment_image = Media::getAttachmentByID($image_id);

$main_heading = ACF::getField('heading', $data);
$main_content = ACF::getField('content', $data);

$branded_box_heading = ACF::getField('branded-box_heading', $data);
$branded_box_content = ACF::getField('branded-box_content', $data);

$is_announcement_bar_visible = ACF::getField('show-announcement-bar', $data);
$anouncement_bar_text = ACF::getField('announcement-bar-text', $data);

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module home-hero" id="<?php echo esc_html($row_id); ?>">
  <?php if ($is_announcement_bar_visible === '1') { ?>
    <div class="home-hero__announcement"><?php echo apply_filters('the_content', $anouncement_bar_text); ?></div>
  <?php } ?>
  <div class="home-hero__video-container">
    <div class="home-hero__video-overlay"></div>
    <?php if ($hero_type === 'image') { ?>
      <div class="home-hero__image-background" style="background-image: url(<?php echo esc_url($attachment_image->url); ?>)"></div>
    <?php } ?>
    
    <?php if ($hero_type === 'video') { ?>
      <video class="home-hero__video-background" src="<?php echo esc_html($attachment_video->url); ?>" loop playsinline muted type="video/mp4" uk-video="autoplay: true"></video>
    <?php } ?>
    <h1 class="home-hero__main-heading"><?php echo apply_filters('the_content', $main_heading); ?></h1>
  </div>
  <div class="home-hero__column-container">
    <div class="home-hero__column home-hero__column--branded">
      <h2> <?php echo esc_html($branded_box_heading); ?> </h2>
      <div class="home-hero__branded-content">
        <?php echo apply_filters('the_content', $branded_box_content); ?>
      </div>
    </div>
    <div class="home-hero__column home-hero__column--unbranded">
      <?php echo apply_filters('the_content', $main_content); ?>
    </div>
  </div>
</section>

<?php

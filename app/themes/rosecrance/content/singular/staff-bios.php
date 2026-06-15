<?php

/**
 * Staff Bios template file.
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$post_id = get_the_ID();
$data = ACF::getPostMeta($post_id);

$full_name = ACF::getField('name', $data, '');
$specialty = ACF::getField('specialty', $data, null);
$job_title = ACF::getField('job-title', $data, '');
$bio_detail = ACF::getField('bio-detail', $data, '');
$bio_portrait = ACF::getField('bio-image_image', $data, null);
$name_and_specialty = isset($specialty) ? $full_name . ', ' . $specialty : $full_name;
$image = Media::getAttachmentByID($bio_portrait)->url;
?>

<div id="primary">
  <article id="post-<?php the_ID(); ?>" class="staff-bios">
    <div class="uk-container uk-container-large staff-bios-container">
      <div class="uk-grid uk-grid-medium" uk-grid>
        <div class="uk-width-1-3@m uk-width-1-1 uk-visible@m">
          <?php if (!empty($image)) { ?>
            <img src="<?php echo esc_url($image); ?>" atl="<?php echo esc_attr($full_name); ?>" class="staff-bios__image" />
          <?php } ?>
        </div>

        <div class="uk-width-2-3@m uk-width-1-1">
          <?php if (!empty($name_and_specialty)) { 
              echo nl2br(Util::getHTML(
                  $name_and_specialty,
                  'h1',
                  ['class' => 'staff-bios__headline hdg hdg--1']
              ));
          } ?>

          <?php if (!empty($job_title)) { 
              echo nl2br(Util::getHTML(
                  $job_title,
                  'p',
                  ['class' => 'staff-bios__eyebrow']
              ));
          } ?>

          <div class="uk-hidden@m">
            <?php if (!empty($image)) { ?>
              <img src="<?php echo esc_url($image); ?>" atl="<?php echo esc_attr($full_name); ?>" class="staff-bios__image" />
            <?php } ?>
          </div>

          <?php if (!empty($bio_detail)) { ?>
              <div class="staff-bios__content content-block">
                  <?php echo apply_filters('the_content', $bio_detail); ?>
              </div>
          <?php } ?>
          </div>
      </div>
    </div>
    <?php
      // hook: App/Fields/Modules/outputFlexibleModules()
      do_action('rosecrance/modules/output', get_the_ID());
    ?>
  </article>
</div>
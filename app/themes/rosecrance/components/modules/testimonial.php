<?php

/**
 * ACF Module: Testimonial
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$background_color = ACF::getField('background-color', $data, 'primary-dark');
$font_size = ACF::getField('font-size', $data);
$image_position = ACF::getField('image-position', $data);
$image_id = ACF::getField('image', $data);
$content = ACF::getField('content', $data);
$attribution = ACF::getField('attribution', $data); 
$image = Media::getAttachmentByID($image_id);

if (!$content) {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module testimonial" id="<?php echo esc_html($row_id); ?>">
    <div class="testimonial__container <?php echo esc_attr($font_size); ?> <?php echo esc_attr($image_position); ?>" style="background-color: var(--color-<?php echo esc_attr($background_color); ?>)">
        <div class="testimonial__inner-wrapper">
            <?php if ($image_position === 'image-left') { ?>
                <div class="testimonial__image-wrapper">
                    <div class="testimonial__image" style="background-image: url(<?php echo esc_url($image->url); ?>);"></div>
                </div>

                <div class="testimonial__content-wrapper">
                    <div class="testimonial__content">
                        <p class="testimonial__quote"><?php echo esc_html($content); ?></p>

                        <?php if (!empty($attribution)) { ?>
                            <p class="testimonial__attribution">- <?php echo esc_html($attribution); ?></p>
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="testimonial__content-wrapper">
                    <div class="testimonial__content">
                        <p class="testimonial__quote"><?php echo esc_html($content); ?></p>

                        <?php if (!empty($attribution)) { ?>
                            <p class="testimonial__attribution">&ndash; <?php echo esc_html($attribution); ?></p>
                        <?php } ?>
                    </div>
                </div>

                <div class="testimonial__image-wrapper">
                    <div class="testimonial__image" style="background-image: url(<?php echo esc_url($image->url); ?>);"></div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
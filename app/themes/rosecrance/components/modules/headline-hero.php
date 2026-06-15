<?php

/**
 * ACF Module: Headline Hero
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$block_fill_color = ACF::getField('block-fill-color', $data, '#FAA834');
$text_block_color = ACF::getField('text-block-color', $data, 'primary-grey');

$is_announcement_bar_visible = ACF::getField('show-announcement-bar', $data);
$anouncement_bar_text = ACF::getField('announcement-bar-text', $data);
?>

<section class="module hero headline-hero" id="<?php echo esc_html($row_id); ?>">
    <?php if ($is_announcement_bar_visible === '1') { ?>
        <div class="hero__announcement"><?php echo apply_filters('the_content', $anouncement_bar_text); ?></div>
    <?php } ?>
    <div class="headline-hero__wrapper" style="background-color: <?php echo esc_attr($block_fill_color); ?>;">
        <div class="uk-container uk-container-medium">  
            <h1 class="headline-hero__heading text-color-<?php echo esc_attr($text_block_color); ?>"><?php echo esc_html($heading)?></h1>
        </div>
    </div>
</section>
 
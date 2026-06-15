<?php

/**
 * ACF Module: Large Hero
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$cta = ACF::getField('large-hero-configuration_cta', $data, null);
$secondary_cta = ACF::getField('large-hero-configuration_secondary-cta', $data, null);
$content = ACF::getField('content', $data, null);
$color_block = ACF::getField('color-block', $data, 'inactive');
$block_fill_color = ACF::getField('block-fill-color', $data, '#FAA834');
$text_block_color = ACF::getField('text-block-color', $data, '#695E4A');
$color_block_heading = ACF::getField('color-block-heading', $data, null);
$color_block_content = ACF::getField('color-block-content', $data, null);
$hero_image_size = ACF::getField('hero-image-size', $data, 'large');

$is_announcement_bar_visible = ACF::getField('show-announcement-bar', $data);
$anouncement_bar_text = ACF::getField('announcement-bar-text', $data);
?>

<?php if ($is_announcement_bar_visible === '1') { ?>
    <div class="hero__announcement"><?php echo apply_filters('the_content', $anouncement_bar_text); ?></div>
<?php } ?>

<section class="module hero large-hero" id="<?php echo esc_html($row_id); ?>">
    <div class="large-hero__wrapper">
        <div class="large-hero__content-wrapper">
            <div class="large-hero__section large-hero__section--top">
                <div class="uk-container uk-container-medium">  
                    <h1 class="large-hero__heading"><?php echo esc_html($heading)?></h1>
                </div>
            </div>

            <div class="large-hero__section large-hero__section--middle">
                <div class="large-hero__media-bg large-hero__media-bg--desktop uk-visible@m">
                    <div class="large-hero__media media-size-<?php echo esc_attr($hero_image_size); ?>" <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'large-hero-configuration_main-image-settings'); ?>></div>
                </div>
                <div class="large-hero__media-bg large-hero__media-bg--mobile uk-hidden@m">
                    <div class="large-hero__media"  <?php echo Util::getAgnosticInlineBackgroundStyles($data, 'large-hero-configuration_main-mobile-image-settings'); ?>></div>
                </div>
            </div>

            <div class="large-hero__section large-hero__section--bottom">
                <div class="uk-container uk-container-medium">
                    <?php if ($color_block === 'inactive') { ?>  
                        <?php if (!empty($content)) { ?>
                            <div class="large-hero__content content-block">
                                <?php echo apply_filters('the_content', $content); ?>
                            </div>
                        <?php } ?>

                        <?php
                        if (!is_null($cta)) { ?>
                            <div class="large-hero__cta-wrapper">
                                <?php echo Util::getButtonHTML($cta, $primary_cta_options); ?>
                            </div>
                        <?php }

                        if (!is_null($secondary_cta)) { ?>
                            <div class="large-hero__cta-wrapper">
                                <?php echo Util::getButtonHTML($secondary_cta, $secondary_cta_options); ?>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="uk-grid uk-grid-large uk-child-width-1-2@m uk-child-width-1-1@s">
                            <div>
                                <div class="large-hero__content content-block">
                                    <?php echo apply_filters('the_content', $content); ?>
                                </div>

                                <?php
                                if (!is_null($cta)) { ?>
                                    <div class="large-hero__cta-wrapper">
                                        <?php echo Util::getButtonHTML($cta, $primary_cta_options); ?>
                                    </div>
                                <?php }

                                if (!is_null($secondary_cta)) { ?>
                                    <div class="large-hero__cta-wrapper">
                                        <?php echo Util::getButtonHTML($secondary_cta, $secondary_cta_options); ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <div>
                                <div class="large-hero__color-block text-color-<?php echo esc_attr($text_block_color); ?>" style="background-color: <?php echo esc_attr($block_fill_color); ?>;">
                                    <?php if (!empty($color_block_heading)) {
                                        echo nl2br(Util::getHTML(
                                            $color_block_heading,
                                            'h3',
                                            ['class' => 'large-hero__color-block__title color-block-title']
                                        ));
                                    } ?>

                                    <?php if (!empty($color_block_content)) { ?>
                                        <div class="large-hero__color-block__content content-block">
                                            <?php echo apply_filters('the_content', $color_block_content); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
 
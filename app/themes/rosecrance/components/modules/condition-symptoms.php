<?php

/**
 * ACF Module: Condition Symptoms
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$eyebrow = ACF::getField('eyebrow', $data);
$eyebrow_type = ACF::getField('eyebrow-type', $data, 'h2');
$headline = ACF::getField('headline', $data);
$headline_type = ACF::getField('headline-type', $data, 'h2');
$content  = ACF::getField('content', $data);
$block_fill_color = ACF::getField('block-fill-color', $data, '#FAA834');
$text_block_color = ACF::getField('text-block-color', $data, '#695E4A');
$color_block_heading = ACF::getField('color-block-heading', $data, null);
$color_block_content = ACF::getField('color-block-content', $data, null);
$additional_content = ACF::getField('additional-content', $data);

if (!$content) {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module condition-symptoms" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container uk-container-medium">
        <div class="uk-hidden@m">
            <div class="condition-symptoms__color-block text-color-<?php echo esc_attr($text_block_color); ?>" style="background-color: <?php echo esc_attr($block_fill_color); ?>;">
                <?php if (!empty($color_block_heading)) {
                    echo nl2br(Util::getHTML(
                        $color_block_heading,
                        'h3',
                        ['class' => 'condition-symptoms__color-block__title color-block-title']
                    ));
                } ?>

                <?php if (!empty($color_block_content)) { ?>
                    <div class="condition-symptoms__color-block__content content-block">
                        <?php echo apply_filters('the_content', $color_block_content); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        
        <div class="condition-symptoms__headline-container uk-width-1-2@m uk-width-1-1@s">
            <?php if (!empty($eyebrow)) { 
                echo nl2br(Util::getHTML(
                    $eyebrow,
                    $eyebrow_type,
                    ['class' => 'condition-symptoms__eyebrow']
                ));
            } ?>
            
            <?php if (!empty($headline)) { 
                echo nl2br(Util::getHTML(
                    $headline,
                    $headline_type,
                    ['class' => 'condition-symptoms__headline hdg hdg--1']
                ));
            } ?>
        </div>
        <div class="uk-grid uk-grid-large uk-child-width-1-2@m uk-child-width-1-1@s">
            <div>
                <?php if (!empty($content)) { ?>
                    <div class="condition-symptoms__content content-block">
                        <?php echo apply_filters('the_content', $content); ?>
                    </div>
                <?php } ?>
            </div>

            <div class="uk-visible@m condition-symptoms__color-block-container">
                <div class="condition-symptoms__color-block text-color-<?php echo esc_attr($text_block_color); ?>" style="background-color: <?php echo esc_attr($block_fill_color); ?>;">
                    <?php if (!empty($color_block_heading)) {
                        echo nl2br(Util::getHTML(
                            $color_block_heading,
                            'h3',
                            ['class' => 'condition-symptoms__color-block__title color-block-title']
                        ));
                    } ?>

                    <?php if (!empty($color_block_content)) { ?>
                        <div class="condition-symptoms__color-block__content content-block">
                            <?php echo apply_filters('the_content', $color_block_content); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php if (!empty($additional_content)) { ?>
            <div class="condition-symptoms__additional-content content-block">
                <?php echo apply_filters('the_content', $additional_content); ?>
            </div>
        <?php } ?>
    </div>
</section>
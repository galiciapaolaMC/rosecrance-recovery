<?php

/**
 * ACF Module: Column Content
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$main_headline = ACF::getField('main-headline', $data);
$main_headline_type = ACF::getField('main-headline-type', $data, 'h2');
$column_alignment = ACF::getField('column-alignment', $data, 'blocks');
$items = ACF::getRowsLayout('column-items', $data);

if (empty($items)) {
    return;
}

if ($column_alignment === 'blocks') {
    $uk_grid = 'uk-grid';
} else {
    $uk_grid = 'uk-grid=masonry: pack;';
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module column-content" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container uk-container-medium">
        <?php if (!empty($main_headline)) {  ?>
            <div class="column-content__main-headline">
                <?php echo nl2br(Util::getHTML(
                    $main_headline,
                    $main_headline_type
                )); ?>
            </div>
        <?php } ?>

        <div class="column-content__containter">
            <div class="uk-grid uk-grid-large uk-child-width-1-2@m uk-child-width-1-1@s" <?php echo esc_attr($uk_grid); ?>>
                <?php foreach ($items as $item) { 
                    $headline = ACF::getField('headline', $item);
                    $content  = ACF::getField('content-block', $item);
                    $desktop_image = ACF::getField('desktop-image', $item);
                    $mobile_image = ACF::getField('mobile-image', $item);
                    $buttons = ACF::getRowsLayout('buttons', $item);
                    $links = ACF::getRowsLayout('links', $item); 
                    $column_type = ACF::getField('column-type', $item, 'content'); ?>
                    
                    <div class="column-content__content">
                        <?php if (!empty($headline)) { ?>
                            <?php echo nl2br(Util::getHTML(
                                $headline,
                                'h3',
                                ['class' => 'column-content__subheadline']
                            )); ?>
                        <?php } ?> 

                        <?php if ($column_type === 'content') {
                            if (!empty($content)) { ?>
                                <div class="column-content__content-container content-block">
                                    <?php echo apply_filters('the_content', $content); ?>
                                </div>
                            <?php } 
                        } ?>

                        <?php if ($column_type === 'link-list') {
                            if (!empty($links)) { 
                                foreach ($links as $link_item) { 
                                    $link = ACF::getField('link', $link_item); ?> 

                                    <div class="column-content__links">
                                        <?php echo Util::getButtonHTML($link, ['class' => 'btn btn-inline', 'icon-end' => 'arrow-right-dark']); ?>
                                    </div>
                            <?php } 
                            } 
                        } ?>

                        <?php if (!empty($desktop_image) && $column_type === 'content') {
                            $image_mobile = Media::getAttachmentSrcByID($mobile_image);
                            $image_desktop = Media::getAttachmentSrcByID($desktop_image);

                            if (empty($image_mobile)) {
                               $image_mobile = $image_desktop;
                            } ?>

                            <div class="column-content__image">
                                <div class="uk-visible@m uk-position-center image-container" style="background-image:url(<?php echo esc_url($image_desktop); ?>);"></div>
                                <div class="uk-hidden@m uk-position-center image-container" style="background-image:url(<?php echo esc_url($image_mobile); ?>);"></div>
                            </div>

                        <?php } ?>
                        
                        <?php if (!empty($buttons)) { ?>
                            <div class="column-content__buttons">
                                <?php foreach ($buttons as $item) { 
                                    $button = ACF::getField('button', $item);
                                    $button_type = ACF::getField('button-type', $item);
                    
                                    if ($button_type === 'primary') {
                                        $icon = 'arrow-right-dark';
                                    } else {
                                        $icon = 'arrow-right-white';
                                    }
                    
                                    echo Util::getButtonHTML($button, ['class' => 'btn btn-'. $button_type, 'icon-end' => $icon]);    
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
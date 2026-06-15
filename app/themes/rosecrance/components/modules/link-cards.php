<?php

/**
 * ACF Module: Carousel
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$items = ACF::getRowsLayout('items', $data);
$headline = ACF::getField('headline', $data);
$headline_type = ACF::getField('headline-type', $data, 'h2');
$column_type = ACF::getField('column-type', $data, '3-col');

if (!$items) {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);

if ($column_type === '2-col') {
    $column_class = 'uk-child-width-1-2@s';
} elseif ($column_type === '4-col') {
    $column_class = 'uk-child-width-1-4@s';
} else {
    $column_class = 'uk-child-width-1-3@s';
}
?>

<section class="module link-cards" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container uk-container-large">
        <?php if (!empty($headline)) { 
            echo nl2br(Util::getHTML(
                $headline,
                $headline_type,
                ['class' => 'link-cards__headline']
            ));
        } ?>

        <div class="uk-grid uk-grid-small <?php echo esc_attr($column_class); ?> uk-flex-center uk-width-1-1 uk-grid-match" uk-grid>
            <?php foreach ($items as $item) {
                $link = ACF::getField('button', $item); 
                $link_color = ACF::getField('link-color', $item, 'primary-orange'); ?>

                <div>
                    <a href="<?php echo esc_url($link['url']); ?>" class="link-cards__link link-cards__link--<?php echo esc_attr($link_color); ?>"><?php echo esc_html($link['title']); ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
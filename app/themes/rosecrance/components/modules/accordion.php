<?php

/**
 * ACF Module: Accordion
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$headline = ACF::getField('headline', $data);
$additional_text = ACF::getField('additional-text', $data);
$items  = ACF::getRowsLayout('accordion-items', $data);
$heading_color = ACF::getField('headings_color', $data, null);

$heading_color_class = !is_null($heading_color) ? 'accordion__headline--' . $heading_color : '';

if (empty($items)) {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module accordion" id="<?php echo esc_html($row_id); ?>">
    <div class="site-wrapper">
        <div class="uk-container uk-container-medium">
            <div class="accordion__heading-container">
                <?php
                echo nl2br(Util::getHTML(
                    $headline,
                    'h2',
                    ['class' => 'accordion__heading']
                ));

                if (!empty($additional_text)) { ?>
                    <p class="accordion__sub-heading"><?php echo esc_html($additional_text); ?></p>
                <?php } ?>
            </div>

            <ul uk-accordion>
                <?php foreach ($items as $item) {
                    $title = ACF::getField('title', $item);
                    $content = ACF::getField('content', $item); ?>

                    <li class="accordion__row">
                        <button class="accordion__headline uk-accordion-title  <?php echo esc_attr($heading_color_class)?>">
                            <?php
                            echo nl2br(Util::getHTML(
                                $title,
                                'h3',
                                ['class' => 'accordion__title']
                            )); ?>
                            <div class="accordion__icon accordion__icon-open" aria-hidden="true">
                                &#8211;
                            </div>
                            <div class="accordion__icon accordion__icon-closed" aria-hidden="true">
                                +
                            </div>
                        </button>
                        <div class="uk-accordion-content accordion__content content-block"><?php echo apply_filters('the_content', $content); ?></div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>
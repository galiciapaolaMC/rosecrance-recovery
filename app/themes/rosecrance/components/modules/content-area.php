<?php

/**
 * ACF Module: Content Area
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
$links = ACF::getRowsLayout('links', $data);

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module content-area" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container uk-container-medium">
        <?php if (!empty($eyebrow)) { 
            echo nl2br(Util::getHTML(
                $eyebrow,
                $eyebrow_type,
                ['class' => 'content-area__eyebrow']
            ));
        } ?>
        
        <?php if (!empty($headline)) { 
            echo nl2br(Util::getHTML(
                $headline,
                $headline_type,
                ['class' => 'content-area__headline hdg hdg--1']
            ));
        } ?>

        <?php if (!empty($content)) { ?>
            <div class="content-area__content content-block">
                <?php echo apply_filters('the_content', $content); ?>
            </div>
        <?php } ?>

        <?php if (!empty($links)) {
            foreach ($links as $item) {
                $button = ACF::getField('button', $item);
                $button_type = ACF::getField('button-type', $item);

                if ($button_type === 'primary') {
                    $icon = 'arrow-right-dark';
                } else {
                    $icon = 'arrow-right-white';
                }

                echo Util::getButtonHTML($button, ['class' => 'btn btn-'. $button_type, 'icon-end' => $icon]);
            }
        } ?>
    </div>
</section>
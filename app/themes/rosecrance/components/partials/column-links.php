<?php

/**
 * ACF Module Partial: Column Links
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$headline = ACF::getField('headline', $data);
$headline_type = ACF::getField('headline-type', $data, 'h2');
$items = ACF::getRowsLayout('items', $data);

if (empty($items)) {
    return;
}

?>

<section class="partial column-links">
    <div class="uk-container">
        <?php if (!empty($headline)) { ?>
            <div class="headline__content">
                <?php
                echo nl2br(Util::getHTML(
                    $headline,
                    $headline_type,
                    ['class' => 'title']
                ));
                ?>
            </div>
        <?php } ?>

        <?php foreach ($items as $item) {
            $subheadline = ACF::getField('subheadline', $item);
            $subheadline_type = ACF::getField('subheadline-type', $item, 'h3');
            $links = ACF::getRowsLayout('links', $item);
            ?>

            <div class="column-links__link-container">
                <?php if (!empty($subheadline)) { ?>
                    <div class="subheadline__content">
                        <?php
                        echo nl2br(Util::getHTML(
                            $subheadline,
                            $subheadline_type,
                            ['class' => 'title']
                        ));
                        ?>
                    </div>
                <?php } ?>

                <div class="link-list uk-grid uk-grid-medium uk-child-width-1-2@m uk-child-width-1-1@s" uk-grid>
                    <?php foreach ($links as $link_item) {
                        $link = ACF::getField('link', $link_item); ?>

                        <div class="link-item">
                            <?php echo Util::getButtonHTML($link, ['class' => 'btn btn-inline', 'icon-end' => 'arrow-right-dark']); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
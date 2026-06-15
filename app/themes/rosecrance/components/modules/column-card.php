<?php

/**
 * ACF Module: Column Card
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Media;
use Rosecrance\App\Fields\Util;

$items  = ACF::getRowsLayout('column-items', $data);

if (empty($items)) {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);

if (count($items) === 3) {
    $column_class = 'uk-width-1-3@m uk-width-1-1@s';
} else {
    $column_class = 'uk-width-1-2@m uk-width-1-1@s two-column-card';
}
?>

<section class="module column-card" id="<?php echo esc_html($row_id); ?>">
    <div class="site-wrapper">
        <div class="uk-container uk-container-medium">
            <div class="column-card__container">
                <div class="uk-grid uk-grid-medium" uk-grid>
                    <?php foreach ($items as $item) {
                        $title = ACF::getField('title', $item);
                        $content = ACF::getField('content', $item);
                        $image = ACF::getField('image', $item); ?>
                        
                        <div class="<?php echo esc_attr($column_class); ?>">
                            <div class="column-card__content">
                                <?php if (!empty($image)) {
                                    echo Util::getImageHTML(Media::getAttachmentByID($image));
                                } ?>

                                <?php if (!empty($title)) {
                                    echo nl2br(Util::getHTML(
                                        $title,
                                        'h2',
                                        ['class' => 'column-card__content--title']
                                    ));
                                } ?>

                                <?php if (!empty($content)) { ?>
                                    <p class="column-card__content--text"><?php echo esc_html($content); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
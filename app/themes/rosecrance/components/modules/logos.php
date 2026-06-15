<?php

/**
 * ACF Module: Logos
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Media;
use Rosecrance\App\Fields\Util;

$items  = ACF::getRowsLayout('logo-items', $data);

if (empty($items)) {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);

?>

<section class="module logos" id="<?php echo esc_html($row_id); ?>">
    <div class="site-wrapper">
        <div class="uk-container uk-container-medium">
            <div class="logos__container">
                <div class="uk-grid uk-grid-medium" uk-grid>
                    <?php foreach ($items as $item) {
                        $image = ACF::getField('image', $item); ?>
                        
                        <div class="uk-width-1-4@m uk-width-1-2">
                            <div class="logos__content">
                                <?php if (!empty($image)) {
                                    echo Util::getImageHTML(Media::getAttachmentByID($image));
                                } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
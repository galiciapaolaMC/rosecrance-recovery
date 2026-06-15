<?php

/**
 * ACF Module: Image
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Media;
use Rosecrance\App\Fields\Util;

$image = ACF::getField('image', $data);

if (!$image) {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module image" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container">
        <div class="module__image">
            <?php echo Util::getImageHTML(Media::getAttachmentByID($image)); ?>
        </div>
    </div>
</section>
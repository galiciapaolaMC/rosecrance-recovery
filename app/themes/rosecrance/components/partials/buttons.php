<?php

/**
 * ACF Module Partial: Buttons
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$items = ACF::getRowsLayout('items', $data);

if (empty($items)) {
    return;
}

?>

<section class="partial buttons">
    <div class="uk-container">
        <?php foreach ($items as $item) {
            $button = ACF::getField('button', $item);
            $button_type = ACF::getField('button-type', $item);

            if ($button_type === 'primary' || $button_type === 'white') {
                $icon = 'arrow-right-dark';
            } else {
                $icon = 'arrow-right-white';
            } ?>

            <div class="buttons__content">
                <?php echo Util::getButtonHTML($button, ['class' => 'btn btn-'. $button_type, 'icon-end' => $icon]); ?>
            </div>
        <?php } ?>
    </div>
</section>
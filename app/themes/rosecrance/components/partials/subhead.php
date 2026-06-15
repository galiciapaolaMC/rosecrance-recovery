<?php

/**
 * ACF Module Partial: Subhead
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$subhead = ACF::getField('subhead', $data);

if (empty($subhead)) {
    return;
}

?>

<section class="partial subhead">
    <div class="uk-container">
        <div class="subhead__content">
            <p><?php echo esc_html($subhead); ?>
        </div>
    </div>
</section>
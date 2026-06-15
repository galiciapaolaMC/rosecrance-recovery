<?php

/**
 * ACF Module Partial: Content
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$content = ACF::getField('content-block', $data);

if (empty($content)) {
    return;
}

?>

<section class="partial content">
    <div class="uk-container">
        <div class="content__body content-block">
            <?php echo apply_filters('the_content', $content); ?>
        </div>
    </div>
</section>
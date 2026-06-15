<?php

/**
 * ACF Module Partial: Headline Orange
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$headline = ACF::getField('headline', $data);
$headline_type = ACF::getField('headline-type', $data);

if (empty($headline)) {
    return;
}

?>

<section class="partial headline-orange">
    <div class="uk-container">
        <div class="headline-orange__content">
            <?php
            echo nl2br(Util::getHTML(
                $headline,
                $headline_type,
                ['class' => 'title']
            ));
            ?>
        </div>
    </div>
</section>
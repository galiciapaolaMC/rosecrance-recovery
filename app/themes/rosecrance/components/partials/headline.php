<?php

/**
 * ACF Module Partial: Headline
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

<section class="partial headline">
    <div class="uk-container">
        <div class="headline__content">
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
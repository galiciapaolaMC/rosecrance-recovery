<?php

/**
 * ACF Module Partial: Donte Box
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$headline = ACF::getField('headline', $data);
$link = ACF::getField('link', $data);

if (empty($headline)) {
    return;
}

?>

<section class="partial donate-box">
    <div class="donate-box__content">
        <?php
        echo nl2br(Util::getHTML(
            $headline,
            'h2',
            ['class' => 'title']
        ));
        
        if (!empty($link)) {
            echo Util::getButtonHTML($link, ['class' => 'btn btn-white', 'icon-end' => 'arrow-right-dark']); 
        } ?>
    </div>
</section>
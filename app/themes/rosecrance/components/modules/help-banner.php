<?php

/**
 * ACF Module: Help Banner
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$options = Options::getSiteOptions();
$activate = ACF::getField('activate-help-banner', $data);
$headline = ACF::getField('headline-help-banner', $options);
$content = ACF::getField('content-help-banner', $options);

if ($activate === 'inactive') {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module help-banner" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container uk-container-large">
        <div class="help-banner__heading">
            <?php
            echo nl2br(Util::getHTML(
                $headline,
                'h2',
                ['class' => 'help-banner__title']
            ));
            ?>
        </div>
        <div class="help-banner__body">
            <?php echo apply_filters('the_content', $content); ?>
        </div>
    </div>
</section>
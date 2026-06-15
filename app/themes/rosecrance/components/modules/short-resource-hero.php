<?php

/**
 * ACF Module: Short Resource Hero
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$download_button = ACF::getField('download-button', $data, null);
$is_announcement_bar_visible = ACF::getField('show-announcement-bar', $data);
$anouncement_bar_text = ACF::getField('announcement-bar-text', $data);

?>

<?php if ($is_announcement_bar_visible === '1') { ?>
    <div class="resource-hero__announcement"><?php echo apply_filters('the_content', $anouncement_bar_text); ?></div>
<?php } ?>

<section class="module resource-hero short-resource-hero" id="<?php echo esc_html($row_id); ?>">
    <div class="short-resource-hero__wrapper">
        <div class="short-resource-hero__bg-container short-resource-hero__bg-container--mobile"<?php echo Util::getAgnosticInlineBackgroundStyles($data, 'image-configuration_main-image-settings'); ?>></div>
        <div class="short-resource-hero__bg-container short-resource-hero__bg-container--desktop"<?php echo Util::getAgnosticInlineBackgroundStyles($data, 'image-configuration_main-mobile-image-settings'); ?>></div>

        <div class="uk-container uk-container-medium">
        <div class="short-resource-hero__content-wrapper">
            <div class="short-resource-hero__section short-resource-hero__section--left">
                <?php if (!is_null($subhead)) { ?>
                    <p class="short-resource-hero__eyebrow"><?php echo esc_html($subhead); ?> </p>
                <?php } ?>
                <h1 class="short-resource-hero__heading"><?php echo esc_html($heading)?></h1>

                <?php if (!empty($download_button)) {
                    echo Util::getButtonHTML($download_button, ['class' => 'btn btn-white', 'icon-end' => 'download-dark-grey']);
                } ?>
            </div>
            <div class="short-resource-hero__section short-resource-hero__section--right background-<?php echo esc_attr($content_color); ?>">
                <?php echo apply_filters('the_content', $content); ?>
            </div>
        </div>
        </div>
    </div>
</section>
<?php

/**
 * ACF Module: Content Banner
 *
 * @var array $data
 * @var string $row_id
 */

 use Rosecrance\App\Fields\ACF;
 use Rosecrance\App\Fields\Util;


$variant = ACF::getField('variant', $data);
$heading = ACF::getField('heading', $data);
$heading_tag = 'h2';
if ($variant === 'wide') {
    $heading_tag = 'h1';
}

$content = ACF::getField('content', $data);
$cta = ACF::getField('cta', $data, null);
$secondary_cta = ACF::getField('secondary-cta', $data, null);
$pre_link_text = ACF::getField('inline-link_text', $data);
$inline_link = ACF::getField('inline-link_link', $data, null);
$content_alignment = ACF::getField('content-alignment', $data);
$color_variant = ACF::getField('color-variant', $data);

$banner_variant_class = 'content-banner--' . $variant;
$content_alignment_class = 'content-banner--' . $content_alignment;
$color_variant_class = 'content-banner--' . $color_variant;

$css_classes = implode(' ', ['content-banner', $content_alignment_class, $color_variant_class, $banner_variant_class]);

$showBackgroundGraphic = ACF::getField('show-background-graphic', $data);
$backgroundStyle = '';
if ($showBackgroundGraphic) {
    $backgroundStyle = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/rosecrance-bg.png);"';
}

do_action('rosecrance/modules/styles', $row_id, $data);

?>

<section class="module <?php echo esc_attr($css_classes); ?>" id="<?php echo esc_html($row_id); ?>" >
    <div class="content-banner__bg-container" <?php echo $backgroundStyle ?> aria-hidden="true">
    </div>

    <div class="uk-container uk-container-medium">
        <div class="content-banner__body">
            <?php if (!empty($heading)) {
                echo nl2br(Util::getHTML(
                    $heading,
                    $heading_tag,
                    ['class' => 'content-banner__heading']
                ));
            } ?>
            <?php if (!empty($content)) { ?>
            <div class="content-banner__description">
                <?php echo apply_filters('the_content', $content); ?>
            </div>
            <?php } ?>
            <?php if (!empty($cta) || !empty($secondary_cta) && $variant === 'narrow') { 
                $container_class = !empty($inline_link) ? 'content-banner__button-container content-banner__button-container--inline-link-present' : 'content-banner__button-container content-banner__button-container';
            ?>
                <div class="<?php echo esc_attr($container_class); ?>">
                    <?php if (!empty($cta)) { 
                        echo Util::getButtonHTML($cta, ['class' => 'btn btn-primary content-banner__cta', 'icon-end' => 'arrow-right-dark']); 
                    }?>
                    <?php if (!empty($secondary_cta)) { 
                        echo Util::getButtonHTML($secondary_cta, ['class' => 'btn btn-secondary content-banner__cta', 'icon-end' => 'arrow-right-white']); 
                    }?>
                </div>
            <?php } ?>
            <?php if (!empty($pre_link_text) && !empty($inline_link)) { ?>
                <div class="content-banner__inline-link">
                    <p><?php echo esc_html($pre_link_text); ?> <?php echo Util::getButtonHTML($inline_link, ['class' => 'btn btn-inline']); ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
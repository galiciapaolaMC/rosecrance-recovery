<?php

/**
 * ACF Module: Wysiwyg
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$page_id = get_the_ID();
$content = ACF::getField('content', $data);
$download_link = ACF::getField('download-link', $data);
$social_share_buttons = ACF::getField('social-share-buttons', $data);
$social_share_headline = ACF::getField('social-share-headline', $data);
$citation = ACF::getField('citation-text', $data);
$use_block_quote_styles = ACF::getField('use-block-quote-styles', $data);
$remove_content = ACF::getField('remove-content', $data);
$add_script = ACF::getField('add-script', $data);

$block_quote_class = '';
if ($use_block_quote_styles) {
    $block_quote_class = 'wysiwyg--custom-block-quote';
}

$citation_class = '';

do_action('rosecrance/modules/styles', $row_id, $data);

if ($citation === 'true') {
    $citation_class = 'citation-container';
}
?>

<section class="module wysiwyg <?php echo esc_attr($block_quote_class); ?>" id="<?php echo esc_html($row_id);?>">
    <div class="uk-container uk-container-medium">
        <div class="wysiwyg__content content-block <?php echo esc_attr($citation_class); ?>">
            <?php if (!empty($content)) { 
                echo apply_filters('the_content', $content); 
            } ?>

            <?php if (!empty($download_link)) {
                echo Util::getButtonHTML($download_link, ['class' => 'btn btn-secondary', 'icon-end' => 'download-white']);
            } ?>

            <?php if ($social_share_buttons === 'active') { ?>
                <div class="wysiwyg__social-buttons">
                    <?php if (!empty($social_share_headline)) {
                        echo nl2br(Util::getHTML(
                            $social_share_headline,
                            'p',
                            ['class' => 'wysiwyg__social-headline']
                        ));
                    } 
                    
                    $permalink = get_the_permalink($page_id); 
                    $page_title = get_the_title($page_id); ?>

                    <div class="social-wrapper">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($permalink); ?>" target="_blank">
                            <?php echo Util::getIconHTML('facebook'); ?>
                        </a>

                        <a href="https://twitter.com/share?url=<?php echo esc_url($permalink); ?>&text=<?php echo esc_attr($page_title); ?>" target="_blank">
                            <?php echo Util::getIconHTML('twitter'); ?>
                        </a>

                        <a href="https://www.linkedin.com/sharing/share-offsite?url=<?php echo esc_url($permalink); ?>" target="_blank">
                            <?php echo Util::getIconHTML('linkedin'); ?>
                        </a>
                    </div>
                </div>
            <?php } ?>

            <?php if ($add_script === 'yes') : 
                $script = ACF::getField('script', $data);
                echo $script;
            endif; ?>
        </div>
    </div>
</section>
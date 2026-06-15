<?php

/**
 * ACF Module: News Articles
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$initial_display_count = 8;

$section_title = ACF::getField('title', $data);

$news_articles = get_posts([
    'post_type' => array('news-detail'),
    'post_status' => 'publish',
    'numberposts' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
]);

if (count($news_articles) <= 0) {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<div class="module news-articles" id="<?php echo esc_html($row_id); ?>">
    <div class="news-articles__title-container">
        <h2><?php echo esc_html($section_title); ?></h2>
    </div>
    <div class="news-articles__cards-container">
        <?php
            foreach($news_articles as $news_article) {
                echo util::getCard($news_article);
            }
        ?>
    </div>
    <?php if (count($news_articles) >= $initial_display_count) { ?>
        <div class="news-articles__view-button-container">
            <button class="btn btn-primary news-articles__view-toggle-button" data-show-text="<?php _e('View More', 'rosecrance') ?>" data-hide-text="<?php _e('View Less', 'rosecrance'); ?>">
                <?php _e('View More', 'rosecrance') ?>
            </button>
        </div>
    <?php } ?>
</div>


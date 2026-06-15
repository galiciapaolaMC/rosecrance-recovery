<?php

/**
 * Template Name: Resources
 *
 * This template outputs resources cards along with filters
 *
 * @package Rosecrance
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\Util;
$resources_post_id = get_the_ID();
get_header();

$toggle_podcasts = true;
$toggle_videos = true;
$toggle_blog_articles = true;
$toggle_extended_articles = true;

if (isset($_GET['filter']) && !empty($_GET['filter'])) {
    $filter = $_GET['filter'];
    
    if ($filter === 'podcasts') {
        $toggle_podcasts = true;
        $toggle_videos = false;
        $toggle_blog_articles = false;
        $toggle_extended_articles = false;
    } else if ($filter === 'videos') {
        $toggle_podcasts = false;
        $toggle_videos = true;
        $toggle_blog_articles = false;
        $toggle_extended_articles = false;
    } else if ($filter === 'blog-post') {
        $toggle_podcasts = false;
        $toggle_videos = false;
        $toggle_blog_articles = true;
        $toggle_extended_articles = false;
    } else if ($filter === 'extended-article') {
        $toggle_podcasts = false;
        $toggle_videos = false;
        $toggle_blog_articles = false;
        $toggle_extended_articles = true;
    } 
}
?>

<div id="primary" class="resource-library">
    <div id="smooth-wrapper">
        <div id="smooth-content">
            <?php 
                $part = 'resource-library-banner';
                $parent_class = 'resources-libary';
                $options = Options::getSiteOptions();
                $pinned_post_ids = (Array)ACF::getField('pinned-posts', $options, []);
                $conditions = ['' => '-'];
                foreach (Util::getPostsAsAssociativeArray('conditions') as $key => $value) {
                    $conditions[$key] = $value;
                }
                $audiences = array('' => '-');
                foreach (Util::getPostsAsAssociativeArray('audience') as $key => $value) {
                    $audiences[$key] = $value;
                }
                $posts = get_posts([
                    'post_type' => array('podcast', 'videos', 'blog-post', 'extended-article'), // , drug-fact-sheet 'videos', 'blog-article', 'extended-article', 'drug-fact-sheet'
                    'post_status' => 'publish',
                    'numberposts' => -1,
                    'orderby' => 'modified',
                    'order' => 'DESC'
                ]);

                $unsorted_pinned_posts = array();
                $priority_one_posts = array();
                $priority_two_posts = array();
                $priority_three_posts = array();
                $post_info = array();

                foreach($posts as $post) {
                    
                    
                    $post_id = $post->ID;
                    $meta = ACF::getPostMeta($post_id);
                    $priority = ACF::getField('card_priority', $meta);
                    $name = ACF::getField('name', $meta);
                    $post_title = isset( $post->post_title ) ? $post->post_title : '';
                    $title_text = !empty($name) ? esc_html($name) : $post_title;
                    $description_text = ACF::getField('description', $meta, '');

                    $related_conditions = ACF::getField('conditions_related-conditions', $meta);
                    $related_audiences = ACF::getField('audiences_related-audiences', $meta);
                    $related_programs = ACF::getField('programs_related-programs', $meta);
                    $related_services = ACF::getField('services_related-services', $meta);

                    $type = get_post_type($post_id);
                    if (in_array($post_id, $pinned_post_ids)) {
                        $unsorted_pinned_posts[$post_id] = $post;
                    } else {
                        switch ($priority) {
                            case '1':
                                $priority_one_posts[] = $post;
                                break;
                            case '2':
                                $priority_two_posts[] = $post;
                                break;
                            case '3':
                            default:
                                $priority_three_posts[] = $post;
                                break;
                        }
                    }

                    // prepare data to be localized to javascript
                    $post_info[$post_id] = array (
                        'id' => $post_id,
                        'type' => $type,
                        'related_conditions' => $related_conditions !== '' ? $related_conditions : [],
                        'related_audiences' => $related_audiences !== '' ? $related_audiences : [],
                        'related_programs' => $related_programs !== '' ? $related_programs : [],
                        'related_services' => $related_services !== '' ? $related_services : [],
                        'title_text' => $title_text,
                        'description_text' => $description_text
                    );
                }

                wp_localize_script(
                    'rosecrance-theme',
                    'post_data',
                    $post_info
                );

                $file = locate_template("templates/partials/{$part}.php");
                if (file_exists($file)) {
                    include $file;
                }
            ?>
            <div class="resource-library__controls">
                <div class="resource-library__dropdown-filters">
                    <?php
                    echo Util::getSelectFieldHtml('conditions', 'We offer hope for', $conditions, [], true, false, false);
                    echo Util::getSelectFieldHtml('audience', 'Audience', $audiences, '', false, false, false);
                    echo Util::getTextFieldHtml('search', 'Search', '', 'search');
                    ?>
                </div>
                <div class="resource-library__toggle-filters">
                    <?php 
                    echo Util::getToggleControlHtml('podcasts', 'Podcasts', $toggle_podcasts);
                    echo Util::getToggleControlHtml('videos', 'Videos', $toggle_videos);
                    echo Util::getToggleControlHtml('blog-post', 'Blog Articles', $toggle_blog_articles);
                    echo Util::getToggleControlHtml('extended-article', 'Extended Articles', $toggle_extended_articles);
                    ?>
                </div>
            </div>
            <div class="resource-library__results-container">
                <div class="resource-library__results-count-container"> 
                    <span class="resource-library__results-count"></span> <?php _e('Results', 'rosecrance'); ?>
                </div>
                <div class="resource-library__results uk-grid-small" uk-grid="masonry: next">
                    <?php
                        $data_card_identifier = 'data-card-container';
                        foreach($pinned_post_ids as $pinned_post_id) {
                            if (array_key_exists($pinned_post_id, $unsorted_pinned_posts)) {
                                $pinned_post = $unsorted_pinned_posts[$pinned_post_id];
                                $post_id = $pinned_post->ID . '-card_container';
                                printf(
                                    '<div class="card-container" id="%1$s" %2$s> %3$s </div>',
                                    $post_id,
                                    $data_card_identifier,
                                    util::getCard($pinned_post, 'tall')
                                );
                            }
                        }
                        foreach($priority_one_posts as $priority_one_post) {
                            $post_id = $priority_one_post->ID . '-card_container';
                            printf(
                                '<div class="card-container" id="%1$s" %2$s> %3$s </div>',
                                $post_id,
                                $data_card_identifier,
                                util::getCard($priority_one_post, 'tall')
                            );
                        }
                        foreach($priority_two_posts as $priority_two_post) {
                            $post_id = $priority_two_post->ID . '-card_container';
                            printf(
                                '<div class="card-container" id="%1$s" %2$s> %3$s </div>',
                                $post_id,
                                $data_card_identifier,
                                util::getCard($priority_two_post, 'tall')
                            );
                        }
                        foreach($priority_three_posts as $priority_three_post) {
                            $post_id = $priority_three_post->ID . '-card_container';
                            printf(
                                '<div class="card-container" id="%1$s" %2$s> %3$s </div>',
                                $post_id,
                                $data_card_identifier,
                                util::getCard($priority_three_post, 'tall')
                            );
                        }
                    ?>
                </div>
                <div class="resource-library__view-button-container">
                        <button class="btn btn-primary resource-library__view-button" id="view-more-less-button" data-show-text="<?php _e('View More', 'rosecrance') ?>" data-hide-text="<?php _e('View Less', 'rosecrance'); ?>">
                            <?php _e('View More', 'rosecrance') ?>
                        </button>
                </div>
            </div>
            <div class="resource-library__modules">
                <?php
                    // hook: App/Fields/Modules/outputFlexibleModules()
                    do_action('rosecrance/modules/output', $resources_post_id);

                ?>
            </div>   
        </div>
    </div>
</div>

<?php
get_footer();
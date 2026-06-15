<?php

/**
 * ACF Module: Carousel
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

function checkIfFilterMatch($filter, $related_items) {
    $filter_is_empty = empty(array_values($filter));
    if ($filter_is_empty) {
        return true;
    }

    return is_array($related_items) && !empty($related_items) && is_array($filter) && array_intersect(array_values($filter), array_values($related_items));
}

$carousel_title = ACF::getField('title', $data);
$options = Options::getSiteOptions();
$pinned_post_ids = (Array)ACF::getField('pinned-posts', $options, []);
$included_post_types = ACF::getField('included-post-types', $data);
$filters = ACF::getRowsLayout('filters', $data);

$audiences_filter = [];
$blog_posts_filter = [];
$conditions_filter = [];
$drug_fact_sheets_filter = [];
$extended_articles_filter = [];
$locations_filter = [];
$podcast_filter = [];
$programs_filter = [];
$service_lines_filter = [];
$services_filter = [];
$videos_filter = [];

$meta_query_args = array();

foreach ($filters as $filter) {
    $filter_by = ACF::getField('filter-by', $filter);
    
    if ($filter_by === 'audience') {
        $audiences_filter = ACF::getField('audience-post-list', $filter, []);
    } else if ($filter_by === 'blog-posts') {
        $blog_posts_filter = ACF::getField('blog-post-post-list', $filter, []);
    } else if ($filter_by === 'conditions') {
        $conditions_filter = ACF::getField('conditions-post-list', $filter, []);
    } else if ($filter_by === 'drug-fact-sheets') {
        $drug_fact_sheets_filter = ACF::getField('drug-fact-sheet-post-list', $filter, []);
    } else if ($filter_by === 'extended-article') {
        $extended_articles_filter = ACF::getField('extended-article-post-list', $filter, []);
    } else if ($filter_by === 'location') {
        $locations_filter = ACF::getField('locations-post-list', $filter, []);
    } else if ($filter_by === 'podcast') {
        $podcast_filter = ACF::getField('podcast-post-list', $filter, []);
    } else if ($filter_by === 'programs') {
        $programs_filter = ACF::getField('programs-post-list', $filter, []);
    } else if ($filter_by === 'services') {
        $services_filter = ACF::getField('services-post-list', $filter, []);
    } else if ($filter_by === 'service-line') {
        $service_lines_filter = ACF::getField('service-lines-post-list', $filter, []);
    } else if ($filter_by === 'videos') {
        $videos_filter = ACF::getField('videos-post-list', $filter, []);
    }
}

$get_posts_args = [
    'post_type' => $included_post_types,
    'post_status' => 'publish',
    'numberposts' => -1,
    'order' => 'RAND',
];

$posts = get_posts($get_posts_args);

$unsorted_pinned_posts = array();
$priority_one_posts = array();
$priority_two_posts = array();
$priority_three_posts = array();


foreach ($posts as $post) {
    $post_id = $post->ID;
    $title = $post->post_tite;

    $post_meta = ACF::getPostMeta($post_id);

    $priority = ACF::getField('card_priority', $post_meta);
    $related_audiences = ACF::getField('audiences_related-audiences', $post_meta);
    $related_blog_posts = ACF::getField('blog-posts_related-blog-posts', $post_meta);
    $related_conditions = ACF::getField('conditions_related-conditions', $post_meta);
    $related_drug_fact_sheets = ACF::getField('drug-fact-sheets_related-drug-fact-sheets', $post_meta);
    $related_extended_articles = ACF::getField('extended-articles_related-extended-articles', $post_meta);
    $related_locations = ACF::getField('locations_related-locations', $post_meta);
    $related_podcasts = ACF::getField('podcasts_related-podcasts', $post_meta);
    $related_programs = ACF::getField('programs_related-programs', $post_meta);
    $related_services = ACF::getField('services_related-services', $post_meta);
    $related_service_lines = ACF::getField('service-lines_related-service-lines', $post_meta);
    $related_videos = ACF::getField('videos_related-videos', $post_meta);


    if (
        checkIfFilterMatch($audiences_filter, $related_audiences) && 
        checkIfFilterMatch($blog_posts_filter, $related_blog_posts) &&
        checkIfFilterMatch($conditions_filter, $related_conditions) &&
        checkIfFilterMatch($drug_fact_sheets_filter, $related_drug_fact_sheets) &&
        checkIfFilterMatch($extended_articles_filter, $related_extended_articles) &&
        checkIfFilterMatch($locations_filter, $related_locations) &&
        checkIfFilterMatch($podcast_filter, $related_podcasts) &&
        checkIfFilterMatch($programs_filter, $related_programs) &&
        checkIfFilterMatch($services_filter, $related_services) &&
        checkIfFilterMatch($service_lines_filter, $related_service_lines) &&
        checkIfFilterMatch($videos_filter, $related_videos)) {

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
    }
}

do_action('rosecrance/modules/styles', $row_id, $data);

?>

<div class="module card-carousel" id="<?php echo esc_html($row_id); ?>">
    <div class="card-carousel__title-container">
        <h2><?php echo esc_html($carousel_title); ?></h2>
    </div>
    <div class="card-carousel__container">
        <div class="uk-position-relative uk-visible-toggle uk-light" uk-slider="finite: true">
            <ul class="uk-slider-items uk-grid card-carousel__slider uk-grid-small">
                <?php
                    foreach($pinned_post_ids as $pinned_post_id) {
                        if (array_key_exists($pinned_post_id, $unsorted_pinned_posts)) {
                            $pinned_post = $unsorted_pinned_posts[$pinned_post_id];
                            echo '<li class="card-carousel__item">' . util::getCard($pinned_post) . '</li>';
                        }
                    }

                    foreach($priority_one_posts as $priority_one_post) {
                        echo '<li class="card-carousel__item">' . util::getCard($priority_one_post) . '</li>';
                    }
                    foreach($priority_two_posts as $priority_two_post) {
                        echo '<li class="card-carousel__item">' . util::getCard($priority_two_post) . '</li>';
                    }
                    foreach($priority_three_posts as $priority_three_post) {
                        echo '<li class="card-carousel__item">' . util::getCard($priority_three_post) . '</li>';
                    }
                    
                ?>
            </ul>

            <div class="card-carousel__nav-container"> 
                <a href class="card-carousel__cycle-button card-carousel__cycle-button--previous" uk-slider-item="previous"><?php echo util::getIconHTML('arrow-right-dark'); ?></a>
                <a href class="card-carousel__cycle-button card-carousel__cycle-button--next" uk-slider-item="next"><?php echo util::getIconHTML('arrow-right-dark'); ?></a>
            </div>
        </div>
    </div>
</div>
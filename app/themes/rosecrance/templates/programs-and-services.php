<?php

/**
 * Template Name: Programs and Services
 *
 * This template outputs programs and services cards along with filters
 *
 * @package Rosecrance
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\Util;
$programs_services_post_id = get_the_ID();
get_header();

$toggle_programs = true;
$toggle_services = true;

if (isset($_GET['filter']) && !empty($_GET['filter'])) {
    $filter = $_GET['filter'];
    
    if ($filter === 'programs') {
        $toggle_programs = true;
        $toggle_services = false;
    } else if ($filter === 'services') {
        $toggle_programs = false;
        $toggle_services = true;
    }
}

$virtual_location_id = null;
$virtual_location = get_posts([
    'post_type' => 'locations',
    'post_status' => 'publish',
    'numberposts' => 1,
    'meta_query' => [
        [
            'key' => 'virtual-location',
            'value' => 'true',
            'compare' => '='
        ]
    ]
]);

count($virtual_location) > 0 ? $virtual_location_id = $virtual_location[0]->ID : null;

wp_localize_script(
    'rosecrance-theme',
    'virtual_location_id',
    $virtual_location_id
);

$regions = get_posts([
    'post_type' => 'regions',
    'post_status' => 'publish',
    'numberposts' => -1,
    'orderby' => 'date',
    'order' => 'ASC'
]);

$regions_associative_post_array = array();
$regions_related_locations = array();
$programs_services_location_map = array();

foreach ($regions as $region) {
    $regions_associative_post_array[$region->ID] = $region->post_title;
    $meta = ACF::getPostMeta($region->ID);
    $related_locations = ACF::getField('locations_related-locations', $meta);
    $regions_related_locations[$region->ID] = $related_locations;
}

wp_localize_script(
    'rosecrance-theme',
    'region_location_map',
    $regions_related_locations
);

?>

<div id="primary" class="programs-and-services">
    <div id="smooth-wrapper">
        <div id="smooth-content">
            <?php 
            $part = 'resource-library-banner';
            $page_title = __('Programs + Services', 'rosecrance');
            $parent_class="programs-and-services";

            $options = Options::getSiteOptions();
            $pinned_post_ids = (Array)ACF::getField('pinned-posts', $options, []);
            $conditions = ['' => '-'];
            foreach (Util::getPostsAsAssociativeArray('conditions') as $key => $value) {
                $conditions[$key] = $value;
            }
            $audiences = ['' => '-'];
            foreach (Util::getPostsAsAssociativeArray('audience') as $key => $value) {
                $audiences[$key] = $value;
            }
            asort($audiences);
            $regions = ['' => '-', 'virtual' => 'Virtual'];
            foreach ($regions_associative_post_array as $key => $value) {
                $regions[$key] = $value;
            }
            asort($regions);
            $posts = get_posts([
                'post_type' => array('services', 'programs'),
                'post_status' => 'publish',
                'numberposts' => -1,
                'order' => 'ASC'
            ]);

            
            $unsorted_pinned_posts = array();
            $priority_one_posts = array();
            $priority_two_posts = array();
            $priority_three_posts = array();

            foreach($posts as $post) {
                $post_id = $post->ID;
                $meta = ACF::getPostMeta($post_id);
                $priority = ACF::getField('card_priority', $meta);
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

            $file = locate_template("templates/partials/{$part}.php");
            if (file_exists($file)) {
                include $file;
            }
            ?>
            <div class="programs-and-services__controls">
                <div class="programs-and-services__dropdown-filters">
                    <?php
                    echo Util::getSelectFieldHtml('conditions', 'We offer hope for', $conditions, [], true);
                    echo Util::getSelectFieldHtml('audience', 'Audience', $audiences);
                    echo Util::getSelectFieldHtml('region', 'Region', $regions);
                    ?>
                </div>
                <div class="programs-and-services__toggle-filters">
                    <?php 
                    echo Util::getToggleControlHtml('programs', 'Programs', $toggle_programs);
                    echo Util::getToggleControlHtml('services', 'Services', $toggle_services);
                    ?>
                </div>
            </div>
            <div class="programs-and-services__results-container">
                <div class="programs-and-services__results-count-container"> 
                    <span class="programs-and-services__results-count"></span> <?php _e('Results', 'rosecrance'); ?>
                </div>
                <div class="programs-and-services__results">
                    <?php
                        foreach($pinned_post_ids as $pinned_post_id) {
                            if (array_key_exists($pinned_post_id, $unsorted_pinned_posts)) {
                                $pinned_post = $unsorted_pinned_posts[$pinned_post_id];
                                echo util::getCard($pinned_post);
                            }
                        }
                        foreach($priority_one_posts as $priority_one_post) {
                            echo util::getCard($priority_one_post);
                        }
                        foreach($priority_two_posts as $priority_two_post) {
                            echo util::getCard($priority_two_post);
                        }
                        foreach($priority_three_posts as $priority_three_post) {
                            echo util::getCard($priority_three_post);
                        }
                    ?>
                </div>
                <div class="programs-and-services__view-button-container">
                        <button class="btn btn-primary programs-and-services__view-button" id="view-more-less-button" data-show-text="<?php _e('View More', 'rosecrance') ?>" data-hide-text="<?php _e('View Less', 'rosecrance'); ?>">
                            <?php _e('View More', 'rosecrance') ?>
                        </button>
                </div>
            </div>
            <div class="programs-and-services__modules">
                <?php
                    // hook: App/Fields/Modules/outputFlexibleModules()
                    do_action('rosecrance/modules/output', $programs_services_post_id);

                ?>
            </div>      
        </div>
    </div>
</div>

<?php
get_footer();
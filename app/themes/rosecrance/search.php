<?php
/**
 * The search results template file.
 *
 *
 * @package Rosecrance
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Fields\Options;
use Rosecrance\App\Media;

get_header(); ?>


<div id="primary">
    <section class="search-page">
        <div class="search-page__container">
            
            <?php 
            $services_high = array();
            $services_medium = array();
            $services_low = array();

            $programs_high = array();
            $programs_medium = array();
            $programs_low = array();
            
            $resources = array();

            $results = array();
            $filters = array();

            $html = '';

            if (have_posts()) {
                global $wp_query;

                $found_count = $wp_query->found_posts;
                $team_page = get_page_by_path('team-approach');

                if ($team_page) {
                    $team_page_id = $team_page->ID;
                    $wp_post_ids = wp_list_pluck($wp_query->posts, 'ID');
                
                    // If the team page was appended and not part of the original results
                    if (in_array($team_page_id, $wp_post_ids) && $found_count === 0) {
                        $found_count = 1;
                    }
                }

                echo '<div class="search-page__top-banner">
                    <div class="uk-container uk-container-large">
                        <h1 class="search-page__headline hdg hdg--1">'. __('Search Results for', 'rosecrance') . '</h1>
                        <p class="search-page__search-term">' . get_search_query() . '</p>
                    </div>
                </div>
                
                <div class="search-page__results">
                    <div class="uk-container uk-container-large">';

                        while (have_posts()) {
                            global $post;
                            the_post();
                            
                            $post_type = get_post_type($post->ID);
                            $data = ACF::getPostMeta($post->ID);
                            $priority = ACF::getField('card_priority', $data);

                            if ($post_type !== 'page') {
                                array_push($filters, $post_type);
                            }
                            
                            if ($post_type === 'services') {
                                if ($priority === '1') {
                                    array_push($services_low, $post->ID);
                                } else if ($priority === '2') {
                                    array_push($services_medium, $post->ID);
                                } else if ($priority === '3'){
                                    array_push($services_high, $post->ID);
                                }
                            } else if ($post_type === 'programs') {
                                if ($priority === '1') {
                                    array_push($programs_low, $post->ID);
                                } else if ($priority === '2') {
                                    array_push($programs_medium, $post->ID);
                                } else if ($priority === '3') {
                                    array_push($programs_high, $post->ID);
                                }
                            } else {
                                array_push($resources, $post->ID);
                            }
                        }

                        $filters = array_unique($filters);
                        asort($filters);
                        $results = array_merge($programs_high, $services_high, $programs_medium, $services_medium, $programs_low, $services_low, $resources);

                        echo '<div class="search-form__container">
                            <div class="uk-grid uk-grid-small" uk-grid>
                                <div class="uk-width-5-6@m uk-width-1-1@s search-form-container">
                                    <form role="search" method="get" id="searchform" class="searchform" action="'. get_home_url() .'">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="'. __('Search', 'rosecrance') .'" value="'. get_search_query() .'" name="s" title="'. __('Search for:', 'rosecrance') .'" />
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="submit">
                                                        '. __('Search', 'rosecrance') .'
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="clear-search">
                                        <button class="uk-button uk-button-default clear-button" type="button">
                                            ' . Util::getIconHTML('close') . '
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="uk-width-1-6@m uk-width-1-1@s">
                                    <div class="uk-inline filter-container">
                                        <button class="uk-button uk-button-default filter-button" type="button">
                                            ' . __('Filter By', 'rosecrance') . '
                                            ' . Util::getIconHTML('filter') . '
                                        </button>

                                        <div uk-dropdown="mode: click; target: !.filter-container">
                                            <div class="uk-grid uk-grid-small uk-child-width-1-1@m uk-child-width-1-2@s " uk-grid>';
                                                foreach ($filters as $filter) {
                                                    $post_type_text = str_replace('-', ' ', $filter);
                                                    $post_type_text = str_replace('detail', '', $post_type_text);

                                                    echo '<div>
                                                        <label class="filter-search"><input type="checkbox" checked value="' . esc_html($filter) . '" name="filter" />' . esc_html($post_type_text) . '</label>
                                                    </div>';
                                                }
                                    echo '</div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                                

                        echo '<p class="posts-found">' . $found_count . ' ' . __(' results found', 'rosecrance') . '</p>';

                        echo '<ul>';
                            foreach ($results as $post_id) :
                                $html .= apply_filters('rosecrance/search-page/search-result', $post_id);
                            endforeach; 

                            echo $html;
                        
                        echo '</ul>
                            <button class="uk-button uk-button-default show-more-button btn btn-primary" type="button">
                                ' . __('View More', 'rosecrance') . '
                            </button>
                        </div>
                    </div>';
            } else {
                // Loads the content/singular/page.php template.
                get_template_part('content/content', 'none'); 
            } ?>

        </div>
    </section>
</div>

<?php get_footer();
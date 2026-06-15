<?php

namespace Rosecrance\App\Posts\Types;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Posts\PostTypes;
use Rosecrance\App\Posts\Taxonomies;

/**
 * Class StaffBios
 *
 * @package Rosecrance\App\Posts\Types
 */
class StaffBios implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('init', [$this, 'registerPost']);
        add_action('pre_get_posts', [$this,'exclude_staff_bios_from_search']);
        add_filter('the_posts', [$this,'redirect_staff_bio_search_to_team_page'], 10, 2);
    }

    /**
     * Register Post Type.
     */
    public function registerPost()
    {
        PostTypes::registerPostType(
            'staff-bios',
            __('Staff Bio', 'rosecrance'),
            __('Staff Bios', 'rosecrance'),
            [
                'menu_icon' => 'dashicons-text-page',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false
            ]
        );

        Taxonomies::registerTaxonomy(
            'staff-type',
            __('Staff Type', 'rosecrance'),
            __('Staff Types', 'rosecrance'),
            ['staff-bios']
        );
    }

    function exclude_staff_bios_from_search($query) {
        if (!is_admin() && $query->is_main_query() && $query->is_search()) {
            // Get all public post types
            $post_types = get_post_types(['public' => true], 'names');
    
            // Remove staff-bios from the list
            unset($post_types['staff-bios']);
    
            $query->set('post_type', array_values($post_types));
        }
    }

    function redirect_staff_bio_search_to_team_page($posts, $query) {
        if (!is_admin() && $query->is_main_query() && $query->is_search()) {
            $search_term = $query->get('s');
    
            // Optional: avoid running match check on empty or too-short queries
            if (empty($search_term) || strlen($search_term) < 3) {
                return $posts;
            }
    
            // Search for matching 'staff-bios'
            $staff_bios_query = new \WP_Query([
                'post_type' => 'staff-bios',
                's' => $search_term,
                'posts_per_page' => 1,
                'fields' => 'ids',
                'suppress_filters' => true, // Ignore external filters that might interfere
            ]);
    
            if (!empty($staff_bios_query->posts)) {
                $team_page = get_page_by_path('team-approach');
    
                if ($team_page && !in_array($team_page->ID, wp_list_pluck($posts, 'ID'))) {
                    $posts[] = get_post($team_page->ID);
                }
            }
        }
    
        return $posts;
    }
}

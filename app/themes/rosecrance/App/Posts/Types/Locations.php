<?php

namespace Rosecrance\App\Posts\Types;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Posts\PostTypes;
use Rosecrance\App\Posts\Taxonomies;

/**
 * Class Locations
 *
 * @package Rosecrance\App\Posts\Types
 */
class Locations implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('init', [$this, 'registerPost']);
    }

    /**
     * Register Post Type.
     */
    public function registerPost()
    {
        PostTypes::registerPostType(
            'locations',
            __('Location', 'rosecrance'),
            __('Locations', 'rosecrance'),
            [
                'menu_icon' => 'dashicons-location',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false
            ]
        );

        Taxonomies::registerTaxonomy(
            'location-type',
            __('Location Type', 'rosecrance'),
            __('Location Types', 'rosecrance'),
            ['locations']
        );
    }

    
}

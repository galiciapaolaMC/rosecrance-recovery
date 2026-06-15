<?php

namespace Rosecrance\App\Posts\Types;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Posts\PostTypes;
use Rosecrance\App\Posts\Taxonomies;

/**
 * Class ServiceLines
 *
 * @package Rosecrance\App\Posts\Types
 */
class ServiceLines implements WordPressHooks
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
            'service-lines',
            __('Service Line', 'rosecrance'),
            __('Service Lines', 'rosecrance'),
            [
                'menu_icon' => 'dashicons-text-page',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false
            ]
        );
    }

    
}

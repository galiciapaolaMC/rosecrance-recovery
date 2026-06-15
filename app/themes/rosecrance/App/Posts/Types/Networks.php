<?php

namespace Rosecrance\App\Posts\Types;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Posts\PostTypes;
use Rosecrance\App\Posts\Taxonomies;

/**
 * Class Networks
 *
 * @package Rosecrance\App\Posts\Types
 */
class Networks implements WordPressHooks
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
            'networks',
            __('Network', 'rosecrance'),
            __('Networks', 'rosecrance'),
            [
                'menu_icon' => 'dashicons-admin-site-alt3',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false
            ]
        );
    }

    
}

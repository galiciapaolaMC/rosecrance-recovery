<?php

namespace Rosecrance\App\Posts\Types;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Posts\PostTypes;
use Rosecrance\App\Posts\Taxonomies;

/**
 * Class Audience
 *
 * @package Rosecrance\App\Posts\Types
 */
class Audience implements WordPressHooks
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
            'audience',
            __('Audience', 'rosecrance'),
            __('Audiences', 'rosecrance'),
            [
                'menu_icon' => 'dashicons-groups',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false
            ]
        );
    }

    
}

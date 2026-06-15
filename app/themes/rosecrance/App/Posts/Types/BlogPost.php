<?php

namespace Rosecrance\App\Posts\Types;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Posts\PostTypes;
use Rosecrance\App\Posts\Taxonomies;

/**
 * Class BlogPost
 *
 * @package Rosecrance\App\Posts\Types
 */
class BlogPost implements WordPressHooks
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
            'blog-post',
            __('Blog Post', 'rosecrance'),
            __('Blog Posts', 'rosecrance'),
            [
                'menu_icon' => 'dashicons-media-text',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false,
                'rewrite' => array('slug' => 'blog')
            ]
        );
    }

    
}

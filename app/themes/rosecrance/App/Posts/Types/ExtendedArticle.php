<?php

namespace Rosecrance\App\Posts\Types;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Posts\PostTypes;
use Rosecrance\App\Posts\Taxonomies;

/**
 * Class ExtendedArticle
 *
 * @package Rosecrance\App\Posts\Types
 */
class ExtendedArticle implements WordPressHooks
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
            'extended-article',
            __('Extended Article', 'rosecrance'),
            __('Extended Articles', 'rosecrance'),
            [
                'menu_icon' => 'dashicons-media-document',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false,
                'rewrite' => array('slug' => 'articles')
            ]
        );
    }

    
}

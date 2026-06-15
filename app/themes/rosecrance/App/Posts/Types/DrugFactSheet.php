<?php

namespace Rosecrance\App\Posts\Types;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Posts\PostTypes;
use Rosecrance\App\Posts\Taxonomies;

/**
 * Class DrugFactSheet
 *
 * @package Rosecrance\App\Posts\Types
 */
class DrugFactSheet implements WordPressHooks
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
            'drug-fact-sheet',
            __('Drug Fact Sheet', 'rosecrance'),
            __('Drug Fact Sheets', 'rosecrance'),
            [
                'menu_icon' => 'dashicons-media-document',
                'supports' => ['title', 'thumbnail'],
                'menu_position' => 29,
                'has_archive' => false
            ]
        );
    }

    
}

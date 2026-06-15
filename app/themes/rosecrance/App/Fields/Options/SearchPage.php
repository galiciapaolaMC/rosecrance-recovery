<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class SearchPage
 *
 * @package Rosecrance\App\Fields\Options
 */
class SearchPage
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/options/serch-page',
            [
                Tab::make(__('Search Page', 'rosecrance'), 'serch-page')
                    ->placement('left'),
                WysiwygEditor::make(__('Search Text', 'rosecrance'), 'search-text')
                    ->mediaUpload(false),
                Link::make(__('Search Link', 'rosecrance'), 'search-link')
                    ->returnFormat('array')
            ]
        );
    }
}

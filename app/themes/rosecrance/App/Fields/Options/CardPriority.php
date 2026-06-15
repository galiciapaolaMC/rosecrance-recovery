<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class CardPriority
 *
 * @package Rosecrance\App\Fields\Options
 */
class CardPriority
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/card-priority',
            [
                Tab::make(__('Card Priority', 'rosecrance'), 'card-priority')
                    ->placement('left'),
                Relationship::make(__('Pinned Posts', 'rosecrance'), 'pinned-posts')
                  ->postTypes(['services', 'programs', 'videos', 'blog-post', 'extended-article', 'podcast', 'drug-fact-sheet'])
                  ->filters([
                    'search',
                    'post_type'
                  ])
                  ->returnFormat('id')
                  ->max(5)
                  ->instructions(__('Pin up to five Programs or Services. These pinned items will have their priority set higher than everything else.'))
            ]
        );
    }
}

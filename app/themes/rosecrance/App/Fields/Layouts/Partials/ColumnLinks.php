<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class ColumnLinks
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ColumnLinks extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/column-links',
            Layout::make(__('Column Links', 'rosecrance'), 'column-links')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Headline Type', 'rosecrance'), 'headline-type')
                        ->choices([
                            'h2'  => __('H2', 'rosecrance'),
                            'h3'  => __('H3', 'rosecrance')
                        ])
                        ->defaultValue('h2'),
                    Text::make(__('Headline', 'rosecrance'), 'headline'),
                    Repeater::make(__('Items', 'rosecrance'), 'items')
                        ->layout('block')
                        ->min(1)
                        ->max(2)
                        ->buttonLabel(__('Add Item'))
                        ->fields([
                            ButtonGroup::make(__('Subheadline Type', 'rosecrance'), 'Subheadline-type')
                                ->choices([
                                    'h3'  => __('H3', 'rosecrance'),
                                    'h4'  => __('H4', 'rosecrance')
                                ])
                                ->defaultValue('h3'),
                            Text::make(__('Subheadline', 'rosecrance'), 'subheadline'),
                            Repeater::make(__('Links', 'rosecrance'), 'links')
                                ->layout('block')
                                ->min(1)
                                ->max(6)
                                ->buttonLabel(__('Add Item'))
                                ->fields([
                                    Link::make(__('Link', 'rosecrance'), 'link')
                                ]),
                        ])
                ])
        );
    }
}

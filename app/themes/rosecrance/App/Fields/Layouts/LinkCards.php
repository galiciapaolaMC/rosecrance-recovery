<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;

use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class LinkCards
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class LinkCards extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/link-cards',
            Layout::make(__('Link Cards'), 'link-cards')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Headline Type', 'rosecrance'), 'headline-type')
                        ->choices([
                            'h2'  => __('H2', 'rosecrance'),
                            'h3'  => __('H3', 'rosecrance'),
                            'p'  => __('Paragraph', 'rosecrance')
                        ])
                        ->defaultValue('h2'),
                    Text::make(__('Headline', 'rosecrance'), 'headline'),
                    ButtonGroup::make(__('Column Type', 'rosecrance'), 'column-type')
                        ->choices([
                            '2-col'  => __('2 Columns', 'rosecrance'),
                            '3-col'  => __('3 Columns', 'rosecrance'),
                            '4-col'  => __('4 Columns', 'rosecrance')
                        ])
                        ->defaultValue('3-col'),
                    Repeater::make(__('Items'))
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Item'))
                        ->fields([
                            ButtonGroup::make(__('Link Color', 'rosecrance'), 'link-color')
                                ->choices([
                                    'primary-blue'  => __('Blue', 'rosecrance'),
                                    'primary-orange'  => __('Orange', 'rosecrance')
                                ])
                                ->defaultValue('primary-orange'),
                            Text::make(__('Headline', 'rosecrance'), 'headline'),
                            Link::make(__('Button', 'rosecrance'), 'button')
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CONTENT_AREA_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

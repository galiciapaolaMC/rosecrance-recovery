<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;

/**
 * Class HeadlineOrange
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class HeadlineOrange extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/headline-orange',
            Layout::make(__('Headline Orange', 'rosecrance'), 'headline-orange')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Headline Type', 'rosecrance'), 'headline-type')
                        ->choices([
                            'h2'  => __('H2', 'rosecrance'),
                            'h3'  => __('H3', 'rosecrance')
                        ])
                        ->defaultValue('h2'),
                        Text::make(__('Headline', 'rosecrance'), 'headline')
                ])
        );
    }
}

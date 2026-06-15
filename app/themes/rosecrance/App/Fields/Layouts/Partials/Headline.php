<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Textarea;

/**
 * Class Headline
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Headline extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/headline',
            Layout::make(__('Headline', 'rosecrance'), 'headline')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Headline Type', 'rosecrance'), 'headline-type')
                        ->choices([
                            'h2'  => __('H2', 'rosecrance'),
                            'h3'  => __('H3', 'rosecrance')
                        ])
                        ->defaultValue('h2'),
                    Textarea::make(__('Headline', 'rosecrance'), 'headline')
                        ->rows(3)
                ])
        );
    }
}

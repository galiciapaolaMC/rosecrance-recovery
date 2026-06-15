<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;

/**
 * Class Buttons
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Buttons extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/buttons',
            Layout::make(__('Buttons', 'rosecrance'), 'buttons')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Items', 'rosecrance'), 'items')
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Item', 'rosecrance'), 'add-item')
                        ->fields([
                            Link::make(__('Button', 'rosecrance'), 'button')
                                ->returnFormat('array')
                                ->wrapper([
                                    'width' => '50'
                                ]),
                            Select::make(__('Button Type', 'rosecrance'), 'button-type')
                                ->choices([
                                    'primary' => __('Primary', 'rosecrance'),
                                    'secondary' => __('Secondary', 'rosecrance'),
                                    'white' => __('White', 'rosecrance')
                                ])
                                ->defaultValue('primary')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '50'
                                ])
                        ])
                ])
        );
    }
}

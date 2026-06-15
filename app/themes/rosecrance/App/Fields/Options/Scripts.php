<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Textarea;

/**
 * Class Scripts
 *
 * @package Rosecrance\App\Fields\Options
 */
class Scripts
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/options/scripts',
            [
                Tab::make(__('Scripts', 'rosecrance'), 'scripts')
                    ->placement('left'),
                Textarea::make(__('Head Scripts', 'crop-nutrition'), 'head-scripts')
                    ->rows(10),
                Textarea::make(__('Body Scripts', 'crop-nutrition'), 'body-scripts')
                    ->rows(10),
                Textarea::make(__('Footer Scripts', 'crop-nutrition'), 'footer-scripts')
                    ->rows(10),
            ]
        );
    }
}

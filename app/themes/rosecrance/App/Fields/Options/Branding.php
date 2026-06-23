<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image;

/**
 * Class Branding
 *
 * @package Rosecrance\App\Fields\Options
 */
class Branding
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/options/branding',
            [
                Tab::make(__('Branding', 'rosecrance'), 'branding')
                    ->placement('left'),
                Image::make(__('Site Logo', 'rosecrance'), 'site-logo')
                    ->returnFormat('array')
                    ->previewSize('thumbnail'),
                ButtonGroup::make(__('Header Activation', 'rosecrance'), 'header-activation')
                    ->choices([
                        'on' => __('On', 'rosecrance'),
                        'off'  => __('Off', 'rosecrance')
                    ])
                    ->defaultValue('on'),
            ]
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Text;

/**
 * Class Footer
 *
 * @package Rosecrfance\App\Fields\Options
 */
class Footer
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/options/footer',
            [
                Tab::make(__('Footer', 'rosecrance'))
                    ->placement('left'),
                Image::make(__('Footer Logo', 'rosecrance'), 'footer-logo')
                    ->returnFormat('array')
                    ->previewSize('thumbnail'),
                Image::make(__('Center Logo', 'rosecrance'), 'center-logo')
                  ->returnFormat('array')
                  ->previewSize('thumbnail'),
                Text::make(__('Address', 'rosecrance'), 'address')
            ]
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class FloatingMobileButton
 *
 * @package Rosecrance\App\Fields\Options
 */
class FloatingMobileButton
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/floating-mobile-button',
            [
                Tab::make(__('Floating Mobile Button', 'rosecrance'), 'floating-mobile-button')
                    ->placement('left'),
                Text::make(__('Floating Mobile Button Button Text', 'rosecrance'), 'floating-mobile-button-text'),
                Text::make(__('Floating Mobile Button Phone Number', 'rosecrance'), 'floating-mobile-button-phone-number')
                      ->instructions(__('Preferred format: xxxxxxxxxx. Desktop phone number configuration is done in the mega-menu settings.', 'rosecrance')),
            ]
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class MapKeys
 *
 * @package Rosecrance\App\Fields\Options
 */
class MapKeys
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/options/map-keys',
            [
                Tab::make(__('Map Keys', 'rosecrance'), 'map-keys')
                    ->placement('left'),
                Text::make(__('Google API Key', 'rosecrance'), 'google-api-key'),
                Text::make(__('Google Map ID', 'rosecrance'), 'google-map-id'),
                Text::make(__('Zip Code API Key', 'rosecrance'), 'zipcode-api-key')
            ]
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class TreatmentLocator
 *
 * @package Rosecrance\App\Fields\Options
 */
class TreatmentLocator
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/treatment-locator',
            [
                Tab::make(__('Treatment Locator', 'rosecrance'), 'treatment-locator')
                    ->placement('left'),
                Link::make(__('Location Link', 'rosecrance'), 'location-link'),
                ButtonGroup::make(__('Headline Type', 'rosecrance'), 'headline-type')
                    ->choices([
                        'p' => __('Paragraph', 'rosecrance'),
                        'h1'  => __('H1', 'rosecrance'),
                        'h2'  => __('H2', 'rosecrance'),
                        'h3'  => __('H3', 'rosecrance'),
                    ])
                    ->defaultValue('h2'),
                Text::make(__('Headline', 'rosecrance'), 'headline'),
                Text::make(__('Zip Code Field Text', 'rosecrance'), 'zip-code-field-text')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Text::make(__('Insurance Field Text', 'rosecrance'), 'insurance-field-text')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Text::make(__('Button Text', 'rosecrance'), 'button-text'),
                Text::make(__('Additional Information', 'rosecrance'), 'additional-information'),
                WysiwygEditor::make(__('Modal Content', 'rosecrance'), 'modal-content')
                    ->mediaUpload(false)
            ]
        );
    }
}

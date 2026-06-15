<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ConditionSymptoms
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ConditionSymptoms extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/condition-symptoms',
            Layout::make(__('Condition Symptoms', 'rosecrance'), 'condition-symptoms')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Eyebrow Type', 'rosecrance'), 'eyebrow-type')
                        ->choices([
                            'h1'  => __('H1', 'rosecrance'),
                            'h2'  => __('H2', 'rosecrance'),
                            'h3'  => __('H3', 'rosecrance')
                        ])
                        ->defaultValue('h3'),
                    Text::make(__('Eyebrow', 'rosecrance'), 'eyebrow'),
                    ButtonGroup::make(__('Headline Type', 'rosecrance'), 'headline-type')
                        ->choices([
                            'h1'  => __('H1', 'rosecrance'),
                            'h2'  => __('H2', 'rosecrance'),
                            'h3'  => __('H3', 'rosecrance')
                        ])
                        ->defaultValue('h2'),
                    Text::make(__('Headline', 'rosecrance'), 'headline'),
                    WysiwygEditor::make(__('Content', 'rosecrance'), 'content')
                        ->mediaUpload(false),
                    Select::make(__('Block Fill Color', 'rosecrance'), 'block-fill-color')
                        ->choices([
                            '#FAA834' => __('Primary Orange', 'rosecrance'),
                            '#007EAB' => __('Primary Blue', 'rosecrance'),
                            '#695E4A' => __('Primary Grey', 'rosecrance'),
                            '#FFFFFF' => __('White', 'rosecrance'),
                            '#484848' => __('Dark Grey', 'rosecrance'),
                            '#0054A0' => __('Dark Blue', 'rosecrance'),
                            '#60AFDD' => __('Light Blue', 'rosecrance'),
                            '#AD005B' => __('Purple', 'rosecrance')
                        ])
                        ->defaultValue('#FAA834')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Select::make(__('Text Block Color', 'rosecrance'), 'text-block-color')
                        ->choices([
                            'primary-grey' => __('Primary Grey', 'rosecrance'),
                            'white' => __('White', 'rosecrance')
                        ])
                        ->defaultValue('primary-grey')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Text::make(__('Color Block Heading', 'rosecrance'), 'color-block-heading'),
                    WysiwygEditor::make(__('Color Block Content', 'rosecrance'), 'color-block-content'),
                    WysiwygEditor::make(__('Additional Content', 'rosecrance'), 'additional-content')
                        ->mediaUpload(false),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CONTENT_AREA_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

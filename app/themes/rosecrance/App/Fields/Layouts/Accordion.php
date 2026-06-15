<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\WysiwygEditor;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class Accordion
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Accordion extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/accordion',
            Layout::make(__('Accordion', 'rosecrance'), 'accordion')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Headline Type', 'rosecrance'), 'headline-type')
                        ->choices([
                            'h2'  => __('H2', 'rosecrance'),
                            'h3'  => __('H3', 'rosecrance'),
                        ])
                        ->defaultValue('h2'),
                    Text::make(__('Headline', 'rosecrance'), 'headline'),
                    Textarea::make(__('Additional Text', 'rosecrance'), 'additional-text')
                        ->rows(2),
                    Repeater::make(__('Accordion Items', 'rosecrance'), 'accordion-items')
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Item'))
                        ->fields([
                            Text::make(__('Title', 'rosecrance'), 'title')
                                ->wrapper([
                                    'width' => '100'
                                ]),
                            WysiwygEditor::make(__('Content', 'rosecrance'), 'content')
                                ->mediaUpload(false)
                        ]),
                    $this->styleTab(),
                    Group::make(__('Headings', 'rosecrance'), 'headings')
                        ->layout('block')
                        ->fields([
                            ButtonGroup::make(__('Color', 'rosecrance'), 'color')
                                ->choices([
                                    'grey' => __('Dark Grey', 'rosecrance'),
                                    'blue' => __('Blue', 'rosecrance')
                                ])
                                ->defaultValue('grey')
                            ]),
                    Common::paddingGroup(DEFAULT_ACCORDION_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

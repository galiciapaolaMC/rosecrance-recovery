<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ContentArea
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ContentArea extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/content-area',
            Layout::make(__('Content Area', 'rosecrance'), 'content-area')
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
                    Repeater::make(__('Links', 'rosecrance'), 'links')
                        ->layout('block')
                        ->buttonLabel(__('Add Item'))
                        ->fields([
                            Link::make(__('Button', 'rosecrance'), 'button')
                                ->returnFormat('array')
                                ->wrapper([
                                    'width' => '50'
                                ]),
                            Select::make(__('Button Type', 'rosecrance'), 'button-type')
                                ->choices([
                                    'primary' => __('Primary', 'rosecrance'),
                                    'secondary' => __('Secondary', 'rosecrance')
                                ])
                                ->defaultValue('primary')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '50'
                                ])
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CONTENT_AREA_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

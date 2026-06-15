<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ConditionPicker
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ConditionPicker extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/condition-picker',
            Layout::make(__('Condition Picker', 'rosecrance'), 'condition-picker')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Headline Type', 'rosecrance'), 'headline-type')
                        ->choices([
                            'h1'  => __('H1', 'rosecrance'),
                            'h2'  => __('H2', 'rosecrance'),
                            'h3'  => __('H3', 'rosecrance')
                        ])
                        ->defaultValue('h1'),
                    Text::make(__('Headline', 'rosecrance'), 'headline'),
                    WysiwygEditor::make(__('Content', 'rosecrance'), 'content')
                        ->mediaUpload(false),
                    Text::make(__('Selector Text', 'rosecrance'), 'selector-text'),
                    Text::make(__('Button Text', 'rosecrance'), 'button-text'),
                    $this->optionsTab(),
                    Group::make(__('Background Desktop', 'rosecrance'), 'background-desktop')
                        ->layout('block')
                        ->fields([
                            Image::make(__('Image', 'rosecrance'), 'image')
                                ->previewSize('thumbnail'),
                            Select::make(__('Repeat', 'rosecrance'), 'repeat')
                                ->choices([
                                    'no-repeat' => __('No Repeat', 'rosecrance'),
                                    'repeat'    => __('Repeat', 'rosecrance'),
                                    'repeat-x'  => __('Repeat (X)', 'rosecrance'),
                                    'repeat-y'  => __('Repeat (Y)', 'rosecrance'),
                                ])
                                ->defaultValue('no-repeat')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '33.33'
                                ]),
                            Select::make(__('Position', 'rosecrance'), 'position')
                                ->choices([
                                    'left top'      => __('Left / Top', 'rosecrance'),
                                    'left center'   => __('Left / Center', 'rosecrance'),
                                    'left bottom'   => __('Left / Bottom', 'rosecrance'),
                                    'right top'     => __('Right / Top', 'rosecrance'),
                                    'right center'  => __('Right / Center', 'rosecrance'),
                                    'right bottom'  => __('Right / Bottom', 'rosecrance'),
                                    'center top'    => __('Center / Top', 'rosecrance'),
                                    'center center' => __('Center / Center', 'rosecrance'),
                                    'center bottom' => __('Center / Bottom', 'rosecrance'),
                                ])
                                ->defaultValue('center center')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '33.33'
                                ]),
                            Select::make(__('Size', 'rosecrance'), 'size')
                                ->choices([
                                    'cover'     => __('Cover', 'rosecrance'),
                                    'contain'   => __('Contain', 'rosecrance')
                                ])
                                ->defaultValue('cover')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '33.33'
                                ]),
                            ]),
                    Group::make(__('Background Mobile', 'rosecrance'), 'background-mobile')
                        ->layout('block')
                        ->fields([
                            Image::make(__('Image', 'rosecrance'), 'image')
                                ->previewSize('thumbnail'),
                            Select::make(__('Repeat', 'rosecrance'), 'repeat')
                                ->choices([
                                    'no-repeat' => __('No Repeat', 'rosecrance'),
                                    'repeat'    => __('Repeat', 'rosecrance'),
                                    'repeat-x'  => __('Repeat (X)', 'rosecrance'),
                                    'repeat-y'  => __('Repeat (Y)', 'rosecrance'),
                                ])
                                ->defaultValue('no-repeat')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '33.33'
                                ]),
                            Select::make(__('Position', 'rosecrance'), 'position')
                                ->choices([
                                    'left top'      => __('Left / Top', 'rosecrance'),
                                    'left center'   => __('Left / Center', 'rosecrance'),
                                    'left bottom'   => __('Left / Bottom', 'rosecrance'),
                                    'right top'     => __('Right / Top', 'rosecrance'),
                                    'right center'  => __('Right / Center', 'rosecrance'),
                                    'right bottom'  => __('Right / Bottom', 'rosecrance'),
                                    'center top'    => __('Center / Top', 'rosecrance'),
                                    'center center' => __('Center / Center', 'rosecrance'),
                                    'center bottom' => __('Center / Bottom', 'rosecrance'),
                                ])
                                ->defaultValue('center center')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '33.33'
                                ]),
                            Select::make(__('Size', 'rosecrance'), 'size')
                                ->choices([
                                    'cover'     => __('Cover', 'rosecrance'),
                                    'contain'   => __('Contain', 'rosecrance')
                                ])
                                ->defaultValue('cover')
                                ->returnFormat('value')
                                ->wrapper([
                                    'width' => '33.33'
                                ]),
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_CONDITION_PICKER_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

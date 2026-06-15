<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ColumnContent
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ColumnContent extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/column-content',
            Layout::make(__('Column Content', 'rosecrance'), 'column-content')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Main Headline Type', 'rosecrance'), 'main-headline-type')
                        ->choices([
                            'h2'  => __('H2', 'rosecrance'),
                            'h3'  => __('H3', 'rosecrance')
                        ])
                        ->defaultValue('h2'),
                    Text::make(__('Main Headline', 'rosecrance'), 'main-headline'),
                    ButtonGroup::make(__('Column Alignment', 'rosecrance'), 'column-alignment')
                        ->choices([
                            'blocks' => __('Blocks', 'rosecrance'),
                            'masonry' => __('Masonry', 'rosecrance')
                        ])
                        ->defaultValue('blocks'),
                    Repeater::make(__('Column Items', 'rosecrance'), 'column-items')
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Item', 'rosecrance'), 'add-item')
                        ->fields([
                            Text::make(__('Headline', 'rosecrance'), 'headline'),
                            ButtonGroup::make(__('Column Type', 'rosecrance'), 'column-type')
                                ->choices([
                                    'content' => __('Content', 'rosecrance'),
                                    'link-list' => __('Link List', 'rosecrance')
                                ])
                                ->defaultValue('content'),
                            WysiwygEditor::make(__('Content Block', 'rosecrance'), 'content-block')
                                ->mediaUpload(false)
                                ->conditionalLogic([
                                    ConditionalLogic::where('column-type', '==', 'content')
                                ]),
                            Image::make(__('Desktop Image', 'rosecrance'), 'desktop-image')
                                ->returnFormat('array')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('column-type', '==', 'content')
                                ]),
                            Image::make(__('Mobile Image', 'rosecrance'), 'mobile-image')
                                ->returnFormat('array')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('column-type', '==', 'content')
                                ]),
                            Repeater::make(__('Buttons', 'rosecrance'), 'buttons')
                                ->layout('block')
                                ->buttonLabel(__('Add Button', 'rosecrance'), 'add-button')
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
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('column-type', '==', 'content')
                                ]),
                            Repeater::make(__('Links', 'rosecrance'), 'links')
                                ->layout('block')
                                ->buttonLabel(__('Add Link', 'rosecrance'), 'add-link')
                                ->fields([
                                    Link::make(__('Link', 'rosecrance'), 'link')
                                        ->returnFormat('array')
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('column-type', '==', 'link-list')
                                ]),
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_COLUMN_CONTENT_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

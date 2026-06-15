<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Rosecrance\App\Fields\Layouts\Partials\Buttons;
use Rosecrance\App\Fields\Layouts\Partials\Content;
use Rosecrance\App\Fields\Layouts\Partials\DonateBox;
use Rosecrance\App\Fields\Layouts\Partials\Headline;
use Rosecrance\App\Fields\Layouts\Partials\ImageFiftyFifty;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\ColorPicker;
use Extended\ACF\Fields\FlexibleContent;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;

/**
 * Class FiftyFiftyStatistics
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class FiftyFiftyStatistics extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/fifty-fifty-statistics',
            Layout::make(__('Fifty Fifty Statistics', 'rosecrance'), 'fifty-fifty-statistics')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Statistic Type', 'rosecrance'), 'statistic-type')
                        ->choices([
                            'percentage'  => __('Percentage', 'rosecrance'),
                            'number' => __('Number', 'rosecrance'),
                            'headline' => __('Headline', 'rosecrance')
                        ])
                        ->defaultValue('percentage')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    ButtonGroup::make(__('Top Content Alignment', 'rosecrance'), 'top-content-alignment')
                        ->choices([
                            'left'  => __('Left', 'rosecrance'),
                            'right' => __('Right', 'rosecrance')
                        ])
                        ->defaultValue('left')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Text::make(__('Eyebrow', 'rosecrance'), 'eyebrow'),
                    Text::make(__('Statistic Value', 'rosecrance'), 'statistic-value')
                        ->conditionalLogic([
                            ConditionalLogic::where('statistic-type', '!=', 'headline')
                        ]),
                    Textarea::make(__('Content', 'rosecrance'), 'content')
                        ->rows(2)
                        ->conditionalLogic([
                            ConditionalLogic::where('statistic-type', '!=', 'headline')
                        ]),
                    Textarea::make(__('Headline Text', 'rosecrance'), 'headline-text')
                        ->rows(2)
                        ->conditionalLogic([
                            ConditionalLogic::where('statistic-type', '==', 'headline')
                        ]),
                    Repeater::make(__('Columns', 'rosecrance'), 'columns')
                        ->min(1)
                        ->max(4)
                        ->fields([
                            FlexibleContent::make(__('Modules', 'rosecrance'), 'modules')
                                ->buttonLabel(__('Add Element', 'rosecrance'), 'rosecrance')
                                ->layouts([
                                    (new Buttons())->fields(),
                                    (new Content())->fields(),
                                    (new DonateBox())->fields(),
                                    (new Headline())->fields(),
                                    (new ImageFiftyFifty())->fields()
                                ])
                        ])
                        ->buttonLabel(__('Add Column', 'rosecrance'), 'add-column'),
                    $this->optionsTab(),
                    ButtonGroup::make(__('Background Color', 'rosecrance'), 'background-color')
                        ->choices([
                            'white'  => __('White', 'rosecrance'),
                            'cream'  => __('Cream', 'rosecrance'),
                            'primary-orange' => __('Primary Orange', 'rosecrance'),
                            'primary-blue' => __('Primary Blue', 'rosecrance')
                        ])
                        ->instructions(__('Default color is white', 'rosecrance'))
                        ->wrapper([
                            'width' => '50'
                        ]),
                    ButtonGroup::make(__('Background Animation', 'rosecrance'), 'background-animation')
                        ->choices([
                            'active'  => __('Active', 'rosecrance'),
                            'inactive' => __('Inactive', 'rosecrance'),
                        ])
                        ->defaultValue('inactive')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    ButtonGroup::make(__('Gap Size', 'rosecrance'))
                        ->choices([
                            'collapse'  => __('None', 'rosecrance'),
                            'small' => __('Small', 'rosecrance'),
                            'medium' => __('Medium', 'rosecrance'),
                            'large' => __('Large', 'rosecrance'),
                            'xlarge' => __('XLarge', 'rosecrance')
                        ])
                        ->instructions(__('Default value is none', 'rosecrance'))
                        ->defaultValue('none')
                        ->wrapper([
                            'width' => '100'
                        ]),
                    TrueFalse::make(__('Reverse Mobile', 'rosecrance'))
                        ->defaultValue(0)
                        ->instructions(__('This will only work if there are exactly 2 columns.', 'rosecrance'))
                        ->wrapper([
                            'width' => '50'
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_FIFTY_FIFTY_STATISTICS_PADDING),
                    $this->anchorTab(),
                    Common::anchorData()
                ])
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Rosecrance\App\Fields\Layouts\Partials\Buttons;
use Rosecrance\App\Fields\Layouts\Partials\ColumnLinks;
use Rosecrance\App\Fields\Layouts\Partials\Content;
use Rosecrance\App\Fields\Layouts\Partials\Headline;
use Rosecrance\App\Fields\Layouts\Partials\HeadlineOrange;
use Rosecrance\App\Fields\Layouts\Partials\ImageFiftyFifty;
use Rosecrance\App\Fields\Layouts\Partials\ImageSlider;
use Rosecrance\App\Fields\Layouts\Partials\Subhead;
use Rosecrance\App\Fields\Layouts\SalesforceForm;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\ColorPicker;
use Extended\ACF\Fields\FlexibleContent;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
use Rosecrance\App\Fields\Layouts\Partials\WysiwygFiftyFifty;

/**
 * Class FiftyFifty
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class FiftyFifty extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/fifty-fifty',
            Layout::make(__('Fifty Fifty', 'rosecrance'), 'fifty-fifty')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Columns', 'rosecrance'), 'columns')
                        ->min(1)
                        ->max(4)
                        ->fields([
                            FlexibleContent::make(__('Modules', 'rosecrance'), 'modules')
                                ->buttonLabel(__('Add Element', 'rosecrance'), 'rosecrance')
                                ->layouts([
                                    (new Buttons())->fields(),
                                    (new ColumnLinks())->fields(),
                                    (new Content())->fields(),
                                    (new Headline())->fields(),
                                    (new HeadlineOrange())->fields(),
                                    (new ImageFiftyFifty())->fields(),
                                    (new ImageSlider())->fields(),
                                    (new Subhead())->fields(),
                                    (new WysiwygFiftyFifty())->fields(),
                                    (new SalesforceForm())->fields()
                                ])
                        ])
                        ->buttonLabel(__('Add Column', 'rosecrance'), 'add-column'),
                    $this->optionsTab(),
                    ColorPicker::make(__('Background Color', 'rosecrance'))
                        ->defaultValue('transparent')
                        ->instructions(__('Default color is transparent', 'rosecrance')),
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
                    Common::paddingGroup(DEFAULT_FIFTY_FIFTY_PADDING),
                    Common::backgroundFillGroup(),
                    ButtonGroup::make(__('Module Vertical Alignment', 'rosecrance'), 'module-vertical-alignment')
                        ->choices([
                            'top' => __('Top', 'rosecrance'),
                            'middle' => __('Middle', 'rosecrance'),
                            'bottom' => __('Bottom', 'rosecrance')
                        ])
                        ->defaultValue('middle'),
                    $this->anchorTab(),
                    Common::anchorData()
                ])
        );
    }
}

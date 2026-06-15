<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\Acf\ConditionalLogic;
use Rosecrance\App\Fields\Common;
use Extended\Acf\Fields\ButtonGroup;
use Extended\Acf\Fields\Layout;
use Extended\Acf\Fields\Link;
use Extended\Acf\Fields\Repeater;
use Extended\Acf\Fields\Text;
use Extended\Acf\Fields\WysiwygEditor;

/**
 * Class LocationDetailMap
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class LocationDetailMap extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/location-detail-map',
            Layout::make(__('Location Detail Map', 'rosecrance'), 'location-detail-map')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Additional Phone Numbers', 'rosecrance'), 'phone-numbers')
                        ->layout('block')
                        ->buttonLabel(__('Add Phone Number', 'rosecrance'), 'add-phone-number')
                        ->fields([
                            Link::make(__('Phone', 'rosecrance'), 'phone')
                        ]),
                    Repeater::make(__('Service Hours', 'rosecrance'), 'service-hours')
                        ->layout('block')
                        ->buttonLabel(__('Add Service Hour', 'rosecrance'), 'add-service-hour')
                        ->fields([
                            Text::make(__('Service Hour', 'rosecrance'), 'service-hour')
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_LOCATION_DETAIL_MAP_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

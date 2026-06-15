<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\Acf\Fields\Group;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;
use Extended\Acf\Fields\Relationship;

/**
 * Class LocationSearch
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class LocationSearch extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/location-search',
            Layout::make(__('Location Search', 'rosecrance'), 'location-search')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Activate Search', 'rosecrance'), 'activate-search')
                        ->choices([
                            'true'  => __('True', 'rosecrance'),
                            'false' => __('False', 'rosecrance')
                        ])
                        ->defaultValue('true'),
                    Text::make(__('Headline', 'rosecrance'), 'headline')
                        ->required(),
                    $this->relationshipsTab(),
                    Group::make(__('Programs', 'rosecrance'), 'programs')
                        ->layout('block')
                        ->fields([
                            Relationship::make(__('Related Programs', 'rosecrance'), 'related-programs')
                                ->postTypes(['programs'])
                                ->filters([
                                    'search', 
                                ])
                                ->returnFormat('id')
                                ->instructions(__('Select programs that this location relates to.', 'rosecrance')),
                        ]),
                    Group::make(__('Services', 'rosecrance'), 'services')
                        ->layout('block')
                        ->fields([
                            Relationship::make(__('Related Services', 'rosecrance'), 'included-services')
                                ->postTypes(['services'])
                                ->filters([
                                    'search', 
                                ])
                                ->returnFormat('id')
                                ->instructions(__('Select services that this location includes.', 'rosecrance')),
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_LOCATION_SEARCH_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\Accordion;
use Rosecrance\App\Fields\Layouts\ColumnContent;
use Rosecrance\App\Fields\Layouts\Hero;
use Rosecrance\App\Fields\Layouts\Layouts;
use Rosecrance\App\Fields\Layouts\LocationDetailMap;
use Rosecrance\App\Fields\Layouts\Wysiwyg;

use Extended\ACF\ConditionalLogic;
use Extended\Acf\Fields\ButtonGroup;
use Extended\Acf\Fields\Checkbox;
use Extended\Acf\Fields\FlexibleContent;
use Extended\Acf\Fields\Group;
use Extended\Acf\Fields\Link;
use Extended\Acf\Fields\Relationship;
use Extended\Acf\Fields\Text;
use Rosecrance\App\Fields\Layouts\BioList;
use Rosecrance\App\Fields\Layouts\FiftyFifty;
use Rosecrance\App\Fields\Layouts\Media;

/**
 * Class Locations
 *
 * @package Rosecrance\App\Fields\Posts
 */
class Locations extends Layouts
{
    /**
     * Defines fields used within Locations post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/posts/locations',
            [
                $this->contentTab(),
                ButtonGroup::make(__('Virtual Location', 'rosecrance'), 'virtual-location')
                    ->choices([
                        'true'  => __('True', 'rosecrance'),
                        'false' => __('False', 'rosecrance')
                    ])
                    ->defaultValue('false'),
                Text::make(__('Additional Text', 'rosecrance'), 'additional-text')
                    ->conditionalLogic([
                        ConditionalLogic::where('virtual-location', '==', 'true')
                    ]),
                Text::make(__('Zip Code', 'rosecrance'), 'zip-code')
                    ->required()
                    ->wrapper([
                        'width' => '33'
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::where('virtual-location', '==', 'false')
                    ]),
                Text::make(__('Latitude', 'rosecrance'), 'latitude')
                    ->required()
                    ->wrapper([
                        'width' => '33'
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::where('virtual-location', '==', 'false')
                    ]),
                Text::make(__('Longitude', 'rosecrance'), 'longitude')
                    ->required()
                    ->wrapper([
                        'width' => '33'
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::where('virtual-location', '==', 'false')
                    ]),
                Text::make(__('Address', 'rosecrance'), 'address')
                    ->required()
                    ->conditionalLogic([
                        ConditionalLogic::where('virtual-location', '==', 'false')
                    ]),
                Link::make(__('Main Phone Number', 'rosecrance'), 'main-phone-number')
                    ->conditionalLogic([
                        ConditionalLogic::where('virtual-location', '==', 'false')
                    ]),
                Checkbox::make(__('Insurance Type', 'rosecrance'), 'insurance-type')
                    ->choices([
                        'employer' => __('Employer', 'rosecrance'),
                        'state-marketplace' => __('State/Marketplace', 'rosecrance'),
                        'medicaid' => __('Medicaid', 'rosecrance'),
                        'medicare' => __('Medicare', 'rosecrance'),
                        'self-pay' => __('Self-Pay', 'rosecrance'),
                        'none' => __('None', 'rosecrance'),
                    ])
                    ->layout('horizontal'),
                FlexibleContent::make(__('Modules', 'rosecrance'), 'modules')
                    ->buttonLabel(__('Add Element', 'rosecrance'), 'rosecrance')
                    ->layouts([
                        (new Accordion())->fields(),
                        (new BioList)->fields(),
                        (new ColumnContent())->fields(),
                        (new FiftyFifty())->fields(),
                        (new Hero())->fields(),
                        (new LocationDetailMap())->fields(),
                        (new Media())->fields(),
                        (new Wysiwyg())->fields(),
                    ]),
                $this->relationshipsTab(),
                Group::make(__('Regions', 'rosecrance'), 'regions')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Regions', 'rosecrance'), 'related-regions')
                            ->postTypes(['regions'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select regions that this location relates to.', 'rosecrance')),
                    ]),
                Group::make(__('Networks', 'rosecrance'), 'networks')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Networks', 'rosecrance'), 'related-networks')
                            ->postTypes(['networks'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select networks that this location relates to.', 'rosecrance')),
                    ]),
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
                Group::make(__('Conditions', 'rosecrance'), 'conditions')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Conditions', 'rosecrance'), 'related-conditions')
                            ->postTypes(['conditions'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select conditions that this location relates to.', 'rosecrance')),
                            ]),
                Group::make(__('Service Lines', 'rosecrance'), 'service-lines')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Service Lines', 'rosecrance'), 'related-service-lines')
                            ->postTypes(['service-lines'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select service lines that this location relates to.', 'rosecrance')),
                        ]),
                Group::make(__('Staff', 'rosecrance'), 'staff')
                        ->layout('block')
                        ->fields([
                            Relationship::make(__('Associated Staff Bios', 'rosecrance'), 'staff-bios')
                                ->postTypes(['bios'])
                                ->filters([
                                    'search', 
                                ])
                                ->returnFormat('id')
                                ->instructions(__('Select staff bios that this location relates to.', 'rosecrance')),
                            ]),
                $this->locationFinderTab(),
                Group::make(__('Location Finder Overrides', 'rosecrance'), 'location-finder-overrides')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Service Override', 'rosecrance'), 'service-override')
                            ->postTypes(['services'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('This location will always show up in the map when these services are filtered', 'rosecrance')),
                        Relationship::make(__('Program Override', 'rosecrance'), 'program-override')
                            ->postTypes(['programs'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('This location will always show up in the map when these programs are filtered', 'rosecrance')),
                    ]),
            ]
        );
    }
}

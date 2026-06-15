<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
use Rosecrance\App\Fields\Common;

/**
 * Class Services
 *
 * @package Rosecrance\App\Fields\Posts
 */
class Services extends Layouts
{
    /**
     * Defines fields used within Services post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/posts/services',
            [
                $this->contentTab(),
                Text::make(__('Name', 'rosecrance'), 'name'),
                $this->optionsTab(),
                Common::getCardPriorityField(),
                Common::getInsuranceField(),
                $this->relationshipsTab(),
                TrueFalse::make(__('Offered Stand-alone', 'rosecrance'))
                  ->instructions('Designates whether this service is eligible to be offered independent of a program'),
                Group::make(__('Programs', 'rosecrance'), 'programs')
                    ->layout('block')
                    ->fields([
                    Relationship::make(__('Parent Programs', 'rosecrance'), 'parent-programs')
                        ->postTypes(['programs'])
                        ->filters([
                        'search', 
                        ])
                        ->returnFormat('id')
                        ->instructions(__('Select one or more programs that this service is included in.', 'rosecrance'))
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
                            ->instructions(__('Select conditions that this service relates to.', 'rosecrance')),
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
                            ->instructions(__('Select service lines that this service relates to.', 'rosecrance')),
                        ]),
                Group::make(__('Audiences', 'rosecrance'), 'audiences')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Audiences', 'rosecrance'), 'related-audiences')
                            ->postTypes(['audience'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select the audience that this service relates to.', 'rosecrance')),
                        ]),
                Group::make(__('Locations', 'rosecrance'), 'locations')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Locations', 'rosecrance'), 'related-locations')
                            ->postTypes(['locations'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select the location that this program relates to.', 'rosecrance')),
                    ]),
        ]
        );
    }
}

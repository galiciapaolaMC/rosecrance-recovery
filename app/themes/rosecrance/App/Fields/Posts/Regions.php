<?php

namespace Rosecrance\App\Fields\Posts;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\Acf\Fields\Group;
use Extended\Acf\Fields\Relationship;
use Extended\Acf\Fields\Text;

/**
 * Class Regions
 *
 * @package Rosecrance\App\Fields\Posts
 */
class Regions extends Layouts
{
    /**
     * Defines fields used within Regions post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/posts/regions',
            [
                $this->contentTab(),
                Text::make(__('Name', 'rosecrance'), 'name'),
                $this->relationshipsTab(),
                ButtonGroup::make(__('Region Type', 'rosecrance'), 'region-type')
                    ->choices([
                        'parent-region' => __('Parent Region', 'rosecrance'),
                        'child-region' => __('Child Region', 'rosecrance'),
                        'standard-region' => __('Standalone Region', 'rosecrance'),
                    ])
                    ->instructions(__('A parent region is a region that contains other regions rather than individual locations. A standalone region is one that is not a child nor a parent. A child region is a member of a parent region.', 'rosecrance'))
                    ->defaultValue('standard-region'),
                Group::make(__('Locations', 'rosecrance'), 'locations')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Locations', 'rosecrance'), 'related-locations')
                            ->postTypes(['locations'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select location that this region relates to.', 'rosecrance'))
                        ])
                    ->conditionalLogic([ConditionalLogic::where('region-type', '==', 'standard-region')]),
                Group::make(__('Regions', 'rosecrance'), 'regions')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Child Regions', 'rosecrance'), 'child-regions')
                            ->postTypes(['regions'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select regions that are contained within this region.', 'rosecrance'))
                            ->conditionalLogic([ConditionalLogic::where('region-type', '==', 'parent-region')]),
                        Relationship::make(__('Parent Region', 'rosecrance'), 'parent-region')
                            ->postTypes(['regions'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->max(1)
                            ->min(1)
                            ->instructions(__('Select the parent region that contains this region.', 'rosecrance'))
                            ->conditionalLogic([ConditionalLogic::where('region-type', '==', 'child-region')]),
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('region-type', '==', 'child-region'),
                            ConditionalLogic::where('region-type', '==', 'parent-region')
                        ]),


            ]
        );
    }
}

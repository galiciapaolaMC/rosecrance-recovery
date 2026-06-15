<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;
use Rosecrance\App\Fields\Common;

/**
 * Class Programs
 *
 * @package Rosecrance\App\Fields\Posts
 */
class Programs extends Layouts
{
    /**
     * Defines fields used within Programs post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/posts/programs',
            [
                $this->contentTab(),
                Text::make(__('Name', 'rosecrance'), 'name'),
                $this->optionsTab(),
                Common::getCardPriorityField(),
                
                $this->relationshipsTab(),
                Group::make(__('Audiences', 'rosecrance'), 'audiences')
                ->layout('block')
                ->fields([
                    Relationship::make(__('Related Audiences', 'rosecrance'), 'related-audiences')
                        ->postTypes(['audience'])
                        ->filters([
                            'search', 
                        ])
                        ->returnFormat('id')
                        ->instructions(__('Select the audience that this program relates to.', 'rosecrance')),
                ]),
                Group::make(__('Blog Posts', 'rosecrance'), 'blog-posts')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Blog Posts', 'rosecrance'), 'related-blog-posts')
                            ->postTypes(['blog-post'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select blog posts that this program relates to.', 'rosecrance')),
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
                            ->instructions(__('Select conditions that this program relates to.', 'rosecrance')),
                        ]),
                Group::make(__('Drug Fact Sheets', 'rosecrance'), 'drug-fact-sheets')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Drug Fact Sheets', 'rosecrance'), 'related-drug-fact-sheets')
                            ->postTypes(['drug-fact-sheet'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select drug fact sheets that this program relates to.', 'rosecrance')),
                        ]),
                Group::make(__('Extended Articles', 'rosecrance'), 'extended-articles')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Extended Articles', 'rosecrance'), 'related-extended-articles')
                            ->postTypes(['extended-article'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select drug fact sheets that this program relates to.', 'rosecrance')),
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
                Group::make(__('Podcasts', 'rosecrance'), 'podcasts')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Podcasts', 'rosecrance'), 'related-podcasts')
                            ->postTypes(['podcast'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select podcasts that this program relates to.', 'rosecrance')),
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
                            ->instructions(__('Select service lines that this program relates to.', 'rosecrance')),
                        ]),
                Group::make(__('Services', 'rosecrance'), 'services')
                        ->layout('block')
                        ->fields([
                            Relationship::make(__('related Services', 'rosecrance'), 'related-services')
                                ->postTypes(['services'])
                                ->filters([
                                    'search', 
                                ])
                                ->returnFormat('id')
                                ->instructions(__('Select services that this program includes.', 'rosecrance'))
                            ]),
                Group::make(__('Videos', 'rosecrance'), 'videos')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Videos', 'rosecrance'), 'related-videos')
                            ->postTypes(['videos'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select videos that this program relates to.', 'rosecrance')),
                        ]),
            ]
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;

/**
 * Class ServiceLines
 *
 * @package Rosecrance\App\Fields\Posts
 */
class ServiceLines extends Layouts
{
    /**
     * Defines fields used within ServiceLines post type.
     *
     * @return array
     */
    public function fields()
    {
        $filters = apply_filters(
            'rosecrance/posts/service-lines',
            [
                $this->contentTab(),
                Text::make(__('Name', 'rosecrance'), 'name'),
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
                            ->instructions(__('Select program that this condition relates to.', 'rosecrance')),
                        ]),
                Group::make(__('Services', 'rosecrance'), 'services')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Services', 'rosecrance'), 'related-services')
                            ->postTypes(['services'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select services that this condition relates to.', 'rosecrance')),
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
                            ->instructions(__('Select program that this condition relates to.', 'rosecrance')),
                        ]),
            ]
        );
        return $filters;
    }
}

<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\Acf\Fields\Group;
use Extended\Acf\Fields\Relationship;
use Extended\Acf\Fields\Text;

/**
 * Class Networks
 *
 * @package Rosecrance\App\Fields\Posts
 */
class Networks extends Layouts
{
    /**
     * Defines fields used within Networks post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/posts/networks',
            [
                $this->contentTab(),
                Text::make(__('Name', 'rosecrance'), 'name'),
                $this->relationshipsTab(),
                Group::make(__('Locations', 'rosecrance'), 'locations')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Locations', 'rosecrance'), 'related-locations')
                            ->postTypes(['locations'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select location that this region relates to.', 'rosecrance')),
                        ])
            ]
        );
    }
}

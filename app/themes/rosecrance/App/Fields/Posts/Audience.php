<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\Acf\Fields\Group;
use Extended\Acf\Fields\Relationship;
use Extended\Acf\Fields\Text;
use Extended\ACF\Fields\TrueFalse;

/**
 * Class Audience
 *
 * @package Rosecrance\App\Fields\Posts
 */
class Audience extends Layouts
{
    /**
     * Defines fields used within Audience post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/posts/audience',
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
                $this->optionsTab(),
                TrueFalse::make(__('Hide Page', 'rosecrance'), 'hide-page')
                    ->instructions(__('Check this box to prevent this page from being visited directly - it will instead redirect to the homepage', 'rosecrance'))
                    
            ]
        );
    }
}

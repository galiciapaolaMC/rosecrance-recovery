<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\ColumnContent;
use Rosecrance\App\Fields\Layouts\ConditionSymptoms;
use Rosecrance\App\Fields\Layouts\ContentBanner;
use Rosecrance\App\Fields\Layouts\Layouts;
use Rosecrance\App\Fields\Layouts\ResourceHero;
use Rosecrance\App\Fields\Layouts\Wysiwyg;
use Extended\Acf\Fields\FlexibleContent;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Rosecrance\App\Fields\Common;

/**
 * Class DrugFactSheet
 *
 * @package Rosecrance\App\Fields\Posts
 */
class DrugFactSheet extends Layouts
{
    /**
     * Defines fields used within News Detail post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/posts/drug-fact-sheet',
            [
                $this->contentTab(),
                FlexibleContent::make(__('Modules', 'rosecrance'), 'modules')
                    ->buttonLabel(__('Add Element', 'rosecrance'), 'rosecrance')
                    ->layouts([
                        (new ResourceHero())->fields(),
                        (new ColumnContent())->fields(),
                        (new ConditionSymptoms())->fields(),
                        (new ContentBanner())->fields(),
                        (new Wysiwyg())->fields()
                    ]),
                $this->optionsTab(),
                Common::getCardPriorityField(),
                Text::make(__('Name', 'rosecrance'), 'name'),
                Textarea::make(__('Description', 'rosecrance'), 'description'),
                $this->relationshipsTab(),
                Group::make(__('Conditions', 'rosecrance'), 'conditions')
                    ->layout('block')
                    ->fields([
                        Relationship::make(__('Related Conditions', 'rosecrance'), 'related-conditions')
                            ->postTypes(['conditions'])
                            ->filters([
                                'search', 
                            ])
                            ->returnFormat('id')
                            ->instructions(__('Select conditions that this drug fact sheet relates to.', 'rosecrance')),
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
                                ->instructions(__('Select services that this drug fact sheet relates to.', 'rosecrance'))
                            ]),
                Group::make(__('Programs', 'rosecrance'), 'programs')
                        ->layout('block')
                        ->fields([
                            Relationship::make(__('Programs', 'rosecrance'), 'related-programs')
                                ->postTypes(['programs'])
                                ->filters([
                                'search', 
                                ])
                                ->returnFormat('id')
                                ->instructions(__('Select one or more programs that this drug fact sheet relates to.', 'rosecrance'))
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
                                ->instructions(__('Select the audience that this drug fact sheet relates to.', 'rosecrance')),
                            ]),
            ]
        );
    }
}

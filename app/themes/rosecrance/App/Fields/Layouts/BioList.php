<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Taxonomy;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Rosecrance\App\Fields\Common;

/**
 * Class BioList
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class BioList extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/bio-list',
            Layout::make(__('Bio List', 'rosecrance'), 'bio-list')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('List Type', 'rosecrance'), 'list-type')
                        ->choices([
                            'manual-selection' => __('Manual Selection', 'rosecrance'),
                            'groups' => __('Groups', 'rosecrance')
                        ])
                        ->defaultValue('manual-selection'),
                    Text::make(__('Heading', 'rosecrance'), 'heading'),
                    Textarea::make(__('Description', 'rosecrance'), 'description'),
                    ButtonGroup::make(__('View All Button', 'rosecrance'), 'view-all-button')
                        ->choices([
                            'inactive' => __('Inactive', 'rosecrance'),
                            'active' => __('Active', 'rosecrance')
                        ])
                        ->defaultValue('active'),
                    Relationship::make(__('Bios', 'rosecrance'), 'bios')
                      ->postTypes(['staff-bios'])
                      ->filters([
                        'search', 
                      ])
                      ->returnFormat('id')
                      ->min(1)
                      ->instructions(__('Choose the bios that should be shown in this section', 'rosecrance'))
                      ->conditionalLogic([
                            ConditionalLogic::where('list-type', '==', 'manual-selection')
                        ]),
                    Taxonomy::make(__('Groups', 'rosecrance'), 'groups')
                        ->taxonomy('staff-type')
                        ->appearance('checkbox')
                        ->returnFormat('id')
                        ->instructions(__('Choose the group(s) of bios that should be shown in this section', 'rosecrance'))
                        ->conditionalLogic([
                            ConditionalLogic::where('list-type', '==', 'groups')
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_BIO_LIST_PADDING),
                ])
        );
    }
}
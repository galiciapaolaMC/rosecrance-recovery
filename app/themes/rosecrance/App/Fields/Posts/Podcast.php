<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\ContentBanner;
use Rosecrance\App\Fields\Layouts\Layouts;
use Rosecrance\App\Fields\Layouts\PodcastEmbed;
use Rosecrance\App\Fields\Layouts\ResourceHero;
use Rosecrance\App\Fields\Layouts\Wysiwyg;
use Extended\Acf\Fields\FlexibleContent;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Url;
use Rosecrance\App\Fields\Common;

/**
 * Class Podcast
 *
 * @package Rosecrance\App\Fields\Posts
 */
class Podcast extends Layouts
{
    /**
     * Defines fields used within Podcast post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/posts/podcast',
            [
                $this->contentTab(),
                Url::make(__('Spotify URL', 'rosecrance'), 'spotify-url'),
                FlexibleContent::make(__('Modules', 'rosecrance'), 'modules')
                    ->buttonLabel(__('Add Element', 'rosecrance'), 'rosecrance')
                    ->layouts([
                        (new ResourceHero())->fields(),
                        (new PodcastEmbed())->fields(),
                        (new ContentBanner())->fields(),
                        (new Wysiwyg())->fields()
                    ]),
                $this->optionsTab(),
                Text::make(__('Name', 'rosecrance'), 'name'),
                Textarea::make(__('Description', 'rosecrance'), 'description'),
                Common::getCardPriorityField(),
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
                            ->instructions(__('Select conditions that this podcast relates to.', 'rosecrance')),
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
                                ->instructions(__('Select services that this podcast relates to.', 'rosecrance'))
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
                                ->instructions(__('Select one or more programs that this podcast relates to.', 'rosecrance'))
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
                                ->instructions(__('Select the audience that this podcast relates to.', 'rosecrance')),
                            ]),
            ]
        );
    }
}

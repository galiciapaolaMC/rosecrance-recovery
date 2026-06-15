<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Checkbox;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Rosecrance\App\Fields\Common;

/**
 * Class CardCarousel
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class CardCarousel extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/carousel',
            Layout::make(__('Card Carousel', 'rosecrance'), 'card-carousel')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Title', 'rosecrance'), 'title')
                      ->required(),
                    Checkbox::make(__('Included Post Types', 'rosecrance'), 'included-post-types')
                      ->choices([
                        'audience' => __('Audience', 'rosecrance'),
                        'blog-post' => __('Blog Posts', 'rosecrance'),
                        'conditions' => __('Conditions', 'rosecrance'),
                        'drug-fact-sheet' => __('Drug Fact Sheets', 'rosecrance'),
                        'extended-article' => __('Extended Articles', 'rosecrance'),
                        'location' => __('Locations', 'rosecrance'),
                        'podcast' => __('Podcasts', 'rosecrance'),
                        'programs' => __('Programs', 'rosecrance'),
                        'services' => __('Services', 'rosecrance'),
                        'service-line' => __('Service Lines', 'rosecrance'),
                        'videos' => __('Videos', 'rosecrance'),
                      ])
                      ->returnFormat('value')
                      ->required(),
                    Repeater::make(__('Filters', 'rosecrance'), 'filters')
                      ->layout('block')
                      ->buttonLabel(__('Add Filter'))
                      ->fields([
                          Select::make(__('Filter by', 'rosecrance'), 'filter-by')
                            ->choices([
                              'audience' => __('Audience', 'rosecrance'),
                              'blog-posts' => __('Blog Posts', 'rosecrance'),
                              'conditions' => __('Conditions', 'rosecrance'),
                              'drug-fact-sheets' => __('Drug Fact Sheets', 'rosecrance'),
                              'extended-article' => __('Extended Articles', 'rosecrance'),
                              'locations' => __('Location', 'rosecrance'),
                              'podcast' => __('Podcasts', 'rosecrance'),
                              'programs' => __('Programs', 'rosecrance'),
                              'service-line' => __('Service Line', 'rosecrance'),
                              'services' => __('Services', 'rosecrance'),
                              'videos' => __('Videos', 'rosecrance'),
                            ]),
                          Common::getPostListField('audience', 'audiences', 'Audiences', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'audience')
                            ]),
                          Common::getPostListField('blog-post', 'blog-posts', 'Blog Posts', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'blog-posts')
                            ]),
                          Common::getPostListField('conditions', 'conditions', 'Conditions', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'conditions')
                            ]),
                          Common::getPostListField('drug-fact-sheet', 'drug-fact-sheets', 'Drug Fact Sheets', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'drug-fact-sheets')
                            ]),
                          Common::getPostListField('extended-article', 'extended-article', 'Extended Articles', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'extended-article')
                            ]),
                          Common::getPostListField('locations', 'locations', 'Locations', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'location')
                            ]),
                          Common::getPostListField('podcast', 'podcasts', 'Podcasts', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'podcast')
                            ]),
                          Common::getPostListField('programs', 'programs', 'Programs', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'programs')
                            ]),
                          Common::getPostListField('service-lines', 'service-lines', 'Service Lines', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'service-line')
                            ]),
                          Common::getPostListField('services', 'services', 'Services', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'services')
                            ]),
                          Common::getPostListField('videos', 'videos', 'Videos', 'checkbox')
                            ->conditionalLogic([
                              ConditionalLogic::where('filter-by', '==', 'videos')
                            ]),
                      ]),
                    $this->optionsTab(),
                    Common::paddingGroup(DEFAULT_CARD_CAROUSEL_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

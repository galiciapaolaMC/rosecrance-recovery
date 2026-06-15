<?php

namespace Rosecrance\App\Fields\FieldGroups;

use Rosecrance\App\Fields\Layouts\ActivateTreatmentLocator;
use Rosecrance\App\Fields\Layouts\Accordion;
use Rosecrance\App\Fields\Layouts\Carousel;
use Rosecrance\App\Fields\Layouts\ColumnContent;
use Rosecrance\App\Fields\Layouts\ColumnCard;
use Rosecrance\App\Fields\Layouts\ConditionPicker;
use Rosecrance\App\Fields\Layouts\ConditionSymptoms;
use Rosecrance\App\Fields\Layouts\ContentArea;
use Rosecrance\App\Fields\Layouts\FiftyFifty;
use Rosecrance\App\Fields\Layouts\FiftyFiftyStatistics;
use Rosecrance\App\Fields\Layouts\Hero;
use Rosecrance\App\Fields\Layouts\HelpBanner;
use Rosecrance\App\Fields\Layouts\HomeHero;
use Rosecrance\App\Fields\Layouts\Image;
use Rosecrance\App\Fields\Layouts\Media;
use Rosecrance\App\Fields\Layouts\LinkCards;
use Rosecrance\App\Fields\Layouts\Logos;
use Rosecrance\App\Fields\Layouts\ResourceHero;
use Rosecrance\App\Fields\Layouts\SubNavigation;
use Rosecrance\App\Fields\Layouts\Testimonial;
use Rosecrance\App\Fields\Layouts\Video;
use Rosecrance\App\Fields\Layouts\ContentBanner;
use Rosecrance\App\Fields\Layouts\BioList;
use Rosecrance\App\Fields\Layouts\Wysiwyg;
use Rosecrance\App\Fields\Layouts\PodcastEmbed;
use Rosecrance\App\Fields\Layouts\SalesforceForm;
use Rosecrance\App\Fields\FieldGroups\RegisterFieldGroups;
use Rosecrance\App\Fields\Layouts\CardCarousel;
use Rosecrance\App\Fields\Layouts\NewsArticles;

use Extended\ACF\Location;
use Extended\ACF\Fields\FlexibleContent;

/**
 * Class PageBuilderFieldGroup
 *
 * @package Rosecrance\App\Fields\PageBuilderFieldGroup
 */
class PageBuilderFieldGroup extends RegisterFieldGroups
{
    /**
     * Register Field Group via Wordplate
     */
    public function registerFieldGroup()
    {
        register_extended_field_group([
            'title'    => __('Page Builder', 'rosecrance'),
            'fields'   => $this->getFields(),
            'location' => [
                Location::where('page_template', '==', 'templates/page-builder.php'),
                Location::where('post_type', '==', 'programs'),
                Location::where('post_type', '==', 'conditions'),
                Location::where('post_type', '==', 'services'),
                Location::where('post_type', '==', 'service-lines'),
                Location::where('post_type', '==', 'networks'),
                Location::where('post_type', '==', 'regions'),
                Location::where('post_type', '==', 'audience'),
                Location::where('post_type', '==', 'staff-bios'),
            ],
            'style' => 'default'
        ]);
    }

    /**
     * Register the fields that will be available to this Field Group.
     *
     * @return array
     */
    public function getFields()
    {
        return apply_filters('rosecrance/field-group/page-builder/fields', [
            FlexibleContent::make(__('Modules', 'rosecrance'), 'modules')
                ->buttonLabel(__('Add Module', 'rosecrance'), 'add-module')
                ->layouts([
                    (new ActivateTreatmentLocator())->fields(),
                    (new Accordion())->fields(),
                    (new BioList())->fields(),
                    (new CardCarousel())->fields(),
                    (new Carousel())->fields(),
                    (new ColumnContent())->fields(),
                    (new ColumnCard())->fields(),
                    (new ConditionPicker())->fields(),
                    (new ConditionSymptoms())->fields(),
                    (new ContentArea())->fields(),
                    (new ContentBanner())->fields(),
                    (new FiftyFifty())->fields(),
                    (new FiftyFiftyStatistics())->fields(),
                    (new Hero())->fields(),
                    (new HelpBanner())->fields(),
                    (new HomeHero())->fields(),
                    (new Image())->fields(),
                    (new Media())->fields(),
                    (new LinkCards())->fields(),
                    (new Logos())->fields(),
                    (new NewsArticles())->fields(),
                    (new PodcastEmbed())->fields(),
                    (new ResourceHero())->fields(),
                    (new SalesforceForm())->fields(),
                    (new SubNavigation())->fields(),
                    (new Testimonial())->fields(),
                    (new Video())->fields(),
                    (new Wysiwyg())->fields()
                ])
        ]);
    }
}

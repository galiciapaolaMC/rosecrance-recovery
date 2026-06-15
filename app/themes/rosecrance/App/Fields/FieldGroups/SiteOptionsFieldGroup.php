<?php

namespace Rosecrance\App\Fields\FieldGroups;

use Extended\ACF\Location;
use Rosecrance\App\Fields\Options\Scripts;
use Rosecrance\App\Fields\Options\Branding;
use Rosecrance\App\Fields\Options\CardPriority;
use Rosecrance\App\Fields\Options\FloatingMobileButton;
use Rosecrance\App\Fields\Options\HelpBanner;
use Rosecrance\App\Fields\Options\MapKeys;
use Rosecrance\App\Fields\Options\OrangeMenu;
use Rosecrance\App\Fields\Options\SearchPage;
use Rosecrance\App\Fields\Options\TreatmentLocator;
use Rosecrance\App\Fields\Options\Footer;
use Rosecrance\App\Fields\Options\SalesforceForms;

/**
 * Class SiteOptionsFieldGroup
 *
 * @package Rosecrance\App\Fields\SiteOptionsFieldGroup
 */
class SiteOptionsFieldGroup extends RegisterFieldGroups
{
    /**
     * Register Field Group via Wordplate
     */
    public function registerFieldGroup()
    {
        register_extended_field_group([
            'title'    => __('Site Options', 'rosecrance'),
            'fields'   => $this->getFields(),
            'location' => [
                Location::where('options_page', '==', 'theme-general-options')
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
        return apply_filters(
            'rosecrance/field-group/site-options/fields',
            array_merge(
                (new Branding())->fields(),
                (new HelpBanner())->fields(),
                (new MapKeys())->fields(),
                (new Footer())->fields(),
                (new OrangeMenu())->fields(),
                (new SearchPage())->fields(),
                (new TreatmentLocator())->fields(),
                (new CardPriority())->fields(),
                (new FloatingMobileButton())->fields(),
                (new SalesforceForms())->fields(),
                (new Scripts())->fields(),
            )
        );
    }
}

<?php

namespace Rosecrance\App\Fields\FieldGroups;

use Rosecrance\App\Fields\Layouts\ColumnContent;
use Rosecrance\App\Fields\Layouts\LocationSearch;
use Rosecrance\App\Fields\FieldGroups\RegisterFieldGroups;

use Extended\ACF\Location;
use Extended\ACF\Fields\FlexibleContent;
use Rosecrance\App\Fields\Layouts\HelpBanner;
use Rosecrance\App\Fields\Layouts\Wysiwyg;

/**
 * Class ProgramsAndServicesFieldGroup
 *
 * @package Rosecrance\App\Fields\ProgramsAndServicesFieldGroup
 */
class ProgramsAndServicesFieldGroup extends RegisterFieldGroups
{
    /**
     * Register Field Group via Wordplate
     */
    public function registerFieldGroup()
    {
        register_extended_field_group([
            'title'    => __('Programs And Services Builder', 'rosecrance'),
            'fields'   => $this->getFields(),
            'location' => [
                Location::where('page_template', '==', 'templates/programs-and-services.php')
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
        return apply_filters('rosecrance/field-group/programs-and-services/fields', [
            FlexibleContent::make(__('Modules', 'rosecrance'), 'modules')
                ->buttonLabel(__('Add Module', 'rosecrance'), 'add-module')
                ->layouts([
                    (new HelpBanner())->fields(),
                    (new Wysiwyg())->fields() 
                ])
        ]);
    }
}

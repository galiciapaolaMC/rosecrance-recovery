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
 * Class ResourceLibraryFieldGroup
 *
 * @package Rosecrance\App\Fields\ResourceLibraryFieldGroup
 */
class ResourceLibraryFieldGroup extends RegisterFieldGroups
{
    /**
     * Register Field Group via Wordplate
     */
    public function registerFieldGroup()
    {
        register_extended_field_group([
            'title'    => __('Resource Library Builder', 'rosecrance'),
            'fields'   => $this->getFields(),
            'location' => [
                Location::where('page_template', '==', 'templates/resources.php')
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
        return apply_filters('rosecrance/field-group/resources/fields', [
            FlexibleContent::make(__('Modules', 'rosecrance'), 'modules')
                ->buttonLabel(__('Add Module', 'rosecrance'), 'add-module')
                ->layouts([
                    (new HelpBanner())->fields(),
                    (new Wysiwyg())->fields() 
                ])
        ]);
    }
}

<?php

namespace Rosecrance\App\Fields\FieldGroups;

use Rosecrance\App\Fields\FieldGroups\RegisterFieldGroups;
use Extended\ACF\Location;

/**
 * Class CustomPostTypeFieldGroups
 *
 * @package Rosecrance\App\Fields\CustomPostTypeFieldGroup
 */
class CustomPostTypeFieldGroups extends RegisterFieldGroups
{
    /**
     * Register Field Group via Wordplate
     */
    public function registerFieldGroup()
    {
        $conditions = register_extended_field_group([
            'title'    => __('Conditions', 'rosecrance'),
            'fields'   => $this->getFields('Conditions'),
            'location' => [
                Location::where('post_type', '==', 'conditions')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Programs', 'rosecrance'),
            'fields'   => $this->getFields('Programs'),
            'location' => [
                Location::where('post_type', '==', 'programs')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Regions', 'rosecrance'),
            'fields'   => $this->getFields('Regions'),
            'location' => [
                Location::where('post_type', '==', 'regions')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Services', 'rosecrance'),
            'fields'   => $this->getFields('Services'),
            'location' => [
                Location::where('post_type', '==', 'services')
            ],
            'style' => 'default'
        ]);
      
        register_extended_field_group([
            'title'    => __('Locations', 'rosecrance'),
            'fields'   => $this->getFields('Locations'),
            'location' => [
                Location::where('post_type', '==', 'locations')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Networks', 'rosecrance'),
            'fields'   => $this->getFields('Networks'),
            'location' => [
                Location::where('post_type', '==', 'networks')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Service Lines', 'rosecrance'),
            'fields'   => $this->getFields('ServiceLines'),
            'location' => [
                Location::where('post_type', '==', 'service-lines')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Staff Bios', 'rosecrance'),
            'fields'   => $this->getFields('StaffBios'),
            'location' => [
                Location::where('post_type', '==', 'staff-bios'),
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Extended Article', 'rosecrance'),
            'fields'   => $this->getFields('ExtendedArticle'),
            'location' => [
                Location::where('post_type', '==', 'extended-article')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Blog Post', 'rosecrance'),
            'fields'   => $this->getFields('BlogPost'),
            'location' => [
                Location::where('post_type', '==', 'blog-post')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('News Detail', 'rosecrance'),
            'fields'   => $this->getFields('NewsDetail'),
            'location' => [
                Location::where('post_type', '==', 'news-detail')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Drug Fact Sheet', 'rosecrance'),
            'fields'   => $this->getFields('DrugFactSheet'),
            'location' => [
                Location::where('post_type', '==', 'drug-fact-sheet')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Audience', 'rosecrance'),
            'fields'   => $this->getFields('Audience'),
            'location' => [
                Location::where('post_type', '==', 'audience')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([
            'title'    => __('Videos', 'rosecrance'),
            'fields'   => $this->getFields('Videos'),
            'location' => [
                Location::where('post_type', '==', 'videos')
            ],
            'style' => 'default'
        ]);

        register_extended_field_group([   
            'title'    => __('Podcast', 'rosecrance'),
            'fields'   => $this->getFields('Podcast'),
            'location' => [
                Location::where('post_type', '==', 'podcast')
            ],
            'style' => 'default'
        ]);
    }

    /**
     * Register the fields that will be available to this Field Group.
     *
     * @return array
     */
    public function getFields($name = '')
    {
        $n = 'Rosecrance\App\Fields\Posts\\' . $name;
        $lower = strtolower($name);
        return apply_filters(
            'rosecrance/field-group/{$lower}/fields',
            array_merge(
                (new $n())->fields()
            )
        );
    }
}

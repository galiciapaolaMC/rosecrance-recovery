<?php

namespace Rosecrance\App;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Media;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

/**
 * Class LocationFilter
 *
 * @package Rosecrance\App
 */

class LocationFilter implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('rosecrance/region-filter/output', [$this, 'outputRegionFilter'], 10, 2);
        add_action('rosecrance/program-filter/output', [$this, 'outputProgramFilter'], 10, 2);
        add_action('rosecrance/service-filter/output', [$this, 'outputServiceFilter'], 10, 2);
    }
    
    public function outputProgramFilter($initial_value = '', $label = 'Programs')
    {
        $this->outputGeneralFilter($initial_value, 'programs', $label);
    }

    public function outputServiceFilter($initial_value = '', $label = 'Services')
    {
        $this->outputGeneralFilter($initial_value, 'services', $label);
    }

    public function outputGeneralFilter($initial_value = '', $post_type, $label)
    {
        $args = array(
            'post_status' => 'publish',
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );

        $query = new \WP_Query($args); 

        $default_option = [
            'label' => __('All ' . $post_type, 'rosecrance'),
            'value' => '',
            'type' => 'standalone',
        ];
        $options = array($default_option);

        foreach ($query->posts as $post) {
            $options[] = [
                'label' => $post->post_title,
                'value' => $post->ID,
                'type' => 'standalone',
            ];
        }

        $this->outputFilter($post_type, $options, $label, $initial_value);
    }

    public function outputRegionFilter($initial_value = '', $label = 'Region')
    {
        $args = array(
            'post_status' => 'publish',
            'post_type' => 'regions',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );

        $query = new \WP_Query($args); 

        
        $default_option = [
            'label' => __('All regions', 'rosecrance'),
            'value' => '',
            'type' => 'default',
        ];
        $options = array($default_option);

        foreach ($query->posts as $post) {
            $region_post_meta = ACF::getPostMeta($post->ID);
            $region_type = ACF::getField('region-type', $region_post_meta);

            if ($region_type === 'child-region') {
                continue;
            } elseif ($region_type === 'parent-region') {
                $child_regions = (array) ACF::getField('regions_child-regions', $region_post_meta, []);
                $options[] = [
                    'label' => $post->post_title,
                    'value' => $post->ID,
                    'type' => 'parent',
                ];
                foreach ($child_regions as $child_region) {
                    $child_region_post = get_post($child_region);
                    $options[] = [
                        'label' => $child_region_post->post_title,
                        'value' => $child_region_post->ID,
                        'type' => 'child',
                    ];
                }
            } else {
                $options[] = [
                    'label' => $post->post_title,
                    'value' => $post->ID,
                    'type' => 'standalone',
                ];
            }
        }

        $this->outputFilter('regions', $options, $label, $initial_value);
    }

    public function outputOption($option, $field_name, $initial_value) 
    {
        $label = $option['label'];
        $value = $option['value'];
        $filter_value = Util::createSlug($label);
        $type = $option['type'] ?? 'standalone';

        $selected = $value === $initial_value ? 'selected' : '';
        $option_html = sprintf(
            '<li class="select-field-option select-field-option--%2$s" role="option" data-select-field-option>
                <label class="select-field-option__container">
                    <input
                        class="select-field-option__input select-field-option__input--radio"
                        type="radio"
                        value="%1$s"
                        name="%3$s"
                        data-label-value="%4$s"
                        data-filter-value="%5$s"
                        %6$s
                    />
                    <span class="select-field-option__label">%4$s</span>
                </label>
            </li>',
            $value,
            $type,
            $field_name,
            $label,
            $filter_value,
            $selected
        );
        return $option_html;
    }

    public function outputFilter($post_type, $options, $label, $initial_value = '')
    {
        if (!isset($post_type)) {
            return '<!-- select field missing required arguments -->';
        }

        $id = $post_type . '_select-field';
        $options_html = '';
        $icon = Util::getIconHTML('dropdown');

        foreach ($options as $option) {
            $options_html .= $this->outputOption($option, $post_type, $initial_value); 
        }

        printf(
            '<div class="select-field">
                <span class="select-field__label" id="list-label">%4$s</span>
                <button
                    class="select-field__button"
                    role="combobox"
                    aria-labelledby="list-label"
                    aria-haspopup="listbox"
                    aria-expanded="false"
                    aria-controls="%1$s"
                    aria-label="Select option for %6$s"
                    role="button"
                    data-name="%6$s"
                >
                    <span class="select-field__selected-value">%3$s</span>
                    <span class="select-field__arrow">%5$s</span>
                </button>
                <ul class="select-field__dropdown" role="listbox" id="%1$s">
                    %2$s
                </ul>
            </div>',
            $id . '_dropdown', // dropdown id, used to set aria controls
            $options_html,
            '',
            $label,
            $icon,
            $post_type
        );
    }
}
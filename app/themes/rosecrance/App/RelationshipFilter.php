<?php

namespace Rosecrance\App;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Media;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

/**
 * Class RelationshipFilter
 *
 * @package Rosecrance\App
 */

class RelationshipFilter implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('rosecrance/relationship-filter/output', [$this, 'outputRelationshipFilter'], 10, 2);
    }

    public function outputRelationshipFilter($post_type, $default_option = null)
    {
        $args = array(
            'post_status' => 'publish',
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );

        $query = new \WP_Query($args); ?>

        <select name="filter_<?php echo esc_attr($post_type); ?>" class="select-filter">
            <?php if (!is_null($default_option)) { ?>
                <option value="<?php echo esc_attr($default_option['value']); ?>"><?php echo esc_html($default_option['label']); ?></option>
            <?php } else { ?>
                <option value=""><?php echo _e('Select an option', 'rosecrance'); ?></option>
            <?php } ?>

            <?php while ($query->have_posts()) :
                $query->the_post();
                $post_id = get_the_ID();
                $post = get_post($post_id); 
                $post_slug = $post->post_name; ?>
            
                <option class="filter-item <?php echo esc_attr($post_type); ?>" data-type="<?php echo esc_attr($post_type); ?>" data-id="<?php echo esc_attr($post_id); ?>" id="<?php echo esc_attr($post_type) ?>-<?php echo esc_attr($post_slug) ?>" value="<?php echo esc_attr($post_id) ?>" role="option" aria-selected="false" id="<?php echo esc_attr($post->post_name) ?>">
                    <?php echo esc_html(the_title()) ?>
                </option>

            <?php endwhile; ?>
        </select>

        <?php 
    }
}
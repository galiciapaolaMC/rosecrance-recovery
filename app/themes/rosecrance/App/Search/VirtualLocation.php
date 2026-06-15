<?php

namespace Rosecrance\App\Search;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Media;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

/**
 * Class VirtualLocation
 *
 * @package Rosecrance\App\Search
 */

class VirtualLocation implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('rosecrance/virtual-locations/output', [$this, 'outputVirtualLocation'], 10, 2);
    }

    public function outputVirtualLocation($post_type, $taxonomy)
    {
        $args = array(
            'post_status' => 'publish',
            'post_type' => $post_type,
            'location-type' => $taxonomy,
            'posts_per_page' => -1,
            'orderby' => 'name',
            'order' => 'DESC'
        );

        $query = new \WP_Query($args);
        
        while ($query->have_posts()) :
            $query->the_post();
            $post_id = get_the_ID();
            $post = get_post($post_id);
            $permalink = get_the_permalink($post_id);
            $data_similar = ACF::getPostMeta($post_id);
            $additional_text = ACF::getField('additional-text', $data_similar); ?>
        
            <div class="virtual-location-container">
                <h2><?php the_title(); ?></h2>

                <?php if (!empty($additional_text)) { ?>
                    <p><?php echo esc_html($additional_text); ?></p>
                <?php } ?>

                <a href="<?php echo esc_url($permalink); ?>" class="btn btn-primary">
                    <?php _e('Location Detail', 'rosecrance');
                    echo Util::getIconHTML('arrow-right-dark'); ?> 
                </a>
            </div>

        <?php endwhile;
    }
}
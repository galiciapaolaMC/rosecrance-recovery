<?php

/**
 * ACF Module: Search Result
 *
 * @global WP_Post $post_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$data_result = ACF::getPostMeta($post_id);
$post = get_post( $post_id );
$post_type = $post->post_type;
$post_title = get_the_title($post_id);
$post_permalink = get_permalink($post_id);

$post_type_text = str_replace('-', ' ', $post_type);
$post_type_text = str_replace('detail', '', $post_type_text);
?>


<li data-type="<?php echo esc_attr($post_type); ?>">
    <a href="<?php echo esc_url($post_permalink); ?>">
        <?php if ($post_type_text !== 'page') { ?>
            <p class="post-type"><?php echo esc_html($post_type_text); ?></p>
        <?php } ?>
        <h2>
            <?php echo esc_html($post_title); ?>
        </h2>
    </a>
</li>
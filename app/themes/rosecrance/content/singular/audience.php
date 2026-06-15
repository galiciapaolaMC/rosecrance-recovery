<?php

/**
 * Audience template file.
 */

use Rosecrance\App\Fields\ACF;

$post_id = get_the_ID();
$video_post = get_post($post_id);
$data = ACF::getPostMeta($post_id);

$hide_page = ACF::getField('hide-page', $data, false);

if ($hide_page) {
    wp_redirect(home_url());
    exit;
}
?>

<div id="primary">
  <article id="post-<?php the_ID(); ?>" class="audience">
    <?php
      // hook: App/Fields/Modules/outputFlexibleModules()
      do_action('rosecrance/modules/output', get_the_ID());
    ?>
  </article>
</div>
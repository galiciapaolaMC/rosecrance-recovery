<?php

/**
 * Conditions template file.
 */

$title = get_the_title();
?>

<div id="primary">
  <article id="post-<?php the_ID(); ?>" class="conditions-detail-page" data-title="<?php echo esc_html($title); ?>">
    <?php
      // hook: App/Fields/Modules/outputFlexibleModules()
      do_action('rosecrance/modules/output', get_the_ID());
    ?>
  </article>
</div>
<?php

/**
 * Regions template file.
 */
?>

<div id="primary">
  <article id="post-<?php the_ID(); ?>" class="regions-detail-page">
    <?php
      // hook: App/Fields/Modules/outputFlexibleModules()
      do_action('rosecrance/modules/output', get_the_ID());
    ?>
  </article>
</div>
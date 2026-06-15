<?php

/**
 * Service Lines template file.
 */
?>

<div id="primary">
  <article id="post-<?php the_ID(); ?>" class="service-lines-detail-page">
    <?php
      // hook: App/Fields/Modules/outputFlexibleModules()
      do_action('rosecrance/modules/output', get_the_ID());
    ?>
  </article>
</div>
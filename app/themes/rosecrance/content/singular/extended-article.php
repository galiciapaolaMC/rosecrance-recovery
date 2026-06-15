<?php

/**
 * Extended Article template file.
 */
?>

<div id="primary">
    <article id="post-<?php the_ID(); ?>" class="extended-article extended-article-detail-page">
        <?php
        $file = locate_template("components/partials/go-back-button.php");
        if (file_exists($file)) {
            include $file;
        }
        
        // hook: App/Fields/Modules/outputFlexibleModules()
        do_action('rosecrance/modules/output', get_the_ID());
        ?>
    </article>
</div>
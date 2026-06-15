<?php

/**
 * Locations template file.
 */

$title = get_the_title();
?>

<div id="primary">
    <article id="post-<?php the_ID(); ?>" class="location-detail-page" data-title="<?php echo esc_html($title); ?>">
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
<?php

/**
 * The template for displaying all single posts.
 *
 * @package Rosecrance
 */

get_header(); ?>

<main class="uk-padding-remove" id="primary">
    <?php 
    while (have_posts()) {
        the_post();
        // Loads the content/singular/page.php template.
        get_template_part('content/singular/' . get_post_type());
    }
    ?>
</main>

<?php get_footer();

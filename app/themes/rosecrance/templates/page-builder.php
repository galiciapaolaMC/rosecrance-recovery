<?php

/**
 * Template Name: Page Builder
 *
 * This template displays Advanced Custom Fields
 * flexible content fields in a user-defined order.
 *
 * @package Rosecrance
 */

get_header();
?>

<div id="primary">
    <div id="smooth-wrapper">
        <div id="smooth-content">
            <?php
            // hook: App/Fields/Modules/outputFlexibleModules()
            do_action('rosecrance/modules/output', get_the_ID());
            ?>
        </div>
    </div>
</div><!-- /#primary -->

<?php
get_footer();

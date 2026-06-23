<?php

/**
 * Template Name: Page Builder
 *
 * This template displays Advanced Custom Fields
 * flexible content fields in a user-defined order.
 *
 * @package Rosecrance
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Options;

get_header();

$options = Options::getSiteOptions();
$header_activation = ACF::getField('header-activation', $options);
?>

<div id="primary" class="header-<?php echo $header_activation; ?>">
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

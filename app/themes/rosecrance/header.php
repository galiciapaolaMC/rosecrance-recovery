<?php

/**
 * The template for displaying the header.
 *
 * @package Rosecrance
 */

use Rosecrance\App\Media;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\Util;

$options = Options::getSiteOptions();
$logo = ACF::getField('site-logo', $options);
$header_activation = ACF::getField('header-activation', $options);

$left_links = ACF::getRowsLayout('left-links', $options);
$right_links = ACF::getRowsLayout('right-links', $options);
$head_scripts = ACF::getField('head-scripts', $options);
$body_scripts = ACF::getField('body-scripts', $options);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="stylesheet" href="https://use.typekit.net/hxc5ixo.css">

    <?php 
    wp_head(); 
    echo $head_scripts;
    ?>
    
</head>

<body <?php body_class(); ?>>
    <?php echo $body_scripts; ?>
    <?php do_action('rosecrance/styles/icons'); ?>

    <!-- skip to main content -->
    <a href="#primary" class="screen-reader-text"><?php _e('Skip to Main Content', 'rosecrance'); ?></a>

    <?php if ($header_activation === 'on') : ?>
        <header id="masthead" class="header" role="banner">
            <?php if (!empty($left_links) || !empty($right_links)) { ?> 
                <div class="header__orange-nav">
                    <div class="uk-container uk-container-large uk-padding-remove">
                        <div class="uk-grid uk-grid-medium">
                            <div class="uk-width-1-5@m uk-width-1-1@s">
                            </div>
                            
                            <div class="uk-width-4-5@m uk-width-1-1@s">
                                <div class="uk-grid uk-grid-large">
                                    <div class="uk-width-2-3@m uk-width-1-2@s">
                                        <?php if (!empty($left_links)) { 
                                            foreach ($left_links as $item) { 
                                                $item_link = ACF::getField('link', $item);
                                                $border = ACF::getField('border', $item); ?> 

                                                <a class="header__orange-nav-link <?php if ($border) { ?> link-border <?php } ?>" href="<?php echo $item_link['url']; ?>" target="<?php echo $item_link['target']; ?>"><?php echo $item_link['title']; ?></a>
                                            
                                            <?php } ?> 
                                        <?php } ?>
                                    </div>

                                    <div class="uk-width-1-3@m uk-width-1-2@s orange-nav-right">
                                        <div class="search-container">
                                            <?php if (!empty($right_links)) { 
                                                foreach ($right_links as $item) { 
                                                    $item_link = ACF::getField('link', $item);
                                                    $border = ACF::getField('border', $item); ?> 

                                                    <a class="header__orange-nav-link <?php if ($border) { ?> link-border <?php } ?>" href="<?php echo $item_link['url']; ?>" target="<?php echo $item_link['target']; ?>"><?php echo $item_link['title']; ?></a>
                                                
                                                <?php } ?> 
                                            <?php } ?>

                                            <button id="search-button" class="search-btn">
                                                <?php echo Util::getIconHTML('search'); ?>
                                            </button>

                                            <div class="search-form-container">
                                                <?php get_search_form(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header__orange-nav-mobile">
                    <div class="uk-container uk-container-large uk-padding-remove">
                        <div class="uk-grid uk-grid-medium">
                            <?php if (!empty($left_links)) { 
                                foreach ($left_links as $item) { 
                                    $item_link = ACF::getField('link', $item);
                                    $border = ACF::getField('border', $item); ?> 

                                    <div class="uk-width-1-2">
                                        <a class="header__orange-nav-link <?php if ($border) { ?> link-border <?php } ?>" href="<?php echo $item_link['url']; ?>" target="<?php echo $item_link['target']; ?>"><?php echo $item_link['title']; ?></a>
                                    </div>
                                
                                <?php } ?> 
                            <?php } ?>
                                    
                            <?php if (!empty($right_links)) { 
                                foreach ($right_links as $item) { 
                                    $item_link = ACF::getField('link', $item);
                                    $border = ACF::getField('border', $item); ?> 

                                    <div class="uk-width-1-2">
                                        <a class="header__orange-nav-link <?php if ($border) { ?> link-border <?php } ?>" href="<?php echo $item_link['url']; ?>" target="<?php echo $item_link['target']; ?>"><?php echo $item_link['title']; ?></a>
                                    </div>
                                
                                <?php } ?> 
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="uk-container uk-container-large uk-padding-remove">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-1-5@m">
                            <a class="header__logo" href="<?php echo home_url(); ?>"><?php echo Util::getImageHTML(Media::getAttachmentByID($logo)); ?></a>
                        </div>

                        <div class="uk-width-4-5@m">
                            <div class="header__menu-container">
                                <div class="header__search-mobile">
                                    <form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_home_url(); ?>">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="<?php _e('Search', 'rosecrance') ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php _e('Search for:', 'rosecrance') ?>" />
                                                <div class="input-group-btn">
                                                    <button class="search-btn" type="submit">
                                                        <?php echo Util::getIconHTML('search'); ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="header__back-button">
                                    <button class="back-button-mobile">
                                        <?php echo Util::getIconHTML('back-arrow'); ?>
                                        <?php _e('Back', 'rosecrance'); ?>
                                    </button>
                                </div>

                                <?php
                                // Loads the menu/primary.php template.
                                get_template_part('menu/primary');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header><!-- .header -->
    <?php endif; ?>
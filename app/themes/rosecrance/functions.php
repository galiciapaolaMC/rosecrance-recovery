<?php

/**
 * Functions and definitions
 *
 * @package Rosecrance
 */

use Rosecrance\App\Core\Init;
use Rosecrance\App\Setup;
use Rosecrance\App\Scripts;
use Rosecrance\App\Media;
use Rosecrance\App\Shortcodes;
use Rosecrance\App\Api\LocationSearch;
use Rosecrance\App\RelationshipFilter;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\Modules;
use Rosecrance\App\Fields\FieldGroups\CustomPostTypeFieldGroups;
use Rosecrance\App\Fields\FieldGroups\SiteOptionsFieldGroup;
use Rosecrance\App\Fields\FieldGroups\PageBuilderFieldGroup;
use Rosecrance\App\Fields\FieldGroups\LocationsBuilderFieldGroup;
use Rosecrance\App\Fields\FieldGroups\ProgramsAndServicesFieldGroup;
use Rosecrance\App\Fields\FieldGroups\ResourceLibraryFieldGroup;
use Rosecrance\App\LocationFilter;
use Rosecrance\App\Posts\Types\BlogPost;
use Rosecrance\App\Posts\Types\ExtendedArticle;
use Rosecrance\App\Posts\Types\ServiceLines;
use Rosecrance\App\Posts\Types\StaffBios;
use Rosecrance\App\Posts\Types\Conditions;
use Rosecrance\App\Posts\Types\Locations;
use Rosecrance\App\Posts\Types\Networks;
use Rosecrance\App\Posts\Types\Programs;
use Rosecrance\App\Posts\Types\Regions;
use Rosecrance\App\Posts\Types\Services;
use Rosecrance\App\Posts\Types\NewsDetail;
use Rosecrance\App\Posts\Types\DrugFactSheet;
use Rosecrance\App\Posts\Types\Audience;
use Rosecrance\App\Posts\Types\Videos;
use Rosecrance\App\Posts\Types\Podcast;
use Rosecrance\App\Search\VirtualLocation;

/**
 * Define Theme Version
 * Define Theme directories
 */
define('THEME_VERSION', '1.0.2');
define('ROSECRANCE_THEME_DIR', trailingslashit(get_template_directory()));
define('ROSECRANCE_THEME_PATH_URL', trailingslashit(get_template_directory_uri()));

require __DIR__ . '/constants.php';

// Require Autoloader
require_once ROSECRANCE_THEME_DIR . 'vendor/autoload.php';

/**
 * Theme Setup
 */
add_action('after_setup_theme', function () {
    (new Init())
        ->add(new Setup())
        ->add(new Scripts())
        ->add(new Media())
        ->add(new Shortcodes())
        ->add(new LocationSearch())
        ->add(new RelationshipFilter())
        ->add(new LocationFilter())
        ->add(new ACF())
        ->add(new Options())
        ->add(new Modules())
        ->add(new SiteOptionsFieldGroup())
        ->add(new PageBuilderFieldGroup())
        ->add(new LocationsBuilderFieldGroup())
        ->add(new CustomPostTypeFieldGroups())
        ->add(new ProgramsAndServicesFieldGroup())
        ->add(new ResourceLibraryFieldGroup())
        ->add(new Conditions())
        ->add(new Locations())
        ->add(new Networks())
        ->add(new Programs())
        ->add(new Regions())
        ->add(new Services())
        ->add(new VirtualLocation())
        ->add(new ServiceLines())
        ->add(new StaffBios())
        ->add(new ExtendedArticle())
        ->add(new BlogPost())
        ->add(new NewsDetail())
        ->add(new DrugFactSheet())
        ->add(new Audience())
        ->add(new Videos())
        ->add(new Podcast())
        // ->add(new RegisterBlocks())
        ->initialize();

    // Translation setup
    load_theme_textdomain('rosecrance', ROSECRANCE_THEME_DIR . '/languages');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Add automatic feed links in header
    add_theme_support('automatic-feed-links');

    // Add Post Thumbnail Image sizes and support
    add_theme_support('post-thumbnails');

    // Switch default core markup to output valid HTML5.
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ]);
});

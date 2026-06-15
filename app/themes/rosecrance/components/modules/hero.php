<?php

/**
 * ACF Module: Hero
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

// common variables
$variant = ACF::getField('hero-variant', $data);
$heading = ACF::getField('heading', $data);
$primary_cta_options = ['class' => 'btn btn-primary hero__cta', 'icon-end' => 'arrow-right-dark'];
$secondary_cta_options = ['class' => 'btn btn-secondary hero__cta', 'icon-end' => 'arrow-right-white'];

$background_overlay_opacity = ACF::getField('background-opacity-overlay_opacity', $data);

do_action('rosecrance/modules/styles', $row_id, $data);

switch ($variant) {
    case HERO_VARIANTS['CONTENT_CONTAINER']:
        $file = locate_template("components/modules/content-container-hero.php");
        if (file_exists($file)) {
            $desktop_video_overlay_opacity = ACF::getField('content-container-hero-configuration_desktop-video-options_overlay-opacity', $data);
            $mobile_video_overlay_opacity = ACF::getField('content-container-hero-configuration_mobile-video-options_overlay-opacity', $data);
            include $file;
        }
        break;
    case HERO_VARIANTS['MEDIA']:
        $file = locate_template("components/modules/media-hero.php");
        if (file_exists($file)) {
            $desktop_video_overlay_opacity = ACF::getField('media-hero-configuration_desktop-video-options_overlay-opacity', $data);
            $mobile_video_overlay_opacity = ACF::getField('media-hero-configuration_mobile-video-options_overlay-opacity', $data);
            include $file;
        }
        break;
    case HERO_VARIANTS['LARGE']:
        $file = locate_template("components/modules/large-hero.php");
        if (file_exists($file)) {
            include $file;
        }
        break;
    case HERO_VARIANTS['HEADLINE']:
            $file = locate_template("components/modules/headline-hero.php");
            if (file_exists($file)) {
                include $file;
            }
            break;
    default:
        // should be an impossible case. Return early.
        echo '<!-- Hero module missing variant field -->';
        return;
}
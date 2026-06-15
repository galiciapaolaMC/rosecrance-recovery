<?php

/**
 * ACF Module: Resource Hero
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

// common variables
$variant = ACF::getField('hero-variant', $data);
$subhead = ACF::getField('subhead', $data);
$heading = ACF::getField('heading', $data);
$content = ACF::getField('content', $data);
$media_type = ACF::getField('media-type', $data, 'image');
$image_size = ACF::getField('image-size', $data, 'large');
$video_type = ACF::getField('video-configuration_type', $data, null);
$video_link = ACF::getField('video-configuration_video-link', $data, null);
$video_file_id = ACF::getfield('video-configuration_video-file', $data, null);

do_action('rosecrance/modules/styles', $row_id, $data);

switch ($variant) {
    case RESOURCE_HERO_VARIANTS['LARGE']:
        $file = locate_template("components/modules/large-resource-hero.php");
        if (file_exists($file)) {
            include $file;
        }
        break;
    case RESOURCE_HERO_VARIANTS['SHORT']:
        $file = locate_template("components/modules/short-resource-hero.php");
        if (file_exists($file)) {
            include $file;
        }
        break;
    default:
        // should be an impossible case. Return early.
        echo '<!-- Resource Hero module missing variant field -->';
        return;
}
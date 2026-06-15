<?php
/**
 * ACF Module Partial: ImageFiftyFifty
 *
 * @var array $data
 *
 * @var string $row_id
 *
 * @var string $cell_number
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Media;
use Rosecrance\App\Fields\Util;

$media_type = ACF::getField('media-type', $data, 'image');
$media_animation = ACF::getField('media-animation', $data, 'inactive');
$desktop_image_size = ACF::getField('desktop-image-size', $data, 'cover');
$mobile_image_size = ACF::getField('mobile-image-size', $data, 'cover');
$image_mobile = Media::getAttachmentSrcByID(ACF::getField('mobile-image', $data));
$image_desktop = Media::getAttachmentSrcByID(ACF::getField('desktop-image', $data));
$video_type = ACF::getField('video-type', $data, 'link');
$video_link = ACF::getField('video-link', $data);
$video_file_id = ACF::getField('video-file', $data);
$preview_image_id = ACF::getField('preview-image', $data);
$mobile_image_id = ACF::getField('mobile-image', $data);
$desktop_image_id = ACF::getField('desktop-image', $data);
$image_mobile_parallax = '';
$image_desktop_parallax = '';

$image_mobile_style = !empty($image_mobile) ? ' style="background-size: ' . esc_attr($mobile_image_size) . ';"' : ' style="background-size: ' . esc_attr($desktop_image_size) . ';"';
$image_desktop_style = !empty($image_desktop) ? ' style="background-size: ' . esc_attr($desktop_image_size) . ';"' : '';

if ($media_animation === 'active') {
    $image_mobile_parallax = ' uk-parallax="y: 50; target: #image-mobile-' . esc_attr($row_id) . '; "';
    $image_desktop_parallax = ' uk-parallax="y: -250; target: #image-desktop-' . esc_attr($row_id) . ';"';
}
?>

<div class="partial image-fifty-fifty">
    <div class="image-fifty-fifty__inside-wrap">
        <?php if ($media_type === 'image') { ?>
            <div id="image-mobile-<?php echo esc_attr($row_id); ?>" class="image-fifty-fifty__image-holder image-mobile uk-hidden@m" <?php echo $image_mobile_style; ?> id-mobile="<?php echo esc_attr($mobile_image_id); ?>-<?php echo esc_attr($row_id); ?>">
                <?php if (!empty($image_mobile)) { ?>
                    <div class="image-container" style="background-image: url(<?php echo esc_url($image_mobile); ?>);" <?php echo $image_mobile_parallax; ?> id-mobile="<?php echo esc_attr($mobile_image_id); ?>-<?php echo esc_attr($row_id); ?>"></div>
                <?php } else { ?> 
                    <div class="image-container" style="background-image: url(<?php echo esc_url($image_desktop); ?>);" <?php echo $image_mobile_parallax; ?> id-mobile="<?php echo esc_attr($desktop_image_id); ?>-<?php echo esc_attr($row_id); ?>"></div>
                <?php } ?>
            </div>
            <div id="image-desktop-<?php echo esc_attr($row_id); ?>" class="image-fifty-fifty__image-holder image-desktop uk-visible@m" <?php echo $image_desktop_style; ?> id-desktop="<?php echo esc_attr($desktop_image_id); ?>-<?php echo esc_attr($row_id); ?>">
                <div class="image-container" style="background-image: url(<?php echo esc_url($image_desktop); ?>);" <?php echo $image_desktop_parallax; ?> id-desktop="<?php echo esc_attr($desktop_image_id); ?>-<?php echo esc_attr($row_id); ?>"></div>
            </div>
        <?php } ?>

        <?php if ($media_type === 'video') { ?>
            <div class="video-fifty-fifty__container">
                <?php if ($video_type === 'link') { ?>
                    <iframe class="video-fifty-fifty__content" src="<?php echo esc_url($video_link); ?>"></iframe>
                <?php } else {
                    $attachment_video = Media::getAttachmentByID($video_file_id); 
                    $preview_image = '';

                    if (!empty($preview_image_id)) {
                        $preview_image_url = Media::getAttachmentByID($preview_image_id);  ?>

                        <video class="video-fifty-fifty__content video-file" src="<?php echo esc_url($attachment_video->url); ?>" poster="<?php echo esc_url($preview_image_url->url); ?>" playsinline type="video/mp4" uk-video="autoplay: false"></video>
                    <?php } else { ?> 
                        <video class="video-fifty-fifty__content video-file" src="<?php echo esc_url($attachment_video->url); ?>" playsinline type="video/mp4" uk-video="autoplay: false"></video>
                    <?php } ?> 

                    <button class="play-btn">
                        <svg class="icon icon-play" aria-hidden="true">
                            <use xlink:href="#icon-play"></use>
                        </svg> 
                    </button>

                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
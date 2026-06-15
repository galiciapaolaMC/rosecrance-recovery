<?php

/**
 * Video template file.
 */
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Media;

$post_id = get_the_ID();
$video_post = get_post($post_id);
$data = ACF::getPostMeta($post_id);

$video_type = ACF::getField('type', $data);
$video_link = ACF::getField('video-link', $data);
$video_file_id = ACF::getField('video-file', $data);
$preview_image_id = ACF::getField('preview-image', $data);

$description_text = ACF::getField('description', $data);

$subhead = __('VIDEO', 'rosecrance');
$video_name = ACF::getField('name', $data);
$post_title = isset( $video_post->post_title ) ? $video_post->post_title : '';
$heading = !empty($podcast_name) ? esc_html($podcast_name) : $post_title;

?>

<div id="primary">
    <article id="post-<?php the_ID(); ?>" class="video-post video-detail-page">
        <?php $file = locate_template("components/partials/go-back-button.php");
        if (file_exists($file)) {
            include $file;
        } ?>
        
        <section class="module resource-hero large-resource-hero">
            <div class="large-resource-hero__wrapper">
                <div class="large-resource-hero__content-wrapper">
                    <div class="large-resource-hero__section large-resource-hero__section--top">
                        <div class="uk-container uk-container-medium">  
                            <?php if (!is_null($subhead)) { ?>
                                <p class="large-resource-hero__eyebrow"><?php echo esc_html($subhead); ?> </p>
                            <?php } ?>

                            <h1 class="large-resource-hero__heading"><?php echo esc_html($heading)?></h1>

                            <?php if (!empty($description_text)) { ?>
                                <div class="large-resource-hero__content">
                                    <?php echo apply_filters('the_content', $description_text); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="large-resource-hero__section large-resource-hero__section--middle">
                        <?php 
                        if($video_type == 'link') { ?>
                            <div class="large-resource-hero__media-bg large-resource-hero__media-bg--video">
                                <iframe class="large-resource-hero__video large-resource-hero__video--iframe" src="<?php echo esc_url($video_link); ?>"></iframe>
                            </div>
                        <?php
                        } else if($video_type == 'file') {
                            $attachment_video = Media::getAttachmentByID($video_file_id); 
                        ?>  
                            <div class="large-resource-hero__media-bg large-resource-hero__media-bg--video">
                                <video class="large-resource-hero__video video-file" src="<?php echo esc_html($attachment_video->url); ?>" controls playsinline type="video/mp4" uk-video="autoplay: false"></video>
                            </div>
                        <?php
                        }  ?>
                    </div>
                </div>
            </div>
        </section>

        <?php
            // hook: App/Fields/Modules/outputFlexibleModules()
            do_action('rosecrance/modules/output', get_the_ID());
        ?>
    </article>
</div>
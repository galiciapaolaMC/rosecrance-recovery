<?php

/**
 * The template for displaying the footer.
 *
 * @package Rosecrance
 */


use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;

$options = Options::getSiteOptions();
$footer_logo = ACF::getField('footer-logo', $options);
$footer_logo_attachment = Media::getAttachmentByID($footer_logo);

// contact column
$addiction_phone_number = ACF::getField('contact-column_addiction-phone-number', $options);
$addiction_tel_link = 'tel:+' . esc_attr(preg_replace('/\D/', '', $addiction_phone_number));
$mental_health_phone_number = ACF::getField('contact-column_mental-health-phone-number', $options);
$mental_heatlh_tel_link = 'tel:+' . esc_attr(preg_replace('/\D/', '', $mental_health_phone_number));

$contact_page_link = ACF::getField('contact-column_contact-page-link', $options);
$addresses = ACF::getRowsLayout('contact-column_addresses', $options);
$media_contact_name = ACF::getField('contact-column_media-contact-name', $options);
$media_contact_title = ACF::getField('contact-column_media-contact-title', $options);
$media_contact_email = ACF::getField('contact-column_media-contact-email', $options);

// menu links column
$footer_links = ACF::getRowsLayout('links-column_links', $options);
// newsletter column
$privacy_policy_link = ACF::getField('newsletter-column_privacy-policy', $options, '');

// Badges
$rosecrance_network_badge = ACF::getField('badges_rosecrance-network-badge', $options, null);
$rosecrance_network_link = ACF::getField('badges_rosecrance-network-link', $options);
$rosecrance_network_html = null;
$rosecrance_network_attachment = Media::getAttachmentByID($rosecrance_network_badge);
if (!is_null($rosecrance_network_attachment)) {
    $rosecrance_network_html = Util::getImageHTML($rosecrance_network_attachment);
}
$trusted_partner_badge = ACF::getField('badges_trusted-partner-badge', $options, null);
$trusted_partner_link = ACF::getField('badges_trusted-partner-link', $options);
$trusted_partner_html = null;
$trusted_partner_attachment = Media::getAttachmentByID($trusted_partner_badge);
if (!is_null($trusted_partner_attachment)) {
    $trusted_partner_html = Util::getImageHTML($trusted_partner_attachment);
}
$elite_care_badge = ACF::getField('badges_elite-care-badge', $options, null);
$elite_care_link = ACF::getField('badges_elite-care-link', $options);
$elite_care_html = null;
$elite_care_attachment = Media::getAttachmentByID($elite_care_badge);
if (!is_null($elite_care_attachment)) {
    $elite_care_html = Util::getImageHTML($elite_care_attachment);
}

// Sub-footer
$subfooter_styles = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/footer-image.png);"';
$copyright = ACF::getField('sub-footer_copyright', $options);
$subfooter_links = ACF::getRowsLayout('sub-footer_subfooter-links', $options);

// Social Media Links
$facebook_link = ACF::getField('social-media_facebook-link', $options);
$instagram_link = ACF::getField('social-media_instagram-link', $options);
$x_link = ACF::getField('social-media_x-link', $options);
$youtube_link = ACF::getField('social-media_youtube-link', $options);
$linkedin_link = ACF::getField('social-media_linkedin-link', $options);

// Mobile Floating Button
$mobile_floating_button_text = ACF::getField('floating-mobile-button-text', $options);
$mobile_floating_button_phone_number = ACF::getField('floating-mobile-button-phone-number', $options);

$footer_scripts = ACF::getField('footer-scripts', $options);
?>

<footer class="footer" role="contentinfo">
    <div class="footer__container">
        <div class="footer__logo-column">
            <div class="footer__logo">
                <img src="<?php echo esc_url($footer_logo_attachment->url); ?>" alt="<?php echo esc_attr($footer_logo_attachment->alt); ?>" width="185" height="64" />
            </div>

            <?php if (!empty($addiction_tel_link)|| !empty($mental_heatlh_tel_link)) { ?>
                <div class="footer__contact-row">
                    <h3 class="footer-header"><?php _e('Contact Us', 'rosecrance'); ?></h3>
                    <p class="footer-body-copy"> <?php _e('Addiction & Mental Health Services', 'rosecrance'); ?> </p>
                    <?php if (!empty($addiction_tel_link)) { ?> <a class="footer-phone-number" href="<?php echo $addiction_tel_link ?>"><?php echo esc_html($addiction_phone_number); ?></a> <?php } ?>
                    <?php if (!empty($mental_heatlh_tel_link)) { ?> <a class="footer-phone-number"href="<?php echo $mental_heatlh_tel_link ?>"><?php echo esc_html($mental_health_phone_number); ?></a> <?php } ?>
                    <?php if (!empty($contact_page_link)) { echo Util::getButtonHTML($contact_page_link, ['class' => 'btn btn-white footer-link footer__contact-link', 'icon-end' => 'arrow-right-dark']); } ?>
                </div>
            <?php } ?>
        </div>
        <div class="footer__columns">
            <div class="footer__column footer__contact-column">
                <?php if (!empty($addiction_tel_link)|| !empty($mental_heatlh_tel_link)) { ?>
                    <div class="footer__contact_us">
                        <h3 class="footer-header"><?php _e('Contact Us', 'rosecrance'); ?></h3>
                        <p class="footer-body-copy"> <?php _e('Addiction & Mental Health Services', 'rosecrance'); ?> </p>
                        <?php if (!empty($addiction_tel_link)) { ?> <a class="footer-phone-number" href="<?php echo $addiction_tel_link ?>"><?php echo esc_html($addiction_phone_number); ?></a> <?php } ?>
                        <?php if (!empty($mental_heatlh_tel_link)) { ?> <a class="footer-phone-number"href="<?php echo $mental_heatlh_tel_link ?>"><?php echo esc_html($mental_health_phone_number); ?></a> <?php } ?>
                        <?php if (!empty($contact_page_link)) { echo Util::getButtonHTML($contact_page_link, ['class' => 'btn btn-white footer-link footer__contact-link', 'icon-end' => 'arrow-right-dark']); } ?>
                    </div>
                <?php } ?>

                <?php if (!empty($addresses)) { ?>
                <div class="footer__contact-row">
                    <h3 class="footer-header"><?php _e('Corporate Locations', 'rosecrance'); ?></h3>

                    <?php foreach ($addresses as $address) { 
                        $address_row = ACF::getField('address', $address); 
                        $directions_link = ACF::getField('directions-link', $address); ?>
                        <div class="footer__address">
                            <a href="<?php echo esc_url($directions_link['url']); ?>" target="_blank">
                                <?php echo apply_filters('the_content', $address_row);?>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php if (!empty($media_contact_name)) { ?>
                    <div class="footer__contact-row">
                        <h3 class="footer-header"><?php _e('Media Contact', 'rosecrance'); ?></h3>
                        <p class="footer-body-copy"> <?php echo esc_html($media_contact_name); ?> </p>
                        <?php if (!empty($media_contact_title)) { ?><p class="footer-body-copy"> <?php echo esc_html($media_contact_title); ?> </p><?php } ?>
                        <?php if (!empty($media_contact_email)) { ?><a class="footer-email" href="mailto:<?php echo esc_html($media_contact_email); ?>"> <?php echo esc_html($media_contact_email); ?> </a><?php } ?>
                    </div>
                <?php } ?>
            </div>
            <?php if(!empty($footer_links)) { ?>
            <div class="footer__column footer__links-column">
                <?php foreach ($footer_links as $footer_link) { 
                    $link = ACF::getField('link', $footer_link);
    
                    echo Util::getButtonHTML($link, ['class' => 'btn btn-white footer-link footer__page-link', 'icon-end' => 'arrow-right-dark']);    
                } ?>
            </div>
            <?php } ?>
            <div class="footer__column footer__newsletter-column">
                <div class="footer__badges">
                    <a class="footer__badge" href="<?php if(isset($rosecrance_network_link)) { echo   $rosecrance_network_link['url']; } ?>"><?php echo $rosecrance_network_html; ?></a>
                    <a class="footer__badge" href="<?php if(isset($trusted_partner_link)) { echo  $trusted_partner_link['url']; } ?>"><?php echo $trusted_partner_html; ?></a>

                    <?php if (!empty($elite_care_link['url'])) { ?>
                        <a class="footer__badge" href="<?php if(isset($elite_care_link)) { echo  $elite_care_link['url']; } ?>"><?php echo $elite_care_html; ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    
</footer>
<div class="sub-footer" <?php echo $subfooter_styles; ?>>
    <div class="sub-footer__container">
        <nav class="sub-footer__menu">
                <?php foreach ($subfooter_links as $subfooter_link) { 
                    $link = ACF::getField('link', $subfooter_link);

                    echo '<a href="' . $link['url'] . '">' . $link['title'] . '</a>';    
                } ?>
        </nav>
        <?php if(!empty($copyright)) { ?>
            <div class="sub-footer__copyright">
                <?php echo esc_html($copyright); ?>
            </div>
        <?php } ?>
        <div class="sub-footer__social-media">
            <?php if (!empty($facebook_link)) { 
                $facebook_url = esc_attr($facebook_link['url']);    
            ?>
                <a href="<?php echo $facebook_url ?>" aria-label="<?php _e('Facebook', 'rosecrance'); ?>" target="_blank"><?php echo Util::getIconHTML('facebook-neutral'); ?></a>
            <?php } ?>
            <?php if (!empty($instagram_link)) { 
                $instagram_url = esc_attr($instagram_link['url']);    
            ?>
                <a href="<?php echo $instagram_url ?>" aria-label="<?php _e('Instagram', 'rosecrance'); ?>" target="_blank"><?php echo Util::getIconHTML('instagram-neutral'); ?></a>
            <?php } ?>
            <?php if (!empty($x_link)) { 
                $twitter_url = esc_attr($x_link['url']);    
            ?>
                <a href="<?php echo $twitter_url ?>" aria-label="<?php _e('Twitter', 'rosecrance'); ?>" target="_blank"><?php echo Util::getIconHTML('x-neutral'); ?></a>
            <?php } ?>
            <?php if (!empty($youtube_link)) { 
                $youtube_url = esc_attr($youtube_link['url']);    
            ?>
                <a href="<?php echo $youtube_url ?>" aria-label="<?php _e('YouTube', 'rosecrance'); ?>" target="_blank"><?php echo Util::getIconHTML('youtube-neutral'); ?></a>
            <?php } ?>
            <?php if (!empty($linkedin_link)) { 
                $linkedin_url = esc_attr($linkedin_link['url']);    
            ?>
                <a href="<?php echo $linkedin_url ?>" aria-label="<?php _e('LinkedIn', 'rosecrance'); ?>" target="_blank"><?php echo Util::getIconHTML('linkedin-neutral'); ?></a>
            <?php } ?>
        </div>
    </div>
</div>
<?php if (!empty($mobile_floating_button_text) && !empty($mobile_floating_button_phone_number)) { ?>
    <a href="<?php echo 'tel:' . esc_attr(preg_replace('/\D/', '', $mobile_floating_button_phone_number)); ?>" class="mobile-floating-button">
        <?php echo esc_html($mobile_floating_button_text); ?>
    </div>
<?php } ?>
<?php 
wp_footer(); 

echo $footer_scripts;
?>

</body>

</html>
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
$footer_logo_html = null;
if (!is_null($footer_logo_attachment)) {
    $footer_logo_html = Util::getImageHTML($footer_logo_attachment);
}

$center_logo = ACF::getField('center-logo', $options);
$center_logo_attachment = Media::getAttachmentByID($center_logo);
$center_logo_html = null;
if (!is_null($center_logo_attachment)) {
    $center_logo_html = Util::getImageHTML($center_logo_attachment);
}

$address = ACF::getField('address', $options);
$footer_scripts = ACF::getField('footer-scripts', $options);
?>

<footer class="footer" role="contentinfo">
    <div class="uk-container">
        <div class="uk-grid uk-grid-large uk-child-width-1-3@m uk-child-width-1-2" uk-grid>
            <div>
                <div class="footer__logo-column">
                    <div class="footer__logo">
                        <?php echo $footer_logo_html; ?>
                    </div>
                </div>
            </div>

            <div>
                <div class="footer__logo-column">
                    <div class="footer__logo-center">
                        <?php echo $center_logo_html; ?>
                    </div>
                </div>
            </div>

            <div class="uk-width-1-3@m uk-width-1-1">
                <div class="footer__address">
                    <p><?php echo $address; ?></p>
                </div>

                <div class="footer__copyright">
                    <p><?php _e('© '.date('Y').' Rosecrance. All rights reserved.', 'rosecrance'); ?></p>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php 
wp_footer(); 

echo $footer_scripts;
?>

</body>

</html>
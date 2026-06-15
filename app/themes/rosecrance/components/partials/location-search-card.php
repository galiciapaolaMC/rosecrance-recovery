<?php

/**
 * ACF Module: Location Search Card
 *
 * @global WP_Post $card
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$data_similar = ACF::getPostMeta($card);
$location_name = get_the_title($card);
$permalink = get_the_permalink($card);
$regions = ACF::getField('regions_related-regions', $data_similar);
$address = ACF::getField('address', $data_similar);
$phone_number = ACF::getField('main-phone-number', $data_similar);
$additional_text = ACF::getField('additional-text', $data_similar);
$directions_link = "https://www.google.com/maps/dir/current+location/" . urlencode(esc_html($address));
?>

<div class="featured-location">
    <div class="location-wrapper">
        <?php if (!empty($regions)) {
            foreach ($regions as $region) {
                $region_name = get_the_title($region); ?>
                
                <p class="region-name"><?php echo esc_html($region_name); ?></p>
            <?php }
        } ?>
        <h2><?php echo esc_html($location_name); ?></h2>
        
        <div class="location-details">
            <?php if (!empty($additional_text)) { ?>
                <p><?php echo esc_html($additional_text); ?></p>
            <?php } ?>
            
            <?php if ($address) { ?>
                <p><?php echo esc_html($address); ?></p>

                <a class="location-details__directions-link" target="_blank" href="<?php echo $directions_link; ?>">
                    <?php _e('Directions', 'rosecrance'); ?>
                </a>
            <?php } ?>

            <?php if (!empty($phone_number)) { ?>
                <a href="<?php echo esc_url($phone_number['url']); ?>"><?php echo esc_html($phone_number['title']); ?></a>
            <?php } ?>
        </div>
        
        <a href="<?php echo esc_url($permalink); ?>" class="btn btn-primary">
            <?php _e('Location Detail', 'rosecrance');
            echo Util::getIconHTML('arrow-right-dark'); ?> 
        </a>
    </div>
</div>
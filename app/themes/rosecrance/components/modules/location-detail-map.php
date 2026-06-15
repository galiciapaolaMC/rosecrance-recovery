<?php

/**
 * ACF Module: Location Detail Map
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\Util;

$data_similar = ACF::getPostMeta(get_the_ID());
$address = ACF::getField('address', $data_similar);
$main_phone_number = ACF::getField('main-phone-number', $data_similar);
$latitude  = ACF::getField('latitude', $data_similar);
$longitude = ACF::getField('longitude', $data_similar);

$phone_numbers = ACF::getRowsLayout('phone-numbers', $data);
$service_hours = ACF::getRowsLayout('service-hours', $data);

$options = Options::getSiteOptions();
$maps_api_key = ACF::getField('google-api-key', $options);
$maps_map_id = ACF::getField('google-map-id', $options);

wp_localize_script(
    'rosecrance-theme',
    'location_map',
    [
        'maps_api_key' => esc_html($maps_api_key),
        'maps_map_id' => esc_html($maps_map_id)
    ]
);

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module location-detail-map" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container uk-container-medium">
        <div class="uk-grid uk-grid-medium" uk-grid>
            <div class="uk-width-2-5@m uk-width-1-1@s">
                <h2 class="location-detail-map__headline"><?php _e('Where to find us', 'rosecrance'); ?></h2>

                <div class="location-detail-map__address">
                    <h3><?php _e('Address', 'rosecrance'); ?></h3>
                    <?php echo esc_html($address); ?>
                </div>

                <?php if (!empty($main_phone_number)) { ?>
                    <div class="location-detail-map__phone-numbers">
                        <h3><?php _e('Phone', 'rosecrance'); ?></h3>

                        <a href="<?php echo esc_url($main_phone_number['url']); ?>"><?php echo esc_html($main_phone_number['title']); ?></a>

                        <?php if (!empty($phone_numbers)) {
                        foreach ($phone_numbers as $item) { 
                            $phone_number = ACF::getField('phone', $item); ?>
                            
                            <a href="<?php echo esc_url($phone_number['url']); ?>"><?php echo esc_html($phone_number['title']); ?></a>
                        <?php } 
                        } ?>
                    </div>
                <?php } ?>

                <?php if (!empty($service_hours)) { ?>
                    <div class="location-detail-map__service-hours">
                        <h3><?php _e('Hours', 'rosecrance'); ?></h3>

                        <?php foreach ($service_hours as $item) { 
                            $service_hour = ACF::getField('service-hour', $item); ?>
                            
                            <p><?php echo esc_html($service_hour); ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <div class="uk-width-3-5@m uk-width-1-1@s">
                <div class="location-detail-map__map" id="map-wrapper">
                    <div id="map"></div>
                    <input type="hidden" class="map__latitude" value="<?php echo esc_attr($latitude); ?>">
                    <input type="hidden" class="map__longitude" value="<?php echo esc_attr($longitude); ?>">
                </div>
            </div>
        </div>
    </div>
</section>
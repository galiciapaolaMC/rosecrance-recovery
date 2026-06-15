<?php

/**
 * ACF Module: Location Search
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\Util;

$activate_search = ACF::getField('activate-search', $data);
$headline = ACF::getField('headline', $data);
$view_programs = ACF::getField('programs_related-programs', $data);
$view_services = ACF::getField('services_included-services', $data);

if ($activate_search === 'false' || empty($headline)) {
    return;
}

$options = Options::getSiteOptions();
$maps_api_key = ACF::getField('google-api-key', $options);
$maps_map_id = ACF::getField('google-map-id', $options);
$zipcode_api_key = ACF::getField('zipcode-api-key', $options);

wp_localize_script(
    'rosecrance-theme',
    'location_map',
    [
        'maps_api_key' => esc_html($maps_api_key),
        'maps_map_id' => esc_html($maps_map_id),
        'zipcode_api_key' => esc_html($zipcode_api_key),
        'localized_directions' => __('Directions', 'rosecrance'),
        'localized_location_details' => __('Location Detail', 'rosecrance'),
        'no_results' => __('No results', 'rosecrance'),
        'no_results_zipcode' => __('No locations found near you. Please try filtering by "All Regions" instead.', 'rosecrance'),
        'arrow_right_dark' => Util::getIconHTML('arrow-right-dark'),
    ]
);

$view_programs_list = '';
$view_services_list = '';

if (!empty($view_programs)) {
    foreach($view_programs as $program) {
        $view_programs_list .= $program . ',';
    }
}

if (!empty($view_services)) {
    foreach($view_services as $service) {
        $view_services_list .= $service . ',';
    }
}

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module location-search" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container uk-container-medium">
        <div class="location-search__headline">
            <h1><?php echo esc_html($headline); ?></h1>
        </div>

        <div class="location-search__search-wrapper">
            <div class="search-form">
                <div class="filter-controls">
                    <label class="filter-controls__location-mode-toggle toggle-switch toggle-switch--neutral" data-toggle-name="location-mode">
                        <span class="toggle-switch__label-container">
                            <?php _e('ZIP Code', 'rosecrance'); ?>
                        </span>
                        <div class="toggle-switch__switch-container">
                            <input class="toggle-switch__checkbox" type="checkbox" data-field-type="toggle" name="location-mode" />
                            <span class="toggle-switch__slider"></span>
                        </div>
                        <span class="toggle-switch__label-container">
                            <?php _e('Region', 'rosecrance'); ?>
                        </span>
                    </label>
                    <button class="filter-controls__clear-btn" id="clear-filter">
                        <?php _e('Clear filters'); ?>
                    </button>
                </div>

                <div class="controls-container uk-grid uk-grid-small uk-child-width-1-4@m uk-flex-center@m" uk-grid>

                    <div class="control-container zipcode-control-container">
                        <p class="control-container__label"><?php _e('Zip Code', 'rosecrance'); ?></p>

                        <div class="control-container__input">
                            <input type="text" name="filter_zipcode" class="location-search__zipcode-filter filter-input" placeholder="<?php esc_attr_e('Enter a zip code', 'rosecrance'); ?>" />
                        </div>
                    </div>

                    <div class="control-container region-control-container">
                        <?php                                 
                        do_action('rosecrance/region-filter/output'); ?>

                    </div>

                    <div class="control-container program-control-container">
                        <?php                                 
                            do_action('rosecrance/program-filter/output'); ?>
                    </div>

                    <div class="control-container service-control-container">
                    <?php                                 
                            do_action('rosecrance/service-filter/output'); ?>
                    </div>
                    <div class="control-container submit-control-container">
                        <button class="btn btn-secondary" id="search-location">
                            <?php _e('Search'); ?>
                            
                            <svg class="icon icon-arrow-right-white" aria-hidden="true">
                                <use xlink:href="#icon-arrow-right-white"></use>
                            </svg> 
                        </button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="location-search__map-wrapper">
        <div class="uk-container uk-container-medium">
            <p class="location-search__results-count"></p>
        </div>

        <div class="uk-container uk-container-large uk-padding-remove">
            <div class="location-search__results-container">
                <div class="uk-grid uk-grid-small" uk-grid>
                    <div class="list-wrapper uk-width-1-3@m">
                        <div class="list-result">
                            <div class="list-result__virtual-locations" id="virtual-locations">
                                <?php do_action('rosecrance/virtual-locations/output', 'locations', 'virtual'); ?>
                            </div>

                            <div id="location-list">
                            </div>
                            <div class="list-result__no-results">
                                <p><?php _e('No results', 'rosecrance'); ?></p>
                                <button class="btn btn-primary" id="toggle-regions">
                                    <?php _e('Show All Regions', 'rosecrance'); ?>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="uk-width-2-3@m">
                        <div class="location-search__map" id="map-results"></div>
                        <div id="address_current"></div>
                        <div id="address_new"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($view_programs_list)) {
            $view_programs_list = rtrim($view_programs_list, ','); ?>

            <input type="hidden" name="programs_list" value="<?php echo esc_attr($view_programs_list); ?>" />
        <?php } ?>

        <?php if (!empty($view_services_list)) {
            $view_services_list = rtrim($view_services_list, ','); ?>

            <input type="hidden" name="services_list" value="<?php echo esc_attr($view_services_list); ?>" />
        <?php } ?>
    </div>
</section>
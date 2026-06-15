<?php

/**
 * ACF Module: Treatment Locator
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$post_id = get_the_ID();
$post = get_post($post_id);
$post_slug = null;
$post_type = null;
if (!empty($post)) {
    $post_slug = $post->post_name;
    $post_type = $post->post_type;
}

$options = Options::getSiteOptions();
$activate = ACF::getField('treatment-locator', $data);
$headline = ACF::getField('headline', $options);
$headline_type = ACF::getField('headline-type', $options);
$zip_code_text = ACF::getField('zip-code-field-text', $options);
$insurance_text = ACF::getField('insurance-field-text', $options);
$button_text = ACF::getField('button-text', $options);
$location_link = ACF::getField('location-link', $options);
$additional_information = ACF::getField('additional-information', $options);
$modal_content = ACF::getField('modal-content', $options);

if (!empty($location_link)) {
    $link_url = $location_link['url'];
}

if ($activate === 'inactive') {
    return;
}

$args = array(
    'post_type' => 'regions',
    'post_status' => 'publish',
    'numberposts' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
);
$query = new \WP_Query($args);

$regions = array();
$regions[''] = __('All Regions', 'rosecrance');
foreach ($query->posts as $region) {
    $regions[$region->ID] = $region->post_title;
}

$insurance_providers = array(
    __('Employer', 'employer', 'rosecrance'),
    __('State/Marketplace', 'state-marketplace', 'rosecrance'),
    __('Medicaid', 'medicaid', 'rosecrance'),
    __('Medicare', 'medicare', 'rosecrance'),
    __('Self-Pay', 'self-pay', 'rosecrance'),
    __('None', 'none', 'rosecrance')
);

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section data-link-url="<?php echo esc_html($link_url); ?>" class="module treatment-locator" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container uk-container-large">
        <div class="treatment-locator__container">
            <div class="treatment-locator__headline">
                <div class="treatment-locator__headline-container" uk-sticky>
                    <?php if (!empty($headline)) {
                        echo nl2br(Util::getHTML(
                            $headline,
                            $headline_type,
                            ['class' => 'treatment-locator__headline-title']
                        ));
                    }
                    ?>
                </div>
            </div>
            <div class="treatment-locator__toggle">
                <label class="location-mode-toggle toggle-switch toggle-switch--neutral" data-toggle-name="location-mode">
                    <span class="toggle-switch__label-container">
                        <?php _e('ZIP Code', 'rosecrance'); ?>
                    </span>
                    <div class="toggle-switch__switch-container">
                        <input class="toggle-switch__checkbox" type="checkbox" data-field-type="toggle" name="location-mode-toggle" />
                        <span class="toggle-switch__slider"></span>
                    </div>
                    <span class="toggle-switch__label-container">
                        <?php _e('Region', 'rosecrance'); ?>
                    </span>
                </label>
            </div>

            <div class="treatment-locator__form">
                    <div class="uk-grid uk-grid-small" uk-grid>
                        <div class="uk-width-4-5@m uk-width-1-1@s">
                            <div class="uk-grid uk-grid-small" uk-grid>
                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                
                                    <?php if ($post_type === 'programs') { ?>
                                        <input type="hidden" name="post-id" data-post-type="program" value="<?php echo esc_attr($post_id); ?>" />
                                    <?php } ?>
                                    <?php if ($post_type === 'services') { ?>
                                        <input type="hidden" name="post-id" data-post-type="service" value="<?php echo esc_attr($post_id); ?>" />
                                    <?php } ?>
                                    <input type="hidden" name="location-mode" value="zip-code" />
                                    <div class="treatment-locator__region-container">                          
                                        <?php do_action('rosecrance/region-filter/output', 'All Regions', 'Enter your region'); ?>
                                    </div>
                                    <div class="treatment-locator__zip-code-container">
                                        <?php if (!empty($zip_code_text)) {
                                            echo nl2br(Util::getHTML(
                                                $zip_code_text,
                                                'label',
                                                ['class' => 'treatment-locator__label']
                                            ));
                                        } else {
                                            echo nl2br(Util::getHTML(
                                                __('Enter your Zip Code', 'rosecrance'),
                                                'label',
                                                ['class' => 'treatment-locator__label']
                                            ));
                                        } ?>
                                        <input class="treatment-locator__zip-code-field" aria-label="<?php _e('Enter your Zip Code', 'rosecrance'); ?>" type="text" name="zip-code" />

                                    </div>

                                    <div class="treatment-locator__additional-information">
                                        <?php if (!empty($additional_information)) { ?>
                                            <p class="treatment-locator__additional-information-text">
                                                <?php echo Util::getIconHTML('info');
                                                echo esc_html($additional_information); ?>
                                            </p>

                                            <div class="treatment-locator__additional-information-tooltip">
                                                <div class="tooltip-container">
                                                    <button class="tooltip-container__close" data-tooltip-close-btn>
                                                        <?php echo Util::getIconHTML('close'); ?>
                                                    </button>
                                                    <?php echo apply_filters('the_content', $modal_content); ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="uk-width-1-2@m uk-width-1-1@s">
                                    <?php if (!empty($insurance_text)) {
                                        echo nl2br(Util::getHTML(
                                            $insurance_text,
                                            'label',
                                            ['class' => 'treatment-locator__label']
                                        ));
                                    } else {
                                        echo nl2br(Util::getHTML(
                                            __('Enter your insurance provider', 'rosecrance'),
                                            'label',
                                            ['class' => 'treatment-locator__label']
                                        ));
                                    } ?>

                                    <?php echo Util::getSelectFieldHtml('insurance-provider', '', $insurance_providers, null, false, false, true); ?>
                                </div>
                            </div>
                        </div>

                        <div class="uk-width-1-5@m uk-width-1-1@s">
                            <button class="treatment-locator__submit btn btn-secondary" type="submit">
                                <?php echo esc_html($button_text); 
                                echo Util::getIconHTML('arrow-right-white'); ?>
                            </button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>
<?php

/**
 * ACF Module: Salesforce Form
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\Options;
use Rosecrance\App\Fields\ACF;

$options = Options::getSiteOptions();
$salesforce_instance_url = ACF::getField('salesforce-instance-info_salesforce-instance-url', $options, 'https://test.salesforce.com');
$email_optin_disclaimer = ACF::getField('disclaimer-email-opt-in-disclaimer-text', $options);
$sms_optin_disclaimer = ACF::getField('disclaimer-sms-opt-in-disclaimer-text', $options);
$form_type = ACF::getField('form-type', $data);
$form_title = ACF::getField('title', $data);
$pre_form_content = ACF::getField('pre-form-content', $data);
$return_url = ACF::getField('return-url', $data, array('url' => 'https://www.rosecrance.org/'));
$return_url = $return_url['url'];
$salesforce_org_id = ACF::getField('salesforce-instance-info_salesforce-org-id', $options, '00DDy0000002LzC');
$google_recaptcha_site_key = ACF::getField('google-recaptcha-info_site-key', $options);
$utm_source = $_GET['Source'] ?? '';
$utm_medium = $_GET['Medium'] ?? '';
$utm_campaign = $_GET['Campaign'] ?? '';
$utm_content = $_GET['Content'] ?? '';

// localize script
wp_localize_script(
    'rosecrance-theme',
    'validationErrors',
    [
        'requiredField' => __('This field is required.', 'rosecrance'),
        'invalidEmail' => __('Please enter a valid email', 'rosecrance'),
        'invalidPhone' => __('Required Format: xxx-xxx-xxxx', 'rosecrance'),
    ]
);

do_action('rosecrance/modules/styles', $row_id, $data);
?>

<section class="module salesforce-form-container" id="<?php echo esc_html($row_id); ?>">
<div class="salesforce-form__heading-container">
    <h2><?php echo esc_html($form_title); ?></h2>
    <div class="salesforce-form__pre-form-content">
        <?php echo apply_filters('the_content', $pre_form_content); ?>
    </div>
</div>
<?php
    switch ($form_type) {
        case SALESFORCE_REFERRAL_FORM_GROUP:
            $file = locate_template(SALESFORCE_FORM_VARIANTS[SALESFORCE_REFERRAL_FORM_GROUP]);
            if (file_exists($file)) {
                include $file;
            }
            break;
        case SALESFORCE_PROFESSIONAL_REFERRAL_FORM:
            $file = locate_template(SALESFORCE_FORM_VARIANTS[SALESFORCE_PROFESSIONAL_REFERRAL_FORM]);
            if (file_exists($file)) {
                include $file;
            }
            break;
        case SALESFORCE_ALUMNI_FORM:
            $file = locate_template(SALESFORCE_FORM_VARIANTS[SALESFORCE_ALUMNI_FORM]);
            if (file_exists($file)) {
                include $file;
            }
            break;
        case SALESFORCE_MEDIA_FORM:
            $file = locate_template(SALESFORCE_FORM_VARIANTS[SALESFORCE_MEDIA_FORM]);
            if (file_exists($file)) {
                include $file;
            }
            break;
        case SALESFORCE_DONATION_FORM:
            $file = locate_template(SALESFORCE_FORM_VARIANTS[SALESFORCE_DONATION_FORM]);
            if (file_exists($file)) {
                include $file;
            }
            break;
        case SALESFORCE_WYSIWYG_FORM:
            $form_wysiqyg = ACF::getField('wysiwyg-form', $data);
            $url_parameter_name = ACF::getField('url-parameter-name', $data);
            $url_parameter_value = ACF::getField('url-parameter-value', $data);
            echo apply_filters('the_content', $form_wysiqyg);

            if (!empty($url_parameter_name) && !empty($url_parameter_value)) {
                echo '<input type="hidden" class="url-parameter" name="url_parameter" data-name="'.esc_attr($url_parameter_name).'" data-value="'.esc_attr($url_parameter_value).'">';
            }
        default:
            // should be an impossible case. Return early.
            echo '<!-- Salesforce Form module is missing the selected form: '. $form_type .' -->';
            return;
    }

?>
</section>
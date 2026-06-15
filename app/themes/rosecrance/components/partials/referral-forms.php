<?php 
use Rosecrance\App\Fields\ACF;
?>
<div class="referral-forms-container" data-form-group>
  <label>
    <div> <?php _e('I am...', 'rosecrance'); ?> </div>
    <select  class="referral-forms-container__referral-type" name="referral-type" title="Referral Type" data-referral-swap>
      <option value="<?php echo esc_attr(SALESFORCE_SELF_REFERRAL_FORM); ?>"><?php _e('A New Patient', 'rosecrance'); ?></option>
      <option value="<?php echo esc_attr(SALESFORCE_SELF_REFERRAL_EXISTING_FORM); ?>"><?php _e('An Existing Patient', 'rosecrance'); ?></option>
      <option value="<?php echo esc_attr(SALESFORCE_FRIEND_FAMILY_REFERRAL_FORM); ?>"><?php _e('Referring a Loved One', 'rosecrance'); ?></option>
      <option value="<?php echo esc_attr(SALESFORCE_PROFESSIONAL_REFERRAL_FORM); ?>"><?php _e('A Professional Referring an Individual', 'rosecrance'); ?></option>   
    </select>
  </label>

  <?php
    $self_referral_form = locate_template(SALESFORCE_FORM_VARIANTS[SALESFORCE_SELF_REFERRAL_FORM]);
    if (file_exists($self_referral_form)) {
      $return_url = ACF::getField('new-patient-return-url', $data, array('url' => 'https://www.rosecrance.org/'));
      $return_url = $return_url['url'];
      include $self_referral_form;
    }
    $self_referral_existing_form = locate_template(SALESFORCE_FORM_VARIANTS[SALESFORCE_SELF_REFERRAL_EXISTING_FORM]);
    if (file_exists($self_referral_existing_form)) {
      $return_url = ACF::getField('existing-patient-return-url', $data, array('url' => 'https://www.rosecrance.org/'));
      $return_url = $return_url['url'];
      include $self_referral_existing_form;
    }
    $friend_and_family_referral_form = locate_template(SALESFORCE_FORM_VARIANTS[SALESFORCE_FRIEND_FAMILY_REFERRAL_FORM]);
    if (file_exists($friend_and_family_referral_form)) {
      $return_url = ACF::getField('friends-and-family-return-url', $data, array('url' => 'https://www.rosecrance.org/'));
      $return_url = $return_url['url'];
      include $friend_and_family_referral_form;
    }
    $professional_referral_form = locate_template(SALESFORCE_FORM_VARIANTS[SALESFORCE_PROFESSIONAL_REFERRAL_FORM]);
    if (file_exists($professional_referral_form)) {
      $return_url = ACF::getField('professional-return-url', $data, array('url' => 'https://www.rosecrance.org/'));
      $return_url = $return_url['url'];
      include $professional_referral_form;
    }

  ?>
</div>
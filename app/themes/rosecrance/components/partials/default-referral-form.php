<?php

?>

<form class="salesforce-form salesforce-form--default-referral" data-form-type="<?php echo esc_attr(SALESFORCE_DEFAULT_REFERRAL_FORM)?>" action="https://test.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8&orgId=<?php echo esc_attr($salesforce_org_id)?>" method="POST" data-form-type="<?php echo esc_html(SALESFORCE_DEFAULT_REFERRAL_FORM); ?>">
  <input type=hidden name="oid" value="<?php echo esc_attr($salesforce_org_id)?>">
  <input type=hidden name="retURL" value="<?php echo esc_attr($return_url)?>">

  <label class="full-width-field">
    <div> <?php _e('Patient Type', 'rosecrance'); ?><span class="required">*</span> </div>
    <select id="00NVt000000o5oH" name="00NVt000000o5oH" title="Category" required>
      <option value="" disabled selected></option>
      <option value="New patient"><?php _e('New patient', 'rosecrance');'' ?></option>
      <option value="Existing patient"><?php _e('Existing patient', 'rosecrance'); ?></option>
      <option value="Referring a loved one"><?php _e('Referring a loved one', 'rosecrance'); ?></option>
      <option value="Professional referring an individual"><?php _e('Professional referring an individual', 'rosecrance'); ?></option>
    </select>
  </label>
  <label>
      <div> <?php _e('First Name', 'rosecrance'); ?><span class="required">*</span></div>
      <input id="first_name" maxlength="40" name="first_name" size="20" type="text" required/>
  </label>
  <label>
      <div> <?php _e('Last Name', 'rosecrance'); ?><span class="required">*</span></div>
      <input id="last_name" maxlength="80" name="last_name" size="20" type="text" required/>
  </label>
  <label>
      <div> <?php _e('Email', 'rosecrance'); ?><span class="required">*</span></div>
      <input id="email" maxlength="80" name="email" size="20" type="text" required/>
  </label>
  <label>
      <div> <?php _e('Mobile', 'rosecrance'); ?><span class="required">*</span></div>
      <input id="mobile" maxlength="40" name="mobile" size="20" type="tel" placeholder="xxx-xxx-xxxx" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required/>
  </label>

  <label>
      <div> <?php _e('Insurance Type', 'rosecrance'); ?><span class="required">*</span></div>
      <select id="00NVt000000o5oLMAQ" name="00NVt000000o5oLMAQ" title="Insurance Type" required>
          <option value="" disabled></option>
          <option value="Employer"><?php _e('Employer', 'rosecrance'); ?></option>
          <option value="State/Marketplace"><?php _e('State/Marketplace', 'rosecrance'); ?></option>
          <option value="Medicaid"><?php _e('Medicaid', 'rosecrance'); ?></option>
          <option value="Medicare"><?php _e('Medicare', 'rosecrance'); ?></option>
          <option value="Self-Pay"><?php _e('Self-Pay', 'rosecrance'); ?></option>
          <option value="None"><?php _e('None', 'rosecrance'); ?></option>
      </select>
  </label>
  <label>
    <div> <?php _e('Age Stage', 'rosecrance'); ?><span class="required">*</span>  </div>
    <select  id="00NVt000000o5oN" name="00NVt000000o5oN" title="Life Stage" required>
      <option value="" disabled selected></option>
      <option value="Youth"><?php _e('Youth', 'rosecrance'); ?></option>
      <option value="Adolescent"><?php _e('Adolescent', 'rosecrance'); ?></option>
      <option value="Adult"><?php _e('Adult', 'rosecrance'); ?></option>
    </select>
  </label>
  <label>
    <div> <?php _e('Seeking Help for', 'rosecrance'); ?><span class="required">*</span>  </div>
    <select id="00NVt000000o5oKMAQ" name="00NVt000000o5oKMAQ" title="Help Reason" required>
      <option value="" disabled selected></option>
      <option value="Addiction/Substance Use"><?php _e('Addiction/Substance Use', 'rosecrance'); ?></option>
      <option value="Mental Health"><?php _e('Mental Health' , 'rosecrance'); ?></option>
      <option value="Addiction/Substance Use & Mental Health"><?php _e('Addiction/Substance Use & Mental Health' , 'rosecrance'); ?></option>
      <option value="TMS Therapy"><?php _e('TMS Therapy' , 'rosecrance'); ?></option>
    </select>
  </label>
  <label class="full-width-field">
    <div> <?php _e('Additional Details', 'rosecrance'); ?><span class="required">*</span></div>
    <textarea name="description" required></textarea>
  </label>

  <div class="salesforce-form__opt-in-section">
      <label>
        <input  id="00NDy0000039dcT" name="00NDy0000039dcT" type="checkbox" value="1" required />
        <div> <?php _e('SMS Opt In', 'rosecrance'); ?></div>
      </label>
      <p class="disclaimer-text">
        <?php _e('By providing your mobile number and checking this box, you are consenting to receive SMS (text) messages from Rosecrance Health Network. Text #### to ##### for help, and text #### to ##### to stop. Message and data rates may apply. Message frequency varies.', 'rosecrance'); ?>
      </p>
      
      <label>
        <input  id="00NDy0000039dcY" name="00NDy0000039dcY" type="checkbox" value="1" required />
        <div> <?php _e('Email Opt In', 'rosecrance'); ?></div>
      </label>
      <p class="disclaimer-text">
        <?php _e('By submitting this form, you are consenting to receive marketing emails from: Rosecrance, 1021 N. Mulford Road, Rockford, IL, 61107 United States, http://www.rosecrance.org. You can revoke your consent to receive emails at any time by using the SafeUnsubscribe® link, found at the bottom of every email.', 'rosecrance'); ?>
      </p>

      <label class="salesforce-form__radio-field">
        <div> <?php _e('Veteran','rosecrance'); ?> </div>
        <div>
          <div><input type="radio" name="00NQL000005HBvR" value="No" required="" /> <?php _e('No', 'rosecrance'); ?></div>
          <div><input type="radio" name="00NQL000005HBvR" value="Yes" /> <?php _e('Yes', 'rosecrance'); ?></div>
        </div>
      </label>

      <input id="conditions_viewed" name="00NVt000000o5oI" type="hidden" />
      <input id="programs_viewed" name="00NVt000000o5oR"  type="hidden"/>
      <input id="services_viewed" name="00NVt000000o5ob" type="hidden" />
      <input id="resources_viewed" name="00NVt000000o5oZ" type="hidden" />
      <input id="locations_viewed" name="00NVt000000o5oO" type="hidden" />
      <input id="therapists_viewed" name="00NVt000000o5oc" type="hidden" />
      <input id="zip_code" name="00NVt000000o5oj" type="hidden" />
      <input id="pageview_prior" name="00NVt000000o5oP" type="hidden"/>
      <input id="utm_source" name="00NVt000000o5ogMAA" type="hidden" />
      <input id="utm_medium" name="00NVt000000o5ofMAA"  type="hidden"/>
      <input id="utm_campaign" name="00NVt000000o5odMAA" type="hidden" />
      <input id="utm_content" name="00NVt000000seP9MAI" type="hidden" />

      <input class="btn btn-primary" type="submit" name="submit">
    </div>
</form>
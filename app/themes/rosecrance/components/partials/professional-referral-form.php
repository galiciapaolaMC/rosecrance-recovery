<?php

?>
<form class="salesforce-form salesforce-referral-form salesforce-form--professional-referral" action="<?php echo esc_html($salesforce_instance_url); ?>/servlet/servlet.WebToLead?encoding=UTF-8&orgId=<?php echo esc_attr($salesforce_org_id)?>" method="POST" data-form-type="<?php echo esc_html(SALESFORCE_PROFESSIONAL_REFERRAL_FORM); ?>" novalidate>
    <input type=hidden name="oid" value="<?php echo esc_attr($salesforce_org_id)?>">
    <input type=hidden name='captcha_settings' value='{"keyname":"Rosecrance","fallback":"true","orgId":"<?php echo esc_html($salesforce_org_id); ?>","ts":""}'>
    <input type=hidden name="retURL" value="<?php echo esc_attr($return_url)?>">
    <input id="type" type="hidden" name="00NVt000000seP8" value="Professional">

    <!--  ----------------------------------------------------------------------  -->
    <!--  NOTE: These fields are optional debugging elements. Please uncomment    -->
    <!--  these lines if you wish to test in debug mode.                          -->
    <!--  <input type="hidden" name="debug" value=1>                              -->
    <!--  <input type="hidden" name="debugEmail"                                  -->
    <!--  value="dlondon@rosecrance.org">                                         -->
    <!--  ----------------------------------------------------------------------  -->
    
    <label>
      <div> <?php _e('Your First Name', 'rosecrance'); ?><span class="required">*</span> </div>
      <input  id="≈" maxlength="40" name="00NVt000000o5oUMAQ" size="20" type="text" required/>
    </label>
    
    <label>
      <div> <?php _e('Your Last Name', 'rosecrance;'); ?><span class="required">*</span> </div>
      <input  id="00NVt000000o5oVMAQ" maxlength="80" name="00NVt000000o5oVMAQ" size="20" type="text" required/>
    </label>
    
    <label>
      <div> <?php _e('Your Email Address', 'rosecrance'); ?><span class="required">*</span> </div>
      <input  id="00NVt000000o5oTMAQ" maxlength="40" name="00NVt000000o5oTMAQ" size="20" type="email" required/>
    </label>
    
    <label>
      <div> <?php _e('Your Mobile Phone Number', 'ropsecramce'); ?><span class="required">*</span> </div>
      <input  id="00NVt000000o5oXMAQ" maxlength="40" name="00NVt000000o5oXMAQ" size="20" type="tel" placeholder="xxx-xxx-xxxx" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required/>
    </label>

    <label>
      <div> <?php _e('Your Organization', 'rosecrance'); ?><span class="required">*</span> </div>
      <input  id="00NVt000000o5oWMAQ" maxlength="50" name="00NVt000000o5oWMAQ" size="20" type="text" required/>
    </label>    
    
    <label>
      <div> <?php _e('Client First Name', 'rosecrance'); ?><span class="required">*</span></div>
      <input  id="first_name" maxlength="40" name="first_name" size="20" type="text" required/>
    </label>

    <label>
      <div> <?php _e('Client Last Name', 'rosecrance'); ?>  <span class="required">*</span></div>
      <input  id="last_name" maxlength="40" name="last_name" size="20" type="text" required/>
    </label>

    <label>
      <div> <?php _e('Client Email', 'rosecrance'); ?><span class="required">*</span></div>
      <input  id="email" maxlength="40" name="email" size="20" type="email" required/>
    </label>

    <label>
      <div> <?php _e('Client Mobile Phone', 'rosecrance'); ?><span class="required">*</span></div>
      <input  id="mobile" maxlength="40" name="mobile" size="20" type="tel" placeholder="xxx-xxx-xxxx" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required/>
    </label>
    
    <label>
      <div> <?php _e('Insurance Type', 'rosecrance'); ?><span class="required">*</span> </div>
      <select  id="00NVt000000o5oLMAQ" name="00NVt000000o5oLMAQ" title="Insurance Type" required>
        <option value="" disabled selected></option>
        <option value="Employer"><?php _e('Employer', 'rosecrance');'' ?></option>
        <option value="State/Marketplace"><?php _e('State/Marketplace', 'rosecrance'); ?></option>
        <option value="Medicaid"><?php _e('Medicaid', 'rosecrance'); ?></option>
        <option value="Medicare"><?php _e('Medicare', 'rosecrance'); ?></option>
        <option value="Self-Pay"><?php _e('Self-Pay', 'rosecrance'); ?></option>
        <option value="None"><?php _e('None</option>', 'rosecrance'); ?> </option>
      </select>
    </label>

    <label>
      <div><?php _e('Seeking Help For', 'rosecrance'); ?><span class="required">*</span> </div>
      <select  id="00NVt000000o5oKMAQ" name="00NVt000000o5oKMAQ" title="Help Reason" required>
        <option value="" disabled selected></option>
        <option value="Addiction/Substance Use"><?php _e('Addiction/Substance Use', 'rosecrance'); ?></option>
        <option value="Mental Health"><?php _e('Mental Health' , 'rosecrance'); ?></option>
        <option value="Addiction/Substance Use & Mental Health"><?php _e('Addiction/Substance Use & Mental Health' , 'rosecrance'); ?></option>
        <option value="TMS Therapy"><?php _e('TMS Therapy' , 'rosecrance'); ?></option>
      </select>
    </label>

    <label>
      <div><?php _e('Description', 'rosecrance'); ?> </div>
      <textarea name="description"></textarea>
    </label>

    <input id="conditions_viewed" name="00NVt000000o5oI" type="hidden" />
    <input id="programs_viewed" name="00NVt000000o5oR"  type="hidden"/>
    <input id="services_viewed" name="00NVt000000o5ob" type="hidden" />
    <input id="resources_viewed" name="00NVt000000o5oZ" type="hidden" />
    <input id="locations_viewed" name="00NVt000000o5oO" type="hidden" />
    <input id="therapists_viewed" name="00NVt000000o5oc" type="hidden" />
    <input id="zip_code" name="00NVt000000o5oj" type="hidden" />
    <input id="pageview_prior" name="00NVt000000o5oP" type="hidden"/>
    <input id="form_submission_page_c" name="00NVt000001bQZF" type="hidden" />
    <input id="utm_source" name="00NVt000000o5ogMAA" type="hidden" value="<?php echo esc_attr($utm_source) ?>"/>
    <input id="utm_medium" name="00NVt000000o5ofMAA"  type="hidden" value="<?php echo esc_attr($utm_medium) ?>"/>
    <input id="utm_campaign" name="00NVt000000o5odMAA" type="hidden" value="<?php echo esc_attr($utm_campaign) ?>"/>
    <input id="utm_content" name="00NVt000000seP9MAI" type="hidden" value="<?php echo esc_attr($utm_content) ?>"/>

    <div class="salesforce-form__opt-in-section">
      <label>
        <input  id="00NVt00000118B5MAI" name="00NVt00000118B5MAI" type="checkbox" value="1" />
        <div> <?php _e('SMS Opt In', 'rosecrance'); ?></div>
      </label>
      <p class="disclaimer-text">
        <?php echo esc_html($sms_optin_disclaimer); ?>
      </p>
      
      <label>
        <input  id="00NVt00000118B4MAI" name="00NVt00000118B4MAI" type="checkbox" value="1" />
        <div> <?php _e('Email Opt In', 'rosecrance'); ?></div>
      </label>
      <p class="disclaimer-text">
        <?php echo esc_html($email_optin_disclaimer); ?>
      </p>

      <label>
        <input id="00NVt000000o5oiMAA" name="00NVt000000o5oiMAA" type="checkbox" value="1" />
        <div> <?php _e('Please do not reach out yet to this client. Haven\'t been notified yet','rosecrance'); ?> </div>
      </label>
      <div class="g-recaptcha" data-sitekey="<?php echo esc_attr($google_recaptcha_site_key); ?>"></div>
      <input class="btn btn-primary" type="submit">
    </div>
</form>
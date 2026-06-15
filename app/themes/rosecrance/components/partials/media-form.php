<?php ?>

<form class="salesforce-form salesforce-form--media" data-form-type="<?php echo esc_attr(SALESFORCE_MEDIA_FORM)?>"  action="<?php echo esc_html($salesforce_instance_url); ?>/servlet/servlet.WebToLead?encoding=UTF-8&orgId=<?php echo esc_attr($salesforce_org_id)?>" method="POST">
  <input type=hidden name="oid" value="<?php echo esc_attr($salesforce_org_id)?>">
  <input type=hidden name="retURL" value="<?php echo esc_attr($return_url)?>">

  <label>
      <div> <?php _e('First Name', 'rosecrance'); ?> <span class="required">*</span></div>
      <input id="first_name" maxlength="40" name="first_name" size="20" type="text" required/>
  </label>
  <label>
      <div> <?php _e('Last Name', 'rosecrance'); ?> <span class="required">*</span></div>
      <input id="last_name" maxlength="80" name="last_name" size="20" type="text" required/>
  </label>
  <label>
      <div> <?php _e('Email', 'rosecrance'); ?> <span class="required">*</span></div>
      <input id="email" maxlength="80" name="email" size="20" type="text" required/>
  </label>
  <label>
      <div> <?php _e('Your Organization', 'rosecrance'); ?> </div>
      <input  id="00NVt000000o5oWMAQ" maxlength="50" name="00NVt000000o5oWMAQ" size="20" type="text" />
  </label>
  <label>
    <div><?php _e('Inquiry/Comment', 'rosecrance'); ?></div>
    <textarea name="description"></textarea>
  </label>

  <input id="utm_source" name="00NVt000000o5ogMAA" type="hidden" value="<?php echo esc_attr($utm_source) ?>"/>
  <input id="utm_medium" name="00NVt000000o5ofMAA"  type="hidden" value="<?php echo esc_attr($utm_medium) ?>"/>
  <input id="utm_campaign" name="00NVt000000o5odMAA" type="hidden" value="<?php echo esc_attr($utm_campaign) ?>"/>
  <input id="utm_content" name="00NVt000000seP9MAI" type="hidden" value="<?php echo esc_attr($utm_content) ?>"/>
  <input id="form_submission_page_c" name="00NVt000001bQZF" type="hidden" />
  <div class="salesforce-form__opt-in-section">
    <label>
      <input  id="00NDy0000039dcT" name="00NDy0000039dcT" type="checkbox" value="1" />
      <div> <?php _e('SMS Opt In', 'rosecrance'); ?></div>
    </label>
    <p class="disclaimer-text">
      <?php echo esc_html($sms_optin_disclaimer); ?>
    </p>
    
    <label>
      <input  id="00NDy0000039dcY" name="00NDy0000039dcY" type="checkbox" value="1" />
      <div> <?php _e('Email Opt In', 'rosecrance'); ?></div>
    </label>
    <p class="disclaimer-text">
      <?php echo esc_html($email_optin_disclaimer); ?>
    </p>
    <div class="g-recaptcha" data-sitekey="<?php echo esc_attr($google_recaptcha_site_key); ?>"></div>
    <input class="btn btn-primary" type="submit">
  </div>
</form>
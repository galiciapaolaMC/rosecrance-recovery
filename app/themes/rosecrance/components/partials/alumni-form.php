<?php ?>

<form class="salesforce-form salesforce-form--alumni" data-form-type="<?php echo esc_attr(SALESFORCE_ALUMNI_FORM)?>" action="<?php echo esc_html($salesforce_instance_url); ?>/servlet/servlet.WebToLead?encoding=UTF-8&orgId=<?php echo esc_attr($salesforce_org_id)?>" method="POST" novalidate>
    <input type=hidden name="oid" value="<?php echo esc_attr($salesforce_org_id)?>">
    <input type=hidden name='captcha_settings' value='{"keyname":"Rosecrance","fallback":"true","orgId":"<?php echo esc_html($salesforce_org_id); ?>","ts":""}'>
    <input type=hidden name="retURL" value="<?php echo esc_attr($return_url)?>">
    <input id="type" type="hidden" name="00NVt000000seP8" value="Alumni">
    <!--  ----------------------------------------------------------------------  -->
    <!--  NOTE: These fields are optional debugging elements. Please uncomment    -->
    <!--  these lines if you wish to test in debug mode.                          -->
    <!--  <input type="hidden" name="debug" value=1>                              -->
    <!--  <input type="hidden" name="debugEmail"                                  -->
    <!--  value="dlondon@rosecrance.org">                                         -->
    <!--  ----------------------------------------------------------------------  -->
    <div class="salesforce-form__field-group">
        <label class="full-width-field">
            <div> <?php _e('Category', 'rosecrance'); ?> </div>
            <select  id="00NVt000000o5oH" name="00NVt000000o5oH" title="Category">
                <option value="" selected disabled></option>
                <option value="New patient"><?php _e('New patient' , 'rosecrance'); ?></option>
                <option value="Existing patient"><?php _e('Existing patient' , 'rosecrance'); ?></option>
                <option value="Referring a loved one"><?php _e('Referring a loved one' , 'rosecrance'); ?></option>
                <option value="Professional referring an individual"><?php _e('Professional referring an individual' , 'rosecrance'); ?></option>
            </select>
        </label>
        <label>
            <div> <?php _e('Your First Name', 'rosecrance'); ?> </div>
            <input id="00NVt000000o5oUMAQ" maxlength="40" name="00NVt000000o5oUMAQ" size="20" type="text" />
        </label>
        <label>
            <div> <?php _e('Your Last Name', 'rosecrance'); ?> </div>
            <input id="00NVt000000o5oVMAQ" maxlength="80" name="00NVt000000o5oVMAQ" size="20" type="text" />
        </label>
        <label>
            <div> <?php _e('Your Email', 'rosecrance'); ?> </div>
            <input  id="00NVt000000o5oTMAQ" maxlength="40" name="00NVt000000o5oTMAQ" size="20" type="email" />
        </label>
        <label>
            <div> <?php _e('Your Mobile Phone Number', 'rosecrance'); ?> </div>
            <input id="00NVt000000o5oXMAQ" maxlength="40" name="00NVt000000o5oXMAQ" size="20" type="tel" placeholder="xxx-xxx-xxxx" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" />
        </label>
    </div>
    <div class="salesforce-form__field-group">
        <label>
            <div> <?php _e('First Name', 'rosecrance'); ?> </div>
            <input  id="first_name" maxlength="40" name="first_name" size="20" type="text" />
        </label>
        <label>
            <div> <?php _e('Last Name', 'rosecrance'); ?> </div>
            <input  id="last_name" maxlength="80" name="last_name" size="20" type="text" />
        </label>
        <label>
            <div> <?php _e('Email', 'rosecrance'); ?> </div>
            <input  id="email" maxlength="80" name="email" size="20" type="text" />
        </label>
        <label>
            <div> <?php _e('Mobile', 'rosecrance'); ?> </div>
            <input  id="mobile" maxlength="40" name="mobile" size="20" type="text" />
        </label>
        <label>
            <div> <?php _e('Insurance Type', 'rosecrance'); ?><span class="required">*</span></div>
            <select  id="00NVt000000o5oLMAQ" name="00NVt000000o5oLMAQ" title="Insurance Type" required>
                <option value="" disabled selected><?php _e('', 'rosecrance'); ?></option>
                <option value="Employer"><?php _e('Employer', 'rosecrance'); ?></option>
                <option value="State/Marketplace"><?php _e('State/Marketplace', 'rosecrance'); ?></option>
                <option value="Medicaid"><?php _e('Medicaid', 'rosecrance'); ?></option>
                <option value="Medicare"><?php _e('Medicare', 'rosecrance'); ?></option>
                <option value="Self-Pay"><?php _e('Self-Pay', 'rosecrance'); ?></option>
                <option value="None"><?php _e('None', 'rosecrance'); ?></option>
            </select>
        </label>
    </div>
    <input id="conditions_viewed" name="00NVt000000o5oI" type="hidden" />
    <input id="programs_viewed" name="00NVt000000o5oR"  type="hidden"/>
    <input id="services_viewed" name="00NVt000000o5ob" type="hidden" />
    <input id="resources_viewed" name="00NVt000000o5oZ" type="hidden" />
    <input id="locations_viewed" name="00NVt000000o5oO" type="hidden" />
    <input id="therapists_viewed" name="00NVt000000o5oc" type="hidden" />
    <input id="zip_code" name="00NVt000000o5oj" type="hidden" />
    <input id="pageview_prior" name="00NVt000000o5oP" type="hidden"/>
    <input id="utm_source" name="00NVt000000o5ogMAA" type="hidden" value="<?php echo esc_attr($utm_source) ?>"/>
    <input id="utm_medium" name="00NVt000000o5ofMAA"  type="hidden" value="<?php echo esc_attr($utm_medium) ?>"/>
    <input id="utm_campaign" name="00NVt000000o5odMAA" type="hidden" value="<?php echo esc_attr($utm_campaign) ?>"/>
    <input id="utm_content" name="00NVt000000seP9MAI" type="hidden" value="<?php echo esc_attr($utm_content) ?>"/>
    <div class="g-recaptcha" data-sitekey="<?php echo esc_attr($google_recaptcha_site_key); ?>"></div>
    <div class="salesforce-form__opt-in-section">
        <input type="submit" class="btn btn-primary">
    </div>
</form>
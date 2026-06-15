<?php

define('DEFAULT_ACCORDION_PADDING', [0, 0, 0, 0]);
define('DEFAULT_ACTIVATE_TREATMENT_LOCATOR_PADDING', [0, 0, 0, 0]);
define('DEFAULT_CARD_CAROUSEL_PADDING', [0, 0, 0, 0]);
define('DEFAULT_BIO_LIST_PADDING', [0, 0, 0, 0]);
define('DEFAULT_COLUMN_CONTENT_PADDING', [0, 0, 0, 0]);
define('DEFAULT_COLUMN_CARD_PADDING', [0, 0, 0, 0]);
define('DEFAULT_CONDITION_PICKER_PADDING', [0, 0, 0, 0]);
define('DEFAULT_CONTENT_AREA_PADDING', [0, 0, 0, 0]);
define('DEFAULT_CONTENT_BANNER_PADDING', [0, 0, 0, 0]);
define('DEFAULT_FIFTY_FIFTY_PADDING', [0, 0, 0, 0]);
define('DEFAULT_FIFTY_FIFTY_STATISTICS_PADDING', [0, 0, 0, 0]);
define('DEFAULT_HELP_BANNER_PADDING', [0, 0, 0, 0]);
define('DEFAULT_HERO_PADDING', [0, 0, 0, 0]);
define('DEFAULT_LOCATION_DETAIL_MAP_PADDING', [0, 0, 0, 0]);
define('DEFAULT_LOCATION_SEARCH_PADDING', [0, 0, 0, 0]);
define('DEFAULT_MEDIA_PADDING', [0, 0, 0, 0]);
define('DEFAULT_NEWS_ARTICLES_PADDING', [0, 0, 0, 0]);
define('DEFAULT_PODCAST_EMBED_PADDING', [0, 0, 0, 0]);
define('DEFAULT_RESOURCE_HERO_PADDING', [0, 0, 0, 0]);
define('DEFAULT_SUB_NAVIGATION_PADDING', [0, 0, 0, 0]);
define('DEFAULT_TESTIMONIAL_PADDING', [0, 0, 0, 0]);
define('DEFAULT_VIDEO_PADDING', [0, 0, 0, 0]);
define('DEFAULT_WYSIWYG_PADDING', [0, 0, 0, 0]);
define('DEFAULT_HOME_HERO_PADDING', [0, 0, 0, 0]);

define('BIO_SHOW_COUNT', 4);

define('HERO_VARIANTS', [
  'MEDIA' => 'media',
  'CONTENT_CONTAINER' => 'content-container',
  'LARGE' => 'large',
  'HEADLINE' => 'headline'
]);

define('RESOURCE_HERO_VARIANTS', [
  'LARGE' => 'large',
  'SHORT' => 'short'
]);

define('SALESFORCE_SELF_REFERRAL_FORM', 'self-referral-form');
define('SALESFORCE_SELF_REFERRAL_EXISTING_FORM', 'self-referral-form-existing');
define('SALESFORCE_MEDIA_FORM', 'media-form');
define('SALESFORCE_DONATION_FORM', 'donation-form');
define('SALESFORCE_WYSIWYG_FORM', 'wysiwyg-form');
define('SALESFORCE_ALUMNI_FORM', 'alumni-form');
define('SALESFORCE_FRIEND_FAMILY_REFERRAL_FORM', 'friend-family-referral-form');
define('SALESFORCE_PROFESSIONAL_REFERRAL_FORM', 'professional-referral-form');
define('SALESFORCE_REFERRAL_FORM_GROUP', 'referral-form-group');

define('SALESFORCE_FORM_VARIANTS', [
  SALESFORCE_SELF_REFERRAL_FORM => '/components/partials/self-referral-form.php',
  SALESFORCE_DONATION_FORM => 'components/partials/donation-form.php',
  SALESFORCE_ALUMNI_FORM => '/components/partials/alumni-form.php',
  SALESFORCE_FRIEND_FAMILY_REFERRAL_FORM => '/components/partials/friend-family-referral-form.php',
  SALESFORCE_PROFESSIONAL_REFERRAL_FORM => '/components/partials/professional-referral-form.php',
  SALESFORCE_REFERRAL_FORM_GROUP => '/components/partials/referral-forms.php',
  SALESFORCE_MEDIA_FORM => 'components/partials/media-form.php',
  SALESFORCE_SELF_REFERRAL_EXISTING_FORM => '/components/partials/self-referral-existing-form.php'
]);
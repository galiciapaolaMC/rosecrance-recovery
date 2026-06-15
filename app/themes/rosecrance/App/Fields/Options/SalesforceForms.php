<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Group;

/**
 * Class SalesforceForms
 *
 * @package Rosecrance\App\Fields\Options
 */
class SalesforceForms
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/options/salesforce-forms',
            [
                Tab::make(__('Salesforce Forms', 'rosecrance'), 'salesforce-forms')
                    ->placement('left'),
                Group::make(__('Salesforce Instance Info', 'rosecrance'), 'salesforce-instance-info')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Salesforce Instance URL', 'rosecrance'), 'salesforce-instance-url')
                            ->defaultValue('https://test.salesforce.com'),
                        Text::make(__('Salesforce Org ID', 'rosecrance'), 'salesforce-org-id')
                            ->defaultValue('00DDy0000002LzC'),
                    ]),
                Group::make(__('Disclaimer Options', 'rosecrance'), 'disclaimer-options')
                    ->layout('block')
                    ->fields([
                      Text::make(__('SMS Opt In Disclaimer Text', 'rosecrance'), 'sms-opt-in-disclaimer-text')
                          ->defaultValue(__('By providing your mobile number and checking this box, you are consenting to receive SMS (text) messages from Rosecrance Health Network. Text #### to ##### for help, and text #### to ##### to stop. Message and data rates may apply. Message frequency varies.', 'rosecrance')),
                      Text::make(__('Email Opt In Disclaimer Text', 'rosecrance'), 'email-opt-in-disclaimer-text')
                          ->defaultValue(__('By submitting this form, you are consenting to receive marketing emails from: Rosecrance, 1021 N. Mulford Road, Rockford, IL, 61107 United States, http://www.rosecrance.org. You can revoke your consent to receive emails at any time by using the SafeUnsubscribe® link, found at the bottom of every email.', 'rosecrance')),
                    ]),
                Group::make(__('Google Recaptcha Info', 'rosecrance'), 'google-recaptcha-info')
                    ->layout('block')
                    ->fields([
                        Text::make(__('Site Key', 'rosecrance'), 'site-key')
                    ]),
            ]
        );
    }
}

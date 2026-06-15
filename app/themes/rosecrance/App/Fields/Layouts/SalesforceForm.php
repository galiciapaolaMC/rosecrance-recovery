<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class SalesforceForm
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class SalesforceForm extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/salesforce-form',
            Layout::make(__('Salesforce Form', 'rosecrance'), 'salesforce-form')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Title', 'rosecrance'), 'title')
                        ->required(),
                    WysiwygEditor::make(__('Pre-form Content', 'rosecrance'), 'pre-form-content'),
                    Select::make(__('Form Type', 'rosecrance'), 'form-type')
                        ->choices([
                            SALESFORCE_DONATION_FORM => __('Donation Form', 'rosecrance'),
                            SALESFORCE_MEDIA_FORM => __('Media Form', 'rosecrance'),
                            SALESFORCE_ALUMNI_FORM => __('Alumni Form', 'rosecrance'),
                            SALESFORCE_REFERRAL_FORM_GROUP => __('Referral Form Group', 'rosecrance'),
                            SALESFORCE_PROFESSIONAL_REFERRAL_FORM => __('Professional Referral Form', 'rosecrance'),
                            'wysiwyg-form' => __('WYSIWYG Form', 'rosecrance')
                        ])
                        ->returnFormat('value')
                        ->required(),
                    WysiwygEditor::make(__('Shorcode/iFrame Injection', 'rosecrance'), 'wysiwyg-form')
                        ->conditionalLogic([
                            ConditionalLogic::where('form-type', '==', 'wysiwyg-form')
                        ]),
                    Text::make(__('URL Parameter Name', 'rosecrance'), 'url-parameter-name')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('form-type', '==', 'wysiwyg-form')
                        ]),
                    Text::make(__('URL Parameter Value', 'rosecrance'), 'url-parameter-value')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('form-type', '==', 'wysiwyg-form')
                        ]),
                    $this->optionsTab(),
                    Link::make(__('Return URL', 'rosecrance'), 'return-url')
                        ->instructions(__('The URL to redirect to after form submission.', 'rosecrance'))
                        ->conditionalLogic([
                            ConditionalLogic::where('form-type', '!=', SALESFORCE_REFERRAL_FORM_GROUP)
                        ]),
                    Link::make(__('Professional Referral Return URL', 'rosecrance'), 'professional-return-url')
                        ->instructions(__('The URL to redirect to after form submission.', 'rosecrance'))
                        ->conditionalLogic([
                            ConditionalLogic::where('form-type', '==', SALESFORCE_REFERRAL_FORM_GROUP)
                        ]),
                    Link::make(__('Friends and Family Return URL', 'rosecrance'), 'friends-and-family-return-url')
                        ->instructions(__('The URL to redirect to after form submission.', 'rosecrance'))
                        ->conditionalLogic([
                            ConditionalLogic::where('form-type', '==', SALESFORCE_REFERRAL_FORM_GROUP)
                        ]),  
                    Link::make(__('New Patient Return URL', 'rosecrance'), 'new-patient-return-url')
                        ->instructions(__('The URL to redirect to after form submission.', 'rosecrance'))
                        ->conditionalLogic([
                            ConditionalLogic::where('form-type', '==', SALESFORCE_REFERRAL_FORM_GROUP)
                        ]),
                    Link::make(__('Existing Patient Return URL', 'rosecrance'), 'existing-patient-return-url')
                        ->instructions(__('The URL to redirect to after form submission.', 'rosecrance'))
                        ->conditionalLogic([
                            ConditionalLogic::where('form-type', '==', SALESFORCE_REFERRAL_FORM_GROUP)
                        ]), 
                    
                ])
        );
    }
}

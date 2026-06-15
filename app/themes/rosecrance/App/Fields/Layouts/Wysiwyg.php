<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\ConditionalLogic;
use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class Wysiwyg
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Wysiwyg extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/wysiwyg',
            Layout::make(__('Wysiwyg', 'rosecrance'), 'wysiwyg')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Citation Text', 'rosecrance'), 'citation-text')
                        ->choices([
                            'true'  => __('True', 'rosecrance'),
                            'false'  => __('False', 'rosecrance')
                        ])
                        ->defaultValue('false')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('remove-content', '==', 'false')
                        ]),
                    ButtonGroup::make(__('Remove Content', 'rosecrance'), 'remove-content')
                        ->choices([
                            'true'  => __('True', 'rosecrance'),
                            'false'  => __('False', 'rosecrance')
                        ])
                        ->defaultValue('false')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    WysiwygEditor::make(__('Content', 'rosecrance'), 'content')
                        ->mediaUpload(false)
                        ->conditionalLogic([
                            ConditionalLogic::where('remove-content', '==', 'false')
                        ]),
                    Link::make(__('Download Link', 'rosecrance'), 'download-link')
                        ->returnFormat('array')
                        ->conditionalLogic([
                            ConditionalLogic::where('citation-text', '==', 'false')->and('remove-content', '==', 'false')
                        ]),
                    ButtonGroup::make(__('Social Share Buttons', 'rosecrance'), 'social-share-buttons')
                        ->choices([
                            'active'  => __('Active', 'rosecrance'),
                            'inactive'  => __('Inactive', 'rosecrance')
                        ])
                        ->defaultValue('inactive'),
                    Text::make(__('Social Share Headline', 'rosecrance'), 'social-share-headline')
                        ->conditionalLogic([
                            ConditionalLogic::where('social-share-buttons', '==', 'active')
                        ]),
                    ButtonGroup::make(__('Add Script', 'rosecrance'), 'add-script')
                      ->choices([
                          'no' => __('No', 'rosecrance'),
                          'yes' => __('Yes', 'rosecrance'),
                      ])
                      ->defaultValue('no'),
                    Textarea::make(__('Script', 'rosecrance'), 'script')
                      ->conditionalLogic([
                            ConditionalLogic::where('add-script', '==', 'yes')
                        ]),
                    $this->optionsTab(),
                    TrueFalse::make(__('Use Block Quote Styles', 'rosecrance'), 'use-block-quote-styles'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_WYSIWYG_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

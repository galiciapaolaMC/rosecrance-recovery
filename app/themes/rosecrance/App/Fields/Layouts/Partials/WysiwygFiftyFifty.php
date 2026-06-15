<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Extended\ACF\ConditionalLogic;
use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;
use Rosecrance\App\Fields\Common;

/**
 * Class WysiwygFiftyFifty
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class WysiwygFiftyFifty extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/wysiwyg-fifty-fifty',
            Layout::make(__('Wysiwyg fifty fifty', 'rosecrance'), 'wysiwyg-fifty-fifty')
                ->layout('block')
                ->fields([
                  $this->contentTab(),
                  TrueFalse::make(__('Apply Form Styling', 'rosecrance'), 'apply-form-styling')
                    ->defaultValue(1),
                  WysiwygEditor::make(__('Content', 'rosecrance'), 'content')
                      ->mediaUpload(false),
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
                  $this->styleTab(),
                  Common::paddingGroup(DEFAULT_WYSIWYG_PADDING),
                  Common::backgroundFillGroup()
                ])
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class HelpBanner
 *
 * @package Rosecrance\App\Fields\Options
 */
class HelpBanner
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/options/help-banner',
            [
                Tab::make(__('Help Banner', 'rosecrance'), 'help-banner')
                    ->placement('left'),
                Text::make(__('Headline', 'rosecrance'), 'headline-help-banner'),
                WysiwygEditor::make(__('Content', 'roseance'), 'content-help-banner')
                    ->mediaUpload(false)
            ]
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class Content
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Content extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/content',
            Layout::make(__('Content', 'rosecrance'), 'content')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    WysiwygEditor::make(__('Content Block', 'rosecrance'), 'content-block')
                        ->mediaUpload(false)
                ])
        );
    }
}

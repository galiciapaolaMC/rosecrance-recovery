<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;

/**
 * Class Subhead
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Subhead extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/subhead',
            Layout::make(__('Subhead', 'rosecrance'), 'subhead')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Subhead', 'rosecrance'), 'subhead')
                ])
        );
    }
}

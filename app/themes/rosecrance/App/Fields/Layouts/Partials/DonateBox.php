<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Text;

/**
 * Class DonateBox
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class DonateBox extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/donate-box',
            Layout::make(__('DonateBox', 'rosecrance'), 'donate-box')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Text::make(__('Headline', 'rosecrance'), 'headline'),
                    Link::make(__('Link', 'rosecrance'), 'link')
                ])
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;

/**
 * Class HelpBanner
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class HelpBanner extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/help-banner',
            Layout::make(__('Help Banner', 'rosecrance'), 'help-banner')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Activate Help Banner', 'rosecrance'), 'activate-help-banner')
                        ->choices([
                            'active'  => __('Active', 'rosecrance'),
                            'inactive' => __('Inactive', 'rosecrance')
                        ])
                        ->defaultValue('active'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_HELP_BANNER_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

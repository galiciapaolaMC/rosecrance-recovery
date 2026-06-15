<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;

/**
 * Class SubNavigation
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class SubNavigation extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/sub-navigation',
            Layout::make(__('Sub Navigation', 'rosecrance'), 'sub-navigation')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Activate Sub Navigation', 'rosecrance'), 'activate-sub-navigation')
                        ->choices([
                            'active'  => __('Active', 'rosecrance'),
                            'inactive' => __('Inactive', 'rosecrance')
                        ])
                        ->defaultValue('active'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_SUB_NAVIGATION_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

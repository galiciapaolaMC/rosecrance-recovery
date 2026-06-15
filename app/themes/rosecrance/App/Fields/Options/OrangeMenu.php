<?php

namespace Rosecrance\App\Fields\Options;

use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Link;

/**
 * Class OrangeMenu
 *
 * @package Rosecrance\App\Fields\Options
 */
class OrangeMenu
{
    /**
     * Defines fields used within Options tab.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/options/orange-menu',
            [
                Tab::make(__('Orange Menu', 'rosecrance'), 'orange-menu')
                    ->placement('left'),
                Repeater::make(__('Left Links', 'rosecrance'), 'left-links')
                    ->layout('block')
                    ->buttonLabel(__('Add Item'))
                    ->max(6)
                    ->fields([
                        Link::make(__('Link', 'rosecrance'), 'link')
                            ->returnFormat('array')
                            ->wrapper([
                                'width' => '90'
                            ]),
                        TrueFalse::make(__('Border', 'rosecrance'), 'border')
                            ->wrapper([
                                'width' => '10'
                            ])
                    ]),
                Repeater::make(__('Right Links', 'rosecrance'), 'right-links')
                    ->layout('block')
                    ->buttonLabel(__('Add Item'))
                    ->max(2)
                    ->fields([
                        Link::make(__('Link', 'rosecrance'), 'link')
                            ->returnFormat('array')
                            ->wrapper([
                                'width' => '90'
                            ]),
                        TrueFalse::make(__('Border', 'rosecrance'), 'border')
                            ->wrapper([
                                'width' => '10'
                            ])
                    ]),
            ]
        );
    }
}

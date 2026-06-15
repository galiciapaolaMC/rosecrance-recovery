<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Layout;

/**
 * Class ActivateTreatmentLocator
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ActivateTreatmentLocator extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/activate-treatment-locator',
            Layout::make(__('Activate Treatment Locator', 'rosecrance'), 'activate-treatment-locator')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Treatment Locator', 'rosecrance'), 'treatment-locator')
                        ->choices([
                            'active' => __('Active', 'rosecrance'),
                            'inactive'  => __('Inactive', 'rosecrance'),
                        ])
                        ->defaultValue('active'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_ACTIVATE_TREATMENT_LOCATOR_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

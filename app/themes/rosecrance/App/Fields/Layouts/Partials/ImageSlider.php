<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;

/**
 * Class ImageSlider
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ImageSlider extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/image-slider',
            Layout::make(__('Image Slider', 'rosecrance'), 'image-slider')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Slider Items', 'rosecrance'), 'slider-items')
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Item', 'rosecrance'), 'add-item')
                        ->fields([
                            WPImage::make(__('Desktop Image', 'rosecrance'), 'desktop-image')
                                ->returnFormat('array')
                                ->wrapper([
                                    'width' => '50'
                                ]),
                            WPImage::make(__('Mobile Image', 'rosecrance'), 'mobile-image')
                                ->returnFormat('array')
                                ->wrapper([
                                    'width' => '50'
                                ])
                        ]),
                    $this->optionsTab(),
                    ButtonGroup::make(__('Enable Indicators', 'rosecrance'), 'show-slider-indicators')
                        ->choices([
                            'true'  => __('Enable', 'rosecrance'),
                            'false' => __('Disable', 'rosecrance'),
                        ])
                        ->instructions(__('Enabling will show a dot navigation button group.', 'rosecrance'))
                        ->defaultValue('true')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    ButtonGroup::make(__('Slider Autoplay', 'rosecrance'), 'slider-autoplay')
                        ->choices([
                            'true'  => __('Enable', 'rosecrance'),
                            'false' => __('Disable', 'rosecrance'),
                        ])
                        ->instructions(__('Enabling will make the slider images change on autoplay.', 'rosecrance'))
                        ->defaultValue('false')
                        ->wrapper([
                            'width' => '50'
                        ]),
                ])
        );
    }
}

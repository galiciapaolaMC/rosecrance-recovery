<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;

/**
 * Class Carousel
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Carousel extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/carousel',
            Layout::make(__('Carousel'), 'carousel')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Carousel Items'))
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Item'))
                        ->fields([
                            WPImage::make('Image')
                                ->returnFormat('array'),
                        ]),
                    $this->optionsTab(),
                    Select::make(__('Animation Type', 'rosecrance'), 'carousel-animation-type')
                        ->choices([
                            'fade'  => __('Fade', 'rosecrance'),
                            'pull'  => __('Pull', 'rosecrance'),
                            'push'  => __('Push', 'rosecrance'),
                            'scale' => __('Scale', 'rosecrance'),
                            'slide' => __('Slide', 'rosecrance'),
                        ])
                        ->defaultValue('slide')
                        ->returnFormat('value')
                        ->wrapper([
                            'width' => '33.33'
                        ]),
                    ButtonGroup::make(__('Enable Arrow Navigation', 'rosecrance'), 'show-carousel-arrows-nav')
                        ->choices([
                            'true'  => __('Enable', 'rosecrance'),
                            'false' => __('Disable', 'rosecrance'),
                        ])
                        ->instructions(__('Enabling will show a previous and next navigation arrow overlayed on the carousel.', 'rosecrance'))
                        ->defaultValue('true')
                        ->wrapper([
                            'width' => '33.33'
                        ]),
                    ButtonGroup::make(__('Enable Indicators', 'rosecrance'), 'show-carousel-indicators')
                        ->choices([
                            'true'  => __('Enable', 'rosecrance'),
                            'false' => __('Disable', 'rosecrance'),
                        ])
                        ->instructions(__('Enabling will show a dot navigation button group.', 'rosecrance'))
                        ->defaultValue('false')
                        ->wrapper([
                            'width' => '33.33'
                        ]),
                ])
        );
    }
}

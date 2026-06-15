<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Url;

/**
 * Class Media
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Media extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/media',
            Layout::make(__('Media', 'rosecrance'), 'media')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Media Type', 'rosecrance'), 'media-type')
                        ->choices([
                            'image' => __('Image', 'rosecrance'),
                            'video' => __('Video', 'rosecrance'),
                        ])
                        ->defaultValue('image'),
                    Repeater::make(__('Slider Images', 'rosecrance'), 'slider-images')
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
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'image')
                        ]),
                    Url::make(__('Video', 'rosecrance'), 'video')
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'video')
                        ]),
                    $this->optionsTab()
                    ->conditionalLogic([
                        ConditionalLogic::where('media-type', '==', 'image')
                    ]),
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
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_MEDIA_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

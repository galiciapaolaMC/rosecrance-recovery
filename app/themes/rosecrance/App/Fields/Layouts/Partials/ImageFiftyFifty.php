<?php

namespace Rosecrance\App\Fields\Layouts\Partials;

use Extended\ACF\ConditionalLogic;
use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Url;

/**
 * Class ImageFiftyFifty
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ImageFiftyFifty extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/image-fifty-fifty',
            Layout::make(__('Image Fifty Fifty', 'rosecrance'), 'image-fifty-fifty')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Media Type', 'rosecrance'), 'media-type')
                        ->choices([
                            'image'  => __('Image', 'rosecrance'),
                            'video' => __('Video', 'rosecrance'),
                        ])
                        ->defaultValue('image')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    ButtonGroup::make(__('Media Animation', 'rosecrance'), 'media-animation')
                        ->choices([
                            'active'  => __('Active', 'rosecrance'),
                            'inactive' => __('Inactive', 'rosecrance'),
                        ])
                        ->defaultValue('inactive')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'image')
                        ]),
                    Image::make(__('Desktop Image', 'rosecrance'), 'desktop-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'image')
                        ]),
                    Image::make(__('Mobile Image', 'rosecrance'), 'mobile-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'image')
                        ]),
                    ButtonGroup::make(__('Video Type', 'rosecrance'), 'video-type')
                        ->choices([
                            'link' => __('Link', 'rosecrance'),
                            'file' => __('File', 'rosecrance')
                        ])
                        ->defaultValue('link')
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'video')
                        ]),
                    Url::make(__('Video Link', 'rosecrance'), 'video-link')
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'video'),
                            ConditionalLogic::where('media-type', '==', 'link')
                        ]),
                    File::make(__('Video File', 'rosecrance'), 'video-file')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'video'),
                            ConditionalLogic::where('media-type', '==', 'file')
                        ]),
                    Image::make(__('Preview Image', 'rosecrance'), 'preview-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'video'),
                            ConditionalLogic::where('media-type', '==', 'link')
                        ]),
                    $this->optionsTab(),
                    Select::make(__('Desktop Image Size', 'rosecrance'), 'desktop-image-size')
                        ->choices([
                            'cover'     => __('Cover', 'rosecrance'),
                            'contain'   => __('Contain', 'rosecrance')
                        ])
                        ->defaultValue('cover')
                        ->returnFormat('value')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Select::make(__('Mobile Image Size', 'rosecrance'), 'mobile-image-size')
                        ->choices([
                            'cover'     => __('Cover', 'rosecrance'),
                            'contain'   => __('Contain', 'rosecrance')
                        ])
                        ->defaultValue('cover')
                        ->returnFormat('value')
                        ->wrapper([
                            'width' => '50'
                        ])
                ])
        );
    }
}

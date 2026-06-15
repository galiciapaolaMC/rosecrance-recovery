<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Url;

/**
 * Class Video
 *
 * @package Extended\App\Fields\Layouts
 */
class Video extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/video',
            Layout::make(__('Video', 'rosecrance'), 'video')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Type', 'rosecrance'), 'type')
                        ->choices([
                            'link' => __('Link', 'rosecrance'),
                            'file' => __('File', 'rosecrance')
                        ])
                        ->defaultValue('link'),
                    Url::make(__('Video Link', 'rosecrance'), 'video-link')
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'link')
                        ]),
                    File::make(__('Video File', 'rosecrance'), 'video-file')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'file')
                        ]),
                    WPImage::make(__('Preview Image', 'rosecrance'), 'preview-image')
                        ->returnFormat('array')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('type', '==', 'file')
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_VIDEO_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

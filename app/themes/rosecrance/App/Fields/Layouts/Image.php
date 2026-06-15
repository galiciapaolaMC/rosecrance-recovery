<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;

/**
 * Class Image
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Image extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/image',
            Layout::make('Image')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    WPImage::make('Image')
                        ->returnFormat('array')
                ])
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class Logos
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Logos extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/logos',
            Layout::make(__('Logos', 'rosecrance'), 'logos')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Logo Items', 'rosecrance'), 'logo-items')
                        ->layout('block')
                        ->min(1)
                        ->buttonLabel(__('Add Item'))
                        ->fields([
                            WPImage::make(__('Image', 'rosecrance'), 'image')
                                ->returnFormat('array')
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_COLUMN_CARD_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

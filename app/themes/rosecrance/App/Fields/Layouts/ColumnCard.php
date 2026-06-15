<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class Column Card
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ColumnCard extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/column-card',
            Layout::make(__('Column Card', 'rosecrance'), 'column-card')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Repeater::make(__('Column Items', 'rosecrance'), 'column-items')
                        ->layout('block')
                        ->min(2)
                        ->max(3)
                        ->buttonLabel(__('Add Item'))
                        ->fields([
                            Text::make(__('Title', 'rosecrance'), 'title'),
                            Textarea::make(__('Content', 'rosecrance'), 'content')
                                ->rows(2),
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

<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Image as WPImage;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class Testimonial
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Testimonial extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/testimonial',
            Layout::make(__('Testimonial', 'rosecrance'), 'testimonial')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Select::make(__('Background Color', 'rosecrance'), 'background-color')
                        ->choices([
                            'primary-grey' => __('Primary Grey', 'rosecrance'),
                            'dark-blue' => __('Dark Blue', 'rosecrance'),
                        ])
                        ->defaultValue('primary-dark')
                        ->returnFormat('value')
                        ->wrapper([
                            'width' => '33'
                        ]),
                    ButtonGroup::make(__('Font Size', 'rosecrance'), 'font-size')
                        ->choices([
                            'short-copy'  => __('Short Copy', 'rosecrance'),
                            'long-copy' => __('Long Copy', 'rosecrance')
                        ])
                        ->defaultValue('short-copy')
                        ->wrapper([
                            'width' => '33'
                        ]),
                    ButtonGroup::make(__('Image Position', 'rosecrance'), 'image-position')
                        ->choices([
                            'image-left'  => __('Left', 'rosecrance'),
                            'image-right' => __('Right', 'rosecrance')
                        ])
                        ->defaultValue('image-left')
                        ->wrapper([
                            'width' => '33'
                        ]),
                    WPImage::make(__('Image', 'rosecrance'), 'image')
                        ->returnFormat('array'),
                    Textarea::make(__('Content', 'rosecrance'), 'content')
                        ->rows(4),
                    Text::make(__('Attribution', 'rosecrance'), 'attribution'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_TESTIMONIAL_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Group;
use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TextArea;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\TrueFalse;

/**
 * Class ContentBanner
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ContentBanner extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/content-banner',
            Layout::make(__('Content Banner', 'rosecrance'), 'content-banner')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Variant', 'rosecrance'))
                        ->choices([
                            'narrow' => __('Narrow', 'rosecrance'),
                            'wide' => __('Wide', 'rosecrance')
                        ])
                        ->defaultValue('narrow'),
                    Text::make(__('Heading', 'rosecrance'), 'heading'),
                    TextArea::make(__('Content', 'rosecrance'), 'content'),
                    Link::make(__('CTA', 'rosecrance'), 'cta')
                        ->conditionalLogic([
                            ConditionalLogic::where('variant', '!=', 'wide')
                        ]),
                    Link::make(__('Secondary CTA', 'rosecrance'), 'secondary-cta')
                        ->conditionalLogic([
                            ConditionalLogic::where('variant', '!=', 'wide')
                        ]),
                    Group::make(__('Inline Link', 'rosecrance'), 'inline-link')
                        ->fields([
                            Text::make(__('Pre-link Text', 'rosecrance'), 'text')
                                ->placeholder(__('Looking for a professional referral link?', 'rosecrance')),
                            Link::make(__('Link', 'rosecrance'), 'link')
                        ]),
                    $this->optionsTab(),
                    TrueFalse::make(__('Show Background Graphic', 'rosecrance'), 'show-background-graphic'),
                    ButtonGroup::make(__('Content Alignment', 'rosecrance'), 'content-alignment')
                        ->choices([
                            'left' => __('Left Aligned', 'rosecrance'),
                            'center' => __('Center Aligned', 'rosecrance'),
                            'right' => __('Right Aligned', 'rosecrance')
                        ])
                        ->defaultValue('center'),
                    $this->styleTab(),
                    Select::make(__('Color Variant', 'rosecrance'), 'color-variant')
                        ->choices([
                            'primary' => __('Primary', 'rosecrance'),
                            'primary-blue' => __('Primary Blue', 'rosecrance'),
                            'primary-orange' => __('Primary Orange', 'rosecrance'),
                            'white' => __('White', 'rosecrance')
                        ]),
                    Common::paddingGroup(DEFAULT_FIFTY_FIFTY_PADDING),        
                    Common::backgroundFillGroup()
                ])
        );
    }
}
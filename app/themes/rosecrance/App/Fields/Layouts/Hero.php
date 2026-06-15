<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\ColorPicker;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class Hero
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class Hero extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/hero',
            Layout::make(__('Hero', 'rosecrance'), 'hero')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Hero Variant', 'rosecrance'), 'hero-variant')
                        ->choices([
                            'media' => __('Media Hero', 'rosecrance'),
                            'content-container' => __('Content Container Hero', 'rosecrance'),
                            'large' => __('Large Hero', 'rosecrance'),
                            'headline' => __('Headline Hero', 'rosecrance'),
                        ])
                        ->defaultValue('media'),
                    ButtonGroup::make(__('Hero Image Size', 'rosecrance'), 'hero-image-size')
                        ->choices([
                            'large' => __('Large', 'rosecrance'),
                            'short' => __('Short', 'rosecrance')
                        ])
                        ->defaultValue('large')
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'large')
                        ]),
                    Text::make(__('Heading', 'rosecrance'), 'heading')
                        ->required(),
                    Select::make(__('Content Color', 'rosecrance'), 'content-color')
                        ->choices([
                            'primary-grey' => __('Primary Grey', 'rosecrance'),
                            'dark-blue' => __('Dark Blue', 'rosecrance'),
                        ])
                        ->defaultValue('primary-dark')
                        ->returnFormat('value')
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'content-container')
                        ]),
                    WysiwygEditor::make(__('Content', 'rosecrance'), 'content')
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '!=', 'headline')
                        ]),
                    ButtonGroup::make(__('Color Block', 'rosecrance'), 'color-block')
                        ->choices([
                            'active' => __('Active', 'rosecrance'),
                            'inactive' => __('Inactive', 'rosecrance')
                        ])
                        ->defaultValue('inactive')
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'large')
                        ]),
                    Select::make(__('Block Fill Color', 'rosecrance'), 'block-fill-color')
                        ->choices([
                            '#FAA834' => __('Primary Orange', 'rosecrance'),
                            '#007EAB' => __('Primary Blue', 'rosecrance'),
                            '#695E4A' => __('Primary Grey', 'rosecrance'),
                            '#FFFFFF' => __('White', 'rosecrance'),
                            '#484848' => __('Dark Grey', 'rosecrance'),
                            '#0054A0' => __('Dark Blue', 'rosecrance'),
                            '#60AFDD' => __('Light Blue', 'rosecrance'),
                            '#AD005B' => __('Purple', 'rosecrance')
                        ])
                        ->defaultValue('#FAA834')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'large')->and('color-block', '==', 'active'),
                            ConditionalLogic::where('hero-variant', '==', 'headline')
                        ]),
                    Select::make(__('Text Block Color', 'rosecrance'), 'text-block-color')
                        ->choices([
                            'primary-grey' => __('Primary Grey', 'rosecrance'),
                            'white' => __('White', 'rosecrance')
                        ])
                        ->defaultValue('primary-grey')
                        ->wrapper([
                            'width' => '50'
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'large')->and('color-block', '==', 'active'),
                            ConditionalLogic::where('hero-variant', '==', 'headline')
                        ]),
                    Text::make(__('Color Block Heading', 'rosecrance'), 'color-block-heading')
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'large')->and('color-block', '==', 'active')
                        ]),
                    WysiwygEditor::make(__('Color Block Content', 'rosecrance'), 'color-block-content')
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'large')->and('color-block', '==', 'active')
                        ]),
                    Group::make(__('Media Hero Configuration', 'rosescrance'), 'media-hero-configuration')
                        ->fields([
                            Text::make(__('Eyebrow Text', 'rosecrance'), 'eyebrow-text')
                                ->instructions(__('Smaller heading that appears above the main heading.')),
                            ButtonGroup::make(__('Activate Gradient Background', 'rosecrance'), 'gradient-background')
                                ->choices([
                                    'active' => __('Active', 'rosecrance'),
                                    'inactive' => __('Inactive', 'rosecrance')
                                ])
                                ->defaultValue('inactive'),
                            Common::getBackgroundSettingsGroup('Main Image Settings', 'main-image-settings')
                                ->wrapper([
                                    'width' => '50'
                                ]),
                            Common::getBackgroundSettingsGroup('Main Mobile Image Settings', 'main-mobile-image-settings')
                                ->wrapper([
                                    'width' => '50'
                                ]),
                            ButtonGroup::make(__('Background Type', 'rosecrance'), 'background-type')
                                ->choices([
                                    'animated-background' => __('Animated Background', 'rosecrance'),
                                    'video-background' => __('Video Background', 'rosecrance')
                                ])
                                ->defaultValue('animated-background'),
                            Common::getBackgroundSettingsGroup('Animated Background Settings', 'animated-bg-settings')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'animated-background')
                                ]),
                            Common::getBackgroundSettingsGroup('Animated Mobile Background Settings', 'animated-mobile-bg-settings')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'animated-background')
                                ]),
                            File::make(__('Desktop Video', 'rosecrance'), 'desktop-video')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'video-background')
                                ]),
                            File::make(__('Mobile Video', 'rosecrance'), 'mobile-video')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'video-background')
                                ]),
                            Group::make(__('Desktop Video Options', 'rosecrance'), 'desktop-video-options')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->fields([
                                    Common::getBackgroundOverlayOpacity()
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'video-background')
                                ]),
                            Group::make(__('Mobile Video Options', 'rosecrance'), 'mobile-video-options')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->fields([
                                    Common::getBackgroundOverlayOpacity()
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'video-background')
                                ]),
                            Select::make(__('CTA Color', 'rosecrance'), 'cta-color')
                                ->choices([
                                    'primary' => __('Primary', 'rosecrance'),
                                    'primary-blue' => __('Primary Blue', 'rosecrance'),
                                    'primary-orange' => __('Primary Orange', 'rosecrance'),
                                    'white' => __('White', 'rosecrance')
                                ])
                                ->defaultValue('primary-orange'),
                            Link::make(__('CTA', 'rosecrance'), 'cta')
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'media')
                        ]),
                    Group::make(__('Content Container Hero Configuration', 'rosescrance'), 'content-container-hero-configuration')
                        ->fields([
                            Text::make(__('Eyebrow Text', 'rosecrance'), 'eyebrow-text')
                                ->instructions(__('Smaller heading that appears above the main heading.')),
                            ButtonGroup::make(__('Background Type', 'rosecrance'), 'background-type')
                                ->choices([
                                    'image-background' => __('Image Background', 'rosecrance'),
                                    'video-background' => __('Video Background', 'rosecrance')
                                ])
                                ->defaultValue('image-background'),
                            Common::getBackgroundSettingsGroup('Desktop Background Settings', 'desktop-background')
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'image-background')
                                ]),
                            Common::getBackgroundSettingsGroup('Mobile Background Settings', 'mobile-background')
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'image-background')
                                ]),
                            File::make(__('Desktop Video', 'rosecrance'), 'desktop-video')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'video-background')
                                ]),
                            File::make(__('Mobile Video', 'rosecrance'), 'mobile-video')
                                ->wrapper([
                                    'width' => '50'
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'video-background')
                                ]),
                            Group::make(__('Desktop Video Options', 'rosecrance'), 'desktop-video-options')
                                ->fields([
                                    Common::getBackgroundOverlayOpacity()
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'video-background')
                                ]),
                            Group::make(__('Mobile Video Options', 'rosecrance'), 'mobile-video-options')
                                ->fields([
                                    Common::getBackgroundOverlayOpacity()
                                ])
                                ->conditionalLogic([
                                    ConditionalLogic::where('background-type', '==', 'video-background')
                                ]),
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'content-container')
                        ]),
                    Group::make(__('Large Hero Configuration', 'rosescrance'), 'large-hero-configuration')
                        ->fields([
                            Common::getBackgroundSettingsGroup('Main Image Settings', 'main-image-settings'),
                            Common::getBackgroundSettingsGroup('Main Mobile Image Settings', 'main-mobile-image-settings'),
                            Link::make(__('CTA', 'rosecrance'), 'cta'),
                            Link::make(__('Secondary CTA', 'rosecrance'), 'secondary-cta'),
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'large')
                        ]),
                    $this->optionsTab(),
                    TrueFalse::make(__('Show Announcement Bar', 'rosecrance'), 'show-announcement-bar')
                        ->defaultValue(false),
                    WysiwygEditor::make(__('Announcement Bar Text', 'rosecrance'), 'announcement-bar-text')
                        ->conditionalLogic([
                            ConditionalLogic::where('show-announcement-bar', '==', 1)
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_HERO_PADDING),
                    Common::backgroundFillGroup(),                
                ])
        );
    }
}

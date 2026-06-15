<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\File;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Url;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class ResourceHero
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class ResourceHero extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/resource-hero',
            Layout::make(__('Resource Hero', 'rosecrance'), 'resource-hero')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Hero Variant', 'rosecrance'), 'hero-variant')
                        ->choices([
                            'large' => __('Headline and Summary', 'rosecrance'),
                            'short' => __('Drug Fact Sheet Variant', 'rosecrance'),
                        ])
                        ->defaultValue('large'),
                    ButtonGroup::make(__('Media Type', 'rosecrance'), 'media-type')
                        ->choices([
                            'none' => __('None', 'rosecrance'),
                            'image' => __('Image', 'rosecrance'),
                            'video' => __('Video', 'rosecrance')
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'large')
                        ])
                        ->defaultValue('image')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    ButtonGroup::make(__('Image Size', 'rosecrance'), 'image-size')
                        ->choices([
                            'large' => __('Large', 'rosecrance'),
                            'small' => __('Small', 'rosecrance')
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'large')->and('media-type', '==', 'image')
                        ])
                        ->defaultValue('large')
                        ->wrapper([
                            'width' => '50'
                        ]),
                    Text::make(__('Subhead', 'rosecrance'), 'subhead'),
                    Text::make(__('Heading', 'rosecrance'), 'heading')
                        ->required(),
                    WysiwygEditor::make(__('Content', 'rosecrance'), 'content')
                        ->required()
                        ->mediaupload(false),
                    Group::make(__('Image Configuration', 'rosescrance'), 'image-configuration')
                        ->fields([
                            Common::getBackgroundSettingsGroup('Main Image Settings', 'main-image-settings'),
                            Common::getBackgroundSettingsGroup('Main Mobile Image Settings', 'main-mobile-image-settings')
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'image'),
                            ConditionalLogic::where('hero-variant', '==', 'short')
                        ]),
                    Group::make(__('Video Configuration', 'rosecrance'), 'video-configuration')
                        ->fields([
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
                        ])
                        ->conditionalLogic([
                            ConditionalLogic::where('media-type', '==', 'video')
                        ]),
                    Link::make(__('Download Button', 'rosecrance'), 'download-button')
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-variant', '==', 'short')
                        ]),
                    $this->optionsTab(),
                    TrueFalse::make(__('Show Announcement Bar', 'rosecrance'), 'show-announcement-bar')
                        ->defaultValue(false),
                    WysiwygEditor::make(__('Announcement Bar Text', 'rosecrance'), 'announcement-bar-text')
                        ->conditionalLogic([
                            ConditionalLogic::where('show-announcement-bar', '==', 1)
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_RESOURCE_HERO_PADDING),
                    Common::backgroundFillGroup(),                
                ])
        );
    }
}

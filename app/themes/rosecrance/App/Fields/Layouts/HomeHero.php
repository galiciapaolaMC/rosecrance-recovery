<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\File;
use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\WysiwygEditor;

/**
 * Class HomeHero
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class HomeHero extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/home-hero',
            Layout::make(__('Home Hero', 'rosecrance'), 'home-hero')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    ButtonGroup::make(__('Hero Type', 'rosecrance'), 'hero-type')
                        ->choices([
                            'video' => __('Video', 'rosecrance'),
                            'image' => __('Image', 'rosecrance'),
                        ])
                        ->defaultValue('video'),
                    File::make(__('Video Background', 'rosecrance'), 'video-background')
                        ->required()
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-type', '==', 'video')
                        ]),
                    Image::make(__('Image Background', 'rosecrance'), 'image-background')
                        ->returnFormat('array')
                        ->required()
                        ->conditionalLogic([
                            ConditionalLogic::where('hero-type', '==', 'image')
                        ]),
                    TextArea::make(__('Heading', 'rosecrance'), 'heading')
                        ->rows(2)
                        ->required(),
                    Textarea::make(__('Content', 'rosecrance'), 'content')
                        ->newLines('br')
                        ->required(),
                    Group::make(__('Branded Box', 'rosecrance'), 'branded-box')
                        ->fields([
                            Text::make(__('Heading', 'rosecrance'), 'heading')
                                ->required(),
                            Textarea::make(__('Content', 'rosecrance'), 'content')
                                ->required(),
                        ]),        
                    TrueFalse::make(__('Show Announcement Bar', 'rosecrance'), 'show-announcement-bar')
                        ->defaultValue(false),
                    WysiwygEditor::make(__('Announcement Bar Text', 'rosecrance'), 'announcement-bar-text')
                        ->conditionalLogic([
                            ConditionalLogic::where('show-announcement-bar', '==', 1)
                        ]),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_HOME_HERO_PADDING),
                    Common::backgroundFillGroup(),    
                ])
        );
    }
}
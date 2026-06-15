<?php

namespace Rosecrance\App\Fields;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\ButtonGroup;
use Extended\ACF\Fields\Checkbox;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Range;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Image;

class Common
{
    public static function getPostListField($post_type, $field_id, $field_name, $field_type = 'select')
    {
        $posts = get_posts([
            'post_type' => $post_type,
            'post_status' => 'publish',
            'numberposts' => -1,
            'order' => 'ASC'
        ]);
        $associative_posts = array();

        $field_id = $post_type . '-post-list';
        foreach ($posts as $post) {
            $id = $post->ID;
            $associative_posts[$id] = $post->post_title;
        }
        if ($field_type == 'checkbox') {
            return Checkbox::make(__($field_name, 'rosecrance'), $field_id)
                ->choices($associative_posts)
                ->returnFormat('value');
        }
        return Select::make(__($field_name, 'rosecrance'), $field_id)
            ->choices($associative_posts)
            ->returnFormat('value');
    }

    public static function getCardPriorityField()
    {
        return Select::make(__('Card Priority', 'rosecrance'))
            ->choices([
                '1' => __('high', 'rosecrance'),
                '2' => __('medium', 'rosecrance'),
                '3' => __('low', 'rosecrance'),
            ])
            ->returnFormat('id')
            ->defaultValue('3')
            ->instructions(__('Sets the priority that cards appear on aggregate pages such as "Programs and Services"', 'rosecrance'));
    }

    public static function getInsuranceField()
    {
        return Checkbox::make(__('Accepted Insurance', 'rosecrance'), 'accepted-insurance')
            ->choices([
                'government' => __('Government Assisted', 'rosecrance'),
                'private' => __('Private Insurance', 'rosecrance')
            ])
            ->defaultValue('private')
            ->returnFormat('array');
    }

    public static function getBackgroundSize()
    {
        return Select::make(__('Background Size', 'rosecrance'), 'background-size')
            ->choices([
                'auto auto' => __('Auto', 'rosecrance'),
                'cover'     => __('Cover', 'rosecrance'),
                'contain'   => __('Contain', 'rosecrance'),
                'inherit'   => __('Inherit', 'rosecrance'),
            ])
            ->defaultValue('cover')
            ->returnFormat('value');
    }

    public static function getBackgroundPosition($defaultValue = 'center center')
    {
        return Select::make(__('Position', 'rosecrance'))
            ->choices([
                'left top'      => __('Left / Top', 'rosecrance'),
                'left center'   => __('Left / Center', 'rosecrance'),
                'left bottom'   => __('Left / Bottom', 'rosecrance'),
                'right top'     => __('Right / Top', 'rosecrance'),
                'right center'  => __('Right / Center', 'rosecrance'),
                'right bottom'  => __('Right / Bottom', 'rosecrance'),
                'center top'    => __('Center / Top', 'rosecrance'),
                'center center' => __('Center / Center', 'rosecrance'),
                'center bottom' => __('Center / Bottom', 'rosecrance'),
            ])
            ->defaultValue($defaultValue)
            ->returnFormat('value');
    }

    public static function getBackgroundRepeat($defaultValue = 'no-repeat')
    {
        return Select::make(__('Repeat', 'rosecrance'))
        ->choices([
            'no-repeat' => __('No Repeat', 'rosecrance'),
            'repeat'    => __('Repeat', 'rosecrance'),
            'repeat-x'  => __('Repeat (X)', 'rosecrance'),
            'repeat-y'  => __('Repeat (Y)', 'rosecrance'),
        ])
        ->defaultValue($defaultValue)
        ->returnFormat('value');
    }

    public static function getBackgroundSettingsGroup($group_name = 'Background Settings', $field_group = 'background-settings')
    {
        return Group::make(__($group_name, 'rosecrance'), $field_group)
            ->layout('block')
            ->fields([
                Image::make(__('Image', 'rosecrance'), 'image')
                    ->previewSize('thumbnail'),
                Common::getBackgroundOverlayOpacity(),
                Common::getBackgroundSize()
                    ->wrapper([
                        'width' => '33.33'
                    ]),
                Common::getBackgroundPosition()
                    ->wrapper([
                        'width' => '33.33'
                    ]),
                Common::getBackgroundRepeat()
                    ->wrapper([
                        'width' => '33.33'
                    ]),
            ]);
    }

    public static function backgroundFillGroup()
    {
        return Group::make(__('Background Fill', 'rosecrance'), 'module-background-fill')
            ->layout('block')
            ->fields([
                ButtonGroup::make(__('Background Fill Type', 'rosecrance'), 'background-type')
                    ->choices([
                        'default' => __('Default', 'rosecrance'),
                        'full-fill' => __('Full', 'rosecrance'),
                        'top-half-fill' => __('Top Half', 'rosecrance'),
                        'bottom-half-fill' => __('Bottom Half', 'rosecrance'),
                        'custom-percentage' => __('Custom Percentage', 'rosecrance')
                    ])
                    ->defaultValue('default'),
                Select::make(__('Fill Color', 'rosecrance'), 'fill-color')
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
                    ->conditionalLogic([
                        ConditionalLogic::where('background-type', '!=', 'default')
                    ]),
                Range::make(__('Percentage', 'rosecrance'), 'percentage')
                    ->min(0)
                    ->max(100)
                    ->step(5)
                    ->DefaultValue(0)
                    ->wrapper([
                        'width' => '50'
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::where('background-type', '==', 'custom-percentage')
                    ]),
                ButtonGroup::make(__('Direction', 'rosecrance'), 'direction')
                    ->choices([
                        'to top' => __('From Top', 'rosecrance'),
                        'to bottom' => __('From Bottom', 'rosecrance')
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::where('background-type', '==', 'custom-percentage')
                    ])
                    ->defaultValue('to top'),
                    ]);
    }

    public static function getBackgroundOverlayOpacity()
    {
        return Select::make(__('Overlay Tint Amount'), 'overlay-opacity')
            ->choices([
                '0' => __('None', 'rosecrance'),
                '20' => __('20%', 'rosecrance'),
                '40' => __('40%', 'rosecrance'),
            ])
            ->defaultValue('0');
    }


    /**
     * Padding Options Group
     *
     * @param array $defaults [mpt, mpb, dpt, dpb]
     * @return Group
     */
    public static function paddingGroup($defaults = [0, 0, 0, 0])
    {
        return Group::make(__('Padding', 'rosecrance'), 'padding')
            ->layout('block')
            ->fields([
                ButtonGroup::make(__('Adjust Padding', 'rosecrance'), 'adjust-padding')
                    ->choices([
                        'false' => __('False', 'rosecrance'),
                        'true' => __('True', 'rosecrance')
                    ])
                    ->defaultValue('false'),
                Group::make(__('Mobile', 'rosecrance'), 'mobile')
                    ->layout('block')
                    ->fields([
                        Range::make(__('Top', 'rosecrance',), 'top')
                            ->min(0)
                            ->max(200)
                            ->step(8)
                            ->DefaultValue($defaults[0])
                            ->wrapper([
                                'width' => '50'
                            ])
                            ->append('px'),
                        Range::make(__('Bottom', 'rosecrance',), 'bottom')
                            ->min(0)
                            ->max(200)
                            ->step(8)
                            ->DefaultValue($defaults[1])
                            ->wrapper([
                                'width' => '50'
                            ])
                            ->append('px')
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::where('adjust-padding', '==', 'true')
                    ]),
                Group::make(__('Desktop', 'rosecrance'), 'desktop')
                    ->layout('block')
                    ->fields([
                        Range::make(__('Top', 'rosecrance',), 'top')
                            ->min(0)
                            ->max(200)
                            ->step(8)
                            ->DefaultValue($defaults[2])
                            ->wrapper([
                                'width' => '50'
                            ])
                            ->append('px'),
                        Range::make(__('Bottom', 'rosecrance',), 'bottom')
                            ->min(0)
                            ->max(200)
                            ->step(8)
                            ->DefaultValue($defaults[3])
                            ->wrapper([
                                'width' => '50'
                            ])
                            ->append('px')
                    ])
                    ->conditionalLogic([
                        ConditionalLogic::where('adjust-padding', '==', 'true')
                    ]),
            ]);
    }

    public static function anchorData()
    {
        return Group::make(__('Anchor Data', 'rosecrance'), 'anchor-data')
            ->layout('block')
            ->fields([
                Text::make(__('Anchor ID', 'rosecrance'), 'anchor-id')
                    ->wrapper([
                        'width' => '50'
                    ]),
                Text::make(__('Anchor Name', 'rosecrance'), 'anchor-name')
                    ->wrapper([
                        'width' => '50'
                    ]),
            ]);
    }
}

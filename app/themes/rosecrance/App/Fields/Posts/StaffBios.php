<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\Layouts;
use Extended\ACF\Fields\Group;
use Extended\ACF\Fields\Relationship;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\WysiwygEditor;
use Rosecrance\App\Fields\Common;

/**
 * Class StaffBios
 *
 * @package Rosecrance\App\Fields\Posts
 */
class StaffBios extends Layouts
{
    /**
     * Defines fields used within Staff Bios post type.
     *
     * @return array
     */
    public function fields()
    {
        $filters = apply_filters(
            'rosecrance/posts/staff-bios',
            [
                $this->contentTab(),
                Text::make(__('Full Name', 'rosecrance'), 'name')
                    ->required(),
                Text::make(__('Specialty', 'rosecrance'), 'specialty')
                  ->instructions(__('Example: MD, Addictionologist, etc.', 'rosecrance')),
                Text::make(__('Job Title', 'rosecrance'), 'job-title')
                  ->instructions(__('Rosecrance job title', 'rosecrance')),
                Common::getBackgroundSettingsGroup('Main Image Settings', 'bio-image')
                  ->instructions(__('If no image is selected, a placeholder will be used.', 'rosecrance')),
                WysiwygEditor::make(__('Bio Detail', 'rosecrance'), 'bio-detail')
            ]
        );
        return $filters;
    }
}

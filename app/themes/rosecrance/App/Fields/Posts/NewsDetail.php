<?php

namespace Rosecrance\App\Fields\Posts;

use Rosecrance\App\Fields\Layouts\ContentBanner;
use Rosecrance\App\Fields\Layouts\Layouts;
use Rosecrance\App\Fields\Layouts\ResourceHero;
use Rosecrance\App\Fields\Layouts\Wysiwyg;
use Rosecrance\App\Fields\Layouts\Media;
use Extended\Acf\Fields\FlexibleContent;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;

/**
 * Class NewsDetail
 *
 * @package Rosecrance\App\Fields\Posts
 */
class NewsDetail extends Layouts
{
    /**
     * Defines fields used within News Detail post type.
     *
     * @return array
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/posts/news-detail',
            [
                $this->contentTab(),
                FlexibleContent::make(__('Modules', 'rosecrance'), 'modules')
                  ->buttonLabel(__('Add Element', 'rosecrance'), 'rosecrance')
                  ->layouts([
                      (new ContentBanner())->fields(),
                      (new Media())->fields(),
                      (new ResourceHero())->fields(),
                      (new Wysiwyg())->fields(),
                  ]),
                $this->optionsTab(),
                Text::make(__('Name', 'rosecrance'), 'name'),
                Textarea::make(__('Description', 'rosecrance'), 'description'),
            ]
        );
    }
}

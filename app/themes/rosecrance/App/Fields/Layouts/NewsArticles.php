<?php

namespace Rosecrance\App\Fields\Layouts;

use Extended\ACF\Fields\Layout;
use Extended\ACF\Fields\Text;
use Rosecrance\App\Fields\Common;

/**
 * Class NewsArticles
 *
 * @package Rosecrance\App\Fields\Layouts
 */
class NewsArticles extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'rosecrance/layout/carousel',
            Layout::make(__('News Articles', 'rosecrance'), 'news-articles')
                ->layout('block')
                ->fields([
                  $this->contentTab(),
                  Text::make(__('Module Title', 'rosecrance'), 'title')
                    ->required(),
                  $this->styleTab(),
                  Common::paddingGroup(DEFAULT_NEWS_ARTICLES_PADDING),
                ])
        );
    }
}
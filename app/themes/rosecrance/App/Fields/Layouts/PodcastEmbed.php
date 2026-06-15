<?php

namespace Rosecrance\App\Fields\Layouts;

use Rosecrance\App\Fields\Common;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Layout;

/**
 * Class Podcast Embed
 *
 * @package Extended\App\Fields\Layouts
 */
class PodcastEmbed extends Layouts
{
    /**
     * Defines fields for this layout.
     *
     * @return object
     */
    public function fields()
    {
        return apply_filters(
            'cn/layout/podcast-embed',
            Layout::make(__('Podcast Embed', 'rosecrance'), 'podcast-embed')
                ->layout('block')
                ->fields([
                    $this->contentTab(),
                    Textarea::make(__('Spotify Embed', 'rosecrance'), 'spotify-embed'),
                    $this->styleTab(),
                    Common::paddingGroup(DEFAULT_PODCAST_EMBED_PADDING),
                    Common::backgroundFillGroup()
                ])
        );
    }
}

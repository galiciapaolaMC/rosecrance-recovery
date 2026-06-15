<?php

/**
 * ACF Module: Podcast Embed
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$spotify_embed = ACF::getField('spotify-embed', $data);

if (!$spotify_embed) {
    return;
}

do_action('rosecrance/modules/styles', $row_id, $data);

?>

<section class="module podcast-embed" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-container uk-container-medium">
        <div class="podcast-embed__content">
            <?php echo apply_filters('the_content', $spotify_embed); ?>
        </div>
    </div>
</section>
<?php

/**
 * ACF Module: Bio List
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$bio_list_type = ACF::getField('list-type', $data, 'manual-selection');
$bio_list_heading = ACF::getField('heading', $data);
$bio_list_description = ACF::getField('description', $data);
$view_all_button = ACF::getField('view-all-button', $data, 'active');

do_action('rosecrance/modules/styles', $row_id, $data);

if ($bio_list_type === 'manual-selection') {
    $bio_post_ids = ACF::getField('bios', $data);
    if (!is_array($bio_post_ids)) {
        $bio_post_ids = !empty($bio_post_ids) ? [$bio_post_ids] : [];
    }
    $bios = array();

    foreach ($bio_post_ids as $post_id) {
        $post_status = get_post_status($post_id);
        
        if ($post_status !== 'publish') {
            continue;
        }

        $post_data = ACF::getPostMeta($post_id);
        $bios[] = $post_data;
    }

    if ($view_all_button === 'active') {
        $visible_bios = array_slice($bios, 0, BIO_SHOW_COUNT);
        $hidden_bios = array_slice($bios, BIO_SHOW_COUNT);
    } else {
        $visible_bios = $bios;
        $hidden_bios = array();
    }
}

if ($bio_list_type === 'groups') {
    $groups = ACF::getField('groups', $data);
    if (!empty($groups)) {
        if (!is_array($groups)) {
            $groups = [$groups];
        }
        foreach ($groups as $group_id) {
            $bios_query = new WP_Query([
                'post_type' => 'staff-bios',
                'orderby' => 'title',
                'order' => 'ASC',
                'tax_query' => [
                    [
                        'taxonomy' => 'staff-type',
                        'field' => 'term_id',
                        'terms' => $group_id,
                    ]
                ],
                'posts_per_page' => -1,
            ]);

            $bio_post_ids = wp_list_pluck($bios_query->posts, 'ID');

            $bios = array();
            foreach ($bio_post_ids as $post_id) {
                $post_status = get_post_status($post_id);
                
                if ($post_status !== 'publish') {
                    continue;
                }

                $post_data = ACF::getPostMeta($post_id);
                $bios[] = $post_data;
            }

            if ($view_all_button === 'active') {
                $visible_bios = array_slice($bios, 0, BIO_SHOW_COUNT);
                $hidden_bios = array_slice($bios, BIO_SHOW_COUNT);
            } else {
                $visible_bios = $bios;
                $hidden_bios = array();
            }
        }
    }
}
?>

<section class="module bio-list" id="<?php echo esc_html($row_id); ?>" >
    <div class="bio-list__wrapper">
        <?php if (!empty($bio_list_heading)) {
            echo nl2br(Util::getHTML(
                $bio_list_heading,
                'h2',
                ['class' => 'bio-list__heading']
            ));
        } ?>
        <?php if (!empty($bio_list_description)) { ?>
            <p class="bio-list__description"> <?php echo esc_html($bio_list_description) ?> </p>
        <?php } ?>
        
    

        <div class="bio-list__bios-container">
            <?php 
                foreach($visible_bios as $index => $visible_bio) {
                    echo Util::getBioCardHtml($visible_bio, $row_id);
                }
            ?>
        </div>

        <?php if (!empty($hidden_bios)) {
            if (count($bios) > BIO_SHOW_COUNT) { ?>
                <div class="bio-list__view-more-bios-container">
                    <?php 
                        foreach($hidden_bios as $index => $hidden_bio) {
                            echo Util::getBioCardHtml($hidden_bio, $row_id);
                        }
                    ?>
                </div>
                <div class="bio-list__view-more-button-container">
                    <button class="bio-list__button btn btn-primary" data-view-more-text="<?php _e('View More Team Members', 'rosecrance'); ?>" data-view-fewer-text="<?php _e('View Fewer Team Members', 'rosecrance'); ?>">
                        <?php _e('View More Team Members', 'rosecrance'); ?>
                    </button>
                </div>
            <?php } 
        } ?>
    </div>
</section>

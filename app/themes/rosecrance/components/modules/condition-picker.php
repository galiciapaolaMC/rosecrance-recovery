<?php

/**
 * ACF Module: Condition Picker
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$headline = ACF::getField('headline', $data);
$headline_type = ACF::getField('headline-type', $data, 'h1');
$content  = ACF::getField('content', $data);
$selector_text = ACF::getField('selector-text', $data);
$button_text = ACF::getField('button-text', $data);
$mobile_background = ACF::getField('background-mobile_image', $data);

do_action('rosecrance/modules/styles', $row_id, $data);

$condition_args = array(
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'post_type' => 'conditions',
    'orderby' => 'title',
    'order' => 'ASC'
);

$condition_posts = get_posts($condition_args);

$associative_conditions_arr = array( '' => 'We offer hope for:');
foreach ($condition_posts as $condition_post) {
    $post_id = $condition_post->ID;
    $permalink = get_the_permalink($post_id);
    $associative_conditions_arr[$permalink] = get_the_title($post_id);
}
?>

<section class="module condition-picker" id="<?php echo esc_html($row_id); ?>">
    <div class="uk-position-relative">
        <div class="condition-picker__background">
            <?php if (!empty($mobile_background)) { ?>
                <div class="background-desktop uk-visible@m" <?php echo Util::getInlineBackgroundStyles($data); ?>></div>
                <div class="background-mobile uk-hidden@m" <?php echo Util::getInlineBackgroundStylesMobile($data); ?>></div>
            <?php } else { ?>
                <div class="background-desktop" <?php echo Util::getInlineBackgroundStyles($data); ?>></div>
            <?php } ?>
        </div>

        <div class="uk-container uk-container-medium">
            <div class="condition-picker__wrapper">
                <?php if (!empty($headline)) { 
                    echo nl2br(Util::getHTML(
                        $headline,
                        $headline_type,
                        ['class' => 'condition-picker__headline']
                    ));
                } ?>

                <?php if (!empty($content)) { ?>
                    <div class="condition-picker__content content-block">
                        <?php echo apply_filters('the_content', $content); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="uk-container uk-container-medium selector-content">
        <div class="condition-picker__selector">
            <?php echo Util::getSelectFieldHtml('conditions', null, $associative_conditions_arr, ''); ?>
            <button class="condition-picker__button btn btn-primary" aria-label="<?php _e('Select Condition', 'rosecrance'); ?>">
                <?php echo esc_html($button_text); ?>

                <svg class="icon icon-arrow-right-dark" aria-hidden="true">
                    <use xlink:href="#icon-arrow-right-dark"></use>
                </svg> 
            </button>
        </div>
    </div>
</section>
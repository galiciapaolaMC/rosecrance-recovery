<?php
/**
 * ACF Module: Fifty Fifty Statistics
 *
 * @var array $data
 * @var string $row_id
 *
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$eyebrow = ACF::getField('eyebrow', $data, null);
$columns = ACF::getRowsLayout('columns', $data);
$background_color = ACF::getField('background-color', $data);
$background_animation = ACF::getField('background-animation', $data, 'inactive');
$gap_size = ACF::getField('gap_size', $data);
$reverse_columns_mobile = ACF::getField('reverse_mobile', $data);
$statistic_type = ACF::getField('statistic-type', $data);
$statistic_value = ACF::getField('statistic-value', $data);
$headline_text = ACF::getField('headline-text', $data);
$top_content_alignment = ACF::getField('top-content-alignment', $data);
$content = ACF::getField('content', $data);
$anchor_id = ACF::getField('anchor-data_anchor-id', $data);
$anchor_name = ACF::getField('anchor-data_anchor-name', $data);
$column_count = count($columns);
$column_gap = "uk-grid-{$gap_size}";
$reverse_mobile = '';
$class_parallax = '';

if (!empty($section_class)) {
    $section_class = " {$section_class}";
}

if ($reverse_columns_mobile === '1' && $column_count === 2) {
    $reverse_mobile = 'reverse';
}

if ($column_count === 1) {
    $classes = 'uk-child-width-expand';
} elseif ($column_count === 2) {
    $classes = 'uk-child-width-1-2@m';
} elseif ($column_count === 3) {
    $classes = 'uk-child-width-1-2@s uk-child-width-1-3@m';
} elseif ($column_count === 4) {
    $classes = 'uk-child-width-1-2@s uk-child-width-1-4@m';
}

$grid_classes = "{$column_gap} {$classes} {$reverse_mobile}";

do_action('rosecrance/modules/styles', $row_id, $data);

if ($background_animation === 'active') {
    $class_parallax = 'parallax-active';
}

?>

<section id="<?php echo esc_attr($row_id); ?>" class="module fifty-fifty-statistics scroll-module background-<?php echo esc_attr($background_color); ?> <?php echo esc_attr($class_parallax); ?>" anchor-id="<?php echo esc_attr($anchor_id); ?>" anchor-name="<?php echo esc_attr($anchor_name); ?>">
    <div class="statistic alignment-<?php echo esc_attr($top_content_alignment); ?>">
        <div class="uk-container uk-container-large">
            <div class="statistic__wrapper">
                <?php
                if (isset($eyebrow)) {
                    echo nl2br(Util::getHTML(
                        $eyebrow,
                        'h2',
                        ['class' => 'statistic__eyebrow']
                    ));
                }
                if ($statistic_type === 'percentage') { ?>
                    <div class="statistic__percentage">
                        <div class="statistic__percentage--value">
                            <p class="text-parallax" ><?php echo esc_html($statistic_value); ?></p>
                            <p class="percentage-icon text-parallax uk-hidden@m" ><?php _e('%', 'rosecrance'); ?></p>
                        </div>
                        <div class="statistic__percentage--percentage">
                            <p class="percentage-icon text-parallax uk-visible@m" ><?php _e('%', 'rosecrance'); ?></p>
                            <div class="statistic__percentage--content content-parallax">
                                <?php echo apply_filters('the_content', $content); ?>
                            </div>
                        </div>
                    </div>
                <?php } else if ($statistic_type === 'number') { ?>
                    <div class="statistic__number">
                        <span class="statistic__number--value text-parallax" ><?php echo esc_html($statistic_value); ?></span>
                        <div class="statistic__number--content content-parallax">
                            <?php echo apply_filters('the_content', $content); ?>
                        </div>
                    </div>
                <?php } else if ($statistic_type === 'headline') { ?> 
                    <div class="statistic__headline">
                        <h2 class="text-parallax" ><?php echo esc_html($headline_text); ?></h2> 
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="fifty-fifty-statistics__grid-wrapper uk-container uk-container-large">
        <div class="<?php echo $grid_classes; ?>" uk-height-match uk-grid>
            <?php
            
            foreach ($columns as $index => $col) :
                $dats = ACF::getRowsLayout('modules', $col);
                
                $cell_number = 'cell-' . ($index + 1);

                ?>
                <div class="fifty-fifty-statistics__cell <?php echo $cell_number; ?>">
                    <div class="fifty-fifty-statistics__container">
                        <?php foreach ($col['modules'] as $ind => $el) {
                            $data = $dats[$ind];
                            $part = implode('-', explode('_', $el));
                            
                            $file = locate_template("components/partials/{$part}.php");
                            if (file_exists($file)) {
                                include $file;
                            }
                        } ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


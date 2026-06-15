<?php
/**
 * ACF Module: Fifty Fifty
 *
 * @var array $data
 * @var string $row_id
 *
 */

use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;

$columns = ACF::getRowsLayout('columns', $data);
$background_color = ACF::getField('background_color', $data);
$gap_size = ACF::getField('gap_size', $data);
$reverse_columns_mobile = ACF::getField('reverse_mobile', $data);
$anchor_id = ACF::getField('anchor-data_anchor-id', $data);
$anchor_name = ACF::getField('anchor-data_anchor-name', $data);
$column_count = count($columns);
$column_gap = "uk-grid-{$gap_size}";
$vertical_alignment = ACF::getField('module-vertical-alignment', $data);
$reverse_mobile = '';

if (!empty($section_class)) {
    $section_class = " {$section_class}";
}

if ($reverse_columns_mobile === '1' && $column_count === 2) {
    $reverse_mobile = 'reverse';
}

$vertical_alignment_class = 'fifty-fifty__cell--align-center';

if ($vertical_alignment === 'top') {
    $vertical_alignment_class = 'fifty-fifty__cell--align-top';
} elseif ($vertical_alignment === 'middle') {
    $vertical_alignment_class = 'fifty-fifty__cell--align-center';
} elseif ($vertical_alignment === 'bottom') {
    $vertical_alignment_class = 'fifty-fifty__cell--align-bottom';
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
?>

<section id="<?php echo esc_attr($row_id); ?>" class="module fifty-fifty scroll-module" style="background: <?php echo esc_attr($background_color); ?>;" anchor-id="<?php echo esc_attr($anchor_id); ?>" anchor-name="<?php echo esc_attr($anchor_name); ?>">
    <div class="fifty-fifty__grid-wrapper uk-container uk-container-medium">
        <div class="<?php echo $grid_classes; ?>" uk-height-match uk-grid>
            <?php
            
            foreach ($columns as $index => $col) :
                $dats = ACF::getRowsLayout('modules', $col);
                
                $cell_number = 'cell-' . ($index + 1);

                ?>
                <div class="fifty-fifty__cell <?php echo $vertical_alignment_class; ?> <?php echo $cell_number; ?>">
                    <div class="fifty-fifty__container">
                        <?php foreach ($col['modules'] as $ind => $el) {
                            $data = $dats[$ind];
                            $part = implode('-', explode('_', $el));
                            if ($part === 'salesforce-form') {
                                $file = locate_template("components/modules/{$part}.php");
                                if (file_exists($file)) {
                                    include $file;
                                }
                            } else {
                                $file = locate_template("components/partials/{$part}.php");
                                if (file_exists($file)) {
                                    include $file;
                                }
                            }
                        } ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
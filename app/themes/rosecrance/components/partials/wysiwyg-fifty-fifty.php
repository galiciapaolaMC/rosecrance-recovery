<?php

/**
 * ACF Module Partial: Subhead
 *
 * @var array $data
 * @var string $row_id
 */

use Rosecrance\App\Fields\ACF;

$apply_form_styling = ACF::getField('apply-form-styling', $data);

$form_styling_class = $apply_form_styling ? 'wysiwyg-fifty-fifty--with-form-styling' : '';
$content = ACF::getField('content', $data);
$add_script = ACF::getField('add-script', $data);
?>

<div class="partial wysiwyg-fifty-fifty <?php echo esc_attr($form_styling_class)?>">
    <div class="fifty-fifty__container">
        <?php echo apply_filters('the_content', $content); ?>

        <?php if ($add_script === 'yes') : 
            $script = ACF::getField('script', $data);
            echo $script;
        endif; ?>
    </div>
</div>
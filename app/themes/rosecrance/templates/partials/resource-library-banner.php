<?php

/**
 * Template partial: resource-library-banner
 *
 * @var string $page_title
 * @var string $parent_class_name
 */

$default_parent_class_name = 'resource-library';
$default_title = __('All Resources', 'rosecrance');
if (!isset($parent_class_name)) {
    $parent_class_name = $default_parent_class_name;
}

if (!isset($page_title)) {
    $page_title = $default_title;
}

$section_class_name = $parent_class_name . '__banner';
$backgroundStyle = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/rosecrance-bg.png);"';

?>
    <div class="resource-library-banner <?php echo esc_html($section_class_name); ?>" <?php echo $backgroundStyle; ?>>
        <h1 class="resource-library-banner__heading <?php echo esc_html($parent_class_name . '__heading'); ?>">
            <?php echo esc_html($page_title); ?>
        </h1>
    </div>
<?php

<?php

namespace Rosecrance\App\Fields;

use Rosecrance\App\Interfaces\WordPressHooks;

/**
 * Class Modules
 *
 * @package Rosecrance\App\Fields
 */
class Modules implements WordPressHooks
{

    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('rosecrance/modules/output', [$this, 'outputFlexibleModules']);
        add_action('rosecrance/modules/styles', [$this, 'outputModuleStyles'], 10, 2);
        add_action('admin_head', [$this, 'disableClassicEditor']);
        add_filter('gutenberg_can_edit_post_type', [$this, 'disableGutenberg'], 10, 2);
        add_filter('use_block_editor_for_post_type', [$this, 'disableGutenberg'], 10, 2);
        add_filter('rosecrance/location/search-card', [$this, 'outputLocationSearchCard'], 10, 1);
        add_filter('rosecrance/search-page/search-result', [$this, 'outputSearchResult'], 10, 1);
    }

    /**
     * Loop through flexible modules meta and include each module file to the page.
     * $data is set to the scope of just the current module, so that only relevant values are passed to each file.
     *
     * @param $post_id
     */
    public function outputFlexibleModules($post_id)
    {
        $post_id = $post_id ?: get_the_ID();
        $meta    = ACF::getPostMeta($post_id);

        if (!empty($meta['modules']) && is_array($meta['modules'])) {
            $modules = ACF::getRowsLayout('modules', $meta);

            foreach ($meta['modules'] as $index => $module) {
                $data   = $modules[$index];
                $row_id = $module . '-' . $index;

                $file = locate_template("components/modules/{$module}.php");
                if (file_exists($file)) {
                    include($file);
                }
            }
        }
    }

    /**
     * Disable Classic Editor by template
     */
    public function disableClassicEditor()
    {
        $post_id = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
        $screen  = get_current_screen();
        if ('page' !== $screen->id || !isset($post_id)) {
            return;
        }
        if (!self::disableEditor($_GET['post'])) {
            remove_post_type_support('page', 'editor');
        }
    }

    /**
     * Disable Gutenberg by template
     *
     * @param $can_edit
     * @param $post_type
     *
     * @return bool
     */
    public function disableGutenberg($can_edit, $post_type)
    {
        $post_id = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
        if (!(is_admin() && !empty($post_id))) {
            return $can_edit;
        }

        return self::disableEditor($post_id);
    }

    /**
     * Templates and Page IDs without editor
     *
     * @param bool $id
     *
     * @return bool
     */
    public static function disableEditor($id = false)
    {
        $disabled_templates = [
            'templates/page-builder.php',
            'templates/locations-builder.php',
        ];

        if (empty($id)) {
            return false;
        }

        $template = get_page_template_slug($id);

        return !in_array($template, $disabled_templates);
    }

    public static function getBackgroundStyles($data)
    {
        $backgroundType = ACF::getField('module-background-fill_background-type', $data, 'default');
        $backgroundColor = ACF::getField('module-background-fill_fill-color', $data, '#FAA834');
        $direction = 'to bottom';
        $percentage = '50';
        if (!isset($backgroundType) || $backgroundType === 'default') {
            return '';
        } else if ($backgroundType === 'full-fill') {
            return 'background-color: ' . $backgroundColor;
        } else if ($backgroundType === 'top-half-fill') {
            $direction = 'to top';
        }

        $custom_percentage = ACF::getField('module-background-fill_percentage', $data);
        if (!empty($custom_percentage) && $backgroundType === 'custom-percentage')
        {
            $percentage = 100 - $custom_percentage;
            $direction = ACF::getField('module-background-fill_direction', $data, $direction);
        }
        return 'background: linear-gradient('. $direction .', transparent 0%, transparent ' . $percentage . '%, '. $backgroundColor .' ' . $percentage . '%, ' . $backgroundColor . ' 100%);';
    }

    /**
     * Print module specific styles if set
     *
     * @param string $row_id
     * @param array $data
     */
    public function outputModuleStyles($row_id, $data)
    {
        if (empty($row_id) || empty($data)) {
            return false;
        }

        $padding = $data['defaults']['padding'] ?? [0, 0, 0, 0];
        $adjust_padding = ACF::getField('padding_adjust-padding', $data);
        $padding_desktop_top = ACF::getField('padding_desktop_top', $data, $padding[2]) . 'px';
        $padding_desktop_bottom = ACF::getField('padding_desktop_bottom', $data, $padding[3]) . 'px';
        $padding_mobile_top  = ACF::getField('padding_mobile_top', $data, $padding[0]) . 'px';
        $padding_mobile_bottom  = ACF::getField('padding_mobile_bottom', $data, $padding[1]) . 'px';
        $background_styles = $this::getBackgroundStyles($data);
        
        if ($padding_desktop_top === '0px' && $padding_desktop_bottom === '0px' && $padding_mobile_top === '0px' && $padding_mobile_bottom === '0px' && $background_styles === '') {
            return;
        }

        echo '<style type="text/css">';

        if ($adjust_padding === 'true') {
            printf(
                '#%1$s { padding-top: %2$s; padding-bottom: %3$s; %4$s}',
                esc_html($row_id),
                esc_html($padding_mobile_top),
                esc_html($padding_mobile_bottom),
                esc_html($background_styles)
            );

            printf(
                '@media (min-width: 992px) {
                        #%1$s { padding-top: %2$s; padding-bottom: %3$s; }
                    }',
                esc_html($row_id),
                esc_html($padding_desktop_top),
                esc_html($padding_desktop_bottom)
            );
        } else {
            if (!empty($background_styles)) {
                printf(
                    '#%1$s { %2$s; }',
                    esc_html($row_id),
                    esc_html($background_styles)
                );
            }
        }

        echo '</style>';
    }

    /**
     * Return string of block html
     *
     * @param array $card
     *
     * @return string
     */
    public function outputLocationSearchCard($card)
    {
        $html = '';
        $file = locate_template("components/partials/location-search-card.php");
        if (file_exists($file)) {
            ob_start();
            include $file;
            $html .= ob_get_contents();
            ob_get_clean();
        }

        return $html;
    }

    /**
     * Return string of block html
     *
     * @param array $post_id
     *
     * @return string
     */
    public function outputSearchResult($post_id)
    {
        $html = '';
        $file = locate_template("content/archive/search.php");
        if (file_exists($file)) {
            ob_start();
            include $file;
            $html .= ob_get_contents();
            ob_get_clean();
        }

        return $html;
    }
}

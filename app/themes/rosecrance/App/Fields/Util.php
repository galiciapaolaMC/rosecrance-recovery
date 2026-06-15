<?php

namespace Rosecrance\App\Fields;

use Rosecrance\App\Media;

/**
 * Class Util
 *
 * @package Rosecrance\App\Fields
 */
class Util
{

    /**
     * Wraps data in HTML w/ optional attributes / escaping.
     *
     * @param       $data - the content (typically text) to wrap
     * @param       $element - the HTML element to wrap the content with
     * @param array $atts - any attributes that should be added to the HTML element
     * @param mixed $escape - whether to escape $data - defaults to true - can be an escaping function
     * @param bool  $self_closing - whether the element is self closing i.e. <img />
     *
     * @return string - an HTML element.
     */
    public static function getHTML($data = null, $element = 'span', $atts = [], $escape = true, $self_closing = false)
    {
        $atts_output = ' ';

        // data cannot be empty without the element being self-closing
        if (empty($data) && $self_closing === false) {
            return '';
        }

        if (is_callable($escape)) {
            $data = $escape($data);
        } elseif ($escape) {
            $data = esc_html($data);
        }

        foreach ($atts as $key => $att) {
            // do not proceed if key is empty
            if (empty($key)) {
                continue;
            }

            // if key is present and attribute is empty, add only key to output.
            // This allows for HTML5 boolean attributes.
            // e.g. <input type="checkbox" checked disabled>Test</input>
            if (!isset($att) || empty($att)) {
                $atts_output .= esc_attr($key) . ' ';
                continue;
            }

            $atts_output .= esc_attr($key) . '="' . esc_attr($att) . '" ';
        }

        return $self_closing ? '<' . $element . $atts_output . ' />' : '<' . $element . $atts_output . '>' . $data . '</' . $element . '>';
    }


    /**
     * Helper/wrapper function that makes dealing with ACF image objects easier.
     * Grabs the required data from the ACF image object renders values into proper image markup.
     *
     * @param $attachment
     * @param string $size
     * @param array $args
     *
     * @return string
     */
    public static function getImageHTML($attachment, $size = 'medium', $args = [])
    {
        $src    = ACF::getField($size, $attachment->sizes, $attachment->url);
        $alt    = !empty($attachment->alt) ? esc_attr($attachment->alt) : esc_attr($attachment->title);
        $params = '';
        foreach ($args as $attr => $value) {
            $params .= sprintf(
                ' %1$s="%2$s"',
                $attr,
                esc_attr($value)
            );
        }
        $image_markup = sprintf(
            '<img src="%1$s" alt="%2$s"%3$s>',
            esc_url($src),
            esc_attr($alt),
            $params
        );
        // check for image caption
        if (!empty($attachment->caption)) {
            $image_markup = sprintf(
                '<figure class="image__caption">%1$s <figcaption>%2$s</figcaption></figure>',
                $image_markup,
                esc_html($attachment->caption)
            );
        }

        return $image_markup;
    }

    /** 
     * Replacement method for getInlineBackgroundStyles and getInlineBackgroundStylesMobile -- allows definition of the fieldgroup
     *
     * @param $data
     * @param $size
     *
     * @return string
     */
    public static function getAgnosticInlineBackgroundStyles($data, $field_group = 'background-desktop', $size = 'full')
    {
        if (empty($data) || !isset($data[$field_group])) {
            return '';
        }

        $image      = ACF::getField($field_group . '_image', $data);

        if (empty($image))
        {
            return '';
        }

        $attachment = !empty($image) ? Media::getAttachmentByID($image) : false;
        $src        = ACF::getField($size, $attachment->sizes, $attachment->url);
        $overlay_opacity = ACF::getField($field_group . '_overlay-opacity', $data, 0);
        $linear_gradient = sprintf(
            'linear-gradient(rgba(72,72,72, %1$s), rgba(72,72,72, %1$s))',
            $overlay_opacity . '%'
        );

        // build out our inline background styles
        $styles = sprintf(
            'style="background: %1$s, %2$s %3$s %4$s/%5$s;"',
            $linear_gradient,
            'url( ' . (!empty($attachment) ? esc_url($src) : '') . ')',
            ACF::getField($field_group . '_repeat', $data, 'no-repeat'),
            ACF::getField($field_group . '_position', $data, 'center center'),
            ACF::getField($field_group . '_background-size', $data, 'auto auto')
        );

        return $styles;
    }

    /**
     * Check for desktop background options in module data and output inline styles.
     *
     * @param $data
     * @param $size
     *
     * @return string
     */
    public static function getInlineBackgroundStyles($data, $size = 'full')
    {
        if (empty($data) || !isset($data['background-desktop'])) {
            return '';
        }

        $image      = ACF::getField('background-desktop_image', $data);
        $attachment = !empty($image) ? Media::getAttachmentByID($image) : false;
        $src        = ACF::getField($size, $attachment->sizes, $attachment->url);

        // build out our inline background styles
        $styles = sprintf(
            'style="background: %1$s %2$s %3$s %4$s/%5$s;"',
            ACF::getField('background-desktop_color', $data, '#FFFFFF'),
            'url( ' . (!empty($attachment) ? esc_url($src) : '') . ')',
            ACF::getField('background_repeat', $data, 'no-repeat'),
            ACF::getField('background-desktop_position', $data, 'center center'),
            ACF::getField('background-desktop_size', $data, 'auto auto')
        );

        return $styles;
    }

    /**
     * Check for mobile background options in module data and output inline styles.
     *
     * @param $data
     * @param $size
     *
     * @return string
     */
    public static function getInlineBackgroundStylesMobile($data, $size = 'full')
    {
        if (empty($data) || !isset($data['background-mobile'])) {
            return '';
        }

        $image      = ACF::getField('background-mobile_image', $data);
        $attachment = !empty($image) ? Media::getAttachmentByID($image) : false;
        $src        = ACF::getField($size, $attachment->sizes, $attachment->url);

        // build out our inline background styles
        $styles = sprintf(
            'style="background: %1$s %2$s %3$s %4$s/%5$s;"',
            ACF::getField('background-mobile_color', $data, '#FFFFFF'),
            'url( ' . (!empty($attachment) ? esc_url($src) : '') . ')',
            ACF::getField('background-mobile_repeat', $data, 'no-repeat'),
            ACF::getField('background-mobile_position', $data, 'center center'),
            ACF::getField('background-mobile_size', $data, 'auto auto')
        );

        return $styles;
    }

    /**
     * Returns standardized icon html by name
     *
     * @param string $icon_name
     *
     * @return string
     */
    public static function getIconHTML($icon_name)
    {
        if (empty($icon_name)) {
            return '';
        }

        return sprintf(
            '<svg class="icon icon-%1$s" aria-hidden="true">
                <use xlink:href="#icon-%1$s"></use>
            </svg>',
            $icon_name
        );
    }

    /**
     * Wrapper function for parsing button data and outputting proper markup.
     *
     * @param $link_array
     * @param array $args
     *
     * @return string
     */
    public static function getButtonHTML($link_array, $args = [])
    {
        $output = '';
        if (!isset($link_array['title'])) {
            return $output;
        }

        $defaults = [
            'class' => 'btn btn-primary',
            'icon-end' => '',
            'icon-start' => ''
        ];
        $atts = wp_parse_args($args, $defaults);
        $icon_start = self::getIconHTML($atts['icon-start']);
        $icon_end = self::getIconHTML($atts['icon-end']);

        $output = sprintf(
            '<a href="%2$s" target="%3$s" class="%4$s">%5$s%1$s%6$s</a>',
            esc_html($link_array['title']),
            esc_url($link_array['url']),
            esc_attr($link_array['target']),
            $atts['class'],
            $icon_start,
            $icon_end,
        );

        return $output;
    }

    public static function getTextFieldHtml($name, $label, $initial_value = '', $icon = null) {
        if (!isset($name) || !isset($label)) {
            return '<!-- input field missing required arguments -->';
        }

        $id = $name . '_text-field';
        $icon_html = '';
        $icon_class = '';
        if (!is_null($icon)) {
            $icon_html = self::getIconHTML($icon);
            $icon_class = 'text-field--has-icon';
        } 

        $text_field_html = sprintf(
            '<label class="text-field %6$s">
                <span class="text-field__label">%1$s</span>
                <div class="text-field__field-container">
                    %5$s
                    <input class="text-field__field" type="text" value="%2$s" name="%3$s" data-field-type="text" id="%4$s" />
                </div>
            </label>',
            $label,
            $initial_value,
            $name,
            $id,
            $icon_html,
            $icon_class
        );

        return $text_field_html;
    }

    public static function getSelectFieldHtml($name, $label, $options = [], $initial_value = null, $is_multi_select = false, $submit_button = true, $key_value = false) {

        if (!isset($name)) {
            return '<!-- select field missing required arguments -->';
        }

        $id = $name . '_select-field';
        $input_type = $is_multi_select ? 'checkbox' : 'radio';
        $multi_select_data_attribute = $is_multi_select ? 'data-multiselect' : '';
        $options_html = '';
        $button_type = '';

        $initial_text_values = [];

        foreach ($options as $key => $option) {
            $checked = '';
            
            $slug = self::createSlug($option);

            if (is_string($initial_value) && $key === $initial_value) {
                $checked = 'checked';
                array_push($initial_text_values, $option);
            } else if(is_array($initial_value) && in_array($key, $initial_value)) {
                $checked = 'checked';
                array_push($initial_text_values, $option);
            }

            if ($key_value === true) {
                $value = strtolower($option);
                $value = str_replace(' ', '-', $value);
                $value = str_replace('/', '-', $value);
                
                $input_value = $value;
            } else {
                $input_value = $key;
            }

            $options_html .= sprintf(
                '<li class="select-field-option" role="option" data-select-field-option data-val-type="val-type-%4$s-%1$s">
                    <label class="select-field-option__container">
                        <input
                            class="select-field-option__input select-field-option__input--%1$s"
                            type="%1$s"
                            value="%2$s"
                            name="%3$s"
                            data-label-value="%4$s"
                            data-filter-value="%5$s"
                            %6$s
                        />
                        <span class="select-field-option__label">%4$s</span>
                    </label>
                </li>',
                $input_type,
                $input_value,
                $name,
                $option,
                strtolower($slug),
                $checked
            );
        }

        $initial_text_value = implode(', ', $initial_text_values);
        $initial_text_value = $initial_text_value === '' ? '-' : $initial_text_value;
        $icon = Util::getIconHTML('dropdown');

        if ($submit_button === false) {
            $button_type = 'type="button"';
        }

        $label_text = '';
        if (!is_null($label)) {
            $label_text = sprintf(
                '<span class="select-field__label" id="listbox-label">%1$s</span>',
                $label
            );
        }

        return sprintf(
            '<div class="select-field" %5$s>
                %4$s
                <button
                    class="select-field__button"
                    role="combobox"
                    aria-labelledby="listbox-label"
                    aria-haspopup="listbox"
                    aria-expanded="false"
                    aria-controls="%1$s"
                    aria-label="Select option for %8$s"
                    %7$s
                    data-name="%8$s"
                >
                    <span class="select-field__selected-value">%3$s</span>
                    <span class="select-field__arrow">%6$s</span>
                </button>
                <ul class="select-field__dropdown" role="listbox" id="%1$s">
                    %2$s
                </ul>
            </div>',
            $id . '_dropdown', // dropdown id, used to set aria controls
            $options_html,
            '',
            $label_text,
            $multi_select_data_attribute,
            $icon,
            $button_type,
            $name
        );
    }

    public static function getToggleControlHtml($name, $label, $initial_value = false) {

        $data_key = 'data-toggle-name="' . $name .'"'; 
        $initial_check = $initial_value ? 'checked' : '';

        $output = sprintf(
            '<label class="toggle-switch" %1$s>
                <div class="toggle-switch__switch-container">
                    <input class="toggle-switch__checkbox" type="checkbox" data-field-type="toggle" name="%3$s" %4$s />
                    <span class="toggle-switch__slider"></span>
                </div>
                <span class="toggle-switch__label-container">
                    %2$s
                </span>
            </label>',
            $data_key,
            $label,
            $name,
            $initial_check
        );

        return $output;
    }

    public static function getPostsAsAssociativeArray($post_type) {

        if (!isset($post_type)) {
            return [];
        }

        $posts = get_posts([
            'post_type' => $post_type,
            'post_status' => 'publish',
            'numberposts' => -1,
            'order' => 'ASC',
            'orderby' => 'title'
        ]);

        $associative_post_array = array();

        foreach ($posts as $post) {
            $associative_post_array[$post->ID] = $post->post_title;
        }

        return $associative_post_array;
    }

    public static function getRelatedPosts($related_post_id_array, $post_type) {
        if (empty($related_post_array) ||  empty($post_type)) {
            return null;
        }
        $args = array(
            'post_type' => $post_type,
            'post__in' => $related_post_id_array
        );

        return get_posts($args);
    }

    public static function getHumanReadablePostType($post_type) {
        $post_type_dictionary = array(
            'videos' => 'Video',
            'podcast' => 'Podcast',
            'extended-article' => 'Extended Article',
            'blog-post' => 'Blog Post',
            'news-detail' => 'News Detail',
            'drug-fact-sheet' => 'Drug Fact Sheet'
        );

        if (array_key_exists($post_type, $post_type_dictionary)) {
            return $post_type_dictionary[$post_type];
        }
        return $post_type;
    }

    // TODO: refactor the below functions into a card class - factory pattern applicable?

    /**
     * outputs the proper post card
     *
     * @param $post
     * @param $size - can equal 'small' | 'wide' | 'tall'
     *
     * @return string
     */
    public static function getCard($post, $size = 'small') {
        if (empty($post)) {
            return null;
        }
        $postType = get_post_type($post->ID);
        switch ($postType) {
            case 'programs':
                return self::getProgramCard($post);
            case 'services':
                return self::getServiceCard($post);
            case 'podcast':
                return self::getPodcastCard($post, $size);
            case 'videos':
                return self::getVideoCard($post, $size);
            case 'news-detail':
                return self::getNewsCard($post);
            case 'extended-article':
            case 'conditions':
            case 'blog-post':
            case 'audience';
            case 'drug-fact-sheet':
            case 'resources':
                return self::getResourceCard($post);
            default:
                return '<!--' . _e(sprintf('This post type (%1$s) does not have a card written for it yet', $postType), 'rosecrance') . '-->'; 
        }
    }

    public static function getNewsCard($news_post) {
        $post_id = $news_post->ID;
        $post_title = isset( $news_post->post_title ) ? $news_post->post_title : '';

        $featured_image_id = get_post_thumbnail_id($news_post);
        $post_link = get_post_permalink($news_post);

        $image_styles = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/news-bg.png);"';
        if (!empty($featured_image_id)) {
            $attachment = !empty($featured_image_id) ? Media::getAttachmentByID($featured_image_id) : false;
            $src = ACF::getField('full', $attachment->sizes, $attachment->url);

            if ($src) {
                $image_styles = 'style="background-image: url(' . esc_attr($src) . ');"';
            }
        }

        $card_image_output = sprintf(
            '<div class="preview-card__image news-card__image" %1$s></div>',
            $image_styles
        );
        

        $title_container = sprintf(
            '<div class="preview-card__title news-card__title">
                <span>%1$s</span>
            </div>',
            esc_html($post_title)
        );

        return sprintf(
            '<a data-card href="%4$s" class="%3$s" id="%5$s" %6$s>
                %1$s
                %2$s
            </a>',
            $card_image_output,
            $title_container,
            'news-card preview-card preview-card--cream',
            $post_link,
            'card-' . $post_id,
            'data-visible="true"'
        );

    }

    public static function getVideoCard($video_post, $size) {
        $post_id = $video_post->ID;
        $post_meta = ACF::getPostMeta($post_id);

        $video_name = ACF::getField('name', $post_meta);
        $post_title = isset( $video_post->post_title ) ? $video_post->post_title : '';
        $post_link = get_post_permalink($video_post);
        $title_text = !empty($podcast_name) ? esc_html($podcast_name) : $post_title;

        $description_text = ACF::getField('description', $post_meta);
        $eyebrow_text = __('Video', 'rosecrance');
        $card_id_string = 'card-' . $post_id;

        $featured_image_id = get_post_thumbnail_id($video_post);
        $image_src = get_template_directory_uri() . '/assets/images/card-placeholder.png';
        if (!empty($featured_image_id)) {
            $attachment = !empty($featured_image_id) ? Media::getAttachmentByID($featured_image_id) : false;
            $image_src = ACF::getField('full', $attachment->sizes, $attachment->url);
        }

        $image_styles = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/card-placeholder.png);"';
        if (!empty($featured_image_id)) {
            $attachment = !empty($featured_image_id) ? Media::getAttachmentByID($featured_image_id) : false;
            $src = ACF::getField('full', $attachment->sizes, $attachment->url);

            if ($src) {
                $image_styles = 'style="background-image: url(' . esc_attr($src) . ');"';
            }
        }

        switch ($size) {
            case 'tall':
                return self::getLargeVideoCardTemplate($size, $image_styles, $post_link, $card_id_string, $eyebrow_text, $title_text, $description_text);
            default:
                return self::getSmallVideoCardTemplate($video_post, $image_styles, $post_link, $eyebrow_text, $title_text);
        }
    }

    public static function getSmallVideoCardTemplate($post, $image_styles, $post_link, $eyebrow_text, $title_text) {
        return self::getCardHtml($post, $post_link, $eyebrow_text, $title_text, 'orange', 'videos', $image_styles);
    }

    public static function getLargeVideoCardTemplate($size, $image_styles, $post_link, $card_id_string, $eyebrow_text, $title_text, $description_text) {
        $orientation_class = $size === 'tall' ? 'video-card--tall' : 'video-card--wide';

        $card_media_section = sprintf(
            '<div class="video-card__media-container" %1$s aria-label="%2$s" role="img"> </div>',
            $image_styles,
            __('Video card preview image', 'rosecrance'),
        );

        return sprintf(
            '<a href="%7$s" data-card class="video-card %6$s" id="%1$s" >
                %2$s
                <div class="video-card__eyebrow">
                    %3$s
                </div>
                <h3 class="video-card__title">
                    %4$s
                </h3>
                <p class="video-card__description">
                    %5$s
                </p>
            </a>',
            $card_id_string,
            $card_media_section,
            $eyebrow_text,
            $title_text,
            $description_text,
            $orientation_class,
            $post_link
        );
    }

    public static function getPodcastCard($podcast_post, $size) {
        $post_id = $podcast_post->ID;
        $post_meta = ACF::getPostMeta($post_id);

        $podcast_name = ACF::getField('name', $post_meta);

        $post_title = isset( $podcast_post->post_title ) ? $podcast_post->post_title : '';
        $post_link = get_post_permalink($podcast_post);
        $title_text = !empty($podcast_name) ? esc_html($podcast_name) : $post_title;
        $description_text = ACF::getField('description', $post_meta);
        $eyebrow_text = __('Podcast', 'rosecrance');

        $image_src = get_template_directory_uri() . '/assets/images/podcast-card-image.png';
        $card_id_string = 'card-' . $post_id;

        switch ($size) {
            case 'tall':
            case 'wide':
                return self::getLargePodcastCardTemplate($size, $image_src, $post_link, $card_id_string, $eyebrow_text, $title_text, $description_text);
            default:
                return self::getSmallPodcastCardTemplate($image_src, $post_link, $card_id_string, $eyebrow_text, $title_text, $description_text);
        }
    }

    public static function getLargePodcastCardTemplate($size, $preview_img_src, $post_link, $card_id_string, $eyebrow_text, $title_text, $description_text) {
        $orientation_class = $size === 'tall' ? 'podcast-card--tall' : 'podcast-card--wide';

        $card_media_section = sprintf(
            '<div class="podcast-card__media-container">
                <img src="%1$s" alt="%2$s"/>
            </div>',
            $preview_img_src,
            __('Podcast card preview image', 'rosecrance'),
        );

        return sprintf(
            '<a href="%7$s" data-card class="podcast-card %6$s" id="%1$s" >
                %2$s
                <div class="podcast-card__eyebrow">
                    %3$s
                </div>
                <h3 class="podcast-card__title">
                    %4$s
                </h3>
                <p class="podcast-card__description">
                    %5$s
                </p>
            </a>',
            $card_id_string,
            $card_media_section,
            $eyebrow_text,
            $title_text,
            $description_text,
            $orientation_class,
            $post_link
        );
    }

    public static function getSmallPodcastCardTemplate($preview_img_src, $post_link, $card_id_string, $eyebrow_text, $title_text, $description_text) {
        $play_icon = Util::getIconHTML('play-outline');
        $spotify_icon = Util::getIconHTML('spotify-outline');

        $card_media_section = sprintf(
            '<div data-card class="podcast-card__media-container">
                <img src="%1$s" alt="%2$s"/>
            </div>',
            $preview_img_src,
            __('Podcast card preview image', 'rosecrance'),
        );

        return sprintf(
            '<a href="%6$s" class="podcast-card" id="%1$s" >
                %2$s
                <div class="podcast-card__eyebrow">
                    %3$s
                </div>
                <h3 class="podcast-card__title">
                    %4$s
                </h3>
                <p class="podcast-card__description">
                    %5$s
                </p>
            </a>',
            $card_id_string,
            $card_media_section,
            $eyebrow_text,
            $title_text,
            $description_text,
            $post_link
        );
    }

    public static function getProgramCard($program_post) {
        $post_id = $program_post->ID;
        $program_name = get_post_meta($post_id, 'name', true);

        $post_title = isset( $program_post->post_title ) ? $program_post->post_title : '';
        $post_link = get_post_permalink($program_post);

        $title_text = !empty($program_name) ? esc_html($program_name) : $post_title;
        $eyebrow_text = __('Program', 'rosecrance');
        $featured_image_id = get_post_thumbnail_id($program_post);
        $image_styles = null;
        if (!empty($featured_image_id)) {
            $attachment = !empty($featured_image_id) ? Media::getAttachmentByID($featured_image_id) : false;
            $src = ACF::getField('full', $attachment->sizes, $attachment->url);
            $image_styles = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/card-placeholder.png);"';
            if ($src) {
                $image_styles = 'style="background-image: url(' . esc_attr($src) . ');"';
            }
        }

        return self::getCardHtml($program_post, $post_link, $eyebrow_text, $title_text, 'orange', 'program', $image_styles);
    }

    public static function getServiceCard($service_post) {
        $post_id = $service_post->ID;
        $service_name = get_post_meta($post_id, 'name', true);

        $post_title = isset( $service_post->post_title ) ? $service_post->post_title : '';
        $post_link = get_post_permalink($service_post);

        $title_text = !empty($service_name) ? esc_html($service_name) : $post_title;
        $eyebrow_text = __('Service', 'rosecrance');
        $featured_image_id = get_post_thumbnail_id($service_post);
        $image_styles = null;
        if (!empty($featured_image_id)) {
            $attachment = !empty($featured_image_id) ? Media::getAttachmentByID($featured_image_id) : false;
            $src = ACF::getField('full', $attachment->sizes, $attachment->url);
            $image_styles = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/card-placeholder.png);"';
            if ($src) {
                $image_styles = 'style="background-image: url(' . esc_attr($src) . ');"';
            }
        }

        return self::getCardHtml($service_post, $post_link, $eyebrow_text, $title_text, 'grey', 'service', $image_styles);
    }

    public static function getResourceCard($resource_post) {
        $post_id = $resource_post->ID;
        $resource_name = get_post_meta($post_id, 'name', true);

        $post_title = isset( $resource_post->post_title ) ? $resource_post->post_title : '';
        $post_link = get_post_permalink($resource_post);

        $title_text = !empty($resource_name) ? esc_html($resource_name) : $post_title;
        $resource_type = get_post_type($resource_post);
        $eyebrow_text = $resource_type ? self::getHumanReadablePostType($resource_type) : __('Resource', 'rosecrance');
        $featured_image_id = get_post_thumbnail_id($resource_post);
        $image_styles = null;
        if (!empty($featured_image_id)) {
            $attachment = !empty($featured_image_id) ? Media::getAttachmentByID($featured_image_id) : false;
            $src = ACF::getField('full', $attachment->sizes, $attachment->url);
            $image_styles = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/card-placeholder.png);"';
            if ($src) {
                $image_styles = 'style="background-image: url(' . esc_attr($src) . ');"';
            }
        }

        return self::getCardHtml($resource_post, $post_link, $eyebrow_text, $title_text, 'cream', 'resource', $image_styles);
    }

    public static function getCardDataFieldString($post) {
        $post_id = $post->ID;
        $post_meta = ACF::getPostMeta($post_id);

        // Typecasting the below to Array because intellisense is confused in vscode. These will be arrays. 
        $audience_ids = (Array)ACF::getField('audiences_related-audiences', $post_meta, []);
        $audiences = [];
        $condition_ids = (Array)ACF::getField('conditions_related-conditions', $post_meta, []);
        $service_ids = (Array)ACF::getField('services_included-services', $post_meta, []);
        $service_line_ids = (Array)ACF::getField('service-lines_related-services-lines', $post_meta, []);
        $program_ids = (Array)ACF::getField('programs_related-programs', $post_meta, []);
        $region_ids = (Array)ACF::getField('regions_related-regions', $post_meta, []);
        $location_ids = (Array)ACF::getField('locations_related-locations', $post_meta, []);

        if (!empty($audience_ids)) {
            foreach ($audience_ids as $key => $audience_id) {
                array_push($audiences, get_post($audience_id)->post_name);
            }
        }

        $programs_string = count($program_ids) ? 'data-related-programs=' . esc_html(implode(',', $program_ids)) : '';
        $conditions_string = count($condition_ids) ? 'data-related-conditions=' . esc_html(implode(',', $condition_ids)) : '';
        $audience_string = count($audience_ids) ? 'data-related-audiences=' . esc_html(implode(',', $audience_ids)) . ' data-filter-audiences=' . esc_html(implode(',', $audiences)) : '';
        $region_string = count($region_ids) ? 'data-related-regions=' . esc_html(implode(',', $region_ids)) : '';
        $location_string = count($location_ids) ? 'data-related-locations=' . esc_html(implode(',', $location_ids)) : '';
        $service_string = count($service_ids) ? 'data-related-services=' . esc_html(implode(',', $service_ids)): '';
        $service_lines = count($service_line_ids) ? 'data-related-service-lines=' . esc_html(implode(',', $service_line_ids)): '';
        return implode(' ', [$programs_string, $conditions_string, $audience_string, $region_string, $service_string, $service_lines, $location_string]);
    }

    public static function getCardHtml($post, $post_link, $eyebrow_text, $title_text, $accentColor = 'white', $post_type = 'resource', $image_styles = null, $service_line_text = null) {
        $card_variant_class = 'preview-card--' . $accentColor;
        $card_post_variant_class = 'preview-card--' . $post_type;
        $css_classes = implode(' ', ['preview-card', $card_variant_class, $card_post_variant_class]);
        $placeholder_image_styles = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/card-placeholder.png);"';
        $post_type_data_string = ' data-post-type="'. esc_html($post_type) .'"';
        $visibility_data_string = ' data-visible="true"';
        $card_id_string = 'card-' . $post->ID;
        $card_data_string = Util::getCardDataFieldString($post) . $post_type_data_string . $visibility_data_string;
        
        if (empty($image_styles)) {
            // get placeholder here and set to $image
            $image_styles = $placeholder_image_styles;
        }

        $card_image_output = sprintf(
            '<div class="preview-card__image" %1$s> %2$s </div>',
            $image_styles,
            $service_line_text
        );
        
        $eyebrow_output = sprintf(
            '<div class="preview-card__eyebrow"> %1$s </div>',
            esc_html($eyebrow_text)
        );

        $title_container = sprintf(
            '<div class="preview-card__title">
                %1$s
            </div>',
            esc_html($title_text)
        );

        $card_output = sprintf(
            '<a data-card href="%5$s" class="%4$s" id="%6$s" %7$s>
                %1$s
                %2$s
                %3$s
            </a>',
            $card_image_output,
            $eyebrow_output,
            $title_container,
            $css_classes,
            $post_link,
            $card_id_string,
            $card_data_string
        );

        return $card_output;

    }

    public static function getBioCardHtml($bio, $unique_id = '')
    {
        $full_name = ACF::getField('name', $bio, '');
        $specialty = ACF::getField('specialty', $bio, null);
        $job_title = ACF::getField('job-title', $bio, '');
        $bio_detail = ACF::getField('bio-detail', $bio, '');
        $bio_portrait = ACF::getField('bio-image_image', $bio, null);
        $modal_id = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $full_name . $specialty . $job_title . $unique_id)));
        $name_and_specialty = isset($specialty) ? $full_name . ', ' . $specialty : $full_name;
        $card_output = '';
        $bio_modal_output = '';

        $default_portrait_styles = 'style="background-image: url(' . get_template_directory_uri() . '/assets/images/bio-placeholder.png);"';
        $portrait_image_styles = $bio_portrait !== null ? Util::getAgnosticInlineBackgroundStyles($bio, 'bio-image') : $default_portrait_styles;

        $card_image_output = sprintf(
            '<div class="staff-bio-card__portrait" %1$s></div>',
            $portrait_image_styles
        );

        if (!empty($bio_detail)) {
            $card_info_output = sprintf(
                '<div class="staff-bio-card__info-wrapper">
                    <div class="staff-bio-card__credentials-container">
                        <span>%1$s</span>
                        <p class="staff-bio-card__title">
                            %3$s
                        </p>
                    </div>
                    %2$s
                </div>',
                esc_html($name_and_specialty),
                self::getIconHTML('expand'),
                esc_html($job_title)
            );
        } else {
            $card_info_output = sprintf(
                '<div class="staff-bio-card__info-wrapper">
                    <div class="staff-bio-card__credentials-container">
                        <span>%1$s</span>
                        <p class="staff-bio-card__title">
                            %2$s
                        </p>
                    </div>
                </div>',
                esc_html($name_and_specialty),
                esc_html($job_title)
            );
        }

        $modal_image_output = sprintf(
            '<div class="staff-bio-card-modal__portrait" %1$s></div>',
            $portrait_image_styles
        );

        if (!empty($bio_detail)) {
            $bio_modal_output = sprintf(
                '<div class="staff-bio-card-modal" id="%1$s" uk-modal>
                    <div class="staff-bio-card-modal__body uk-modal-dialog uk-modal-body content-block">
                        <button class="uk-modal-close-default staff-bio-card-modal__close" type="button">%6$s %7$s</button>
                        <div class="staff-bio-card-modal__content-container">
                            %2$s
                            <div class="staff-bio-card-modal__text-content">
                                <h3>%3$s</h3>
                                <span>%4$s</span>
                                <div class="staff-bio-card-modal__wysiwyg">%5$s</div>
                            </div>
                        </div>
                    </div>
                </div>',
                $modal_id,
                $modal_image_output,
                esc_html($name_and_specialty),
                esc_html($job_title),
                apply_filters('the_content', $bio_detail),
                self::getIconHTML('expand'),
                __('Close', 'rosecrance')
            );
        }

        if (!empty($bio_detail)) {
            $card_output = sprintf(
                '<div class="staff-bio-card" data-expandable-bio uk-toggle="target: #%3$s" data-staff-name="%5$s">%1$s %2$s %4$s</div>',
                $card_image_output,
                $card_info_output,
                $modal_id,
                $bio_modal_output,
                $full_name
            );
        } else {
            $card_output = sprintf(
                '<div class="staff-bio-card no-bio" data-staff-name="%3$s">%1$s %2$s</div>',
                $card_image_output,
                $card_info_output,
                $full_name
            );
        }

        return $card_output;
    }

    public static function createSlug($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}

<?php

namespace Rosecrance\App\Api;

use Rosecrance\App\Interfaces\WordPressHooks;
use Rosecrance\App\Fields\ACF;
use Rosecrance\App\Fields\Util;
use Rosecrance\App\Media;



/**
 * Class Location Search
 *
 * @package Rosecrance\App
 */
class LocationSearch implements WordPressHooks
{
    /**
     * Add class hooks.
     */
    public function addHooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'localizeRestJs']);
        add_action('rest_api_init', [$this, 'locationEndpoints']);
    }

    /**
     * Pass nonce to admin as js to pass to endpoint
     */
    public function localizeRestJs()
    {
        wp_localize_script(
            'rosecrance-theme',
            'locations_by_region_rest',
            [
                'apiNonce' => wp_create_nonce('wp_rest')
            ]
        );

        wp_localize_script(
            'rosecrance-theme',
            'locations_by_zip_code_rest',
            [
                'apiNonce' => wp_create_nonce('wp_rest')
            ]
        );

        wp_localize_script(
            'rosecrance-theme',
            'locations_rest',
            [
                'apiNonce' => wp_create_nonce('wp_rest')
            ]
        );

        wp_localize_script(
            'rosecrance-theme',
            'virtual_locations_rest',
            [
                'apiNonce' => wp_create_nonce('wp_rest')
            ]
        );

        wp_localize_script(
            'rosecrance-theme',
            'locations_map_rest',
            [
                'apiNonce' => wp_create_nonce('wp_rest')
            ]
        );
    }

    /**
     * Location endpoints init
     */
    public function locationEndpoints()
    {
        register_rest_route('locations-by-region-rest/v1', '/search', [
            'methods'             => 'POST',
            'callback'            => [$this, 'loadLocationsByRegion'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('locations-by-zipcode-rest/v1', '/search', [
            'methods'             => 'POST',
            'callback'            => [$this, 'loadLocationsByZipCode'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('locations-rest/v1', '/search', [
            'methods'             => 'POST',
            'callback'            => [$this, 'loadLocations'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('virtual-locations-rest/v1', '/search', [
            'methods'             => 'POST',
            'callback'            => [$this, 'filterVirtual'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('locations-map-rest/v1', '/search', [
            'methods'             => 'POST',
            'callback'            => [$this, 'loadLocationsMap'],
            'permission_callback' => '__return_true'
        ]);
    }

    public function loadLocationsByZipCode($request)
    {
        global $wpdb;
        $locations = [];

        $data = $request->get_param('data');
        $program = $data['program'] ?? '';
        $service = $data['service'] ?? '';
        $zip_codes = $data['zipCodes'] ?? [];
        $insurance_provider = $data['insuranceProvider'] ?? '';
        $services_list = (isset($data['servicesList']) && !empty($data['servicesList'])) ? $data['servicesList'] : [];
        $programs_list = (isset($data['programsList']) && !empty($data['programsList'])) ? $data['programsList'] : [];
        $zipcode_distance_map = array();

        if(!empty($programs_list)) {
            $programs_list = explode(",", $programs_list);
        }

        if(!empty($services_list)) {
            $services_list = explode(",", $services_list);
        }

        $args = array(
            'post_type' => ['locations'],
            'location-type' => 'Physical',
            'order' => 'ASC',
            'orderby' => 'title',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $flattened_zipcodes = array_map(function ($item) {
            return $item['value'];
        }, $zip_codes);
        foreach ($zip_codes as $item) {
            $zipcode_distance_map[$item['value']] = $item['distance'];
        }

        $query = new \WP_Query($args);

        $location_posts = $query->posts;

        $location_posts = array_filter($location_posts, function($post) use ($program, $service, $insurance_provider, $flattened_zipcodes) {
            $location_id = $post->ID;
            $location_meta = ACF::getPostMeta($location_id);
            $location_zipcode = ACF::getField('zip-code', $location_meta);
            $programs_related_programs = ACF::getField('programs_related-programs', $location_meta, []);
            $services_included_services = ACF::getField('services_included-services', $location_meta, []);
            $services_overide = ACF::getField('location-finder-overrides_service-override', $location_meta, []);
            $programs_overide = ACF::getField('location-finder-overrides_service-override', $location_meta, []);
            $insurance_type = ACF::getField('insurance-type', $location_meta, []);

            // if the filtered service or program is founnd in this location's program/service override, we don't care about the other filters.
            if ((!empty($program) && in_array($program, $programs_overide)) || (!empty($service) && in_array($service, $services_overide))) {
                return true;
            }

            if (!in_array($location_zipcode, $flattened_zipcodes)) {
                return false;
            }

            if(!empty($program) && !in_array($program, $programs_related_programs)) {
                return false;
            }
            if(!empty($service) && !in_array($service, $services_included_services)) {
                return false;
            }
            if(!empty($insurance_provider) && !in_array($insurance_provider, $insurance_type)) {
                return false;
            }
            return true;
        });

        foreach ($location_posts as $post) :
            $location_id = $post->ID;
            $title = get_the_title($location_id);
            $location_meta = ACF::getPostMeta($location_id);
            $slug = $post->post_name;
            $address = ACF::getField('address', $location_meta);
            $phone_number = ACF::getField('main-phone-number', $location_meta);
            $additional_text = ACF::getField('additional-text', $data_similar);
            $related_regions = ACF::getField('regions_related-regions', $location_meta);
            $related_region_names = is_array($related_regions) ? array_map(function ($region) {
                return get_the_title($region);
            }, $related_regions) : [];
            $latitude = ACF::getField('latitude', $location_meta);
            $longitude = ACF::getField('longitude', $location_meta);
            $location_zipcode = ACF::getField('zip-code', $location_meta);
            $distance = $zipcode_distance_map[$location_zipcode];
            $locations[] = array(
                'id' => $location_id,
                'title' => $title,
                'slug' => $slug,
                'address' => $address,
                'phone_number' => $phone_number,
                'additional_text'   => $additional_text,
                'related_regions' => $related_region_names,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'zip-code' => $location_zipcode,
                'distance' => (float) $distance
            );
        endforeach;

        usort($locations, function($a, $b) {
            
            return $a['distance'] <=> $b['distance'];
        });

        return new \WP_REST_Response(
            ['locations' => $locations],
            200
        );
    }

    public function loadLocationsByRegion($request)
    {
        global $wpdb;

        $locations = [];

        // get data from request
        $data = $request->get_param('data');
        $region = $data['region'] ?? '';
        $regions = array();
        $program = $data['program'] ?? '';
        $service = $data['service'] ?? '';
        $insurance_provider = $data['insuranceProvider'] ?? '';
    
        // if parent region, we need to get all of child regions locations
        if ($region !== 'all' &&  $region !== '') {
            $region_post_meta = ACF::getPostMeta($region);
            $is_parent_region = ACF::getField('region-type', $region_post_meta) === 'parent-region';
            if ($is_parent_region) {
                $regions = ACF::getField('regions_child-regions', $region_post_meta);
            }
        }

        $args = array(
            'post_type' => ['locations'],
            'location-type' => 'Physical',
            'order' => 'ASC',
            'orderby' => 'title',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $query = new \WP_Query($args);
        $location_posts = $query->posts;

        $location_posts = array_filter($location_posts, function($post) use ($region, $regions, $program, $service, $insurance_provider) {
            $location_id = $post->ID;
            $location_meta = ACF::getPostMeta($location_id);
            $region_related_regions = ACF::getField('regions_related-regions', $location_meta, []);
            $programs_related_programs = ACF::getField('programs_related-programs', $location_meta, []);
            $services_included_services = ACF::getField('services_included-services', $location_meta, []);
            $services_overide = ACF::getField('location-finder-overrides_service-override', $location_meta, []);
            $programs_overide = ACF::getField('location-finder-overrides_service-override', $location_meta, []);

            $insurance_type = ACF::getField('insurance-type', $location_meta, []);

            // if the filtered service or program is founnd in this location's program/service override, we don't care about the other filters.
            if ((!empty($program) && in_array($program, $programs_overide)) || (!empty($service) && in_array($service, $services_overide))) {
                return true;
            }

            // filter out the result if the array of region ids does not intersect with the array of related regions
            if((!empty($regions) && empty(array_intersect($regions, $region_related_regions)))){
                return false;
            }
            if((empty($regions) && !empty($region) && !in_array($region, $region_related_regions))) {
                return false;
            }
            if(!empty($program) && !in_array($program, $programs_related_programs)) {
                return false;
            }
            if(!empty($service) && !in_array($service, $services_included_services)) {
                return false;
            }
            if(!empty($insurance_provider) && !in_array($insurance_provider, $insurance_type)) {
                return false;
            }
            return true;
        });

        foreach ($location_posts as $post) :
            $location_id = $post->ID;
            $title = get_the_title($location_id);
            $location_meta = ACF::getPostMeta($location_id);
            $slug = $post->post_name;
            $address = ACF::getField('address', $location_meta);
            $phone_number = ACF::getField('main-phone-number', $location_meta);
            $additional_text = ACF::getField('additional-text', $location_meta);
            $related_regions = ACF::getField('regions_related-regions', $location_meta);
            $related_region_names = is_array($related_regions) ? array_map(function ($region) {
                return get_the_title($region);
            }, $related_regions) : [];
            $latitude = ACF::getField('latitude', $location_meta);
            $longitude = ACF::getField('longitude', $location_meta);

            $locations[] = array(
                'id' => $location_id,
                'title' => $title,
                'slug' => $slug,
                'address' => $address,
                'phone_number' => $phone_number,
                'additional_text'   => $additional_text,
                'related_regions' => $related_region_names,
                'latitude' => $latitude,
                'longitude' => $longitude
            );
        endforeach;

        // filter by program, service, insurance
        // special case filtering for services and programs that supercede selected region

        return new \WP_REST_Response(
            ['locations' => $locations],
            200
        );
    }

    /**
     * Load results for the front end.
     */
    public function loadLocations($request)
    {
        global $wpdb;
        
        $data = $request->get_param('data');
        $region = $data['region'] ?? [];
        $program = $data['program'] ?? [];
        $service = $data['service'] ?? [];
        $zip_code = $data['zipCode'] ?? [];
        $insurance = $data['insuranceProvider'] ?? [];
        $services_list = (isset($data['servicesList']) && !empty($data['servicesList'])) ? $data['servicesList'] : [];
        $programs_list = (isset($data['programsList']) && !empty($data['programsList'])) ? $data['programsList'] : [];
        $zipcode_distance_map = array();

        if(!empty($programs_list)) {
            $programs_list = explode(",", $programs_list);
        }

        if(!empty($services_list)) {
            $services_list = explode(",", $services_list);
        }

        $region_selected = false;
        
        $html = '';
        
        if (empty($zip_code)) {
            $args = array(
                'post_type' => ['locations'],
                'location-type' => 'Physical',
                'order' => 'ASC',
                'orderby' => 'title',
                'post_status' => 'publish',
                'posts_per_page' => -1
            );
        } else {
            // $zip_code = explode(",", $zip_code);
            $flattened_zipcodes = array_map(function ($item) {
                return $item['value'];
            }, $zip_code);
            foreach ($zip_code as $item) {
                $zipcode_distance_map[$item['value']] = $item['distance'];
            }
            $args = array(
                'post_type' => ['locations'],
                'location-type' => 'Physical',
                'order' => 'ASC',
                'orderby' => 'title',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key'     => 'zip-code',
                        'value'   => $flattened_zipcodes,
                        'compare' => 'IN',
                    )
                )
            );
        }
            
        $query = new \WP_Query($args);
        
        if (empty($region) && empty($program) && empty($service)) {
            // NO FILTERS SELECTED
            $filtered_insurance_ids = array();
            $filtered_posts = array();

            foreach ($query->posts as $post) :
                $data_similar = ACF::getPostMeta($post->ID);
                $insurance_type = ACF::getField('insurance-type', $data_similar);
                $zip = ACF::getField('zip-code', $data_similar);
                $distance = $zipcode_distance_map[$zip];
                if(!empty($insurance)) {
                    foreach($insurance_type as $item) {
                        if($item === $insurance) {
                            array_push($filtered_insurance_ids, $post->ID);
                        }
                    }
                } else {
                    array_push($filtered_posts, $post->ID);
                }
            endforeach; 

            $filters_active = 0;
            if (!empty($filtered_insurance_ids)) {
                $filters_active++;
            }

            if (!empty($filtered_posts)) {
                $filters_active++;
            }

            $filtered_ids = array_merge($filtered_insurance_ids, $filtered_posts);


            $post_ids_by_distance = array();
            foreach ($filtered_ids as $id) :
                $data_similar = ACF::getPostMeta($id);
                $zip = ACF::getField('zip-code', $data_similar);
                $distance = $zipcode_distance_map[$zip];
                if (!isset($posts_by_distance[$distance])) {
                    $posts_by_distance[$distance] = [];
                }
                $post_ids_by_distance[$distance][] = $id;
            endforeach;

            // Sort the array by distance (keys)
            ksort($post_ids_by_distance);

            // Flatten the array to get a sorted list of posts
            $sorted_post_ids = [];
            foreach ($post_ids_by_distance as $distance => $posts) {
                $sorted_post_ids = array_merge($sorted_post_ids, $posts);
            }

            $counted_values = array_count_values($sorted_post_ids); 

            foreach ($counted_values as $key => $value) { 
                if ($value >= 1) { 
                    if ($value === $filters_active) {
                        $html .= apply_filters('rosecrance/location/search-card', $key);
                    }
                } 
            }
        } else {
            $filtered_region_ids = array();
            $filtered_program_ids = array();
            $filtered_service_ids = array();
            $include_program_id = array();
            $include_service_id = array();
            
            foreach ($query->posts as $post) :
                $data_similar = ACF::getPostMeta($post->ID);
                $insurance_type = ACF::getField('insurance-type', $data_similar);
                $region_relationship = ACF::getField('regions_related-regions', $data_similar, []);
                $program_relationship = ACF::getField('programs_related-programs', $data_similar, []);
                $service_relationship = ACF::getField('services_included-services', $data_similar, []);

                // FILTER LOCATIONS WITH SELECTED REGION
                if (!empty($region)) {
                    foreach ($region_relationship as $item) {
                        if ($region !== 'all') {
                            if ($item === $region) {
                                if(!empty($insurance)) {
                                    foreach($insurance_type as $item) {
                                        if($item === $insurance) {
                                            array_push($filtered_region_ids, $post->ID);
                                        }
                                    }
                                } else {
                                    array_push($filtered_region_ids, $post->ID);
                                }
                            }
                        } else {
                            array_push($filtered_region_ids, $post->ID);
                        }
                    }
                }
                
                // FILTER LOCATIONS WITH SELECTED PROGRAM
                if (!empty($program)) {
                    foreach ($program_relationship as $item) {
                        if ($item === $program) {
                            if(!empty($insurance)) {
                                foreach($insurance_type as $item) {
                                    if($item === $insurance) {
                                        array_push($filtered_program_ids, $post->ID);
                                    }
                                }
                            } else {
                                array_push($filtered_program_ids, $post->ID);
                            }
                        }
                        
                        if (in_array($program, $programs_list)) {
                            array_push($include_program_id, $post->ID);
                        }
                    }
                }
                
                // FILTER LOCATIONS WITH SELECTED SERVICE
                if (!empty($service)) {
                    foreach ($service_relationship as $item) {
                        if ($item === $service) {
                            if(!empty($insurance)) {
                                foreach($insurance_type as $item) {
                                    if($item === $insurance) {
                                        array_push($filtered_service_ids, $post->ID);
                                    }
                                }
                            } else {
                                array_push($filtered_service_ids, $post->ID);
                            }
                        }
                        if (in_array($service, $services_list)) {
                            array_push($include_service_id, $post->ID);
                        }
                    }
                }
            endforeach; 
            
            $filters_active = 0;
            if (!empty($filtered_region_ids)) {
                $filters_active++;
            }

            if (!empty($filtered_program_ids)) {
                $filters_active++;
            }

            if (!empty($filtered_service_ids)) {
                $filters_active++;
            }

            $filtered_ids = array_merge($filtered_region_ids, $filtered_program_ids, $filtered_service_ids);
            $counted_values = array_count_values($filtered_ids); 
            
            foreach ($counted_values as $key => $value) { 
                if ($value >= 1) { 
                    if ($value === $filters_active) {
                        $html .= apply_filters('rosecrance/location/search-card', $key);
                    } else if (in_array($key, $include_program_id) || in_array($key, $include_service_id)) {
                        $html .= apply_filters('rosecrance/location/search-card', $key);
                    }
                }
            }
        }
        

        return new \WP_REST_Response(
            ['posts' => $html],
            200
        );
    }

    /**
     * Filter virtual locations
     */
    public function filterVirtual($request)
    {
        $data = $request->get_param('data');
        $program = $data['program'] ?? [];
        $service = $data['service'] ?? [];
        $insurance = $data['insuranceProvider'] ?? [];
        
        global $wpdb;

        $html = '';
        
        $args = array(
            'post_type' => ['locations'],
            'location-type' => 'Virtual',
            'order' => 'ASC',
            'orderby' => 'title',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
         
        $query = new \WP_Query($args);
        
        $filtered_program_ids = array();
        $filtered_service_ids = array();
        $filtered_insurance_ids = array();
        
        foreach ($query->posts as $post) :
            $data_similar = ACF::getPostMeta($post->ID);
            $insurance_type = ACF::getField('insurance-type', $data_similar);
            $program_relationship = ACF::getField('programs_related-programs', $data_similar);
            $service_relationship = ACF::getField('services_included-services', $data_similar);

            // FILTER LOCATIONS WITH SELECTED PROGRAM
            if (!empty($program)) {
                foreach ($program_relationship as $item) {
                    if ($item === $program) {
                        if (!empty($insurance)) {
                            foreach($insurance_type as $item) {
                                if($item === $insurance) {
                                    array_push($filtered_program_ids, $post->ID);
                                }
                            }
                        } else {
                            array_push($filtered_program_ids, $post->ID);
                        }
                    }
                }
            }

            // FILTER LOCATIONS WITH SELECTED SERVICE
            if (!empty($service)) {
                foreach ($service_relationship as $item) {
                    if ($item === $service) {
                        if (!empty($insurance)) {
                            foreach($insurance_type as $item) {
                                if($item === $insurance) {
                                    array_push($filtered_service_ids, $post->ID);
                                }
                            }
                        } else {
                            array_push($filtered_service_ids, $post->ID);
                        }
                    }
                }
            }

            if (empty($program) && empty($service)) {
                if (!empty($insurance)) {
                    foreach($insurance_type as $item) {
                        if($item === $insurance) {
                            array_push($filtered_insurance_ids, $post->ID);
                        }
                    }
                } else {
                    array_push($filtered_insurance_ids, $post->ID);
                }
            }
        endforeach; 

        $filters_active = 0;
        if (!empty($filtered_program_ids)) {
            $filters_active++;
        }

        if (!empty($filtered_service_ids)) {
            $filters_active++;
        }

        if (!empty($filtered_insurance_ids)) {
            $filters_active++;
        }

        $filtered_ids = array_merge($filtered_program_ids, $filtered_service_ids, $filtered_insurance_ids);
        $counted_values = array_count_values($filtered_ids); 
        
        foreach ($counted_values as $key => $value) { 
            if ($value >= 1) { 
                if ($value === $filters_active) {
                    $html .= apply_filters('rosecrance/location/search-card', $key);
                }
            } 
        }

        return new \WP_REST_Response(
            ['posts' => $html],
            200
        );
    }

    /**
     * Loads latitude and longitude of locations.
     */
    public function loadLocationsMap($request)
    {
        global $wpdb;
        
        $data = $request->get_param('data');
        $region = $data['region'] ?? [];
        $program = $data['program'] ?? [];
        $service = $data['service'] ?? [];
        $zip_code = $data['zipCode'] ?? [];
        $insurance = $data['insuranceProvider'] ?? [];
        $services_list = (isset($data['servicesList']) && !empty($data['servicesList'])) ? $data['servicesList'] : [];
        $programs_list = (isset($data['programsList']) && !empty($data['programsList'])) ? $data['programsList'] : [];

        if(!empty($programs_list)) {
            $programs_list = explode(",", $programs_list);
        }

        if(!empty($services_list)) {
            $services_list = explode(",", $services_list);
        }
        
        $locations = array();
        
        if (empty($zip_code)) {
            $args = array(
                'post_type' => ['locations'],
                'location-type' => 'Physical',
                'order' => 'ASC',
                'orderby' => 'title',
                'post_status' => 'publish',
                'posts_per_page' => -1
            );
        } else {
            $zip_code = explode(",", $zip_code);
            
            $args = array(
                'post_type' => ['locations'],
                'location-type' => 'Physical',
                'order' => 'ASC',
                'orderby' => 'title',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key'     => 'zip-code',
                        'value'   => $zip_code,
                        'compare' => 'IN',
                    )
                )
            );
        }
            
        $query = new \WP_Query($args);
        
        $i = 0;
        
        if (empty($region) && empty($program) && empty($service)) {
            // NO FILTERS SELECTED
            foreach ($query->posts as $post) :
                if (empty($insurance)) {
                    $locations[$i]['location'] = array(
                        'ID' => $post->ID,
                        'latitude' => get_field('latitude', $post->ID),
                        'longitude' => get_field('longitude', $post->ID)
                    );
                    $i++;
                } else {
                    $data_similar = ACF::getPostMeta($post->ID);
                    $insurance_type = ACF::getField('insurance-type', $data_similar);

                    foreach($insurance_type as $item) {
                        if($item === $insurance) {
                            $locations[$i]['location'] = array(
                                'ID' => $post->ID,
                                'latitude' => get_field('latitude', $post->ID),
                                'longitude' => get_field('longitude', $post->ID)
                            );
                            $i++;
                        }
                    }
                }
            endforeach;
        } else {
            $filtered_region_ids = array();
            $filtered_program_ids = array();
            $filtered_service_ids = array();
            $include_program_id = array();
            $include_service_id = array();
            
            foreach ($query->posts as $post) :
                $data_similar = ACF::getPostMeta($post->ID);
                $insurance_type = ACF::getField('insurance-type', $data_similar, []);
                $region_relationship = ACF::getField('regions_related-regions', $data_similar, []);
                $program_relationship = ACF::getField('programs_related-programs', $data_similar, []);
                $service_relationship = ACF::getField('services_included-services', $data_similar, []);
                
                // FILTER LOCATIONS WITH SELECTED REGION
                if (!empty($region)) {
                    foreach ($region_relationship as $item) {
                        if ($region !== 'all') {
                            if ($item === $region) {
                                if (!empty($insurance)) {
                                    foreach($insurance_type as $item) {
                                        if($item === $insurance) {
                                            array_push($filtered_region_ids, $post->ID);
                                        }
                                    }
                                } else {
                                    array_push($filtered_region_ids, $post->ID);
                                }
                            }
                        } else {
                            array_push($filtered_region_ids, $post->ID);
                        }
                    }
                }
                
                // FILTER LOCATIONS WITH SELECTED PROGRAM
                if (!empty($program)) {
                    foreach ($program_relationship as $item) {
                        if ($item === $program) {
                            if (!empty($insurance)) {
                                foreach($insurance_type as $item) {
                                    if($item === $insurance) {
                                        array_push($filtered_program_ids, $post->ID);
                                    }
                                }
                            } else {
                                array_push($filtered_program_ids, $post->ID);
                            }
                        }

                        if (in_array($program, $programs_list)) {
                            array_push($include_program_id, $post->ID);
                        }
                    }
                }

                // FILTER LOCATIONS WITH SELECTED SERVICE
                if (!empty($service)) {
                    foreach ($service_relationship as $item) {
                        if ($item === $service) {
                            if (!empty($insurance)) {
                                foreach($insurance_type as $item) {
                                    if($item === $insurance) {
                                        array_push($filtered_service_ids, $post->ID);
                                    }
                                }
                            } else {
                                array_push($filtered_service_ids, $post->ID);
                            }
                        }

                        if (in_array($service, $services_list)) {
                            array_push($include_service_id, $post->ID);
                        }
                    }
                }
            endforeach; 

            $filters_active = 0;
            if (!empty($filtered_region_ids)) {
                $filters_active++;
            }

            if (!empty($filtered_program_ids)) {
                $filters_active++;
            }

            if (!empty($filtered_service_ids)) {
                $filters_active++;
            }

            $filtered_ids = array_merge($filtered_region_ids, $filtered_program_ids, $filtered_service_ids);
            $counted_values = array_count_values($filtered_ids); 
            
            foreach ($counted_values as $key => $value) { 
                if ($value >= 1) { 
                    if ($value === $filters_active) {
                        $locations[$i]['location'] = array(
                            'ID' => $key,
                            'latitude' => get_field('latitude', $key),
                            'longitude' => get_field('longitude', $key)
                        );
                        $i++;
                    } else if (in_array($key, $include_program_id) || in_array($key, $include_service_id)) {
                        $locations[$i]['location'] = array(
                            'ID' => $key,
                            'latitude' => get_field('latitude', $key),
                            'longitude' => get_field('longitude', $key)
                        );
                        $i++;
                    }
                } 
            }
        }

        return new \WP_REST_Response(
            ['posts' => $locations],
            200
        );
    }
}
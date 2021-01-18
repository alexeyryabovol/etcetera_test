<?php
/*
Plugin Name: Real Estate Plugin
Description: Test plugin, which was created for Etcetera Agency - Full Stack Developer - Test Task.
Author: Alexey Ryabovol
Version: 1.0.0
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*Number of Apartments per Page */
define( 'REAL_ESTATE_PLUGIN_PER_PAGE', 5 );

/*Start function*/
add_action( 'init', 'real_estate_plugin_start' );
function real_estate_plugin_start(){
    
        /*Post Type Property Object*/
        register_post_type( 'property_object', [
                'label'       => 'Здание',
                'labels'      => [
                    'name'          => 'Здания',
                    'singular_name' => 'Здание'
                ],
                'public'      => true,
                'has_archive' => true
        ]);
        
        /*Post Type Apartment*/
        register_post_type( 'apartment', [
                'label'   => 'Квартира',
                'labels'  => [
                    'name'          => 'Квартиры',
                    'singular_name' => 'Квартира'
                ],
                'show_ui'            => true,
                'show_in_nav_menus'  => true,
                'supports'           => array('title')
        ]);
        
        /*Taxonomy District*/
        register_taxonomy( 'district', 'property_object', [
                'label'       => 'Район',
                'labels'      => [
                    'name'          => 'Районы',
                    'singular_name' => 'Район'
                ]
        ]);
}

/*Creating shortcode to display filter block*/
add_shortcode('filter_block', 'real_estate_plugin_filter_block_shortcode');
function real_estate_plugin_filter_block_shortcode(){        
        wp_enqueue_script( 'real-estate', plugins_url('/real_estate_plugin/js/real-estate.js'), array('jquery') );
        wp_localize_script('real-estate', 'real_estate_ajax', 
		array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('real-estate-ajax-nonce')
		)
	);  
        
        ob_start();
    
        require('templates/filter_block.php');

        return ob_get_clean();
}

/*AJAX Queries*/
if( wp_doing_ajax() ){
        /*Filter Button*/
        add_action( 'wp_ajax_nopriv_filter_btn', 'real_estate_plugin_filter_btn' );
        add_action( 'wp_ajax_filter_btn', 'real_estate_plugin_filter_btn' );
        function real_estate_plugin_filter_btn(){
                
                check_ajax_referer( 'real-estate-ajax-nonce', 'nonce_code' );
                
                $query_to_db = array();
                $query_to_db_apartment = array();
                
                $query_to_db["number_of_floors"]   = intval( $_POST['form_data']['number_of_floors'] );
                $query_to_db["type"]               = sanitize_text_field( $_POST['form_data']['type'] );
                $query_to_db["ecology"]            = intval( $_POST['form_data']['ecology'] );
                $query_to_db_apartment["rooms"]    = intval( $_POST['form_data']['rooms'] );
                $query_to_db_apartment["balcony"]  = intval( $_POST['form_data']['balcony'] );
                $query_to_db_apartment["bathroom"] = intval( $_POST['form_data']['bathroom'] );
                $offset                            = intval( $_POST['form_data']['offset'] );
                
                $buildings = real_estate_plugin_buildings_query($query_to_db);
                
                if( empty($buildings) && ( !empty($query_to_db["number_of_floors"]) || !empty($query_to_db["type"]) || !empty($query_to_db["ecology"]) )  ){
                        wp_die();
                }
                
                $apartments_query_meta = real_estate_plugin_apartments_query_builder($query_to_db_apartment, $buildings);
                
                if(!empty($offset)){
                        $apartments_query_meta['offset'] = $offset;
                }
                
                                
                $apartments_results = get_posts($apartments_query_meta);
                
                foreach($apartments_results as $apartment){
                    
                        $apartment_id = $apartment->ID;
                        require('templates/single_apartment.php');
                    
                }
                                
                real_estate_plugin_get_pagination( $offset, $apartments_query_meta );
                
                wp_die();
        }
}

/*Query for Buildings*/
function real_estate_plugin_buildings_query($query_to_db){
        $query_meta = array();
        foreach( $query_to_db as $key => $value ){

                if( empty($value) ){
                    continue;
                }

                $query_meta[] = [
                        'key'   => $key,
                        'value' => $value
                ];
        }
        
        $buildings = array();
        if( !empty($query_meta) ){

                $buildings_query_meta = [
                        'post_type'   => 'property_object',
                        'numberposts' => -1,
                        'meta_query'  => [
                                'relation' => 'AND'                                
                        ]
                ];

                $buildings_query_meta['meta_query'][] = $query_meta;

                $buildings = get_posts( $buildings_query_meta );
               
        }
        
        return  $buildings;
}

/*Query Builder for Apartments*/
function real_estate_plugin_apartments_query_builder($query_to_db_apartment, $buildings){
        $apartments_query_meta = [
                'post_type'   => 'apartment',
                'numberposts' => REAL_ESTATE_PLUGIN_PER_PAGE,
                'meta_query'  => [
                        'relation' => 'AND'                                
                ]
        ];


        foreach( $query_to_db_apartment as $key => $value ){

                if( empty($value) ){
                    continue;
                }

                if( $key == 'balcony' || $key == 'bathroom' ){
                        if($value == 2){
                                $value = 0;
                        } 
                }

                $apartments_query_meta['meta_query'][] = [
                        'key'   => $key,
                        'value' => $value
                ];
        }


        if( !empty($buildings) ){

                $apartments_building_ids_query = [
                        'relation' => 'OR'                                
                ];

                foreach($buildings as $building){
                        $apartments_building_ids_query[] = [
                                'key'     => 'house',
                                'value'   => $building->ID,
                                'compare' => 'LIKE'
                        ];
                }

                $apartments_query_meta['meta_query'][] = $apartments_building_ids_query;

        }
        
        return $apartments_query_meta;    
}

/*Display pagination*/
function real_estate_plugin_get_pagination( $offset, $apartments_query_meta ){
    
        $output = '<div class="apartments-pagination">';
        if( $offset >= REAL_ESTATE_PLUGIN_PER_PAGE ){
                $prev_offset = $offset - REAL_ESTATE_PLUGIN_PER_PAGE;
                $output .= '<a class="prev" href="#prev" data-offset="'.$prev_offset.'">&larr;</a>';    
        }
        
        $page_number = intdiv($offset, REAL_ESTATE_PLUGIN_PER_PAGE) + 1;
        $output .= '<span>'.$page_number.'</span>';
        
        $apartments_query_meta['offset'] = $offset + REAL_ESTATE_PLUGIN_PER_PAGE;        
        $apartments_results = get_posts($apartments_query_meta);
        
        if(!empty($apartments_results)){
                $next_offset = $offset + REAL_ESTATE_PLUGIN_PER_PAGE;
                $output .= '<a class="next" href="#next" data-offset="'.$next_offset.'">&rarr;</a>';
        }
        
        $output .= '</div>';
        
        if( $offset >= REAL_ESTATE_PLUGIN_PER_PAGE || !empty($apartments_results) ){
            
                echo $output;
                
        }
}
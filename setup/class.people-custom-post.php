<?php

	// Register 'People' Custom Post Type
function people() {

	$labels = array(
		'name'                  => 'People',
		'singular_name'         => 'Person',
		'menu_name'             => 'People',
		'name_admin_bar'        => 'Person',
		'archives'              => 'Person Archives',
		'attributes'            => 'Person Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All People',
		'add_new_item'          => 'Add New Person',
		'add_new'               => 'Add New',
		'new_item'              => 'New Person',
		'edit_item'             => 'Edit Person',
		'update_item'           => 'Update Person',
		'view_item'             => 'View Person',
		'view_items'            => 'View People',
		'search_items'          => 'Search People',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'People list',
		'items_list_navigation' => 'People list navigation',
		'filter_items_list'     => 'Filter People list',
	);
	$capabilities = array(
		'edit_post'             => 'edit_person',
		'read_post'             => 'read_person',
		'delete_post'           => 'delete_person',
		'edit_posts'            => 'edit_people',
		'edit_others_posts'     => 'edit_others_people',
		'publish_posts'         => 'publish_people',
		'read_private_posts'    => 'read_private_people',
	);
	$args = array(
		'label'                 => 'Person',
		'description'           => 'Post Type Description',
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', 'thumbnail', ),
		'taxonomies'            => array( 'academic_positions', 'academic_colleges', 'schools', 'academic_department', 'boards', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-id',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'slug'					=> 'people',
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capabilities'          => $capabilities,
		'show_in_rest'          => true,
		'rest_base'             => 'people',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	);
	register_post_type( 'people', $args );

}
add_action( 'init', 'people', 0 );

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_departments_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts
function create_departments_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
// first do the translations part for GUI

  $labels = array(
		'name'                           => 'University Departments',
		'singular_name'                  => 'University Departments',
		'search_items'                   => 'Search Departments',
		'all_items'                      => 'All Departments',
		'edit_item'                      => 'Edit Department',
		'update_item'                    => 'Update Department',
		'add_new_item'                   => 'Add New Department',
		'new_item_name'                  => 'New Department',
		'menu_name'                      => 'University Departments',
		'view_item'                      => 'View Department',
		'popular_items'                  => 'Popular Department',
		'separate_items_with_commas'     => 'Separate departments with commas',
		'add_or_remove_items'            => 'Add or remove departments',
		'choose_from_most_used'          => 'Choose from the most used departments',
		'not_found'                      => 'No departments found',
		'parent_item'                	 => 'Parent Department',
		'parent_item_colon'          	 => 'Parent Department:',
		'no_terms'                   	 => 'No University Departments',
		'items_list'                 	 => 'University Departments list',
		'items_list_navigation'      	 => 'University Departments list navigation',
	);
  	$rewrite = array(
		'slug'                       => 'department',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$capabilities = array(
		'manage_terms'               => 'manage_options',
		'edit_terms'                 => 'manage_options',
		'delete_terms'               => 'manage_options',
		'assign_terms'               => 'edit_posts',
	);
	$args = array(
		'label' 					 => __( 'University Departments' ),
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'meta_box_cb'				 => false,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'capabilities'               => $capabilities,
		'show_in_rest'       		 => true,
  		'rest_base'          		 => 'university_department',
  		'rest_controller_class' 	 => 'WP_REST_Terms_Controller',
	);
	register_taxonomy( 'department', array( 'people' ), $args );

}

// Register Custom Taxonomy
function create_academic_position_taxonomy() {

	$labels = array(
		'name'                       => 'Positions',
		'singular_name'              => 'Position',
		'menu_name'                  => 'Academic Positions',
		'all_items'                  => 'All Positions',
		'parent_item'                => 'Parent Position',
		'parent_item_colon'          => 'Parent Position:',
		'new_item_name'              => 'New Position',
		'add_new_item'               => 'Add New Position',
		'edit_item'                  => 'Edit Position',
		'update_item'                => 'Update Position',
		'view_item'                  => 'View Position',
		'separate_items_with_commas' => 'Separate positions with commas',
		'add_or_remove_items'        => 'Add or remove positions',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Positions',
		'search_items'               => 'Search Positions',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Positions',
		'items_list'                 => 'Positions list',
		'items_list_navigation'      => 'Positions list navigation',
	);
	$rewrite = array(
		'slug'                       => 'academic-position',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$capabilities = array(
		'manage_terms'               => 'manage_options',
		'edit_terms'                 => 'manage_options',
		'delete_terms'               => 'manage_options',
		'assign_terms'               => 'edit_people',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,	//Made true to add / edit
		'meta_box_cb'				 => false,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'capabilities'               => $capabilities,
	);
	register_taxonomy( 'academic_positions', array( 'people' ), $args );

}
add_action( 'init', 'create_academic_position_taxonomy', 0 );

// Register Custom Taxonomy
function create_academic_college_taxonomy() {

	$labels = array(
		'name'                       => 'Colleges',
		'singular_name'              => 'College',
		'menu_name'                  => 'Colleges',
		'all_items'                  => 'All Colleges',
		'parent_item'                => 'Parent College',
		'parent_item_colon'          => 'Parent College:',
		'new_item_name'              => 'New College',
		'add_new_item'               => 'Add New College',
		'edit_item'                  => 'Edit College',
		'update_item'                => 'Update College',
		'view_item'                  => 'View College',
		'separate_items_with_commas' => 'Separate colleges with commas',
		'add_or_remove_items'        => 'Add or remove colleges',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Colleges',
		'search_items'               => 'Search Colleges',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Colleges',
		'items_list'                 => 'Colleges list',
		'items_list_navigation'      => 'Colleges list navigation',
	);
	$rewrite = array(
		'slug'                       => 'college',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$capabilities = array(
		'manage_terms'               => 'manage_options',
		'edit_terms'                 => 'manage_options',
		'delete_terms'               => 'manage_options',
		'assign_terms'               => 'edit_people',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,  //Made true to add / edit
		'meta_box_cb'				 => false,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'capabilities'               => $capabilities,
	);
	register_taxonomy( 'academic_colleges', array( 'people' ), $args );

}
add_action( 'init', 'create_academic_college_taxonomy', 0 );

// Register Custom Taxonomy
function create_schools_taxonomy() {

	$labels = array(
		'name'                       => 'Schools',
		'singular_name'              => 'School',
		'menu_name'                  => 'Schools',
		'all_items'                  => 'All Schools',
		'parent_item'                => 'Parent School',
		'parent_item_colon'          => 'Parent School:',
		'new_item_name'              => 'New School',
		'add_new_item'               => 'Add New School',
		'edit_item'                  => 'Edit School',
		'update_item'                => 'Update School',
		'view_item'                  => 'View School',
		'separate_items_with_commas' => 'Separate school with commas',
		'add_or_remove_items'        => 'Add or remove schools',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Schools',
		'search_items'               => 'Search Schools',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Schools',
		'items_list'                 => 'Schools list',
		'items_list_navigation'      => 'Schools list navigation',
	);
	$rewrite = array(
		'slug'                       => 'school',
		'with_front'                 => false,
		'hierarchical'               => false,
	);
	$capabilities = array(
		'manage_terms'               => 'manage_options',
		'edit_terms'                 => 'manage_options',
		'delete_terms'               => 'manage_options',
		'assign_terms'               => 'edit_people',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,  //Made true to add / edit
		'meta_box_cb'				 => false,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'capabilities'               => $capabilities,
	);
	register_taxonomy( 'schools', array( 'people' ), $args );

}
add_action( 'init', 'create_schools_taxonomy', 0 );


add_action( 'init', 'create_academic_departments_taxonomy', 0 );//hook into the init action and call create_book_taxonomies when it fires

//create a custom taxonomy name it topics for your posts
function create_academic_departments_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
// first do the translations part for GUI

  $labels = array(
		'name'                           => 'Academic Departments',
		'singular_name'                  => 'Academic Departments',
		'search_items'                   => 'Search Departments',
		'all_items'                      => 'All Departments',
		'edit_item'                      => 'Edit Department',
		'update_item'                    => 'Update Department',
		'add_new_item'                   => 'Add New Department',
		'new_item_name'                  => 'New Department',
		'menu_name'                      => 'Academic Departments',
		'view_item'                      => 'View Department',
		'popular_items'                  => 'Popular Department',
		'separate_items_with_commas'     => 'Separate departments with commas',
		'add_or_remove_items'            => 'Add or remove departments',
		'choose_from_most_used'          => 'Choose from the most used departments',
		'not_found'                      => 'No departments found'
	);

// Now register the taxonomy

  	register_taxonomy(
  		'academic_department',
		'people',
		array(
			'label' => __( 'Academic Departments' ),
			'hierarchical' => false,
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud' => false,
			'show_admin_column' => false,
			'meta_box_cb' => false,
			'capabilities'=>array(
				'manage_terms' => 'manage_options',//or some other capability your clients don't have
				'edit_terms' => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' =>'edit_people'),
				'rewrite' => array(
				'slug' => 'academic_department'
			)
		)
	);

}

add_action( 'init', 'create_boards_taxonomy', 0 );//hook into the init action and call create_book_taxonomies when it fires

//create a custom taxonomy name it topics for your posts
function create_boards_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
// first do the translations part for GUI

  $labels = array(
		'name'                           => 'Boards',
		'singular_name'                  => 'Board',
		'search_items'                   => 'Search Boards',
		'all_items'                      => 'All Boards',
		'edit_item'                      => 'Edit Board',
		'update_item'                    => 'Update Board',
		'add_new_item'                   => 'Add New Board',
		'new_item_name'                  => 'New Board',
		'menu_name'                      => 'Academic Boards',
		'view_item'                      => 'View Board',
		'popular_items'                  => 'Popular Boards',
		'separate_items_with_commas'     => 'Separate boards with commas',
		'add_or_remove_items'            => 'Add or remove boards',
		'choose_from_most_used'          => 'Choose from the most used boards',
		'not_found'                      => 'No boards found'
	);

// Now register the taxonomy

  	register_taxonomy(
  		'boards',
		'people',
		array(
			'label' => __( 'Boards' ),
			'hierarchical' => false,
			'labels' => $labels,
			'public' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud' => false,
			'show_admin_column' => false,
			'meta_box_cb' => false,
			'capabilities'=>array(
				'manage_terms' => 'manage_options',//or some other capability your clients don't have
				'edit_terms' => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' =>'edit_people'),
				'rewrite' => array(
				'slug' => 'board'
			)
		)
	);

}

// function add_roles_on_plugin_activation() {
//        add_role( 'people_editor', 'Doc Profile Editor', 
//        		array( 	'read' => true,
//        				'read_person' => true, 
//        				'edit_people' => true, 
//        				'edit_published_people' => true, 
//        				//'read_location' => true, 
//        				//'read_private_locations' => true, 
//        				//'edit_locations' => true, 
//        				//'edit_published_locations' => true,  
//        				'upload_files' => true, 
//        				'edit_files' => true 
//        			) 
//        	);
//    }
// register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );

function add_theme_caps() {
    // gets the author role
    $role = get_role( 'administrator' );

    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    $role->add_cap( 'edit_others_posts' );
    $role->add_cap( 'edit_person' );
	$role->add_cap( 'read_person');
	$role->add_cap( 'delete_person');
	$role->add_cap( 'edit_people');
	$role->add_cap( 'edit_others_people');
	$role->add_cap( 'publish_people');
	$role->add_cap( 'read_private_people');
    $role->add_cap( 'edit_location');
	$role->add_cap( 'read_location');
	$role->add_cap( 'delete_location');
	$role->add_cap( 'edit_locations');
	$role->add_cap( 'edit_others_locations');
	$role->add_cap( 'publish_locations');
	$role->add_cap( 'read_private_locations');
}
add_action( 'admin_init', 'add_theme_caps');

// Remove the taxonomy metabox [slugnamediv]
// function remove_person_meta() {
// 	//remove_meta_box( 'conditiondiv', 'people', 'side' );
// 	//remove_meta_box( 'specialtydiv', 'people', 'side' );
// 	//remove_meta_box( 'departmentdiv', 'people', 'side' );
// 	//remove_meta_box( 'patient_typediv', 'people', 'side' );
// 	//remove_meta_box( 'tagsdiv-medical_procedures', 'people', 'side' );
// 	//remove_meta_box( 'medical_termsdiv', 'people', 'side' );
// 	//remove_meta_box( 'custom-post-type-onomies-locations', 'people', 'side');
// }

// add_action( 'admin_menu' , 'remove_person_meta' );

add_action('admin_head', 'acf_hide_title');

function acf_hide_title() {
  echo '<style>
    .acf-field.hide-acf-title {
    border: none;
    padding: 6px 12px;
	}
	.hide-acf-title .acf-label {
	    display: none;
	}
	.acf-field.pbn { padding-bottom:0; }
  </style>';
}

/**
 * Changes strings referencing Featured Images for a post type
 * 
 * In this example, the post type in the filter name is "employee" 
 * and the new reference in the labels is "headshot".
 *
 * @see 	https://developer.wordpress.org/reference/hooks/post_type_labels_post_type/
 *
 * @param 		object 		$labels 		Current post type labels
 * @return 		object 					Modified post type labels
 */
function change_featured_image_labels( $labels ) {

	$labels->featured_image 	= 'Headshot';
	$labels->set_featured_image 	= 'Set headshot';
	$labels->remove_featured_image 	= 'Remove headshot';
	$labels->use_featured_image 	= 'Use as headshot';

	return $labels;

} // change_featured_image_labels()

add_filter( 'post_type_labels_people', 'change_featured_image_labels', 10, 1 );

/**
 * Add REST API support to Teams Meta.
 */
function rest_api_person_meta() {
    register_rest_field('people', 'person_meta', array(
            'get_callback' => 'get_person_meta',
            'update_callback' => null,
            'schema' => null,
        )
    );
}
function get_person_meta($object) {
    $postId = $object['id'];
    //$data = get_post_meta($postId); //Returns All
    //$data = array();
    //People
    $data['person_first_name'] = get_post_meta( $postId, 'person_first_name', true );
    $data['person_middle_name'] = get_post_meta( $postId, 'person_middle_name', true );
    $data['person_last_name'] = get_post_meta( $postId, 'person_last_name', true );
    $data['person_degree'] = get_post_meta( $postId, 'person_degree', true );
	//Academic Data
	$data['person_academic_title'] = get_post_meta( $postId, 'person_academic_title', true );
	$data['person_academic_college'] = get_the_terms( $postId, 'academic_colleges' );
	$data['person_academic_position'] = get_the_terms( $postId, 'academic_positions' );
	$data['person_academic_bio'] = get_post_meta( $postId, 'person_academic_bio', true );
	$data['person_academic_short_bio'] = wp_trim_words( get_post_meta( $postId, 'person_academic_short_bio', true ), 30, ' &hellip;' );
	$data['person_academic_office'] = get_post_meta( $postId, 'person_academic_office', true );
	$data['person_academic_map'] = get_post_meta( $postId, 'person_academic_map', true );
	$data['person_research_profiles_link'] = get_post_meta( $postId, 'person_research_profiles_link', true );
	$data['person_pubmed_author_id'] = get_post_meta( $postId, 'person_pubmed_author_id', true );
	$data['pubmed_author_number'] = get_post_meta( $postId, 'pubmed_author_number', true );
	if( get_post_meta( $postId, 'person_publications', true ) ) :
		$i = 0;
		foreach (get_post_meta( $postId, 'person_publications', true ) as $publication) {
			$data['person_publication'][$i] = get_post_meta( $postId, 'person_publications_' . $i .'_publication_pubmed_info', true );
			$i++;
		}
	endif;
	if( get_post_meta( $postId, 'person_contact_infomation', true ) ) :
		for ( $i = 0; $i < get_post_meta( $postId, 'person_contact_infomation', true ); $i++ ){
			$data['office_full'][$i] = get_post_meta( $postId, 'person_contact_infomation_' . $i . '_office_contact_type', true ) . ': ' . get_post_meta( $postId, 'person_contact_infomation_' . $i . '_office_contact_value', true );
			$data['office_contact_type'][$i] = get_post_meta( $postId, 'person_contact_infomation_' . $i . '_office_contact_type', true );
			$data['office_contact_value'][$i] =  get_post_meta( $postId, 'person_contact_infomation_' . $i . '_office_contact_value', true );
		}
	endif;
	if( get_post_meta( $postId, 'person_academic_appointment', true ) ) :
		for ( $i = 0; $i < get_post_meta( $postId, 'person_academic_appointment', true ); $i++ ){
			$data['person_academic_appointment'][$i] = get_post_meta( $postId, 'person_academic_appointment_' . $i .'_academic_title', true ) . ': ' . get_post_meta( $postId, 'person_academic_appointment_' . $i .'_academic_department', true );		}
	endif;
	if( get_post_meta( $postId, 'person_education', true ) ) :
		for ( $i = 0; $i < get_post_meta( $postId, 'person_education', true ); $i++ ){
			$data['person_education'][$i] = get_post_meta( $postId, 'person_education_' . $i .'_person_education_type', true ) . ': ' . get_post_meta( $postId, 'person_education_' . $i .'_person_education_school', true ) . ' ' . get_post_meta( $postId, 'person_education_' . $i .'_person_education_description', true );		}
	endif;
	//Research
	$data['person_researcher_bio'] = get_post_meta( $postId, 'person_researcher_bio', true );
	$data['person_research_interests'] = get_post_meta( $postId, 'person_research_interests', true );
	//Additional
	if( get_post_meta( $postId, 'person_awards', true ) ) :
		for ( $i = 0; $i < get_post_meta( $postId, 'person_awards', true ); $i++ ){
			$data['person_awards'][$i] = get_post_meta( $postId, 'person_awards_' . $i .'_award_title', true ) . ' (' . get_post_meta( $postId, 'person_awards_' . $i .'_award_year', true ) . ') ' . get_post_meta( $postId, 'person_awards_' . $i .'_award_infor', true );		}
	endif;
	$data['person_additional_info'] = get_post_meta( $postId, 'person_additional_info', true );

    return $data;
}
add_action('rest_api_init', 'rest_api_person_meta');

// Add REST API query var filters
add_filter('rest_query_vars', 'people_add_rest_query_vars');
function people_add_rest_query_vars($query_vars) {
    $query_vars = array_merge( $query_vars, array('meta_key', 'meta_value', 'meta_compare') );
    return $query_vars;
}
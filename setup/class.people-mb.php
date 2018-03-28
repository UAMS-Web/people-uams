<?php

/*
 *  Meta Box Fields for UAMS-2016
 */

//register_activation_hook( __FILE__, 'prefix_create_table' );

global $wpdb;

$table_name = $wpdb->prefix.'uams_people';
if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}uams_people'") != "{$wpdb->prefix}uams_people") {
  add_action( 'init', 'people_create_table' );
  function people_create_table() {

      global $wpdb;
    
      if ( ! class_exists( 'MB_Custom_Table_API' ) ) {
          return;
      }
      MB_Custom_Table_API::create( "{$wpdb->prefix}uams_people", array(
          'person_first_name' => 'VARCHAR(50) NOT NULL',
          'person_middle_name' => 'VARCHAR(50) NOT NULL',
          'person_last_name' => 'VARCHAR(50) NOT NULL',
          'person_degree' => 'VARCHAR(25) NOT NULL',
          'person_academic_title' => 'VARCHAR(255) NOT NULL',
          'person_academic_bio' => 'LONGTEXT NOT NULL',
          'person_academic_short_bio' => 'VARCHAR(255) NOT NULL',
          'person_academic_office' => 'VARCHAR(255) NOT NULL',
          'person_academic_map' => 'VARCHAR(25) NOT NULL',
          'person_contact_information' => 'LONGTEXT NOT NULL',
          'person_academic_appointment' => 'LONGTEXT NOT NULL',
          'person_education' => 'LONGTEXT NOT NULL',
          'person_research_profiles_link' => 'VARCHAR(255) NOT NULL',
          'person_pubmed_author_id' => 'VARCHAR(10) NOT NULL',
          'pubmed_author_number' => 'TINYINT(2) NOT NULL',
          'person_select_publications' => 'LONGTEXT NOT NULL',
          'person_research_bio' => 'LONGTEXT NOT NULL',
          'person_research_interests' => 'TEXT NOT NULL',
          'person_awards' => 'LONGTEXT NOT NULL',
          'person_additional_info' => 'LONGTEXT NOT NULL',
      ) );
  }
}


add_filter( 'rwmb_meta_boxes', 'uams_people_register_meta_boxes' );

function uams_people_register_meta_boxes( $meta_boxes ) {

    global $wpdb;

    $meta_boxes[] = array (
      'id' => 'people',
      'title' => 'People',
      'post_types' =>   array (
         'people',
      ),
      'storage_type' => 'custom_table',    // Important
      'table' => "{$wpdb->prefix}uams_people", // Your custom table name
      'context' => 'normal',
      'priority' => 'high',
      'autosave' => true,
      'tab_style' => 'box',
      'tab_wrapper' => true,
      'tabs' =>   array (
	        'tab_details' =>     array (
	          'label' => 'Details',
	          'icon' => 'dashicons-admin-users',
	        ),
	        'tab_academic' =>     array (
	          'label' => 'Academic Profile',
	          'icon' => 'dashicons-edit',
	        ),
	        'tab_edu' =>     array (
	          'label' => 'Education',
	          'icon' => 'dashicons-book-alt',
	        ),
	        'tab_research' =>     array (
	          'label' => 'Research',
	          'icon' => 'dashicons-clipboard',
	        ),
	        'tab_extra' =>     array (
	          'label' => 'Extra',
	          'icon' => 'dashicons-awards',
	        ),
      ),

      'fields' =>   array (

         
        array (
          	'id' => 'person_first_name',
          	'type' => 'text',
          	'name' => 'First Name',
          	'tab' => 'tab_details',
            'columns' => 4,
        ),
         
        array (
          	'id' => 'person_middle_name',
          	'type' => 'text',
          	'name' => 'Middle Name',
          	'tab' => 'tab_details',
            'columns' => 2,
        ),
         
        array (
          'id' => 'person_last_name',
          'type' => 'text',
          'name' => 'Last Name',
          'tab' => 'tab_details',
          'columns' => 4,
        ),
         
        array (
          'id' => 'person_degree',
          'type' => 'text',
          'name' => 'Degree',
          'tab' => 'tab_details',
          'columns' => 2,
        ),

        array(
          'tab' => 'tab_details',
          'name' => 'University Department(s)',
          'id'   => 'people_departments',
          'type' => 'taxonomy',
          'taxonomy' => 'department',
          'multiple'    => true,
          'js_options'      => array(
            'width' => '95%',
          ),
          'query_args' => array(
            'orderby' => 'name',
          ),
        ),
        
        /* Academic Profile Tab */ 
        array (
          'id' => 'profile_info',
          'type' => 'heading',
          'desc' => 'This information is designed for department and public websites.',
          'name' => 'Profile Information',
          'tab' => 'tab_academic',
          'columns' => 12,
        ),
         
        array (
          'id' => 'person_academic_title',
          'type' => 'text',
          'name' => 'Academic Title',
          'size' => 45,
          'tab' => 'tab_academic',
          'columns' => 12,
        ),
         
        array (
          'id' => 'person_academic_college',
          'type' => 'taxonomy',
          'name' => 'College Affiliation',
          'taxonomy' => 'academic_colleges',
          'field_type' => 'checkbox_list',
          'multiple'    => true,
          'columns' => 6,
          'tab' => 'tab_academic',
        ),
         
        array (
          'id' => 'person_academic_position',
          'type' => 'taxonomy',
          'name' => 'Position',
          'taxonomy' => 'academic_positions',
          'field_type' => 'checkbox_list',
          'multiple'    => true,
          'columns' => 6,
          //'placeholder' => 'Select an Item',
          'tab' => 'tab_academic',
        ),
         
        array (
          'id' => 'person_academic_bio',
          'name' => 'Academic Bio',
          'type' => 'wysiwyg',
          'columns' => 12,
          'options' => array(
              'textarea_rows' => 16,
              //'teeny'         => false,
              'media_buttons' => false,
          ),
          'tab' => 'tab_academic',
        ),
         
        array (
          'id' => 'person_academic_short_bio',
          'type' => 'textarea',
          'name' => 'Short Academic Bio',
          'label_description' => 'Limit of 30 words. Preferred length is approx 18 words.',
          'tab' => 'tab_academic',
          'columns' => 12,
        ),

        array (
          'id' => 'person_academic_office',
          'type' => 'text',
          'name' => 'Office Location',
          'tab' => 'tab_academic',
          'columns' => 6,
        ),
         
        array (
          'id' => 'person_academic_map',
          'name' => 'Building / Map',
          'type' => 'select',
          'columns' => 6,
          'placeholder' => 'Select an Item',
          'options' => array(
            '127' => '12th St. Clinic',
            '116' => 'Administration West (ADMINW)',
            '117' => 'Barton Research (BART)',
            '118' => 'Biomedical Research Center I (BMR1)',
            '119' => 'Biomedical Research Center II (BMR2)',
            '120' => 'Bioventures (BVENT)',
            '121' => 'Boiler House (BH)',
            '122' => 'Central Building (CENT)',
            '123' => 'College of Public Health (COPH)',
            '124' => 'Computer Building (COMP)',
            '125' => 'Cottage 3 (C3)',
            '128' => 'Distribution Center (DIST)',
            '129' => 'Donald W. Reynolds Institute on Aging (RIOA)',
            '126' => 'Ear Nose Throat (ENT)',
            '131' => 'Education Building South (EDS)',
            '130' => 'Education II (EDII)',
            '132' => 'Family Medical Center (FMC)',
            '133' => 'Freeway Medical Tower (FWAY)',
            '134' => 'Harvey and Bernice Jones Eye Institute (JEI)',
            '135' => 'Hospital (HOSP)',
            '136' => 'I. Dodd Wilson Education Building (IDW)',
            '137' => 'Jackson T. Stephens Spine Institute (JTSSI)',
            '138' => 'Magnetic Resonance Imaging (MRI)',
            '139' => 'Mediplex Apartments (1 unit) (MEDPX)',
            '140' => 'Northwest Campus (NWA)',
            '141' => 'Outpatient Center (OPC)',
            '142' => 'Outpatient Diagnostic Center (OPDC)',
            '143' => 'Paint Shop & Flammable Storage (PAINT)',
            '144' => 'PET (PET)',
            '145' => 'Physical Plant (PP)',
            '146' => 'Psychiatric Research Institute (PRI)',
            '147' => 'Radiation Oncology [ROC] (RADONC)',
            '148' => 'Residence Hall Complex (RHC)',
            '149' => 'Ricks Armory',
            '150' => 'Walker Annex (ANNEX)',
            '151' => 'Ward Tower (WARD)',
            '152' => 'West Central Energy Plant (WCEP)',
            '153' => 'Westmark (WESTM)',
            '154' => 'Winston K. Shorey Building (SHOR)',
            '155' => 'Winthrop P. Rockefeller Cancer Institute (WPRCI)',
          ),
          'tab' => 'tab_academic',
        ),


        array(
          'id'     => 'person_contact_information',
          'group_title' => 'Contact Infomation',
          'type'   => 'group',
          'tab' => 'tab_academic',
	      	'clone'  => true,
	      	'sort_clone' => true,
          'collapsible' => true,
	      	'fields' => array(
	            array(
	                'name' => 'Type',
	                'id'   => 'office_contact_type',
	                'type' => 'select',
                  'columns' => 6,
                  'placeholder' => 'Select an Item',
	                'options' => array(
	                	  'phone' => 'Phone',
          						'fax' => 'Fax',
          						'mobile' => 'Mobile',
          						'email' => 'Email',
          						'sms' => 'Text/SMS',
	                ),
	            ),
	            array(
	                'name' => 'Value',
	                'id'   => 'office_contact_value',
	                'type' => 'text',
                  'columns' => 6,
	            ),
        	),
        ),

        
        /* Education Tab */
        array(
          'id'     => 'person_academic_appointment',
          'group_title' => 'Academic Appointment',
          'type'   => 'group',
          'tab' => 'tab_edu',
	      	'clone'  => true,
	      	'sort_clone' => true,
          'collapsible' => true,
          'add_button' => 'Add Academic Appointment',
	      	'fields' => array(
	            array(
	                'name' => 'Academic Title',
	                'id'   => 'academic_title',
	                'type' => 'text',
                  'columns' => 6,
                  'size' => 45,
	            ),
	            array(
                  'id' => 'academic_department',
                  'name' => 'Department',
                  'type' => 'taxonomy',
                  'taxonomy' => 'academic_department',
                  //'field_type' => 'checkbox_list',
                  'columns' => 6,
                  'multiple'    => false,
                  //'std' => '532', // UAMS
                  'query_args' => array(
                    'orderby' => 'name',
                  ),
	            ),
        	),
        ),

		    array(
          	'id'     => 'person_education',
            'group_title' => 'Education',
          	'type'   => 'group',
          	'tab' => 'tab_edu',
            'collapsible' => true,
	      	  'clone'  => true,
	      	  'sort_clone' => true,
            'add_button' => 'Add Education',
	      	  'fields' => array(
	            array(
	                'name' => 'Education Type',
	                'id'   => 'person_education_type',
	                'type' => 'select_advanced',
                  'columns' => 4,
                  'placeholder'     => 'Select an Item',
	                'options' => array(
	                	'University' => 'University',
        						'Internship' => 'Internship',
        						'Residency' => 'Residency',
        						'Fellowship' => 'Fellowship',
        						'AmbulatoryCareTraining' => 'Ambulatory Care Training',
        						'Certificate' => 'Certificate',
        						'ChildAbusePediatricsFellowship' => 'Child Abuse Pediatrics Fellowship',
        						'Clinicaltraining' => 'Clinical training',
        						'Diploma' => 'Diploma',
        						'DoctorofOsteopathicMedicine' => 'Doctor of Osteopathic Medicine',
        						'DoctorofVeterinaryMedicine' => 'Doctor of Veterinary Medicine',
        						'Doctorate' => 'Doctorate',
        						'Graduateschool' => 'Graduate school',
        						'InternshipandResidency' => 'Internship and Residency',
        						'Masters' => 'Masters',
        						'MedicalSchool' => 'Medical School',
        						'Nursingschool' => 'Nursing school',
        						'OneYearofFellowship' => 'One Year of Fellowship',
        						'PostDoctoralTraining' => 'Post Doctoral Training',
        						'Post-graduatetraining' => 'Post-graduate training',
        						'Pre-doctoralIntern' => 'Pre-doctoral Intern',
        						'ResearchScholar' => 'Research Scholar',
        						'Undergraduate' => 'Undergraduate',
	                ),
	            ),
	            array(
	                'name' => 'School',
	                'id'   => 'person_education_school',
                  'type' => 'taxonomy',
                  'taxonomy' => 'schools',
                  'columns' => 4,
                  'multiple'    => false,
                  'query_args' => array(
                    'orderby' => 'name',
                  ),
              ),
              array(
                  'name'    => 'Desctiption',
                  'id'      => 'physician_education_description',
                  'type'    => 'text',
                  'label_description' => 'Description of the Education (if needed)',
                  'columns' => 4,
              ),
          ),
        ),

        array(
          'tab' => 'tab_edu',
          'name' => 'Boards',
          'id'   => 'physician_boards',
          'type' => 'taxonomy',
          'taxonomy' => 'boards',
          'multiple'    => true,
          'js_options'      => array(
            'width' => '95%',
          ),
          'query_args' => array(
            'orderby' => 'name',
          ),
        ),
         
        array (
          'id' => 'person_research_profiles_link',
          'type' => 'url',
          'name' => 'Profiles Link',
          'size' => 50,
          'label_description'  => 'Please include the full URL, including https://',
          'tab' => 'tab_edu',
          'columns' => 5,
        ),
         
        array (
          'id' => 'person_pubmed_author_id',
          'type' => 'text',
          'name' => 'Pubmed Author ID',
          'tab' => 'tab_edu',
          'desc' => 'Used to link to Pubmed complete list. AuthorID is found at the end of a link URL for Author.',
          'columns' => 4,
        ),
         
        array (
          'id' => 'pubmed_author_number',
          'name' => 'Number Lastest Articles',
          'type' => 'select',
          'columns' => 3,
          'tab' => 'tab_edu',
          'placeholder' => __( 'Select an option', 'uams-people' ),
          'std' => '3',
          'options' => array(
            '1' => '1',
            '3' => '3',
            '5' => '5',
            '10' => '10',
          ),
        ),

        array(
          'id'     => 'person_select_publications',
          'group_title' => 'Selected Publications',
          'type'   => 'group',
          'tab' => 'tab_edu',
          'add_button' => 'Add Publication',
          'clone'  => true,
          'sort_clone' => true,
          'collapsible' => true,
          'fields' => array(
              array(
                  'name' => 'PubMed ID (PMID)',
                  'id'   => 'publication_pmid',
                  'type' => 'text',
                  'columns' => 3,
                  'class' => 'pubmed-update'
              ),
              array(
                  'name' => 'Pubmed Information',
                  'id'   => 'publication_pubmed_info',
                  'type' => 'textarea',
                  'columns' => 9,
                  'readonly'  => true,
              ),
          ),
        ),
         
        /* Research Tab */
        array (
          'id' => 'person_research_bio',
          'name' => 'Researcher Bio',
          'type' => 'wysiwyg',
          'options' => array(
              'textarea_rows' => 16,
              'teeny'         => false,
              'media_buttons' => false,
          ),
          'tab' => 'tab_research',
          'columns' => 12,
        ),
         
        array (
          'id' => 'person_research_interests',
          'type' => 'textarea',
          'name' => 'Research Interests',
          'tab' => 'tab_research',
        ),

        /* Extra Tab */
        array(
        	'id'     => 'person_awards',
          'group_title' => 'Award(s)',
        	'type'   => 'group',
        	'tab' => 'tab_extra',
          'collapsible' => true,
	      	'clone'  => true,
          'add_button' => 'Add Award',
	      	'sort_clone' => true,
	      	'fields' => array(
	            array(
	                'name' => 'Year',
	                'id'   => 'award_year',
	                'type' => 'text',
                  'columns' => 6,
	            ),
	            array(
	                'name' => 'Award Title',
	                'id'   => 'award_title',
	                'type' => 'text',
                  'columns' => 6,
	            ),
	            array(
	                'name'    => 'Information',
	                'id'      => 'award_infor',
	                'type'    => 'wysiwyg',
                  'columns' => 12,
                  'options' => array(
                      'textarea_rows' => 6,
                      'teeny'         => true,
                      'media_buttons' => false,
                  ),
	            ),
        	),
          'tab' => 'tab_extra',
        ),
         
        array (
          'id' => 'person_additional_info',
          'name' => 'Additional Info',
          'type' => 'wysiwyg',
          'options' => array(
              'textarea_rows' => 16,
              'teeny'         => false,
              'media_buttons' => false,
          ),
          'tab' => 'tab_extra',
        ),
      ),
      'validation' => array(
		    'rules'  => array(
		        'person_first_name' => array(
		            'required'  => true,
		        ),
            'person_last_name' => array(
                'required'  => true,
            ),
		    ),
		    // Optional override of default error messages
		    // 'messages' => array(
		    //     'field_id' => array(
		    //         'required'  => 'Password is required',
		    //         'minlength' => 'Password must be at least 7 characters',
		    //     ),
		    // )
		  ),
    );

    $meta_boxes[] = array(
      //'id' => 'people_name',
      'title' => 'Instructions',
      'post_types' =>   array (
         'people',
      ),
      //'context' => 'after_editor',
      'priority' => 'low',
      'style' => 'seamless',
      //'default_hidden' => true,
      'autosave' => true,
      'fields' => array(
        array(
            'type' => 'custom_html',
            // HTML content
            'std'  => '<div id="message" class="notice notice-info is-dismissible"><p>More information coming soon...</p></div>',
        ),
        array(
              'id'   => 'person_full_name_meta',
              'type' => 'hidden',
              //'tab' => 'tab_details',
              // Hidden field must have predefined value
              'std'  => '',
              'columns' => 12,
          ),
        ),        
    );

    $meta_boxes[] = array(
      'title'      => 'Additional Information',
      'taxonomies' => 'academic_colleges', // List of taxonomies. Array or string

      'fields' => array(
          array(
              'name' => 'Website URL',
              'id'   => 'college_url',
              'type' => 'url',
              'size' => 40,
              'columns' => 12,
          ),
      ),
      'validation' => array(
        'rules'  => array(
            'college_url' => array(
                'required'  => true,
            ),
        ),
      ),        
    );



    return $meta_boxes;

}

add_action( 'rwmb_enqueue_scripts', function ()
{
  wp_enqueue_script( 'pubmed-update', get_stylesheet_directory_uri() . '/js/mb-pubmed.js', [ 'jquery' ] );
} );
add_action('rwmb_before_save_post', function( $post_id )
{
  // Get person ID to save from "Select a Customer" field
  $first_name = $_POST['person_first_name'];
  $middle_name = $_POST['person_middle_name'];
  $last_name = $_POST['person_last_name'];
  
  // Save related field to phone field
  $_POST['person_full_name_meta'] = $last_name . ' ' . $first_name . ' ' . $middle_name;
  
} );
<?php
/* Custom Theme Functions */

// Fix ACF Support
add_filter('_includes/acf-pro/settings/show_admin', '__return_true');

require( 'setup/class.people.php' );
require( 'setup/class.people-custom-post.php' );
require( 'setup/class.people-mb.php' );

// ACF User Role Filter - Disable Nag
add_filter('remove_hube2_nag', '__return_true');

/* Ajax Search Pro Functions */
// Sort by last name, first name, middle name
add_action( 'pre_get_posts', 'cd_sort_people' );
function cd_sort_people( $query ) {
    if ( $query->is_main_query() && !is_admin() ) {
        if ( $query->is_tax() || $query->is_post_type_archive('people') ) {
	        $query->set('meta_query', array(
                'person_last_name' => array(
                    'key' => 'person_last_name',
                ),
                'person_first_name' => array(
                    'key' => 'person_first_name',
                ),
                'person_middle_name' => array(
                    'key' => 'person_middle_name',
                )
            ));
            $query->set('orderby',array(
                'person_last_name' => 'ASC',
                'person_first_name' => 'ASC',
                'person_middle_name' => 'ASC'
            ));
        }
    }
}

// URL modification for Ajax Search Pro
add_filter( 'asp_results', 'asp_custom_link_meta_results', 1, 2 );
function asp_custom_link_meta_results( $results, $id ) {

	if ($id == '2'){
		//$new_url = '';
		$full_name = '';
		$new_desc = '';
		foreach ($results as $k=>$v) {
		  if (($v->content_type == "pagepost") && (get_post_type($v->id) == "people")) {
		  		// $new_url = '/directory/academic/' . get_post_field( 'post_name', $v->id ) .'/';
		  		$full_name = rwmb_meta('person_first_name', '', $v->id) .' ' .(rwmb_meta('person_middle_name', '', $v->id) ? rwmb_meta('person_middle_name', '', $v->id) . ' ' : '') . rwmb_meta('person_last_name', '', $v->id) . (rwmb_meta('person_degree', '', $v->id) ? ', ' . rwmb_meta('person_degree', '', $v->id) : '');
		  		$new_desc = rwmb_meta('person_academic_short_bio', '', $v->id );
		  }
		  // Change only, if the meta is specified
		  // if ( !empty($new_url) )
	   //    		$results[$k]->link  = $new_url;
	      if ( !empty($full_name) )
      			$results[$k]->title  = $full_name;
		  if ( !empty($new_desc) )
	      		$results[$k]->content  = $new_desc;

	      // $new_url = ''; //Reset
	      $full_name = ''; //Reset
	      $new_desc = ''; //Reset
	  	}
	  	return $results;
	}
}
/* End Ajax Search Pro Functions */

/* MetaBox Functions */
// pubmed finder
new pubmed_field_on_change();

class pubmed_field_on_change {

	public function __construct() {
		// enqueue js extension for acf
		// do this when ACF in enqueuing scripts
		//add_action('rwmb_enqueue_scripts', array($this, 'enqueue_script'));
		// ajax action for loading values
		add_action('wp_ajax_load_content_from_pubmed', array($this, 'load_content_from_pubmed'));
	} // end public function __construct

	public function load_content_from_pubmed() {
		// this is the ajax function that gets the related values and returns them

		// check for our other required values
		if (!isset($_POST['pmid'])) {
			echo json_encode(false);
			exit;
		}

		$idstr = intval($_POST['pmid']); //'22703441';

		// make json api call
		$host = 'http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=pubmed&retmode=json&id={IDS}';
		// insert the pmid
		$url = str_replace( '{IDS}', $idstr, $host );
		// get json data
		$request = wp_remote_get( $url );

		$json = wp_remote_retrieve_body( $request );
		if( is_wp_error( $request ) ) {
			return false; // Bail early
		}

		// make the data readable
		$obj = json_decode($json);

			// Get values
			$result = $obj -> result -> $idstr;
			$title = $result->title;
			// create authors array, just in case
			$authors = [];
			$authorlist = '';
			$last_author = end(array_keys($result->authors));
			foreach ($result->authors as $author) {
				$name = $author->name;
				array_push($authors, $name);
				$authorlist .= $name;
				if (next($result->authors)===FALSE) {
					$authorlist .= '.';
				} else {
					$authorlist .= ', ';
				}
			}
			$journal = $result->fulljournalname;
			$source = $result->source;
			$volume = $result->volume;
			$issue = $result->issue;
			$pages = $result->pages;
			$date = $result->pubdate;
			$doi = $result->elocationid;

			// create full reference
			if ($title != '') {
				$full = $authorlist . ' ' . $title . ' ' . $source . '. ' . $date . '; ';
				$full .= $volume . '('. $issue .'):' . $pages . '. ' . $doi . ' PMID: ' . $idstr . '. <br/> View in Pubmed: <a href="https://www.ncbi.nlm.nih.gov/pubmed/' . $idstr . '" target="_blank">' . $idstr . '</a>';
			} else {
				$full = '';
			}

			// put all the values into an array and return it as json
			$array = array(
			  'full' => $full,
			  'title' => $title,
			  'authors' => $authors,
			  'url' => $url,
			  'id' => $result->uid,
			  );
			echo json_encode($array);
			exit;
		//}


	} // end public function load_content_from_relationship

} // end class my_dynmamic_field_on_relationship

// Pubmed API shortcode
// Example: [pubmed terms="Chernoff%20R%5BAuthor%5D" count="10"]
function pubmed_register() {
	if ( !is_admin() ) {
		wp_register_script( 'pubmed-api', get_stylesheet_directory_uri() . '/js/pubmed-api-async.js', array('jquery'), null, true );
	}
}
add_action( 'wp_enqueue_scripts', 'pubmed_register' );
function uams_pubmed_shortcode( $atts ) {

	/* call the javascript to support the api */
	wp_enqueue_script( 'pubmed-api' );

	$atts = shortcode_atts( array(
		'terms' => '',
		'count' => '20',
	), $atts, 'pubmed' );
	return "<ul class=\"pubmed-list\" data-terms=\"{$atts['terms']}\" data-count=\"{$atts['count']}\"></ul>";
}
add_shortcode( 'pubmed', 'uams_pubmed_shortcode' );

add_action( 'rwmb_enqueue_scripts', 'prefix_enqueue_custom_style' );
function prefix_enqueue_custom_style() {
    wp_enqueue_style( 'admin-mb-style', get_stylesheet_directory_uri() . '/admin.css' );
}

/* FacetWP functions */
// factwp Main Query fix
// add_filter( 'facetwp_is_main_query', function( $is_main_query, $query ) {
//     if ( '' !== $query->get( 'facetwp' ) ) {
//         $is_main_query = (bool) $query->get( 'facetwp' );
//     }
//     return $is_main_query;
// }, 10, 2 );

// Filter to fix facetwp hash error
add_filter( 'facetwp_is_main_query', function( $is_main_query, $query ) {
    if ( 'people' == $query->get( 'post_type' ) ) {
		$is_main_query = false;
    }
    return $is_main_query;
}, 10, 2 );

// FacetWP scripts 
function fwp_facet_scripts() {
?>
<script>
(function($) {
    $(document).on('facetwp-loaded', function() {
        $('.facetwp-facet').each(function() {
            var facet_name = $(this).attr('data-name');
            var facet_label = FWP.settings.labels[facet_name];
            if ($('.facet-label[data-for="' + facet_name + '"]').length < 1) {
                $(this).before('<h4 class="facet-label" data-for="' + facet_name + '">' + facet_label + '</h4>');
            }
        });
    });
    $(document).on('facetwp-loaded', function() {
        $.each(FWP.settings.num_choices, function(key, val) {
            var $parent = $('.facetwp-facet-' + key).closest('.fwp-filter');
            (0 === val) ? $parent.hide() : $parent.show();
        });
        if ($('body').hasClass('tax-academic_colleges')) {
        	if (! FWP.loaded) {
	        	$('.facetwp-facet-college .facetwp-checkbox[data-value="<?php echo get_queried_object()->slug; ?>"]').click();
				$('.college-filter').hide();
			}
        }
        if ($('body').hasClass('tax-department')) {
        	if (! FWP.loaded) {
	        	$('.facetwp-facet-department_checkbox .facetwp-checkbox[data-value="<?php echo get_queried_object()->slug; ?>"]').click();
				$('.department-filter').hide();
			}
        }
    });
    $(document).on('facetwp-refresh', function() {
        if (! FWP.loaded) {
            //FWP.set_hash = function() { /* empty function */ }
            if ($('body').hasClass('tax-academic_colleges')) {
            	FWP.set_hash = function() { /* empty function */ } // Exclude hash function
            	$('.college-filter').hide();
            }
            if ($('body').hasClass('tax-department')) {
            	FWP.set_hash = function() { /* empty function */ } // Exclude hash function
            	$('.department-filter').hide();
            }
        }
    });
})(jQuery);
</script>
<?php
}
add_action( 'wp_head', 'fwp_facet_scripts', 100 );
// Adapted from https://gist.github.com/mgibbs189/f2469009a7039159e229efe5a01dab23
// Add Load more and Load All buttons
function fwp_load_more() {
?>
<script>
(function($) {
    $(function() {
        if ('object' != typeof FWP) {
            return;
        }
        wp.hooks.addFilter('facetwp/template_html', function(resp, params) {
            if (FWP.is_load_more) {
                FWP.is_load_more = false;
                $('.facetwp-template').append(params.html);
                return true;
            }
            return resp;
        });
        $(document).on('click', '.fwp-load-more', function() {
            $('.fwp-load-more').html('Loading more people');
            $('.fwp-load-more').after('<span class="fwp-loader"></span>');
            FWP.is_load_more = true;
            FWP.paged = parseInt(FWP.settings.pager.page) + 1;
            FWP.soft_refresh = true;
            FWP.refresh();
        });
        $(document).on('click', '.fwp-load-all', function() {
            $('.fwp-load-all').html('Loading all people');
            $('.fwp-load-all').after('<span class="fwp-loader"></span>');
            FWP.soft_refresh = true;
            FWP.extras.per_page = 500
            FWP.refresh();
        });
        $(document).on('facetwp-loaded', function() {
            $('.fwp-loader').hide();
            if (FWP.settings.pager.page < FWP.settings.pager.total_pages) {
                if (! FWP.loaded && 1 > $('.fwp-load-more').length) {
                    $('.facetwp-template').after('<div class="facetwp__loader"><button class="fwp-load-more btn btn-primary">Show more</button><button class="fwp-load-all btn btn-primary">Show all</button></div>');
                }
                else {
                    $('.fwp-load-more').html('Show more').show();
                }
            }
            else {
                $('.fwp-load-more').hide();
                $('.fwp-load-all').hide();
            }
        });
    });
})(jQuery);
</script>
<?php
}
add_action( 'wp_head', 'fwp_load_more', 99 );

// FacetWP Sort
add_filter( 'facetwp_sort_options', function( $options, $params ) {
	$params = array(
	    'template_name' => 'people', 
	);
    $options['name_asc'] = array(
        'label' => __( 'Name (A-Z)', 'fwp' ),
        'query_args' => array(
            'orderby' => 'meta_value',
			'meta_key' => 'person_full_name_meta',
			'order' => 'ASC',
        )
    );
    $options['name_desc'] = array(
        'label' => __( 'Name (Z-A)', 'fwp' ),
        'query_args' => array(
            'orderby' => 'meta_value',
			'meta_key' => 'person_full_name_meta',
            'order' => 'DESC',
        )
    );
    //);
     unset( $options['title_asc'] );
     unset( $options['title_desc'] );
     unset( $options['date_desc'] );
     unset( $options['date_asc'] );
    return $options;
}, 10, 2 );

//FacetWP Count
add_filter( 'facetwp_result_count', function( $output, $params ) {
    $output = $params['total'] . ( $params['total'] > 1 ? ' People' : ' Person' );
    return $output;
}, 10, 2 );
/* End FacetWP functions */

// Format Phone Numbers
// Usage ex. format_phone('us', '1234567890') => (123) 456-7890
// Base usage returns in ###-###-#### format
function format_phone($country, $phone) {
  $function = 'format_phone_' . $country;
  if(function_exists($function)) {
    return $function($phone);
  }
  return $phone;
}

function format_phone_us($phone) {
  // note: making sure we have something
  if(!isset($phone{3})) { return ''; }
  // note: strip out everything but numbers
  $phone = preg_replace("/[^0-9]/", "", $phone);
  $length = strlen($phone);
  switch($length) {
  case 7:
    return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
  break;
  case 10:
   return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
  break;
  case 11:
  return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1($2) $3-$4", $phone);
  break;
  default:
    return $phone;
  break;
  }
}
function format_phone_base($phone) {
  // note: making sure we have something
  if(!isset($phone{3})) { return ''; }
  // note: strip out everything but numbers
  $phone = preg_replace("/[^0-9]/", "", $phone);
  $length = strlen($phone);
  switch($length) {
  case 7:
    return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
  break;
  case 10:
   return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
  break;
  case 11:
  return preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3-$4", $phone);
  break;
  default:
    return $phone;
  break;
  }
}
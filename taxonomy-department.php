<?php
   	get_header();

	function custom_field_excerpt($title) {
			global $post;
			$text = rwmb_meta($title);
			if ( '' != $text ) {
				$text = strip_shortcodes( $text );
				$text = apply_filters('the_content', $text);
				$text = str_replace(']]>', ']]>', $text);
				$excerpt_length = 35; // 35 words
				$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
				$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
			}
			return apply_filters('the_excerpt', $text);
		}
	function wpdocs_custom_excerpt_length( $length ) {
	    return 35; // 35 words
	}
	add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

	add_filter( 'facetwp_template_use_archive', '__return_true' );

 	get_template_part( 'header', 'image' ); ?>

	<div class="container uams-body">

	  <div class="row">

	    <div class="col-md-12 uams-content" role='main'>

	      <?php // Hard coded breadcrumbs 
	      		$tax = get_term_by("slug", get_query_var("term"), get_query_var("taxonomy") )
	      ?>
	    <nav class="uams-breadcrumbs" role="navigation" aria-label="breadcrumbs">
	    	<ul>
	    		<li><a href="http://www.uams.edu" title="University of Arkansas for Medical Scineces">Home</a></li>
	    		<li><a href="/" title="<?php echo str_replace('   ', ' ', get_bloginfo('title')); ?>"><?php echo str_replace('   ', ' ', get_bloginfo('title')); ?></a></li>
	    		<li><a href="<?php echo get_bloginfo('url'); ?>/people/" title="People">People</a></li>
	    		<li class="current"><span><?php echo $tax->name; ?></span>
	    	</ul>
	    </nav>

	      <div id='main_content' class="uams-body-copy" tabindex="-1">

				<div class="row">
					<div class="col-md-8 people">
					    <?php $i = 0; ?>

					    <h1><?php echo single_cat_title( '', false ); ?></h1><hr>

					    <?php echo (term_description( '', false ) ? '<p>' .term_description( '', false ) . '</p>' : '' ); ?>

					    <?php echo facetwp_display( 'facet', 'alpha' ); ?>

					    <?php echo facetwp_display( 'template', 'people' ); ?>

					    <?php //echo do_shortcode('[facetwp load_more="true" label="Load more"]'); ?>

					</div><!-- .col -->
					<div class="col-md-4">
			        	<?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=2]' ); // based on install ?>
			        	<?php echo do_shortcode( '[accordion]
													    [section title="Advanced Filter"]
															<div class="fwp-filter">[facetwp facet="college"]</div>
															<div class="fwp-filter">[facetwp facet="position"]</div>
															<div class="fwp-filter department-filter">[facetwp facet="department_checkbox"]</div>
															<button onclick="FWP.reset()">Reset</button>
														[/section]
												  [/accordion]' ); ?>
		        	</div>
				</div><!-- .row -->
   			</div><!-- main_content -->

    	</div><!-- uams-content -->
    <div id="sidebar"></div>

  </div>

</div>

<?php get_footer(); ?>
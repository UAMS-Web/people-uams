<?php
	/**
	 *  Template Name: Physician
	 *  Designed for person single, where type == physicians
	 */
?>
		   <style type="text/css">

			.acf-map {
				width: 100%;
				height: 400px;
				border: #ccc solid 1px;
				margin: 20px 0;
			}

			/* fixes potential theme css conflict */
			.acf-map img {
			   max-width: inherit !important;
			}

			</style>
			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
			<script type="text/javascript">
			(function($) {

			/*
			*  new_map
			*
			*  This function will render a Google Map onto the selected jQuery element
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	4.3.0
			*
			*  @param	$el (jQuery element)
			*  @return	n/a
			*/

			function new_map( $el ) {

				// var
				var $markers = $el.find('.marker');


				// vars
				var args = {
					zoom		: 16,
					center		: new google.maps.LatLng(0, 0),
					mapTypeId	: google.maps.MapTypeId.ROADMAP
				};


				// create map
				var map = new google.maps.Map( $el[0], args);


				// add a markers reference
				map.markers = [];


				// add markers
				$markers.each(function(){

			    	add_marker( $(this), map );

				});


				// center map
				center_map( map );


				// return
				return map;

			}

			/*
			*  add_marker
			*
			*  This function will add a marker to the selected Google Map
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	4.3.0
			*
			*  @param	$marker (jQuery element)
			*  @param	map (Google Map object)
			*  @return	n/a
			*/

			function add_marker( $marker, map ) {

				// var
				var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

				// create marker
				var marker = new google.maps.Marker({
					position	: latlng,
					label		: $marker.attr('data-label'),
					map			: map
				});

				// add to array
				map.markers.push( marker );

				// if marker contains HTML, add it to an infoWindow
				if( $marker.html() )
				{
					// create info window
					var infowindow = new google.maps.InfoWindow({
						content		: $marker.html()
					});

					// show info window when marker is clicked
					google.maps.event.addListener(marker, 'click', function() {

						infowindow.open( map, marker );

					});
				}

			}

			/*
			*  center_map
			*
			*  This function will center the map, showing all markers attached to this map
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	4.3.0
			*
			*  @param	map (Google Map object)
			*  @return	n/a
			*/

			function center_map( map ) {

				// vars
				var bounds = new google.maps.LatLngBounds();

				// loop through all markers and create bounds
				$.each( map.markers, function( i, marker ){

					var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

					bounds.extend( latlng );

				});

				// only 1 marker?
				if( map.markers.length == 1 )
				{
					// set center of map
				    map.setCenter( bounds.getCenter() );
				    map.setZoom( 16 );
				}
				else
				{
					// fit to bounds
					map.fitBounds( bounds );
				}

			}

			/*
			*  document ready
			*
			*  This function will render each map when the document is ready (page has loaded)
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	5.0.0
			*
			*  @param	n/a
			*  @return	n/a
			*/
			// global var
			var map = null;

			$(document).ready(function(){

				$('.acf-map').each(function(){

					// create map
					map = new_map( $(this) );

				});

			});

			$(document).ready(function(){

			  $( '#label_tab-location' ).click( function() {

			  		google.maps.event.trigger(map, 'resize');
			  		center_map(map);

               });

			  $( '#label_tab-location' ).focus( function() {

			  		google.maps.event.trigger(map, 'resize');
			  		center_map(map);

               });

			});

			})(jQuery);
			</script>
			<h2>Base</h2>
<!-- 			<div style="margin-bottom: 10px; max-width: 450px;"><?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=4]' ); ?></div> -->
	        <div class="row">
		        <div class="col-md-8">
	                <h1 class="title-heading-left" data-fontsize="34" data-lineheight="48"><?php echo rwmb_meta('person_first_name'); ?> <?php echo (rwmb_meta('person_middle_name') ? rwmb_meta('person_middle_name') : ''); ?> <?php echo rwmb_meta('person_last_name'); ?><?php echo (rwmb_meta('person_degree') ? ', ' . rwmb_meta('person_degree') : ''); ?></h1>
	                	<?php echo (rwmb_meta('person_academic_title') ? '<h4>' . rwmb_meta('person_academic_title') .'</h4>' : ''); ?>
	                    <?php echo (rwmb_meta('physician_title') ? '<h4>' . rwmb_meta('physician_title') .'</h4>' : ''); ?>
	            </div>
				<div class="col-md-4">
					<!-- Content? -->
	            </div>
	        </div>
			<div class="row">
				<div class="col-md-3">
	                <div style="padding-bottom: 1em;">
	                    <?php the_post_thumbnail( 'medium' ); ?>
	                </div>
	            </div>
				<div class="col-md-9">
	                <div class="js-tabs tabs__uams">
		                <ul class="js-tablist tabs__uams_ul" data-hx="h2">
			               	<?php
				               	// get some info for tabs
				               	$profile_types = rwmb_meta('profile_type');
				               	$physician_locations = rwmb_meta('physician_locations');
						if( ! empty( $profile_types ) && ! is_wp_error( $profile_types ) ): 
							foreach ($profile_types as $profile_type)  { 
								$profile_type_name = $profile_type->name;
								if ( $profile_type_name === 'Academic' ) {
									$profile_academic = true;
								?>
	                    	<li class="js-tablist__item tabs__uams__li">
	                    		<a href="#tab-academic" id="label_tab-academic" class="js-tablist__link tabs__uams__a" data-toggle="tab">
	                            	Academic
	                            </a>
	                        </li>
	      					<?php } elseif ( $profile_type_name === 'Physician' ) { 
	      						$profile_clinical = true;
	      						?>
	                    	<li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-clinical" id="label_tab-clinical" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            Clinical
		                        </a>
	                        </li>
	                        <?php } //endif
	                        } // end foreach ?>
	                    <?php endif; ?>
	                        <li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-academics" id="label_tab-academics" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            Academics
		                        </a>
	                        </li>
	                    <?php if( !empty(rwmb_meta('person_research_bio')) || !empty(rwmb_meta('person_research_interests'))): ?>
	                    	<li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-research" id="label_tab-research" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            Research
		                        </a>
	                        </li>
	                    <?php endif; ?>
	                    <?php if(!empty (rwmb_meta('person_awards')) || rwmb_meta('person_additional_info')): ?>
	                    	<li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-info" id="label_tab-info" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            Additional Info
		                        </a>
	                        </li>
	                    <?php endif; ?>
                        </ul>
                        <div class="uams-tab-content">
	                    <?php if( $profile_academic ): ?>
	                        <div id="tab-academic" class="js-tabcontent tabs__uams__tabcontent">
			                    <?php echo rwmb_meta('person_academic_bio'); ?>
			                    <?php 
			                    	$contact_information = rwmb_meta('person_contact_infomation');
			                    	if( $contact_information ): ?>
	                            	<h3>Contact Infomation</h3>
								    <ul>
								    <?php foreach( $contact_information as $contact_info ): ?>
								        <li><?php echo contact_info['office_contact_type']['label']; ?>: <?php echo contact_info['office_contact_value']; ?></li>
								    <?php endforeach; ?>
								    </ul>
								<?php endif; ?>
			                    <?php if ( rwmb_meta('person_academic_office') ): ?>
			                    <div>
				                    <p><strong>Office:</strong> <?php echo rwmb_meta('person_academic_office'); ?></p>
				                    <p>Map goes here</p>
			                    </div>
			                    <?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if( $profile_clinical ): ?>
	                        <div id="tab-clinical" class="js-tabcontent tabs__uams__tabcontent">
			                    <?php echo rwmb_meta('physician_clinical_bio'); ?>
			                    <p><a class="uams-btn btn-md" target="_self" title="Make an Appointment" href="<?php echo rwmb_meta('physician_appointment_link'); ?>">Make an Appointment</a></p>
			                    <?php if(rwmb_meta('physician_youtube_link')) { ?>
					                <p>
					                    <a class="uams-btn btn-red btn-play btn-md" target="_self" title="Watch Video" href="<?php echo rwmb_meta('physician_youtube_link'); ?>">Watch Video</a>
					                </p>
								<?php } ?>
								<?php

									$locations = rwmb_meta('physician_locations');

									?>
									<?php if( $locations ): ?>
									<h3 data-fontsize="16" data-lineheight="24"><i class="fa fa-medkit"></i> Clinic(s)</h3>
										<ul>
										<?php foreach( $locations as $location ): ?>
											<li>
												<a href="<?php echo get_permalink( $location ); ?>">
													<?php echo get_the_title( $location ); ?>
												</a>
											</li>
										<?php endforeach; ?>
										</ul>
								<?php endif; ?>
			                    <?php // load all 'specialties' terms for the post
									$specialties = rwmb_meta('medical_specialties');

									// we will use the first term to load ACF data from
									if( $specialties ): ?>
									<h3>Specialties</h3>
										<ul>
											<?php foreach( $specialties as $specialty ): ?>
												<li>
													<a href="<?php echo get_term_link( $specialty ); ?>">
													<?php $specialty_name = get_term( $specialty, 'specialty');
														echo $specialty_name->name;
													?>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
								<?php endif; ?>
								<?php // load all 'specialties' terms for the post
									$conditions = rwmb_meta('physician-conditions');

									// we will use the first term to load ACF data from
									if( $conditions ): ?>
									<h3>Conditions/Diseases Treated</h3>
									<p><em>UAMS doctors treat a broad range of conditions some of which may not be listed below.</em></p>
										<ul>
											<?php foreach( $conditions as $condition ): ?>
												<li>
													<?php $condition_name = get_term( $condition, 'condition');
														echo $condition_name->name;
													?>
												</li>
											<?php endforeach; ?>
										</ul>
								<?php endif; ?>
								<?php // load all 'specialties' terms for the post
									$procedures = rwmb_meta('medical_procedures');

									// we will use the first term to load ACF data from
									if( $procedures ): ?>
									<h3>Tests/Procedures Performed</h3>
									<p><em>The following list represents some, but not all, of the procedures offered by this doctor.</em></p>
										<ul>
											<?php foreach( $procedures as $procedure ): ?>
												<li>
													<?php $procedure_name = get_term( $procedure, 'medical_procedures');
														echo $procedure_name->name;
													?>
												</li>
											<?php endforeach; ?>
										</ul>
								<?php endif; ?>
							</div>
						<?php endif; ?>
	                        <div id="tab-academics" class="js-tabcontent tabs__uams__tabcontent">
	                            <?php 
	                            	$academic_appointments = rwmb_meta('person_academic_appointment');
	                            	if( ! empty($academic_appointments) ): ?>
	                            	<h3>Academic Appointments</h3>
								    <ul>
								    <?php foreach( $academic_appointments as $academic_appointment ): ?>
								        <li><?php echo $academic_appointment['academic_title']; ?>, <?php echo $academic_appointment['academic_department']; ?></li>
								    <?php endforeach; ?>
								    </ul>
								<?php endif; ?>
								<?php 
									$schools = rwmb_meta('person_education');
									if( ! empty( $schools ) ): ?>
	                            	<h3>Education</h3>
								    <ul>
								    <?php foreach( $schools as $school ): ?>
								        <li><?php echo $school['person_education_type']; ?> - <?php echo ($school['person_education_description'] ? '' . $school['person_education_description'] .'<br/>' : ''); ?><?php echo $school['person_education_school']; ?></li>
								    <?php endforeach; ?>
								    </ul>
								<?php endif; ?>
								<?php 
									$boards = rwmb_meta( 'physician_boards' );
									if( ! empty( $boards ) ): ?>
	                            	<h3>Professional Certifications</h3>
								    <ul>
								    <?php foreach ( $boards as $board ) : // group value
								    		foreach ( $board as $board_id ) { ?>
								        		<li><?php echo $board_id; ?></li>
								        	<?php }; ?>
								    <?php endforeach; ?>
								    </ul>
								<?php endif; ?>
								<?php 
									$publications = rwmb_meta('person_publications');
									if(  ! empty( $publications )): ?>
	                            	<h3>Selected Publications</h3>
								    <ul>
								    <?php foreach( $publications as $publication ) { ?>
								        <li><?php echo $publication['pub_authors']; ?> (<?php echo $publication['pub_published']; ?>) <?php echo $publication['pub_title']; ?> <em><?php echo $publication['pub_periodical']; ?> <?php echo ( $publication['pub_volume'] ? $publication['pub_volume'] : ''); ?></em><?php echo ( $publication[ 'pub_issue'] ? '(' . $publication['pub_issue'] .')' : ''); ?> <?php echo $publication['pub_pmid']; ?> <?php echo $publication['pub_pmcid']; ?> </li>
								    <?php } ?>
								    </ul>
								<?php endif; ?>
	                        </div>
	                    <?php if( !empty(rwmb_meta('person_research_bio')) || !empty(rwmb_meta('person_research_interests')) ): ?>
	                        <div id="tab-research" class="js-tabcontent tabs__uams__tabcontent">
	                            <?php
		                            if(rwmb_meta('person_research_bio'))
									{
										echo rwmb_meta('person_research_bio');
									}
		                        ?>
								<?php
									if(rwmb_meta('person_research_interests'))
									{ ?>
									<h3>Research Interests</h3>
								<?php
										echo rwmb_meta('person_research_interests');
									}
								?>
								<?php
									if(rwmb_meta('person_research_profiles_link'))
									{ ?>
										<a href="<?php echo rwmb_meta('person_research_profiles_link'); ?>" target="_blank">UAMS TRI Profiles</a>
								<?php }
								?>
	                        </div>
	                    <?php endif; ?>
						<?php 
							$awards = rwmb_meta('person_awards');
							if(! empty( $awards ) || rwmb_meta('person_additional_info')): ?>
	                        <div id="tab-info" class="js-tabcontent tabs__uams__tabcontent">
	                            <?php if(! empty( $awards ) ): ?>
	                            	<h3>Awards</h3>
								    <ul>
								    <?php foreach ( $awards as $award ) { ?>
								        <li><?php echo $award['award_title']; ?> (<?php echo $award['award_year']; ?>)<?php echo ($award['award_infor'] ? '<br/>' . $award['award_infor'] : ''); ?></li>
								    <?php } ?>
								    </ul>
								<?php endif; ?>
								<?php
									if(rwmb_meta('person_additional_info'))
									{
										echo rwmb_meta('person_additional_info');
									}
								?>
	                        </div>
	                    <?php endif; ?>
	            		</div><!-- uams-tab-content -->
	                </div><!-- js-tabs -->
	    		</div><!-- col-md-9 -->
	    		<script src="<?php echo get_template_directory_uri(); ?>/js/uams.tabs.min.js" type="text/javascript"></script>
		    	</script>
				<?php wp_reset_query(); ?>
			</div>
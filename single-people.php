<?php
	/**
	 *  Template Name: People
	 *  Designed for people single
	 */


	get_header();
	$sidebar = get_post_meta($post->ID, "sidebar");
	$breadcrumbs = get_post_meta($post->ID, "breadcrumb");
 ?>
	<?php get_template_part( 'header', 'image' ); ?>

	<!--<div class="col-md-12 mobile-menu"> <?php get_template_part( 'menu', 'mobile' ); ?> </div>-->
	<div class="container uams-body">

	  <div class="row">

	    <div class="col-md-12 uams-content" role='main'>

	      <?php
		      if((!isset($breadcrumbs[0]) || $breadcrumbs[0]!="on")) {
		      	get_template_part( 'breadcrumbs' );
		      }
		  ?>

	      <div id='main_content' class="uams-body-copy" tabindex="-1">
	      	<div class="margin-bottom-one search-box-lg"><?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=2]' ); // install dependent ?></div>
	        <div class="row">
		        <div class="col-md-8">
	                <h1 class="title-heading-left" data-fontsize="34" data-lineheight="48"><?php echo rwmb_meta('person_first_name'); ?> <?php echo (rwmb_meta('person_middle_name') ? rwmb_meta('person_middle_name') : ''); ?> <?php echo rwmb_meta('person_last_name'); ?><?php echo (rwmb_meta('person_degree') ? ', ' . rwmb_meta('person_degree') : ''); ?></h1>
	                	<?php echo (rwmb_meta('person_academic_title') ? '<h4>' . rwmb_meta('person_academic_title') .'</h4>' : ''); ?>
	            </div>
				<div class="col-md-4">
	            </div>
	        </div>
			<div class="row">
				<div class="col-md-3">
	                <div class="margin-bottom-one">
	                    <?php the_post_thumbnail( 'medium' ); ?>
	                    <?php
		                    $colleges = rwmb_meta('person_academic_college');
		                    $departments = rwmb_meta('people_departments');
		                    if( $colleges ):
		                    $colcount = count($colleges);
		                    $coltitle = ($colcount > 1 ? 'Colleges' : 'College'); ?>
		                    <h3><?php echo $coltitle; ?></h3>
							<ul>
								<?php foreach( $colleges as $college ): ?>
									<li>
										<a href="<?php echo get_term_link( $college ); ?>">
											<?php $college_name = get_term( $college, 'academic_colleges');
												echo $college_name->name;
											?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php
		                    elseif( $departments ): 
		                    	$deptcount = count($departments);
		                    	$depttitle = ($deptcount > 1 ? 'Departments' : 'Department'); ?>
		                    <h3><?php echo $depttitle; ?></h3>
							<ul>
								<?php foreach( $departments as $department ): ?>
									<li>
										<a href="<?php echo get_term_link( $department ); ?>">
											<?php $dept_name = get_term( $department, 'academic_colleges');
												echo $dept_name->name;
											?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
	                </div>
	            </div>
				<div class="col-md-9">
	                <div class="js-tabs tabs__uams">
		                <ul class="js-tablist tabs__uams_ul" data-hx="h2">
	                    	<li class="js-tablist__item tabs__uams__li">
	                    		<a href="#tab-overview" id="label_tab-overview" class="js-tablist__link tabs__uams__a" data-toggle="tab">
	                            	Overview
	                            </a>
	                        </li>
	                        <li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-academics" id="label_tab-academics" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            Education
		                        </a>
	                        </li>
	                    <?php if( !empty(rwmb_meta('person_research_bio')) || !empty(rwmb_meta('person_research_interests'))): ?>
	                    	<li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-research" id="label_tab-research" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            Research
		                        </a>
	                        </li>
	                    <?php endif; ?>
	                    <?php if( !empty (rwmb_meta('person_awards')) || rwmb_meta('person_additional_info')): ?>
	                    	<li class="js-tablist__item tabs__uams__li">
	                            <a href="#tab-info" id="label_tab-info" class="js-tablist__link tabs__uams__a" data-toggle="tab">
		                            Additional Info
		                        </a>
	                        </li>
	                    <?php endif; ?>
                        </ul>
                        <div class="uams-tab-content">
	                        <div id="tab-overview" class="js-tabcontent tabs__uams__tabcontent">
			                    <?php echo rwmb_meta('person_academic_bio'); ?>

			                    <?php
			                    	$contact_information = rwmb_meta('person_contact_information');
			                     	if( !empty( $contact_information ) ): ?>
	                            	<h3>Contact Infomation</h3>
								    <ul>
								    	<?php foreach( $contact_information as $contact_info ): ?>
									    	<?php if ($contact_info['office_contact_type'] == 'sms') : // text/mobile ?>
									    		<li>Text/SMS: <a href="sms:<?php echo $contact_info['office_contact_value']; ?>"><?php echo $contact_info['office_contact_value']; ?></a></li>
									    	<?php elseif ($contact_info['office_contact_type'] == 'phone') : // Phone ?>
									    		<li>Phone: <a href="tel:<?php echo format_phone('base', $contact_info['office_contact_value']); ?>"><?php echo format_phone('us', $contact_info['office_contact_value']); ?></a></li>
									    	<?php elseif ($contact_info['office_contact_type'] == 'mobile') : // Phone ?>
									    		<li>Mobile: <a href="tel:<?php echo format_phone('base', $contact_info['office_contact_value']); ?>"><?php echo format_phone('us', $contact_info['office_contact_value']); ?></a></li>
									    	<?php elseif ($contact_info['office_contact_type'] == 'email') : // Email ?>
									    		<li>Email: <a href="mailto:<?php echo $contact_info['office_contact_value']; ?>"><?php echo $contact_info['office_contact_value']; ?></a></li>
									    	<?php else : // Others ?>
									        	<li>Other: <?php echo $contact_info['office_contact_value']; ?></li>
									        <?php endif; ?>
										<?php endforeach; ?>
								    </ul>
								<?php endif; ?>
			                    <?php if ( rwmb_meta('person_academic_office') || rwmb_meta('person_academic_map') ): ?>
			                    <div>
				                    <?php if ( rwmb_meta('person_academic_office') ): ?>
				                    <p><strong>Office:</strong> <?php echo rwmb_meta('person_academic_office'); ?></p>
				                    <?php endif; ?>
				                    <?php if ( rwmb_meta('person_academic_map') ): ?>
				                    <div class="uams-campus-map-widget">
					                  <iframe width="100%" height="365" src="//maps.uams.edu/full-screen/?markerid=<?php echo rwmb_meta('person_academic_map') ?>" frameborder="0"></iframe>
					                  <a href="https://maps.uams.edu/map-mashup/?markerid=<?php echo rwmb_meta('person_academic_map') ?>" target="_blank">View larger</a>
					                </div>
					                <?php endif; ?>
			                    </div>
			                    <?php endif; ?>
							</div>
						<?php if(rwmb_meta('person_academic_appointment')||rwmb_meta('person_education')||rwmb_meta('physician_boards')||rwmb_meta('person_publications')||rwmb_meta('person_pubmed_author_id')): ?>
	                        <div id="tab-academics" class="js-tabcontent tabs__uams__tabcontent">
	                            <?php 
	                            	$academic_appointments = rwmb_meta('person_academic_appointment');
	                            	if( !empty ( $academic_appointments ) ): ?>
	                            	<h3>Academic Appointments</h3>
								    <ul>
								    <?php foreach( $academic_appointments as $academic_appointment ): 
								    		$academic_department_name = get_term($academic_appointment['academic_department'], 'academic_department');
								    	?>
								        <li><?php echo $academic_appointment['academic_title']; ?>, <?php echo $academic_department_name->name; ?></li>
								    <?php endforeach; ?>
								    </ul>
								<?php endif; ?>
								<?php
									$schools = rwmb_meta('person_education');
								 	if( !empty ( $schools ) ): ?>
	                            	<h3>Education</h3>
								    <ul>
								    <?php foreach( $schools as $school ): 
								    	$school_name = get_term( $school['person_education_school'], 'schools');
								    ?>
								        <li><?php echo $school['person_education_type']; ?> - <?php echo ($school['person_education_description'] ? '' . $school['person_education_description'] .'<br/>' : ''); ?><?php echo $school_name->name; ?></li>
								    <?php endforeach; ?>
								    </ul>
								<?php endif;
									$boards = rwmb_meta( 'physician_boards' );
									if( ! empty( $boards ) ): ?>
	                            	<h3>Professional Certifications</h3>
								    <ul>
								    <?php foreach ( $boards as $board ) :
								    		$board_name = get_term( $board, 'boards'); ?>
								        		<li><?php echo $board_name->name; ?></li>
								        	<?php // }; ?>
								    <?php endforeach; ?>
								    </ul>
								<?php endif; ?>
								<?php 
									$publications = rwmb_meta('person_select_publications');
									if( !empty ( $publications ) ): ?>
	                            	<h3>Selected Publications</h3>
								    <ul>
								    <?php foreach( $publications as $publication ): ?>
								        <li><?php echo $publication['publication_pubmed_info']; ?></li>
								    <?php endforeach; ?>
								    </ul>
								<?php endif; ?>
								<?php if( rwmb_meta('person_pubmed_author_id') ): ?>
									<?php
										$pubmedid = trim(rwmb_meta('person_pubmed_author_id'));
										$pubmedcount = (rwmb_meta('pubmed_author_number') ? rwmb_meta('pubmed_author_number') : '3')

									?>
	                            	<h3>Latest Publications</h3>
								    <?php echo do_shortcode( '[pubmed terms="' . urlencode($pubmedid) .'%5BAuthor%5D" count="' . $pubmedcount .'"]' ); ?>
								<?php endif; ?>
								<?php if( rwmb_meta('person_research_profiles_link') ): ?>
	                            	More information is available on <a href="<?php echo rwmb_meta('person_research_profiles_link'); ?>">UAMS Profile Page</a>
								<?php endif; ?>
	                        </div>
	                    <?php endif; ?>
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
				<?php wp_reset_query(); ?>
			</div>

		  </div><!-- #main_content -->

    	</div><!-- uams-content -->

		<div id="sidebar"></div>

  </div><!-- row -->

</div>

<?php get_footer(); ?>
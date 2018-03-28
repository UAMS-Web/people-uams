<?php
	/**
	 *  Template Name: People
	 *  Designed for people archive, where type == academic 
	 */
 ?>
				<?php $args = array(
					    'post_type' => 'people',
					    'tax_query' => array(
							array(
								'taxonomy' => 'profile_type',
								'field' => 'slug',
								'terms' => 'academic'
							)
						)
					);

					$query = new WP_Query( $args );
				?>
			    <style>
				    .whiteBackground { background-color: #fff; }
					.grayBackground { background-color: #fafafa; }
				</style>
				<div class="row">
					<div class="col-md-12">
						<?php // echo do_shortcode( '[wpdreams_ajaxsearchpro id=1]' ); ?>
					</div>
				</div>
				<div class="row">
		        	<div class="col-md-4">
			        	<?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=2]' ); ?>
			        	<?php echo do_shortcode( '[accordion]
													    [section title="Advanced Filter"]
														<h4>College Affiliation</h4>
														[facetwp facet="college_affiliation"]
														<h4>Position Type</h4>
														[facetwp facet="academic_position"]
														[/section]
													[/accordion]' ); ?>


		        	</div>
					<div class="col-md-8 facetwp-template">
					    <?php $i = 0; ?>

					    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
					    <?php $class = ($i%2 == 0)? 'whiteBackground': 'grayBackground'; ?>
					    <?php $full_name = rwmb_meta('person_first_name') .' ' .(rwmb_meta('person_middle_name') ? rwmb_meta('person_middle_name') . ' ' : '') . rwmb_meta('person_last_name') . (rwmb_meta('person_degree') ? ', ' . rwmb_meta('person_degree') : '');
						      $profileurl = '/directory/academic/' . $post->post_name .'/';
					    ?>
					    <div class="<?php echo $class; ?>" style="border:1px solid #ececec;padding:10px; margin-bottom: 10px;">
						    <div class="row">
						        <div class="col-md-12">
							        <a href="<?php echo $profileurl; ?>"><h2 style="margin-top: 0;"><?php echo $full_name; ?></h2></a>
									<?php // load all 'colleges' terms for the post
									$colleges = rwmb_meta('person_academic_college');

									// we will use the first term to load ACF data from
									if( $colleges ): ?>
										<?php foreach( $colleges as $college ): ?>
											<p><strong>
												<?php $college_name = get_term( $college, 'academic_colleges');
													echo $college_name->name;
												?>
											</strong></p>
										<?php endforeach;
									endif; ?>
						        </div>
					    	</div>
					        <div class="row">
					            <div class="col-md-3" style="margin-top:0px;margin-bottom:20px;">
						            <div style="padding-bottom: 1em;">
		                            	<span style="-moz-box-shadow: 0 0 3px rgba(0,0,0,.3);-webkit-box-shadow: 0 0 3px rgba(0,0,0,.3);box-shadow: 0 0 3px rgba(0,0,0,.3);"><a href="<?php echo $profileurl; ?>" target="_self"><?php the_post_thumbnail( 'medium' ); ?></a></span>
						            </div>
			                        <a class="uams-btn btn-blue btn-sm" target="_self" title="View Profile" href="<?php echo $profileurl; ?>">View Profile</a>
					            </div>
					            <div class="col-md-9" style="margin-top:0px;margin-bottom:0px;">
			                            <div class="row" style="margin-top:0px;margin-bottom:0px;">
					                        <div class="col-md-6">
					                            <p><?php echo ( rwmb_meta('person_academic_short_bio') ? rwmb_meta( 'person_academic_short_bio') : wp_trim_words( rwmb_meta( 'person_academic_bio' ), 30, ' &hellip;' ) ); ?></p>
					                            <a class="more" target="_self" title="View Profile" href="<?php echo $profileurl; ?>">View Profile</a>

					                            <p></p>

					                        </div>
					                        <div class="col-md-6">
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
							                    <?php if ( rwmb_meta('person_academic_office') ): ?>
							                    <div>
								                    <p><strong>Office:</strong> <?php echo rwmb_meta('person_academic_office'); ?></p>                    		
								                </div>
							                    <?php endif; ?>

					                        </div><!-- .col-6 -->
					                    </div><!-- .row -->

					            </div><!-- .col-9 -->
					        </div><!-- .row -->
					    </div><!-- .color -->
					    <?php $i++; ?>
						<?php endwhile; ?>
					</div><!-- .col -->
				</div><!-- .row -->

				<?php
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
					?>

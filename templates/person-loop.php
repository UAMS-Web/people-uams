<?php $i = 0; ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php $class = ($i%2 == 0)? 'whiteBackground': 'grayBackground'; ?>
    <?php $full_name = rwmb_meta('person_first_name') .' ' .(rwmb_meta('person_middle_name') ? rwmb_meta('person_middle_name') . ' ' : '') . rwmb_meta('person_last_name') . (rwmb_meta('person_degree') ? ', ' . rwmb_meta('person_degree') : '');
	      $profileurl = get_the_permalink();
    ?>
    <div class="<?php echo $class; ?> archive-box">
	    <div class="row">
	        <div class="col-md-12">
		        <a href="<?php echo $profileurl; ?>"><h2 class="margin-top-none"><?php echo $full_name; ?></h2></a>
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
            <div class="col-md-3" class="margin-top-none margin-bottom-two">
	            <div class="margin-bottom-two">
                	<span><a href="<?php echo $profileurl; ?>" target="_self"><?php the_post_thumbnail( 'medium' ); ?></a></span>
	            </div>
                <a class="uams-btn btn-blue btn-sm" target="_self" title="View Profile" href="<?php echo $profileurl; ?>">View Profile</a>
            </div>
            <div class="col-md-9" class="margin-top-none margin-bottom-none">
                    <div class="row" class="margin-top-none margin-bottom-none">
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
<?php endwhile; else : ?>
	<p><?php _e( 'Sorry, no people matched your criteria.' ); ?></p>
<?php endif; ?>
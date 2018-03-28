<?php
	/**
	 *  Template Name: People
	 *  Designed for people archive, where type != academic && != physician
	 */
 ?>

			    <style>
				    .whiteBackground { background-color: #fff; }
					.grayBackground { background-color: #fafafa; }
				</style>
				<script>
					(function($) {
					    $(document).on('facetwp-refresh', function() {
					        if (FWP.loaded) {
					            $('.facetwp-template').prepend('<div class="loading"><div class="facetwp-loading" style="text-align: center; width:40px; height:40px; background-size:40px 40px;"></div></div>');
					        }
					    });
					})(jQuery);
				</script>
				<div class="row">
		        	<div class="col-md-4">
			        	<?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=1]' ); ?>
			        	<?php echo do_shortcode( '[accordion]
													    [section title="Advanced Filter"]
														<h4>Primary Care</h4>
														[facetwp facet="primary_care"]
														<h4>Conditions Treated</h4>
														[facetwp facet="conditions"]
														<h4>Patient Types</h4>
														[facetwp facet="patient_types"]
														<h4>Gender</h4>
														[facetwp facet="physician_gender"]
														<h4>Language(s)</h4>
														[facetwp facet="physician_language"]
														<button onclick="FWP.reset()">Reset</button>
														[/section]
													[/accordion]' ); ?>
		        	</div>
					<div class="col-md-8 people">
						<?php echo do_shortcode('[facetwp template="physician"]'); ?>
					</div><!-- .col -->
				</div><!-- .row -->

<!-- 					<span class="next-page"><?php next_posts_link( 'Next page', '' ); ?></span> -->
						<style>
						.page-numbers {
							display: inline-block;
							padding: 5px 10px;
							margin: 0 2px 0 0;
							border: 1px solid #eee;
							line-height: 1;
							text-decoration: none;
							border-radius: 2px;
							font-weight: 600;
						}
						.page-numbers.current,
						a.page-numbers:hover {
							background: #f9f9f9;
						}
						</style>
											<div class="pagination"><?php
						global $wp_query;

						$big = 999999999; // need an unlikely integer
						$translated = __( 'Page', 'mytextdomain' ); // Supply translatable string

						echo paginate_links( array(
						    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						    'format' => '?paged=%#%',
						    'current' => max( 1, get_query_var('paged') ),
						    'total' => $wp_query->max_num_pages,
						        //'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>',
						) );
						?></div>
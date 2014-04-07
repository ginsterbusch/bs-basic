<?php
/**
 * Template for displaying pages
 * 
 * @package bootstrap-basic
 */

get_header();

/**
 * determine main column size from actived sidebar
 */
$main_column_size = bootstrapBasicGetMainColumnSize();
?> 
<?php get_sidebar('left'); ?> 
				<div class="col-md-<?php echo $main_column_size; ?> content-area" id="main-column">
					<main id="main" class="site-main" role="main">
						<?php 
						while (have_posts()) {
							the_post();

							get_template_part('content', 'page');

							echo "\n\n";
							
							/**
							 * Original statement: If comments are open or we have at least one comment, load up the comment template
							 * NOTE: Comment option on pages usually sucks, so if there aint no comments yet, the comment form is not being shown ;)
							 * Also, '0' != get_comments_number is wrong, as there will be a integer returned, instead of a string. So the statement would be ALWAYS true.
							 */
							if (comments_open() && 1 >= get_comments_number()) {
								comments_template();
							}

							echo "\n\n";

						} //endwhile;
						?> 
					</main>
				</div>
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?> 

<?php
/**
 * The template for displaying all single poster
 * * @package rediez
 */

get_header();
?>

    <?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', 'rediez_poster' );
	endwhile;
    ?>

<?php
get_footer();
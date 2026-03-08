<?php
/**
 * The template for displaying all single posts
 * * @package rediez
 */

get_header();
?>

    <?php
    while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content', get_post_type() );

        if ( 'post' !== get_post_type() ) :
            the_post_navigation();
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        endif;

    endwhile;
    ?>

<?php
get_footer();
<?php
/**
 * The template for musicians single posts
 *
 * @package rediez
 */

get_header();
?>
    
    <?php while ( have_posts() ) : the_post(); ?>
        
        <section class="musician-detail">
            <div class="container">
                <div class="row">
                    
                    <?php get_template_part( 'template-parts/musician/card' ); ?>
                    
                    <?php get_template_part( 'template-parts/musician/media-tabs' ); ?>
                    
                </div>
            </div>
        </section>
        
    <?php endwhile; ?>

<?php
get_footer();
<?php
/**
 * The template for events single posts
 *
 * @package rediez
 */
get_header();
?>

    <?php while ( have_posts() ) : the_post(); ?>

        <section class="event-detail">
            <div class="container">
                <div class="row">

                    <?php get_template_part( 'template-parts/event/card' ); ?>

                    <?php get_template_part( 'template-parts/event/contacts' ); ?>

                </div>
            </div>
        </section>

    <?php endwhile; ?>

<?php
get_footer();
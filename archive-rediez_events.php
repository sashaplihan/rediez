<?php
/**
 * The template for displaying archive events pages
 *
 * @package rediez
 */

get_header();
?>

    <div class="events-catalog">
        <div class="container">
            <div class="row">

                <?php get_template_part( 'template-parts/event/archive-header' ); ?>

                <div class="events-catalog__body">

                    <?php get_template_part( 'template-parts/event/filters' ); ?>

                    <div class="events-catalog__grid">

                        <?php get_template_part( 'template-parts/event/archive-controls' ); ?>

                        <?php get_template_part( 'template-parts/event/archive-loop' ); ?>

                    </div>

                </div>

            </div>
        </div>
    </div>

<?php
get_footer();
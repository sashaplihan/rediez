<?php
/**
 * Template Name: Главная страница
 */

get_header();
?>

    <?php
	
    get_template_part( 'template-parts/sections/hero');

    get_template_part('template-parts/sections/musicians-home');

	get_template_part( 'template-parts/sections/cta');

	get_template_part( 'template-parts/sections/events-home');

	get_template_part( 'template-parts/sections/advantages');

    get_template_part('template-parts/sections/poster-home');

    get_template_part('template-parts/sections/news-home');
    ?>

<?php
get_footer();
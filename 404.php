<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package rediez
 */

get_header();
?>

		<section class="error-404 not-found">
			<div class="container">
				<div class="row">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Ошибка 404', 'rediez' ); ?></h1>
					</header>

					<div class="page-content">
						<p><?php esc_html_e( 'Запрашиваемой страницы нет на нашем сайте или она была удалена.', 'rediez' ); ?></p>
						<p><?php esc_html_e( 'Но кроме того, что вы искали, у нас есть много чего интересного.', 'rediez' ); ?></p>
						<a href="/" class="hero_link btn--primary error-404_link">На главную</a>
					</div>
				</div>
			</div>
		</section>

<?php
get_footer();

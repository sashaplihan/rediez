<?php
/**
 * Секция CTA (Call to Action)
 */

$page_id = get_the_ID();

if ( carbon_get_post_meta( $page_id, 'show_cta_section' ) ) :
    $cta_icon = carbon_get_post_meta( $page_id, 'cta_icon' );
    $cta_title = carbon_get_post_meta( $page_id, 'cta_title' );
    $cta_text = carbon_get_post_meta( $page_id, 'cta_text' );
    $cta_btn_text = carbon_get_post_meta( $page_id, 'cta_btn_text' );
    $cta_btn_url = carbon_get_post_meta( $page_id, 'cta_btn_url' );
?>

	<section class="cta">
		<div class="container">
			<div class="row">
				<div class="cta__content">
					<h2 class="cta__title">
						<span class="cta__icon">
							<?php if ( $cta_icon ) : ?>
								<img src="<?php echo esc_url( $cta_icon ); ?>" alt="icon">
							<?php else : ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-music.svg" alt="music">
							<?php endif; ?>
						</span>
						<span class="cta__name title"><?php echo esc_html( $cta_title ); ?></span>
					</h2>
					
					<div class="cta__text">
						<?php echo apply_filters( 'the_content', $cta_text ); ?>
					</div>

					<?php if ( $cta_btn_text ) : ?>
					<div class="cta__button">
						<a href="<?php echo esc_url( $cta_btn_url ); ?>" class="cta__link title_link btn--primary">
							<?php echo esc_html( $cta_btn_text ); ?>
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

<?php endif; ?>
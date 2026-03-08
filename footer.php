<?php
/**
 * The template for displaying the footer
 *
 * @package rediez
 */

?>
	</main>
	<footer class="footer">
		<div class="container footer__container">
			<div class="row">
				<div class="footer__content">

					<div class="footer__column footer__column--info">
						<?php
						$footer_logo = carbon_get_theme_option( 'crb_footer_logo' );
						
						if ( $footer_logo ) : 
							$logo_id = attachment_url_to_postid( $footer_logo );
							$logo_alt = $logo_id ? get_post_meta( $logo_id, '_wp_attachment_image_alt', true ) : '';
						?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer__logo">
								<img src="<?php echo esc_url( $footer_logo ); ?>" alt="<?php echo esc_html( $logo_alt ); ?>">
							</a>
						<?php endif; ?>
						
						<?php 
						$footer_description = carbon_get_theme_option( 'crb_footer_description' );
						if ( $footer_description ) : ?>
							<p class="footer__description">
								<?php echo wp_kses_post( $footer_description ); ?>
							</p>
						<?php endif; ?>

						<?php 
						$footer_stats = carbon_get_theme_option( 'crb_footer_stats' );
						if ( $footer_stats ) : ?>
							<p class="footer__text">
								<?php echo wp_kses_post( $footer_stats ); ?>
							</p>
						<?php endif; ?>
					</div>

					<div class="footer__column footer__column--menu">
						<?php 
						$footer_menu_title = carbon_get_theme_option( 'crb_footer_menu_title' );
						if ( $footer_menu_title ) : ?>
							<h3 class="footer__title"><?php echo esc_html( $footer_menu_title ); ?></h3>
						<?php endif; ?>
						
						<nav class="footer__nav">
							<?php 
							wp_nav_menu( array(
								'theme_location' => 'footer_menu',
								'container'      => false,
								'menu_class'     => 'footer-menu',
								'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
								'fallback_cb'    => false,
							) ); 
							?>
						</nav>
					</div>

					<div class="footer__column footer__column--contacts">
						<?php 
						$contacts_title = carbon_get_theme_option( 'crb_footer_contacts_title' );
						if ( $contacts_title ) : ?>
							<h3 class="footer__title"><?php echo esc_html( $contacts_title ); ?></h3>
						<?php endif; ?>
						
						<div class="footer__contacts">
							<?php 
							$phone = carbon_get_theme_option( 'crb_footer_phone' );
							if ( $phone ) : ?>
								<div class="contact-item">
									<span class="contact-item__label">Телефон:</span>
									<a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $phone) ); ?>" 
									class="contact-item__link">
										<?php echo esc_html( $phone ); ?>
									</a>
								</div>
							<?php endif; ?>
							
							<?php 
							$email = carbon_get_theme_option( 'crb_footer_email' );
							if ( $email ) : ?>
								<div class="contact-item">
									<span class="contact-item__label">Email:</span>
									<a href="mailto:<?php echo esc_attr( $email ); ?>" 
									class="contact-item__link">
										<?php echo esc_html( $email ); ?>
									</a>
								</div>
							<?php endif; ?>
							
							<?php 
							$support_email = carbon_get_theme_option( 'crb_footer_support_email' );
							if ( $support_email ) : ?>
								<div class="contact-item">
									<span class="contact-item__label">Поддержка:</span>
									<a href="mailto:<?php echo esc_attr( $support_email ); ?>" 
									class="contact-item__link">
										<?php echo esc_html( $support_email ); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
						
						<?php 
						$social_links = carbon_get_theme_option( 'crb_footer_social' );
						if ( $social_links ) : ?>
							<div class="footer__social">
								<?php 
								$social_title = carbon_get_theme_option( 'crb_footer_social_title' );
								if ( $social_title ) : ?>
									<h4 class="footer__social-title"><?php echo esc_html( $social_title ); ?></h4>
								<?php endif; ?>
								
								<ul class="social-list">
									<?php foreach ( $social_links as $social ) : 
										$network = $social['crb_social_network'];
										$url = $social['crb_social_url'];
										
										if ( !$url ) continue;
										
										$icons = array(
											'vk' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 373.33"><path d="m625.31 25.315c4.4444-14.578 0-25.28-21.191-25.28h-69.972c-17.849 0-26.026 9.2443-30.506 19.484 0 0-35.591 85.19-86.043 140.58-16.284 16.035-23.715 21.12-32.604 21.12-4.4444 0-11.164-5.0844-11.164-19.662v-136.28c0-17.493-4.9066-25.28-19.733-25.28h-110.08c-11.129 0-17.778 8.1065-17.778 15.822 0 16.533 25.208 20.409 27.768 67.021v101.26c0 22.222-4.0533 26.24-12.978 26.24-23.715 0-81.456-85.616-115.73-183.61-6.6488-19.057-13.369-26.737-31.253-26.737h-70.043c-20.017 0-24 9.2443-24 19.484 0 18.169 23.715 108.51 110.54 228.01 57.848 81.599 139.3 125.83 213.54 125.83 44.515 0 49.99-9.8132 49.99-26.737v-61.688c0-19.662 4.1955-23.573 18.311-23.573 10.418 0 28.195 5.1199 69.759 44.444 47.466 46.648 55.252 67.554 81.99 67.554h70.008c19.982 0 30.008-9.8132 24.249-29.226-6.3288-19.306-29.013-47.324-59.057-80.603-16.355-18.915-40.817-39.324-48.248-49.528-10.382-13.084-7.3954-18.951 0-30.577 0 0 85.332-118.04 94.221-158.11z" fill="currentColor" stroke-width="35.555"/></svg>',
											'telegram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="currentColor" transform="translate(40, 40) scale(28)" d="M7.848 12.65l-.331 4.654c.473 0 .678-.203.924-.447l2.22-2.121 4.598 3.367c.843.47 1.437.223 1.665-.776l3.018-14.143c.268-1.247-.45-1.735-1.272-1.43L.928 8.548c-1.21.47-1.192 1.145-.205 1.451l4.535 1.411 10.536-6.592c.496-.329.947-.147.576.181l-8.522 7.653z"/></svg>',
											'youtube' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="currentColor" transform="translate(40, 40) scale(31.111)" d="M17.082 4.782a2.114 2.114 0 00-1.487-1.487c-1.32-.362-6.603-.362-6.603-.362s-5.282 0-6.603.348A2.157 2.157 0 00.902 4.782C.555 6.102.555 8.841.555 8.841s0 2.752.347 4.059a2.114 2.114 0 001.488 1.487c1.334.361 6.602.361 6.602.361s5.282 0 6.603-.347a2.114 2.114 0 001.487-1.487c.348-1.32.348-4.06.348-4.06s.014-2.751-.348-4.072zM7.31 11.371V6.31l4.393 2.53-4.393 2.53z"/></svg>',
											'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="currentColor" transform="translate(40, 40) scale(31.111)" d="M5.599.8C6.479.758 6.759.75 9 .75c2.241 0 2.521.01 3.4.05.88.04 1.48.18 2.005.383a4.06 4.06 0 0 1 1.46.952c.42.412.745.91.952 1.46.203.525.343 1.126.384 2.003.04.881.049 1.162.049 3.402 0 2.241-.01 2.521-.05 3.401-.04.878-.18 1.478-.383 2.003a4.047 4.047 0 0 1-.951 1.462 4.04 4.04 0 0 1-1.461.95c-.525.204-1.125.344-2.003.385-.88.04-1.161.049-3.402.049s-2.521-.01-3.401-.05c-.878-.04-1.478-.18-2.003-.383a4.048 4.048 0 0 1-1.462-.951 4.044 4.044 0 0 1-.951-1.461C.979 13.88.84 13.28.799 12.402.76 11.521.75 11.24.75 9c0-2.241.01-2.521.05-3.4.04-.88.18-1.48.383-2.004.207-.55.532-1.05.952-1.462.412-.42.91-.744 1.46-.951C4.12.979 4.721.84 5.6.799zm6.735 1.484c-.87-.04-1.131-.047-3.334-.047-2.203 0-2.464.008-3.334.047-.804.037-1.241.171-1.532.285-.385.15-.66.328-.949.616-.273.267-.484.59-.616.949-.114.291-.248.728-.284 1.532-.04.87-.049 1.131-.049 3.334 0 2.203.009 2.464.048 3.334.037.805.171 1.241.285 1.532.132.358.343.683.616.949.266.274.591.484.949.616.291.114.728.248 1.532.285.87.04 1.13.048 3.334.048s2.464-.009 3.334-.048c.805-.037 1.241-.171 1.532-.285.385-.15.66-.327.949-.616.274-.266.484-.591.616-.949.114-.291.248-.727.285-1.532.04-.87.048-1.131.048-3.334 0-2.203-.009-2.464-.048-3.334-.037-.804-.171-1.241-.285-1.532a2.562 2.562 0 0 0-.616-.949 2.56 2.56 0 0 0-.949-.616c-.291-.114-.727-.248-1.532-.284zm-4.388 9.26A2.752 2.752 0 1 0 8.73 6.26a2.752 2.752 0 0 0-.784 5.282zM6.002 6a4.24 4.24 0 1 1 5.996 6A4.24 4.24 0 0 1 6 6zm8.179-.61a1.002 1.002 0 1 0-1.375-1.458 1.002 1.002 0 0 0 1.375 1.458z"/></svg>',
											'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="currentColor" transform="translate(80, 80) scale(26.667)" d="M10.394 18V9.79h2.754l.414-3.2h-3.168V4.545c0-.926.256-1.557 1.586-1.557l1.693-.001V.125A22.96 22.96 0 0011.205 0C8.762 0 7.089 1.491 7.089 4.23v2.36H4.326v3.2H7.09V18h3.305z"/></svg>',
										);
										
										$labels = array(
											'vk' => 'ВКонтакте',
											'telegram' => 'Telegram',
											'youtube' => 'YouTube',
											'instagram' => 'Instagram',
											'facebook' => 'Facebook',
										);
										?>
										<li class="social-list__item">
											<a href="<?php echo esc_url( $url ); ?>" 
											class="social-list__link" 
											aria-label="<?php echo esc_attr( $labels[$network] ?? $network ); ?>"
											target="_blank"
											rel="noopener noreferrer">
												<div class="social-list__icon">
													<?php echo $icons[$network] ?? ''; ?>
												</div>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</div>

		<div class="footer__bottom">
			<div class="container">
				<div class="row">
					<div class="footer__wrap">
						<?php 
						$payment_images = carbon_get_theme_option( 'crb_footer_payments' );
						if ( $payment_images ) : ?>
							<div class="payments">
								<ul class="payments__list">
									<?php foreach ( $payment_images as $payment ) : 
										$image_id = $payment['crb_payment_image'];
										if ( $image_id ) : 
											$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
											?>
											<li class="payments__item">
												<a href="#" class="payments__link">
													<?php echo wp_get_attachment_image( $image_id, 'full', false, array(
														'class' => 'payments__icon',
														'alt' => esc_attr( $image_alt )
													) ); ?>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php 
						$docs = carbon_get_theme_option( 'crb_footer_documents' );
						if ( $docs ) : ?>
							<div class="documents">
								<nav class="documents__nav">
									<?php foreach ( $docs as $doc ) : 
										$title = $doc['crb_doc_title'];
										$link = $doc['crb_doc_link'];
										if ( $title && $link ) : ?>
											<a href="<?php echo wp_get_attachment_url( $link ); ?>" target="_blank">
												<?php echo esc_html( $title ); ?>
											</a>
										<?php endif; ?>
									<?php endforeach; ?>
								</nav>
							</div>
						<?php endif; ?>
						
					</div>
				</div>
			</div>
		</div>

		<div class="footer__copyright">
			<div class="container">
				<div class="row">
					<div class="copyright">
						<p class="copyright__text">
							<?php 
							$copyright = carbon_get_theme_option( 'crb_footer_copyright' );
							if ( $copyright ) {
								echo wp_kses_post( $copyright );
							} else {
								echo '© ' . date('Y') . ' ' . esc_html( get_bloginfo('name') ) . '. Все права защищены.';
							}
							?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>

<div class="modal micromodal-slide" id="modal-auth" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-auth-title">
            
            <header class="modal__header">
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            
            <main class="modal__content" id="modal-auth-content">
                
                <div class="auth-tabs-nav">
                    <button class="tab-trigger active" data-tab="musician">Для музыкантов</button>
                    <button class="tab-trigger" data-tab="customer">Для заказчиков</button>
                </div>
                
                <div class="auth-forms-wrapper">
                    
                    <!-- Таб музыкантов -->
                    <div id="musician-content" class="tab-content" style="display:block;">
                        
                        <div class="login-box" style="display:block;">
                            <h4>Вход для музыканта</h4>
                            <?php echo do_shortcode('[ultimatemember form_id="19"]'); ?>
                            <a href="#" class="show-reg">Нет аккаунта? Зарегистрироваться</a>
                        </div>
                        
                        <div class="reg-box" style="display:none;">
                            <h4>Регистрация музыканта</h4>
                            <?php echo do_shortcode('[ultimatemember form_id="16"]'); ?>
                            <a href="#" class="show-login">Уже есть аккаунт? Войти</a>
                        </div>
                        
                    </div>
                    
                    <!-- Таб заказчиков -->
                    <div id="customer-content" class="tab-content" style="display:none;">
                        
                        <div class="login-box" style="display:block;">
                            <h4>Вход для заказчика</h4>
                            <?php echo do_shortcode('[ultimatemember form_id="21"]'); ?>
                            <a href="#" class="show-reg">Стать заказчиком</a>
                        </div>
                        
                        <div class="reg-box" style="display:none;">
                            <h4>Регистрация заказчика</h4>
                            <?php echo do_shortcode('[ultimatemember form_id="18"]'); ?>
                            <a href="#" class="show-login">Войти</a>
                        </div>
                        
                    </div>
                    
                </div>
                
            </main>
            
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>

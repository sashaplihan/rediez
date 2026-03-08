<?php
/**
 * The header for our theme
 *
 * @package rediez
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

	<header class="header">
		<div class="container">
			<div class="row">
				<div class="header__wrapper">
					
					<div class="header__logo">
						<?php
						$logo_url = carbon_get_theme_option( 'crb_header_logo' );
						$site_name = get_bloginfo( 'name' );

						$logo_img = $logo_url
							? '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $site_name ) . '">'
							: '<img src="' . esc_url( get_template_directory_uri() . '/img/Rediez.svg' ) . '" alt="Логотип ' . esc_attr( $site_name ) . '">';

						if ( is_front_page() || is_home() ) : ?>
							
							<span class="header__logo-inner">
								<?php echo $logo_img; ?>
							</span>

						<?php else : ?>

							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo-inner">
								<?php echo $logo_img; ?>
							</a>

						<?php endif; ?>
					</div>

					<div class="header__btn">
						<button class="header__burger" type="button" aria-label="Открыть меню">
							<span></span>
						</button>
					</div>

					<nav class="header__nav">
						<?php 
						wp_nav_menu( array(
							'theme_location' => 'header_menu',
							'container'      => false,
							'menu_class'     => 'nav-menu',
							'menu_id'        => 'menu__list',
							'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'walker'         => new Rediez_Bem_Menu_Walker(),
							'fallback_cb'    => false,
						) ); 
						?>
					</nav>

					<div class="header__auth">
						<?php if ( is_user_logged_in() ) : 
							$user_id = get_current_user_id();
							
							if ( function_exists('um_user_profile_url') ) {
								$profile_url = um_user_profile_url( $user_id );
							} elseif ( function_exists('um_get_core_page') ) {
								$profile_url = get_permalink( um_get_core_page('account') );
							} else {
								$profile_url = admin_url('profile.php');
							}
							
							$account_text = carbon_get_theme_option( 'crb_auth_account_text' ) ?: 'Личный кабинет';
							?>
							
							<a href="<?php echo esc_url( $profile_url ); ?>" class="auth-btn auth-btn--account">
								<?php echo esc_html( $account_text ); ?>
							</a>
							
						<?php else : ?>
							
							<button type="button" class="auth-btn auth-btn--login" data-micromodal-trigger="modal-auth">
								<?php echo esc_html( carbon_get_theme_option( 'crb_auth_login_text' ) ?: 'Вход | Регистрация' ); ?>
							</button>
							
						<?php endif; ?>
					</div>

				</div>
			</div>
		</div>
	</header>

	<main>

	<?php
	if ( ! is_front_page() && ! is_home() ) {
		rediez_breadcrumbs();
	}
	?>
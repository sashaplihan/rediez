<?php
/**
 * Блок контактов мероприятия
 *
 * @package rediez
 */

$icon_path = get_template_directory_uri() . '/assets/images/icons/';

$phone    = carbon_get_the_post_meta( 'crb_event_phone' );
$email    = carbon_get_the_post_meta( 'crb_event_email' );
$telegram = carbon_get_the_post_meta( 'crb_event_telegram' );
$whatsapp = carbon_get_the_post_meta( 'crb_event_whatsapp' );
$viber    = carbon_get_the_post_meta( 'crb_event_viber' );
$tiktok   = carbon_get_the_post_meta( 'crb_event_tiktok' );
$vk       = carbon_get_the_post_meta( 'crb_event_vk' );
$ok       = carbon_get_the_post_meta( 'crb_event_ok' );

// Если нет ни одного контакта — не выводим блок
if ( ! $phone && ! $email && ! $telegram && ! $whatsapp && ! $viber && ! $tiktok && ! $vk && ! $ok ) {
    return;
}
?>

<div class="event-card__contact contact">
    <div class="contact__top">
        <h2>Связаться с нами:</h2>
        <div class="contact__item">
            <?php if ( $phone ) : ?>
                <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>">
                    <span><img src="<?php echo esc_url( $icon_path . 'phone-icon.svg' ); ?>" alt=""></span>
                    <?php echo esc_html( $phone ); ?>
                </a>
            <?php endif; ?>

            <?php if ( $email ) : ?>
                <a href="mailto:<?php echo esc_attr( $email ); ?>">
                    <span><img src="<?php echo esc_url( $icon_path . 'envelope.svg' ); ?>" alt=""></span>
                    <?php echo esc_html( $email ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $socials = array(
        'telegram' => array( 'url' => $telegram, 'icon' => 'telegram-plane.svg', 'label' => 'telegram' ),
        'whatsapp' => array( 'url' => $whatsapp ? 'https://wa.me/' . preg_replace( '/[^+\d]/', '', $whatsapp ) : '', 'icon' => 'whatsapp.svg', 'label' => 'whatsapp' ),
        'viber'    => array( 'url' => $viber    ? 'viber://chat?number=' . preg_replace( '/[^+\d]/', '', $viber ) : '', 'icon' => 'viber.svg', 'label' => 'viber' ),
        'tiktok'   => array( 'url' => $tiktok,  'icon' => 'tiktok.svg',           'label' => 'tiktok' ),
        'vk'       => array( 'url' => $vk,      'icon' => 'vk-icon.svg',          'label' => 'vkontakte' ),
        'ok'       => array( 'url' => $ok,      'icon' => 'odnoklassniki.svg',    'label' => 'odnoklassniki' ),
    );

    $has_socials = array_filter( $socials, function( $s ) { return ! empty( $s['url'] ); } );
    ?>

    <?php if ( ! empty( $has_socials ) ) : ?>
        <div class="contact__bottom network">
            <?php foreach ( $socials as $social ) : ?>
                <?php if ( ! empty( $social['url'] ) ) : ?>
                    <a href="<?php echo esc_url( $social['url'] ); ?>" class="network__icon" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url( $icon_path . $social['icon'] ); ?>" alt="<?php echo esc_attr( $social['label'] ); ?>">
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
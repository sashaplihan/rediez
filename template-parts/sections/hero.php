<?php
/**
 * The template for displaying Hero section
 */

$hero_bg = carbon_get_the_post_meta( 'hero_bg' );
$style_attr = $hero_bg ? ' style="background-image: url(' . esc_url($hero_bg) . ');"' : '';

$left_title    = carbon_get_the_post_meta( 'hero_left_title' );
$left_desc     = carbon_get_the_post_meta( 'hero_left_text' );
$left_list     = carbon_get_the_post_meta( 'hero_left_list' );
$left_btn_text = carbon_get_the_post_meta( 'hero_left_btn_text' );
$left_btn_url  = carbon_get_the_post_meta( 'hero_left_btn_url' );

$right_title    = carbon_get_the_post_meta( 'hero_right_title' );
$right_desc     = carbon_get_the_post_meta( 'hero_right_text' );
$right_list     = carbon_get_the_post_meta( 'hero_right_list' );
$right_btn_text = carbon_get_the_post_meta( 'hero_right_btn_text' );
?>

<section class="hero"<?php echo $style_attr; ?>>
    <div class="container">
        <div class="hero__inner">
            
            <?php if ( $left_title || $left_desc || ! empty( $left_list ) ) : ?>
                <div class="hero__left">
                    <?php if ( $left_title ) : ?>
                        <h1 class="hero__title"><?php echo esc_html( $left_title ); ?></h1>
                    <?php endif; ?>

                    <?php if ( $left_desc || ! empty( $left_list ) ) : ?>
                        <div class="hero__text">
                            <?php if ( $left_desc ) : ?>
                                <p><?php echo esc_html( $left_desc ); ?></p>
                            <?php endif; ?>

                            <?php if ( ! empty( $left_list ) ) : ?>
                                <ul>
                                    <?php foreach ( $left_list as $item ) : ?>
                                        <?php if ( ! empty( $item['item'] ) ) : ?>
                                            <li><?php echo esc_html( $item['item'] ); ?></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $left_btn_text && $left_btn_url ) : ?>
                        <a href="<?php echo esc_url( $left_btn_url ); ?>" class="hero_link btn--primary">
                            <?php echo esc_html( $left_btn_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( $right_title || $right_desc || ! empty( $right_list ) ) : ?>
                <div class="hero__right">
                    <?php if ( $right_title ) : ?>
                        <h2 class="hero__subtitle"><?php echo esc_html( $right_title ); ?></h2>
                    <?php endif; ?>

                    <div class="hero__text hero__text--secondary">
                        <?php if ( $right_desc ) : ?>
                            <p><?php echo esc_html( $right_desc ); ?></p>
                        <?php endif; ?>

                        <?php if ( ! empty( $right_list ) ) : ?>
                            <ul>
                                <?php foreach ( $right_list as $item ) : ?>
                                    <?php if ( ! empty( $item['item'] ) ) : ?>
                                        <li><?php echo esc_html( $item['item'] ); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <?php if ( $right_btn_text ) : ?>
                        <button class="hero_btn btn--secondary"><?php echo esc_html( $right_btn_text ); ?></button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
<?php
/**
 * Template part for displaying single poster events
 * @package rediez
 */

$external_url = carbon_get_the_post_meta( 'poster_external_url' );
?>

<section class="article-detail poster-detail">
    <div class="container">
        <div class="row">
            <div class="article-detail__grid">
                
                <div class="article-detail__top">
                    <div class="article-detail__date date">
                        <span class="icom">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/calendar-days_gray.svg" alt="calendar">
                        </span>
                        <span><?php echo get_the_date( 'd.m.Y' ); ?></span>
                    </div>
                    
                    </div>

                <div class="article-detail__info">
                    <h1 class="article-card__title title"><?php the_title(); ?></h1>
                    
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="article-detail__image">
                            <?php the_post_thumbnail( 'full', [ 'alt' => get_the_title() ] ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="article-detail__text">
                        <?php the_content(); ?>

                        <?php if ( ! empty( $external_url ) ) : ?>
                            <div class="article-detail__external-link" style="margin-top: 30px;">
                                <a href="<?php echo esc_url( $external_url ); ?>" 
                                   class="btn--primary" 
                                   target="_blank" 
                                   rel="nofollow">
                                    Перейти на сайт события
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
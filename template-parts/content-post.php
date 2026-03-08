<?php
/**
 * Template part for displaying posts (News)
 * @package rediez
 */

// Увеличиваем счетчик просмотров
if ( function_exists( 'rediez_set_post_views' ) ) {
    rediez_set_post_views( get_the_ID() );
}
?>

<section class="article-detail">
    <div class="container">
        <div class="row">
            <div class="article-detail__grid">
                
                <div class="article-detail__top">
                    <div class="article-detail__date date">
                        <span class="icom">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/calendar-days_gray.svg" alt="calendar">
                        </span>
                        <span><?php echo get_the_date( 'd.m.Y H.i' ); ?></span>
                    </div>
                    
                    <div class="article-detail__view view">
                        <span class="view__quantity">
                            <?php echo function_exists( 'rediez_get_post_views' ) ? rediez_get_post_views( get_the_ID() ) : '0'; ?>
                        </span>
                        <span class="view__text">просмотров</span>
                    </div>
                </div>

                <div class="article-detail__info">
                    <h1 class="article-card__title title"><?php the_title(); ?></h1>
                    
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'full', [ 'alt' => get_the_title() ] ); ?>
                    <?php endif; ?>

                    <div class="article-detail__text">
                        <?php the_content(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
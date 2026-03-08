<?php
/**
 * Шаблон одной карточки новости в архиве
 */
?>
<div class="news__item">
    <a href="<?php the_permalink(); ?>" class="news__link">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'medium_large', [ 'class' => 'news__image', 'alt' => get_the_title() ] ); ?>
        <?php else : ?>
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/no-image.jpg" alt="placeholder" class="news__image">
        <?php endif; ?>

        <div class="news__info">
            <div class="news__date date">
                <span class="icom">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/calendar-days.svg" alt="icon">
                </span>
                <span><?php echo get_the_date( 'd.m.Y H.i' ); ?></span>
            </div>
            
            <h3 class="news__name"><?php the_title(); ?></h3>
            
            <p class="news__desc">
                <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
            </p>
            
            <div class="link-title">
                <span class="link-title__name">Подробнее</span>
                <span class="link-title__icon">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/arrow-right.svg" alt="arrow">
                </span>
            </div>
        </div>
    </a>
</div>
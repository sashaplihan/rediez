<?php
/**
 * Секция последних новостей для главной страницы
 *
 * @package rediez
 */

$page_id      = get_the_ID();
$show_section = carbon_get_post_meta( $page_id, 'show_news_section' );

if ( ! $show_section ) return;

$count = (int) carbon_get_post_meta( $page_id, 'news_section_count' );
if ( $count < 1 ) $count = 4;

$latest_news_query = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
) );

if ( ! $latest_news_query->have_posts() ) return;
?>

<section class="news">
    <div class="container">
        <div class="news__header">
            <h2 class="news__title">Последние <span>новости</span></h2>

            <?php
            $news_link = get_post_type_archive_link( 'post' );
            if ( ! $news_link ) {
                $news_link = get_permalink( get_option( 'page_for_posts' ) );
            }
            ?>

            <a href="<?php echo esc_url( $news_link ); ?>" class="title_link btn--primary">
                <span class="link-title__name">Все</span>
                <span class="link-title__icon">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/arrow-right.svg" alt="arrow">
                </span>
            </a>
        </div>

        <div class="news__grid">
            <?php while ( $latest_news_query->have_posts() ) : $latest_news_query->the_post(); ?>
                <?php get_template_part( 'template-parts/content', 'news' ); ?>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>
<?php
/**
 * Табы с фото и видео
 *
 * @package rediez
 */

$gallery = carbon_get_the_post_meta( 'crb_musician_gallery' );
$videos = carbon_get_the_post_meta( 'crb_musician_videos' );

// Если нет ни фото, ни видео - не выводим секцию
if ( empty( $gallery ) && empty( $videos ) ) {
    return;
}

/**
 * Функция для преобразования YouTube URL в embed
 */
function rediez_get_youtube_embed_url( $url ) {
    
    if ( empty( $url ) ) {
        return '';
    }
    
    // Получаем ID видео из разных форматов YouTube URL
    preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches );
    
    if ( isset( $matches[1] ) ) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }
    
    return '';
}
?>

<div class="musician-detail__tabs">
    <div class="musician-tab">
        <div class="musician-tab__wrap">
            
            <!-- Кнопки табов -->
            <div class="musician-tab__tabs tabs">
                <?php if ( ! empty( $gallery ) ) : ?>
                    <span class="tabs__btn active">Фото</span>
                <?php endif; ?>
                
                <?php if ( ! empty( $videos ) ) : ?>
                    <span class="tabs__btn <?php echo empty( $gallery ) ? 'active' : ''; ?>">Видео</span>
                <?php endif; ?>
            </div>
            
            <!-- Контент табов -->
            <div class="musician-tab__content content">
                
                <!-- Таб с фото -->
                <?php if ( ! empty( $gallery ) ) : ?>
                    <div class="content__tab">
                        <div class="swiper slider-musician">
                            <div class="swiper-wrapper">
                                <?php foreach ( $gallery as $item ) : 
                                    $image_id = $item['crb_gallery_image'];
                                    if ( $image_id ) :
                                        $image = wp_get_attachment_image_src( $image_id, 'large' );
                                        $alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                                        ?>
                                        <div class="slide-musician swiper-slide">
                                            <img src="<?php echo esc_url( $image[0] ); ?>" 
                                                 alt="<?php echo esc_attr( $alt ?: get_the_title() ); ?>">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Навигация -->
                            <div class="musicians__navigation swiper-button-prev"></div>
                            <div class="musicians__navigation swiper-button-next"></div>
                            
                            <!-- Пагинация -->
                            <div class="musician__pagination swiper-pagination"></div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Таб с видео -->
                <?php if ( ! empty( $videos ) ) : ?>
                    <div class="content__tab" <?php echo ! empty( $gallery ) ? 'style="display: none;"' : ''; ?>>
                        <div class="musician-tab__wrapper">
                            <div class="swiper slider-video">
                                <div class="swiper-wrapper">
                                    <?php foreach ( $videos as $video ) : 
                                        $video_url = $video['crb_video_url'];
                                        $embed_url = rediez_get_youtube_embed_url( $video_url );
                                        
                                        if ( $embed_url ) : ?>
                                            <div class="slide-video swiper-slide">
                                                <iframe width="560" 
                                                        height="315" 
                                                        src="<?php echo esc_url( $embed_url ); ?>" 
                                                        title="YouTube video player" 
                                                        frameborder="0" 
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                        referrerpolicy="strict-origin-when-cross-origin" 
                                                        allowfullscreen>
                                                </iframe>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- Навигация -->
                                <div class="musicians__navigation swiper-button-prev"></div>
                                <div class="musicians__navigation swiper-button-next"></div>
                            </div>
                            
                            <!-- Пагинация -->
                            <div class="video__pagination swiper-pagination"></div>
                        </div>
                    </div>
                <?php endif; ?>
                
            </div>
            
        </div>
    </div>
</div>
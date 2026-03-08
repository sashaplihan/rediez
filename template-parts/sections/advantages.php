<?php
/**
 * Секция Преимущества (Advantages)
 */

$page_id = get_the_ID();

if ( carbon_get_post_meta( $page_id, 'show_advantages_section' ) ) :

$blocks = [
	[
		'title'    => carbon_get_post_meta($page_id, 'adv_mus_title'),
		'items'    => carbon_get_post_meta($page_id, 'adv_mus_list'),
		'btn_text' => carbon_get_post_meta($page_id, 'adv_mus_btn_text'),
		'btn_url'  => carbon_get_post_meta($page_id, 'adv_mus_btn_url'),
	],
	[
		'title'    => carbon_get_post_meta($page_id, 'adv_cust_title'),
		'items'    => carbon_get_post_meta($page_id, 'adv_cust_list'),
		'btn_text' => carbon_get_post_meta($page_id, 'adv_cust_btn_text'),
		'btn_url'  => carbon_get_post_meta($page_id, 'adv_cust_btn_url'),
	]
];
?>

    <section class="advantages">
        <div class="container">
            <div class="row">
                <div class="advantages__grid">
                    
                    <?php foreach ( $blocks as $block ) : ?>
                    <div class="advantages__block">
                        <h2 class="advantages__title"><?php echo esc_html( $block['title'] ); ?></h2>
                        
                        <div class="advantages__list">
                            <?php if ( !empty($block['items']) ) : 
                                foreach ( $block['items'] as $item ) : ?>
                                <div class="advantage">
                                    <div class="advantage__icon">
                                        <?php if ( $item['icon'] ) : ?>
                                            <img src="<?php echo esc_url($item['icon']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                                        <?php else : ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/default-adv.svg" alt="">
                                        <?php endif; ?>
                                    </div>
                                    <div class="advantage__content">
                                        <h3 class="advantage__title"><?php echo esc_html($item['title']); ?></h3>
                                        <p class="advantage__text"><?php echo nl2br(esc_html($item['text'])); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>

                        <?php if ( $block['btn_text'] ) : ?>
                        <div class="advantages__button">
                            <a href="<?php echo esc_url($block['btn_url']); ?>" class="poster__link title_link btn--primary">
                                <?php echo esc_html($block['btn_text']); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </section>

<?php endif; ?>
<?php
/**
 * The template for displaying archive musicians pages
 *
 * @package rediez
 */
get_header();
?>
    
    <div class="musician-catalog">
        <div class="container">
            <div class="row">
                
                <?php get_template_part( 'template-parts/musician/archive-header' ); ?>
                
                <div class="musician-catalog__body">
                    
						<?php get_template_part( 'template-parts/musician/filters' ); ?>
                    
                    <div class="musician-catalog__grid">
                        
						<?php get_template_part( 'template-parts/musician/archive-controls' ); ?>
                        
                        <?php get_template_part( 'template-parts/musician/archive-loop' ); ?>
                        
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

<?php
get_footer();
<?php
/* Single Apartment in Filter Output */
?>
<div class="apartment-item">
        <?php if( !empty($apartment_image = get_field('pic', $apartment_id)) ): ?>
                    
                <div class="apartment-img">                                    
                        <?php echo wp_get_attachment_image( $apartment_image, 'full' ); ?>
                </div>

        <?php endif; ?>
    
        <div class="apartment-desc">
                <h3><?php echo get_the_title($apartment_id); ?></h3>
                
                <?php if( !empty($apartment_house = get_field('house', $apartment_id)) ): ?>
                    
                        <?php if( !empty($house_excerpt = get_the_excerpt($apartment_house[0])) ): ?>
                    
                                <div class="apartment-house-desc">                                
                                        <?php echo wpautop($house_excerpt); ?>
                                </div>
                
                        <?php endif; ?>
                
                <a href="<?php echo get_permalink($apartment_house[0]); ?>" class="house-link" target="_blank">Ссылка на здание</a>

                <?php endif; ?>
        </div>    
</div>

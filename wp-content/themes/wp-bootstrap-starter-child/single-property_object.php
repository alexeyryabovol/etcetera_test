<?php
/*Template for Page of House (Property Object)*/

get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-md-12 col-lg-8">
		<div id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>
			
                        <header>
                                <h1 class="page-title"><?php single_post_title(); ?></h1>
                        </header>
                    
                        <?php if( !empty($house_image = get_field('house_image')) ): ?>
                    
                                <div class="house-img">                                    
                                    <?php echo wp_get_attachment_image( $house_image, 'full' ); ?>
                                </div>
                    
                        <?php endif; ?>
                        
                        <?php if( !empty($house_desc = get_the_content() ) ): ?>
                    
                                <div class="house-content">                                    
                                    <h2>Описание:</h2>
                                    <?php echo apply_filters( 'the_content', $house_desc ); ?>
                                </div>
                    
                        <?php endif; ?>
                        
                        
                        <?php if( !empty($house_location = get_field('location')) ): ?>
                    
                                <h2>Координаты Местонахождения: <b><?php echo $house_location; ?></b></h2>
                    
                        <?php endif; ?>
                                
                        <?php if( !empty($house_number_of_floors = get_field('number_of_floors')) ): ?>
                    
                                <h2>Количество Этажей: <b><?php echo $house_number_of_floors; ?></b></h2>
                    
                        <?php endif; ?>   
                                
                        <?php if( !empty($house_type = get_field('type')) ): ?>
                    
                                <h2>Тип Строения: <b><?php echo $house_type; ?></b></h2>
                    
                        <?php endif; ?> 
                                
                        <?php if( !empty($house_ecology = get_field('ecology')) ): ?>
                    
                                <h2>Экологичность(1 - 5): <b><?php echo $house_ecology; ?></b></h2>
                    
                        <?php endif; ?>
                                
                        <?php $apartments = get_posts([
                                'post_type'    => 'apartment',
                                'numberposts'  => -1,
                                'meta_key'     => 'house',
                                'meta_value'   => get_the_ID(),
                                'meta_compare' => 'LIKE'                                                            
                        ]); ?>        
                                
                         <?php if( !empty($apartments) ): ?>
                    
                                <h2>Квартиры:</h2>
                                <div class="apartments">

                                        <?php foreach( $apartments as $apartment ): ?>
                                                                                
                                                <div class="apartment"> 
                                                    
                                                        <?php if( !empty($apartment_pic = get_field('pic', $apartment->ID)) ): ?>
                    
                                                                <div class="apartment-img">                                    
                                                                        <?php echo wp_get_attachment_image( $apartment_pic, 'full' ); ?>
                                                                </div>

                                                        <?php endif; ?>
                                                        
                                                        <div class="apartment-right">
                                                    
                                                                <h3>Название Квартиры: <b><?php echo get_the_title($apartment->ID); ?></b></h3>

                                                                <?php if( !empty($apartment_square = get_field('square', $apartment->ID)) ): ?>

                                                                        <h3>Площадь: <b><?php echo $apartment_square; ?> кв. м.</b></h3>

                                                                <?php endif; ?>

                                                                <?php if( !empty($apartment_rooms = get_field('rooms', $apartment->ID)) ): ?>

                                                                        <h3>Количество Комнат: <b><?php echo $apartment_rooms; ?></b></h3>

                                                                <?php endif; ?>

                                                                <?php if( !empty(get_field('balcony', $apartment->ID)) ): ?>

                                                                        <h3>Есть Балкон</h3>

                                                                <?php else: ?>

                                                                        <h3>Нет Балкона</h3>

                                                                <?php endif; ?>

                                                                <?php if( !empty(get_field('bathroom', $apartment->ID)) ): ?>

                                                                        <h3>Есть Санузел</h3>

                                                                <?php else: ?>

                                                                        <h3>Нет Санузла</h3>

                                                                <?php endif; ?>
                                                                
                                                        </div>
                                                </div>    

                                        <?php endforeach; ?>

                                </div>
                    
                        <?php endif; ?>
                    
		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</div><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_deregister_style('responsive');
    wp_deregister_style('rehub_shortcode');
    wp_enqueue_style('font_nav', '//fonts.googleapis.com/css?family=Noto+Serif:400,700');
    wp_enqueue_style('head_nav', '//fonts.googleapis.com/css?family=Montserrat:700');
}
add_action( 'wp_enqueue_scripts', 'dequeue_parent_theme_style', 100 );
function dequeue_parent_theme_style() {
    wp_dequeue_style( 'default_font' );
}

//////////////////////////////////////////////////////////////////
// Translation
//////////////////////////////////////////////////////////////////
add_action('after_setup_theme', 'rehub_child_lang_setup');
function rehub_child_lang_setup(){
    load_child_theme_textdomain('rehub_child', get_stylesheet_directory() . '/lang');
}


if ( !function_exists( 'rehub_image_sizes' ) ) {
	function rehub_image_sizes() {
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1130, 0, false );
		if( rehub_option( 'aq_resize_crop') == '1') {
			add_image_size( 'grid_news', 336, 0, false );
			add_image_size( 'feature_slider', 765, 0, false );
			add_image_size( 'med_thumbs', 123, 0, false );
			add_image_size( 'small_thumbs', 92, 0, false );		
			add_image_size( 'medium_news', 370, 0, false );
			add_image_size( 'news_big', 378, 0, false );
			add_image_size( 'video_big', 474, 0, false );
			add_image_size( 'video_narrow', 270, 0, false );
		}
		else {
			add_image_size( 'grid_news', 336, 220, true );
			add_image_size( 'feature_slider', 765, 510, true );
			add_image_size( 'med_thumbs', 123, 90, true );
			add_image_size( 'small_thumbs', 92, 67, true );		
			add_image_size( 'medium_news', 370, 220, true );
			add_image_size( 'news_big', 378, 310, true );
			add_image_size( 'video_big', 474, 342, true );
			add_image_size( 'video_narrow', 270, 110, true );			
		}
	}
}

if( !function_exists('rehub_create_column') ) {
function rehub_create_column ($size='middle') {
	?>
<article class="rething_item small_post inf_scr_item">
    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
        <figure>
            <?php rehub_formats_icons('full'); ?>
            <span class="pattern"></span>
            <?php echo getPostLikeLink( get_the_ID() );?>
            <?php rehub_permalink() ;?>
                <?php $img = get_post_thumb(); $nothumb = get_stylesheet_directory_uri() . '/images/noim.png' ;
                if ($size =='middle') {
                	$params = array( 'width' => 381, 'height' => 255, 'crop' => true);
                } elseif ($size =='small'){
                	$params = array( 'width' => 280, 'height' => 186, 'crop' => true);
                } elseif ($size =='big'){
                	$params = array( 'width' => 579, 'height' => 386, 'crop' => true);                	
                } else {
                	$params = array( 'width' => 381, 'height' => 255, 'crop' => true);
                }
				?>
				<?php if(!empty($img)) : ?>
                	<img src="<?php echo bfi_thumb( $img, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
                <?php else : ?>    
                    <img src="<?php echo $nothumb; ?>" alt="<?php the_title_attribute(); ?>" />
                <?php endif ; ?>
            </a>
        </figure>                                     
    <?php } ?>
    <div class="wrap_thing">
        <div class="top">
            <?php $category = get_the_category(get_the_ID());  ?>
            <?php if ($category) {$first_cat = $category[0]->term_id; meta_small( false, $first_cat, false, false );} ?>
        </div>
        <div class="hover_anons">
            <h2><?php rehub_permalink() ;?><?php the_title();?></a></h2>
            <div class="post-meta"> <?php meta_small( true, false, true, false ); ?> </div>
            <?php rehub_format_score('small') ?>
            <p><?php kama_excerpt('maxchar=320'); ?></p>
        </div>
        <?php rehub_create_btn('yes') ;?>
    </div>
</article>

<?php
}
}	

if( !function_exists('rehub_create_btn') ) {
function rehub_create_btn ($btn_more) {
	?>

		<?php 
			$aff_url_exist = get_post_meta( get_the_ID(), 'affegg_product_orig_url', true ); 
			$offer_url_exist = get_post_meta( get_the_ID(), 'rehub_offer_product_url', true );

		if (!empty($aff_url_exist)) : ?>

			<?php if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
				include(locate_template( 'inc/parts/affeggbutton.php' ) );
			} ?>

		<?php elseif (!empty($offer_url_exist)) : ?>

			<?php
				$offer_url = $offer_url_exist;  
			 	$offer_price = get_post_meta( get_the_ID(), 'rehub_offer_product_price', true ); 
			 	$offer_btn_text = get_post_meta( get_the_ID(), 'rehub_offer_btn_text', true ); 		 	
			 	$offer_price_old = get_post_meta( get_the_ID(), 'rehub_offer_product_price_old', true );
			 	$offer_coupon = get_post_meta( get_the_ID(), 'rehub_offer_product_coupon', true );
			 	$offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_offer_coupon_date', true );
			 	$offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_offer_coupon_mask', true );
			?>
			<?php if(!empty($offer_coupon_date)) : ?>
				<?php 
					$timestamp1 = strtotime($offer_coupon_date); 
					$seconds = $timestamp1 - time(); 
					$days = floor($seconds / 86400);
					$seconds %= 86400;
            		if ($days > 0) {
            			$coupon_style = '';
            		}
            		elseif ($days == 0){
            			$coupon_style = '';
            		}
            		else {
            			$coupon_text = __('Coupon is Expired', 'rehub_child');
            			$coupon_style = 'expired_coupon';
            		}									
				?>
			<?php endif ;?>
	    	<?php if(!empty($offer_coupon)) : ?>
	    		<div class="re_thing_btn clearfix">
	    			<?php wp_enqueue_script('zeroclipboard'); ?>
	    			<?php if (empty($offer_coupon_mask)) :?>
	                	<div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>   
	           	 	<?php else :?>
	                	<div class="rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo get_the_ID(); ?>" data-dest="<?php echo esc_url ($offer_url) ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_child') ?><?php endif ;?></div>   
	            	<?php endif;?>
            	</div>  
	    	<?php else :?>
		        <div class="re_thing_btn clearfix">
		            <a href="<?php echo esc_url ($offer_url) ?>" class="btn_offer_block" target="_blank" rel="nofollow">
		            	<span class="btn_text">
		            		<?php if($offer_btn_text !='') :?>
		            			<?php echo $offer_btn_text ; ?>
		            		<?php elseif(rehub_option('rehub_btn_text') !='') :?>
		            			<?php echo rehub_option('rehub_btn_text') ; ?>
		            		<?php else :?>
		            			<?php _e('Buy this item', 'rehub_child') ?>
		            		<?php endif ;?>
		            	</span> / 
		            	<?php if(!empty($offer_price)) : ?>
		            		<span class="btn_price">
		            			<ins><?php echo $offer_price ?></ins>
		            			<?php if($offer_price_old !='') :?>
		            				<del><?php echo $offer_price_old ; ?></del>
		            			<?php endif ;?>
		            		</span>
		            	<?php endif ;?>	            	
		            </a>
		        </div>	    			    	
	    	<?php endif;?>   

		<?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_post_review_product') : ?>
			<?php $review_aff_link = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_aff_link');
			if(function_exists('thirstyInit') && !empty($review_aff_link)) :?>
				<?php 
					$linkpost = get_post($review_aff_link); 
				 	$offer_price = get_post_meta( $linkpost->ID, 'rehub_aff_price', true ); 
				 	$offer_btn_text = get_post_meta( $linkpost->ID, 'rehub_aff_btn_text', true ); 
				 	$offer_url = get_post_permalink($review_aff_link) ;
				 	$offer_price_old = get_post_meta( $linkpost->ID, 'rehub_aff_price_old', true );
				 	$offer_coupon = get_post_meta( $linkpost->ID, 'rehub_aff_coupon', true );
				 	$offer_coupon_date = get_post_meta( $linkpost->ID, 'rehub_aff_coupon_date', true );
				 	$offer_coupon_mask = get_post_meta( $linkpost->ID, 'rehub_aff_coupon_mask', true );
				?>
				<?php if(!empty($offer_coupon_date)) : ?>
					<?php 
						$timestamp1 = strtotime($offer_coupon_date); 
						$seconds = $timestamp1 - time(); 
						$days = floor($seconds / 86400);
						$seconds %= 86400;
	            		if ($days > 0) {
	            			$coupon_style = '';
	            		}
	            		elseif ($days == 0){
	            			$coupon_style = '';
	            		}
	            		else {
	            			$coupon_text = __('Coupon is Expired', 'rehub_child');
	            			$coupon_style = 'expired_coupon';
	            		}									
					?>
				<?php endif ;?>				
			<?php else :?>
		        <?php $offer_price = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_price') ?>
		        <?php $offer_url = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_url') ?>
		        <?php $offer_btn_text = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_btn_text') ?>
		        <?php $offer_price_old = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_price_old') ?>
	    	<?php endif;?>
	    	<?php if(!empty($offer_coupon)) : ?>
	    		<div class="re_thing_btn clearfix">
	    			<?php wp_enqueue_script('zeroclipboard'); ?>
	    			<?php if ($offer_coupon_mask !='1') :?>
	                	<div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>   
	           	 	<?php else :?>
	                	<div class="rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo $linkpost->ID?>" data-dest="<?php echo get_post_permalink($review_aff_link) ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_child') ?><?php endif ;?></div>   
	            	<?php endif;?>
            	</div>  
	    	<?php else :?>
		        <div class="re_thing_btn clearfix">
		            <a href="<?php echo $offer_url ?>" class="btn_offer_block" target="_blank" rel="nofollow">
		            	<span class="btn_text">
		            		<?php if($offer_btn_text !='') :?>
		            			<?php echo $offer_btn_text ; ?>
		            		<?php elseif(rehub_option('rehub_btn_text') !='') :?>
		            			<?php echo rehub_option('rehub_btn_text') ; ?>
		            		<?php else :?>
		            			<?php _e('Buy this item', 'rehub_child') ?>
		            		<?php endif ;?>
		            	</span> / 
		            	<?php if(!empty($offer_price)) : ?>
		            		<span class="btn_price">
		            			<ins><?php echo $offer_price ?></ins>
		            			<?php if($offer_price_old !='') :?>
		            				<del><?php echo $offer_price_old ; ?></del>
		            			<?php endif ;?>
		            		</span>
		            	<?php endif ;?>	            	
		            </a>
		        </div>	    			    	
	    	<?php endif;?>	
	    <?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_aff_product') :?> 
			<?php $rehub_aff_post_ids = vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_links');
			if(function_exists('thirstyInit') && !empty($rehub_aff_post_ids)) :?>
		        <div class="re_thing_btn clearfix">	             
		            <a href="<?php the_permalink();?>#aff-link-list" class="btn_offer_block">
		            	<span class="btn_text">
		            		<?php if(rehub_option('rehub_btn_text_aff_links') !='') :?>
		            			<?php echo rehub_option('rehub_btn_text_aff_links') ; ?>
		            		<?php else :?>
		            			<?php _e('Choose offer', 'rehub_child') ?>
		            		<?php endif ;?>
		            	</span> / 
		                <?php $min_aff_price_count = get_post_meta(get_the_ID(), 'rehub_min_aff_price', true); if ($min_aff_price_count !='') : ?>
		                	<span class="btn_price"><?php echo rehub_option('rehub_currency'); echo $min_aff_price_count; ?></span>
		                <?php endif ;?>		            	
		            </a>		        
		        </div>	    
	    	<?php endif ;?>

	    <?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_list') :?> 
			<?php $review_woo_list_links = vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_links');
			if(is_plugin_active( 'woocommerce/woocommerce.php' ) && !empty($review_woo_list_links)) :?>
		        <div class="re_thing_btn clearfix">
		            <a href="<?php the_permalink();?>#woo-link-list" class="btn_offer_block">
		            	<span class="btn_text">
		            		<?php if(rehub_option('rehub_btn_text_aff_links') !='') :?>
		            			<?php echo rehub_option('rehub_btn_text_aff_links') ; ?>
		            		<?php else :?>
		            			<?php _e('Choose offer', 'rehub_child') ?>
		            		<?php endif ;?>
		            	</span> / 
		                <?php $min_woo_price_count = get_post_meta(get_the_ID(), 'rehub_min_woo_price', true); if ($min_woo_price_count !='') : ?>
		                	<span class="btn_price"><?php echo rehub_option('rehub_currency'); echo $min_woo_price_count; ?></span>
		                <?php endif ;?>		            	
		            </a>
		        </div>	    
	    	<?php endif ;?>

		<?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') :?>
        	<?php $review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');?>
        	<?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_child') ;?><?php endif ;?>
        	<?php global $woocommerce; global $post;$backup=$post; if($woocommerce) :?>
				<?php 	
					$args = array(
						'post_type' 		=> 'product',
						'posts_per_page' 	=> 1,
						'no_found_rows' 	=> 1,
						'post_status' 		=> 'publish',
						'p'					=> $review_woo_link,

					);
				?>
				<?php $products = new WP_Query( $args ); if ( $products->have_posts() ) : ?>
					<?php while ( $products->have_posts() ) : $products->the_post(); global $product?>
					<?php $offer_price = $product->get_price_html() ?>
		            <?php $offer_coupon = get_post_meta( get_the_ID(), 'rehub_woo_coupon_code', true ) ?>
		            <?php $offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_woo_coupon_date', true ) ?>
		            <?php $offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_woo_coupon_mask', true ) ?>
		            <?php $offer_coupon_url = esc_url( $product->add_to_cart_url() ); ?>
		            <?php if(!empty($offer_coupon_date)) : ?>
						<?php 
						$timestamp1 = strtotime($offer_coupon_date); 
						$seconds = $timestamp1 - time(); 
						$days = floor($seconds / 86400);
						$seconds %= 86400;
						if ($days > 0) {
						  $coupon_text = $days.' '.__('days left', 'rehub_framework');
						  $coupon_style = '';
						}
						elseif ($days == 0){
						  $coupon_text = __('Last day', 'rehub_framework');
						  $coupon_style = '';
						}
						else {
						  $coupon_text = __('Coupon is Expired', 'rehub_framework');
						  $coupon_style = 'expired_coupon';
						}                 
						?>
		          	<?php endif ;?>

			    	<?php if(!empty($offer_coupon)) : ?>
			    		<div class="re_thing_btn clearfix">
							<?php wp_enqueue_script('zeroclipboard'); ?>
							<?php if ($offer_coupon_mask !='1' && $offer_coupon_mask !='on') :?>
							  <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>   
							<?php else :?>
							  <div class="rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo $product->id ?>" data-dest="<?php echo $offer_coupon_url ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?></div>   
							<?php endif;?>   
		            	</div>
		            <?php else :?>
						<div class="re_thing_btn woo_thing_btn clearfix">   
			                	<?php if ($product->product_type =='external' && $product->add_to_cart_url() =='') :?>
			                		<a class='btn_offer_block' href="<?php the_permalink();?>" target="_blank"><?php _e('Prices', 'rehub_child') ;?></a>
			                	<?php else :?>
			                    	<?php if ( $product->is_in_stock() ) : ?>
										<?php  
											echo apply_filters( 'woocommerce_loop_add_to_cart_link',
											sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="btn_offer_block %s product_type_%s"><span class="btn_text">%s</span>%s</a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( $product->id ),
											esc_attr( $product->get_sku() ),
											$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
											esc_attr( $product->product_type ),
											esc_html( $btn_txt ),
											$offer_price !='' ? ' / <span class="btn_price">'.$offer_price.'</span>' : ''
											), $product );
										?>
	    							<?php endif; ?>
								<?php endif; ?>
			            </div>
		            <?php endif; ?>

				<?php endwhile; endif;  wp_reset_postdata(); $post=$backup; ?> 
        	<?php endif ;?>

       	<?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'link' && vp_metabox('rehub_post.link_post.0.link_post_url') != '' && vp_metabox('rehub_post.link_post.0.link_post_btn') != '') :?>
	        <?php $offer_url = vp_metabox('rehub_post.link_post.0.link_post_url') ?>
	        <?php $offer_btn_text = vp_metabox('rehub_post.link_post.0.link_post_btn') ?>       	
	        <div class="re_thing_btn clearfix">
	            <a href="<?php echo $offer_url ?>" class="btn_offer_block" target="_blank" rel="nofollow">
	            	<span class="btn_text"><?php echo $offer_btn_text ; ?></span>	            	
	            </a>
	        </div>
    	
        <?php else :?> 
        	<?php if ($btn_more =='yes') :?>
			  	
			  	<?php if (vp_metabox('rehub_post_side.read_more_custom')): ?>
			  		<div class="re_thing_btn continue_thing_btn no_brd_btn clearfix">
        				<a href="<?php the_permalink();?>"><?php echo vp_metabox('rehub_post_side.read_more_custom');?></a>
        			</div>
				<?php elseif (rehub_option('rehub_readmore_text') !=''): ?>
					<div class="re_thing_btn continue_thing_btn clearfix">
			  			<a href="<?php the_permalink();?>"><?php echo strip_tags(rehub_option('rehub_readmore_text'));?></a>
			  		</div>        						  		
			  	<?php else: ?>
			  		<div class="re_thing_btn continue_thing_btn clearfix">
        				<a href="<?php the_permalink();?>"><?php _e('READ MORE  +', 'rehub_child') ;?></a>
        			</div>
			  	<?php endif ?>

        	<?php endif ;?> 

	    <?php endif ;?> 

	<?php
}
}

//////////////////////////////////////////////////////////////////
// AFF BUTTON
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_affbtn_function') ) {
function rehub_affbtn_function( $atts, $content = null ) { 
    extract(shortcode_atts(array(
		'btn_text' => '',
		'btn_url' => '',
		'btn_price' => '',
		'meta_btn_url' => '',
		'meta_btn_price' => '',
		'button_from_review' => '',				   
    ), $atts));
    if ($button_from_review =='1') :
    	ob_start();
    	rehub_create_btn(''); 
		$out = ob_get_contents();
		ob_end_clean();
	else :	
	    $button_url = (!empty($meta_btn_url)) ? get_post_meta( get_the_ID(), esc_html($meta_btn_url), true ) : $btn_url;
		if (empty ($button_url)) {$button_url = get_the_permalink();}
		$button_price = (!empty($meta_btn_price)) ? get_post_meta( get_the_ID(), esc_html($meta_btn_price), true ) : $btn_price;    
		$out = 	'<div class="re_thing_btn clearfix">';
		$out .='<a href="'.esc_url($button_url).'" class="btn_offer_block" target="_blank" rel="nofollow">';
		$out .='<span class="btn_text">';
		if (!empty($btn_text)) :         
			$out .= $btn_text;
		elseif (rehub_option('rehub_btn_text') !='') :
			$out .= rehub_option("rehub_btn_text");
		else :
			$out .= __("Buy this item", "rehub_framework");	
		endif;
		$out .='</span>';
		if (!empty($button_price)) :
			$out .= ' / <span class="btn_price">'.esc_html($button_price).'</span>'; 
		endif;				
		$out .='</a></div>';
	endif;            
    return $out;
}
add_shortcode('rehub_affbtn', 'rehub_affbtn_function');
}

//Link function

function rehub_permalink(){
	if (vp_metabox('rehub_post.rehub_framework_post_type') == 'link' && vp_metabox('rehub_post.link_post.0.link_post_url') != '') {
		echo '<a href="'.vp_metabox("rehub_post.link_post.0.link_post_url").'" rel="nofollow" target="_blank">';
	}
	else {
	    echo '<a href="'.get_the_permalink().'">';
	}
}

//unregister some parent widgets
add_action( 'widgets_init', 'rehub_parent_unregister_widgets', 11 );
function rehub_parent_unregister_widgets() {
    unregister_widget( 'rehub_tabs_widget' );
}
include (STYLESHEETPATH . '/inc/widgets/tabs_widget_child.php');

//VC init
if (class_exists('WPBakeryVisualComposerAbstract')) {
	function rehub_vc_styles() {
		wp_enqueue_style('rehub_vc', get_stylesheet_directory_uri() .'/functions/vc/vc.css', array(), time(), 'all');
	}	
}

// Love it function!
function like_scripts() {
	wp_enqueue_script( 'like_post', get_stylesheet_directory_uri().'/js/post-like.js', array('jquery'), '1.0', 1 );
	wp_localize_script( 'like_post', 'ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce')
		)
	);
}
add_action('init','like_scripts');
add_action( 'wp_ajax_nopriv_post-like', 'post_like' );
add_action( 'wp_ajax_post-like', 'post_like' );

function post_like() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
	
	if ( isset( $_POST['post_like'] ) ) {
	
		$post_id = $_POST['post_id']; // post id
		$post_like_count = get_post_meta( $post_id, "_post_like_count", true ); // post like count
		
		if ( is_user_logged_in() ) { // user is logged in
			global $current_user;
			$user_id = $current_user->ID; // current user
			$meta_POSTS = get_user_meta( $user_id, "_liked_posts" ); // post ids from user meta
			$meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
			$liked_POSTS = ""; // setup array variable
			$liked_USERS = ""; // setup array variable
			
			if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
				$liked_POSTS = $meta_POSTS[0];
			}
			
			if ( !is_array( $liked_POSTS ) ) // make array just in case
				$liked_POSTS = array();
				
			if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
				$liked_USERS = $meta_USERS[0];
			}		

			if ( !is_array( $liked_USERS ) ) // make array just in case
				$liked_USERS = array();
				
			$liked_POSTS['post-'.$post_id] = $post_id; // Add post id to user meta array
			$liked_USERS['user-'.$user_id] = $user_id; // add user id to post meta array
			$user_likes = count( $liked_POSTS ); // count user likes
	
			if ( !AlreadyLiked( $post_id ) ) { // like the post
				update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Add user ID to post meta
				update_post_meta( $post_id, "_post_like_count", ++$post_like_count ); // +1 count post meta
				update_user_meta( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
				update_user_meta( $user_id, "_user_like_count", $user_likes ); // +1 count user meta
				echo $post_like_count; // update count on front end
				
			} else { // unlike the post
				$pid_key = array_search( $post_id, $liked_POSTS ); // find the key
				$uid_key = array_search( $user_id, $liked_USERS ); // find the key
				unset( $liked_POSTS[$pid_key] ); // remove from array
				unset( $liked_USERS[$uid_key] ); // remove from array
				$user_likes = count( $liked_POSTS ); // recount user likes
				update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Remove user ID from post meta
				update_post_meta($post_id, "_post_like_count", --$post_like_count ); // -1 count post meta
				update_user_meta( $user_id, "_liked_posts", $liked_POSTS ); // Remove post ID from user meta			
				update_user_meta( $user_id, "_user_like_count", $user_likes ); // -1 count user meta
				echo "already".$post_like_count; // update count on front end
				
			}
			
		} else { // user is not logged in (anonymous)
			$ip = $_SERVER['REMOTE_ADDR']; // user IP address
			$meta_IPS = get_post_meta( $post_id, "_user_IP" ); // stored IP addresses
			$liked_IPS = ""; // set up array variable
			
			if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
				$liked_IPS = $meta_IPS[0];
			}
	
			if ( !is_array( $liked_IPS ) ) // make array just in case
				$liked_IPS = array();
				
			if ( !in_array( $ip, $liked_IPS ) ) // if IP not in array
				$liked_IPS['ip-'.$ip] = $ip; // add IP to array
			
			if ( !AlreadyLiked( $post_id ) ) { // like the post
			
				update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Add user IP to post meta
				update_post_meta( $post_id, "_post_like_count", ++$post_like_count ); // +1 count post meta
				echo $post_like_count; // update count on front end
				
			} else { // unlike the post
			
				$ip_key = array_search( $ip, $liked_IPS ); // find the key
				unset( $liked_IPS[$ip_key] ); // remove from array
				update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Remove user IP from post meta
				update_post_meta( $post_id, "_post_like_count", --$post_like_count ); // -1 count post meta
				echo "already".$post_like_count; // update count on front end
				
			}
		}
	}
	
	exit;
}

function AlreadyLiked( $post_id ) { // test if user liked before
	
	if ( is_user_logged_in() ) { // user is logged in
		global $current_user;
		$user_id = $current_user->ID; // current user
		$meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
		$liked_USERS = ""; // set up array variable
		
		if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
			$liked_USERS = $meta_USERS[0];
		}
		
		if( !is_array( $liked_USERS ) ) // make array just in case
			$liked_USERS = array();
			
		if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
			return true;
		}
		return false;
		
	} else { // user is anonymous, use IP address for voting
	
$meta_IPS = get_post_meta($post_id, "_user_IP"); // get previously voted IP address
$ip = $_SERVER["REMOTE_ADDR"]; // Retrieve current user IP
$liked_IPS = ""; // set up array variable

if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
	$liked_IPS = $meta_IPS[0];
}

if ( !is_array( $liked_IPS ) ) // make array just in case
	$liked_IPS = array();

if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
	return true;
}
return false;
	}
	
}
function getPostLikeLink( $post_id ) {
	$like_count = get_post_meta( $post_id, "_post_like_count", true ); // get post likes
if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
	$likes = '0';
} elseif ( $like_count && $like_count != "0" ) { // there are votes!
	$likes = esc_attr( $like_count );
}
	$output = '<span class="thing-post-like">';
	$output .= '<a href="#" data-post_id="'.$post_id.'">';
	if ( AlreadyLiked( $post_id ) ) { // already liked, set up unlike addon
		$output .= '<span class="like prevliked"><i class="fa fa-heart"></i></span>';
		$output .= ' <span class="count alreadyliked">'.$likes.'</span></a></span>';
	} else { // normal like button
		$output .= '<span class="like"><i class="fa fa-heart-o"></i></span>';
		$output .= ' <span class="count">'.$likes.'</span></a></span>';
	}
	if (rehub_option('exclude_post_like') !='1') {
		return $output;
	}
	else {
		return false;
	}
}

/*-----------------------------------------------------------------------------------*/
# 	Hook offer after content 
/*-----------------------------------------------------------------------------------*/
if( !function_exists('set_content_end') ) {
function set_content_end($content) {
	global $post;
	
	if( is_feed() ) return $content;
	
	$output = '';
		ob_start();
		wp_link_pages(array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rehub_child' ), 'after' => '</div>' ));
		$output .= ob_get_clean(); 

	$offer_url_exist = get_post_meta( $post->ID, 'rehub_offer_product_url', true );
	if (!empty($offer_url_exist)) :
		$offer_shortcode = get_post_meta( $post->ID, 'rehub_offer_shortcode', true );
		if (empty($offer_shortcode)) :
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';
			rehub_quick_offer();
			$output .= ob_get_clean();
		endif;
	elseif(vp_metabox('rehub_post.rehub_framework_post_type') == 'review') :
		if(vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_offer_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_post_review_product') :
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';
			rehub_get_offer();
			$output .= ob_get_clean();
		endif;
		if(vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_offer_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_aff_product') :
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';		
			rehub_get_aff_offer();
			$output .= ob_get_clean();
		endif;
		if(vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_offer_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') :
			$review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';			
			rehub_get_woo_offer($review_woo_link);
			$output .= ob_get_clean();		
		endif;
		if(vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_list') :	
			$review_woo_list_links = vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_links');
			if (is_array($review_woo_list_links)) { $review_woo_list_links = implode(',', $review_woo_list_links); }
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';
			rehub_get_woo_list($data_source = 'ids', $type ='', $cat = '', $tag = '', $ids = $review_woo_list_links);
			$output .= ob_get_clean();			
		endif;
	endif; 

	if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_product_shortcode') == '0') :
		$overal_score = rehub_get_overall_score(); 
		$postAverage = get_post_meta(get_the_ID(), 'post_user_average', true);
		ob_start();
		if ((rehub_option('type_user_review') == 'full_review') && ($postAverage !='0' && $postAverage !='' )) :
			echo '<div class="lined_r_title">'.__('Review Score', 'rehub_child').'</div>';
		elseif ($overal_score !='0' && $overal_score !=''):
			echo '<div class="lined_r_title">'.__('Review Score', 'rehub_child').'</div>';
		endif;	
		rehub_get_review();
		$output .= ob_get_clean();
	endif;	

	return $content.$output;
}
}


?>
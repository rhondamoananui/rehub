<div class="product_image_col">
    <figure>     
        <?php 
        $affiliate_link = $row['image_link_affiliate'];
        $link_on_thumb = ($affiliate_link !='') ? rehub_create_affiliate_link() : get_the_permalink(); 
        ?>
        <?php $link_on_thumb_target = ($affiliate_link !='') ? ' class="btn_offer_block"' : '' ; ?>
        <a href="<?php echo $link_on_thumb;?>" target="_blank"<?php echo $link_on_thumb_target;?>>
        <?php $img = get_post_thumb(); $nothumb = get_template_directory_uri() . '/images/default/noimage_100_70.png' ;
        if( rehub_option( 'aq_resize_crop') == '1') {$params = array( 'width' => 110);}
        else {$params = array( 'width' => 110, 'height' => 110, 'crop' => true);} ?>
        <?php if(!empty($img)) : ?>
            <img src="<?php echo bfi_thumb( $img, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
        <?php else : ?>    
            <img src="<?php echo $nothumb; ?>" alt="<?php the_title_attribute(); ?>" />
        <?php endif ; ?>                                    
        </a>
    </figure>
</div>
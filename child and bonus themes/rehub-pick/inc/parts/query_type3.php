<article class="repick_item small_post inf_scr_item<?php if(rehub_option('rehub_grid_images') =='center') : ?> centered_im_grid<?php else : ?> contain_im_grid<?php endif ; ?>">
    <figure>
        <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>   
            <?php rehub_formats_icons('full'); ?>               
            <a href="<?php the_permalink();?>">
                <?php $img = get_post_thumb(); ?>
                <?php if(rehub_option('rehub_grid_images') =='center') : ?>
                    <?php $params = array( 'width' => 380, 'crop' => false);?>
                <?php else : ?>
                    <?php $params = array( 'width' => 404, 'height' => 404, 'crop' => true);?>
                <?php endif ; ?>
                <?php if(!empty($img)) : ?>
                  <img src="<?php echo bfi_thumb( $img, $params ); ?>" alt="<?php the_title_attribute(); ?>" class="img_centered" />
                <?php endif ; ?>
            </a>                                         
        <?php } ?>
    </figure>
    <div class="wrap_thing">
        <div class="hover_anons">
            <h2><?php echo getHotLikeTitle(get_the_ID()); ?><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
            <p><?php kama_excerpt('maxchar=320'); ?></p>
        </div>
        <?php if(vp_metabox('rehub_post_side.disable_top_offer') != '1')  : ?>
            <?php rehub_create_btn('yes') ;?>
        <?php else :?>
            <?php if (vp_metabox('rehub_post_side.read_more_custom')): ?>
                <a href="<?php the_permalink();?>" class="btn_more btn_more_custom"><?php echo strip_tags(vp_metabox('rehub_post_side.read_more_custom'));?></a>
            <?php elseif (rehub_option('rehub_readmore_text') !=''): ?>
                <a href="<?php the_permalink();?>" class="btn_more"><?php echo strip_tags(rehub_option('rehub_readmore_text'));?></a>                                                   
            <?php else: ?>
                <a href="<?php the_permalink();?>" class="btn_more"><?php _e('READ MORE  +', 'rehub_framework') ;?></a>
            <?php endif ?>            
        <?php endif; ?>
        
    </div>
</article>

<?php if (isset ($count) && isset ($count_ads) && isset ($count_ad_code) && !empty($count_ads) && !empty($count_ad_code) && in_array($count, $count_ads)) : ?>    
    <article class="repick_item small_post inf_scr_item contain_im_grid">
        <figure class="mediad_wrap_pad">
            <?php echo $count_ad_code; ?>
        </figure>
        <div class="wrap_thing">
            <div class="hover_anons">
                <?php if (isset ($count_ad_descs) && !empty($count_ad_descs) ) : ?>
                    <?php if ($count_ad_descs) {
                        $randomKey = array_rand($count_ad_descs, 1); 
                        $count_ad_desc = $count_ad_descs[$randomKey]; 
                        unset($count_ad_descs[$randomKey]);
                    }?>
                    <p><?php echo $count_ad_desc; ?></p>
                <?php endif ;?>                         
            </div>
        </div>
    </article> 
<?php endif ;?>
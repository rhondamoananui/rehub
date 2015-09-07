<?php
    $re_egg_id = get_post_meta( get_the_ID(), '_affegg_egg_id', true );
    $re_egg_product_id = get_post_meta( get_the_ID(), '_affegg_product_id', true );
    $re_egg_currency = get_post_meta( get_the_ID(), 'affegg_product_currency', true ); 
    $item = array(
        'id' => $re_egg_product_id,
        'orig_url' => $aff_url_exist,
        'egg_id' => $re_egg_id,
    );
    $offer_url = (class_exists('\Keywordrush\AffiliateEgg\AffiliateEgg')) ? Keywordrush\AffiliateEgg\LinkHandler::createAffUrl($item) : esc_url($offer_url_exist); 
    $offer_price = get_post_meta( get_the_ID(), 'affegg_product_price', true );             
    $offer_price_old = get_post_meta( get_the_ID(), 'affegg_product_old_price', true );
    $offer_currency = (class_exists('\Keywordrush\AffiliateEgg\AffiliateEgg')) ? Keywordrush\AffiliateEgg\TemplateHelper::currencyTyping($re_egg_currency) : $re_egg_currency;
    $offer_coupon = get_post_meta( get_the_ID(), 'affegg_product_product_coupon', true );
    $offer_coupon_date = get_post_meta( get_the_ID(), 'affegg_product_product_coupon_date', true );
    $offer_coupon_mask = 1;
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
<?php if(!empty($offer_coupon) && $offer_coupon !='0') : ?>
    <div class="re_thing_btn clearfix">
        <?php wp_enqueue_script('zeroclipboard'); ?>
        <?php if ($offer_coupon_mask !='1' && $offer_coupon_mask !='on') :?>
            <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>   
        <?php else :?>
            <?php wp_enqueue_script('affegg_coupons'); ?>
            <div class="rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo esc_html ($offer_coupon) ?>" data-codetext="<?php echo esc_html($offer_coupon)?>" data-dest="<?php echo esc_url ($offer_url) ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_child') ?><?php endif ;?></div>   
        <?php endif;?>
    </div>                   
<?php else : ?>             
    <div class="re_thing_btn clearfix">
        <a href="<?php echo esc_url ($offer_url) ?>" class="btn_offer_block" target="_blank" rel="nofollow">
            <span class="btn_text">
                <?php if(rehub_option('rehub_btn_text') !='') :?>
                    <?php echo rehub_option('rehub_btn_text') ; ?>
                <?php else :?>
                    <?php _e('Buy this item', 'rehub_child') ?>
                <?php endif ;?>
            </span>
            <?php if(!empty($offer_price) && $offer_price !='0') : ?>
                 / <span class="btn_price">
                    <ins><?php echo esc_html($offer_price) ?><?php echo ' <sup>'.esc_html($offer_currency).'</sup>' ?></ins>
                    <?php if(!empty($offer_price_old) && $offer_price_old !='0') :?>
                        <del><?php echo $offer_price_old ; ?></del>
                    <?php endif ;?>
                </span>
            <?php endif ;?>                 
        </a>
    </div>                  
<?php endif; ?>     
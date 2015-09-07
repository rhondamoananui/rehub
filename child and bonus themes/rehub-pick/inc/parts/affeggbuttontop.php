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
    $offer_currency = (class_exists('\Keywordrush\AffiliateEgg\AffiliateEgg')) ? Keywordrush\AffiliateEgg\TemplateHelper::currencyTyping($re_egg_currency) : $re_egg_currency;
    $offer_last_update = get_post_meta( get_the_ID(), 'affegg_product_last_update', true );
?>
<div class="right_aff">
    <div class="priced_block clearfix">
        <?php if(!empty($offer_price) && $offer_price !='0') : ?>
            <p> 
                <span class="price_count">
                    <span class="amount"><?php echo '<span>'.esc_html($offer_currency).'</span> ' ?><?php echo esc_html($offer_price) ?></span>                     
                </span>
            </p>
        <?php endif ;?>                             
            <div>
                <a href="<?php echo $offer_url ?>" class="btn_offer_block" target="_blank" rel="nofollow">
                    <?php if(rehub_option('rehub_btn_text') !='') :?>
                        <?php $btn_txt = rehub_option('rehub_btn_text') ; ?>
                    <?php else :?>
                        <?php $btn_txt = __('Buy now', 'rehub_child') ;?>
                    <?php endif ;?> 
                    <?php echo esc_html($btn_txt ) ;?> 
                    <span class="aff_tag mtinside"><?php echo rehub_get_site_favicon($aff_url_exist); ?></span>
                </a>
            </div>
    </div>
    <div class="ameb_search"><?php echo $amazon_link; echo $ebay_link;?></div>
</div>
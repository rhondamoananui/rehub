<?php
/*
  Name: Big product cart with extra and deals list (use for multiple products)
 */
?>
<?php
// sort items by price
usort($items, function($a, $b) {
    if (!(float) $a['price']) return 1;
    if (!(float) $b['price']) return -1;
    return (float) str_replace(' ', '', $a['price']) - (float) str_replace(' ', '', $b['price']);
});
$product_price_update = get_post_meta( get_the_ID(), 'affegg_product_last_update', true );
//Check if post has meta for first product
$aff_thumb_overwrite = get_post_meta( get_the_ID(), 'affegg_image_over', true );
$offer_desc_overwrite = get_post_meta( get_the_ID(), 'affegg_desc_over', true );
//Data for main product
$aff_thumb_first = (!empty ($aff_thumb_overwrite)) ? $aff_thumb_overwrite : $items[0]['img'];
$offer_title_first = wp_trim_words( $items[0]['title'], 20, '...' );
$offer_url_first = $items[0]['url'];
$offer_desc_first = (!empty ($aff_thumb_overwrite)) ? $aff_thumb_overwrite : $items[0]['description'] ;
$best_price_value = str_replace(' ', '', $items[0]['price']); if($best_price_value =='0') {$best_price_value = '';}
$best_price_currency = $items[0]['currency'];
$best_price_text = (rehub_option('rehub_btn_text_best') !='') ? esc_html(rehub_option('rehub_btn_text_best')) : __('Best price', 'rehub_framework');
if (!empty ($items[0]['extra']['features'])) {$attributes = $items[0]['extra']['features'];}
if (!empty ($items[0]['extra']['images'])) {$gallery_images = $items[0]['extra']['images'];}
if (!empty($items[0]['extra']['comments'])) {$import_comments = $items[0]['extra']['comments'];} 
?>
<div class="col_wrap_two">
    <div class="product_egg_extra">
        <div class="image col_item">
            <?php $params = array( 'width' => 500 );?>            
            <?php if (!empty($aff_thumb_first) ) :?> 
                <img src="<?php echo bfi_thumb( esc_attr($aff_thumb_first), $params ); ?>" alt="<?php echo esc_attr($offer_title_first); ?>" />
            <?php else :?>
                <?php $image_id = get_post_thumbnail_id(get_the_ID());  $image_offer_url = wp_get_attachment_url($image_id);?>
                <img src="<?php echo bfi_thumb( $image_offer_url, $params ); ?>" alt="<?php echo esc_attr($offer_title_first); ?>" />
            <?php endif ;?>                                   
        </div>

        <div class="product-summary col_item"> 
            <?php if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && rehub_get_overall_score() !='0') :?>
                <?php $overal_score = rehub_get_overall_score();  ?>
                <div class="rate_bar_wrap top_score_wrap<?php if ((rehub_option('type_user_review') == 'full_review') && ($postAverage !='0' && $postAverage !='' )) {echo ' two_rev';} ?><?php if (rehub_option('color_type_review') == 'multicolor') {echo ' colored_rate_bar';} ?>">
                    <div class="review-top" >
                        <div class="overall-score"> 
                            <span class="overall r_score_<?php echo round($overal_score); ?>" itemprop="ratingValue"><?php echo $overal_score ?></span>
                            <span class="overall-text"><?php _e('Total Score', 'rehub_framework'); ?></span>
                        </div>
                        <div class="review-text">
                            <?php if(!empty($best_price_value)) : ?>
                                <div class="deals-box-pricebest">
                                <span><?php _e('Start from: ', 'rehub_framework');?></span>
                                    <?php echo $best_price_currency; echo $best_price_value; ?>                        
                                </div>                                                       
                            <?php endif ;?> 
                            <?php if(!empty($offer_url_first)) : ?> 
                                <div class="priced_block">
                                    <div>
                                        <a class="btn_offer_block" href="<?php echo esc_url($offer_url_first) ?>"<?= $items[0]['ga_event'] ?> target="_blank" rel="nofollow">
                                            <?php echo $best_price_text; ?>
                                            <span class="aff_tag mtinside"><?php echo rehub_get_site_favicon($items[0]['orig_url']); ?></span>
                                        </a>
                                        
                                    </div>
                                </div>
                            <?php endif ;?>                                                                       
                        </div>                
                    </div>
                </div>                          
            <?php else :?> 
                <?php if(!empty($best_price_value)) : ?>
                    <div class="deals-box-pricebest">
                    <span><?php _e('Start from: ', 'rehub_framework');?></span>
                        <?php echo $best_price_currency; echo $best_price_value; ?>                     
                    </div>                                                       
                <?php endif ;?> 
                <?php if(!empty($offer_url_first)) : ?> 
                    <div class="priced_block">
                        <div>
                            <a class="btn_offer_block" href="<?php echo esc_url($offer_url_first) ?>"<?= $items[0]['ga_event'] ?> target="_blank" rel="nofollow">
                                <?php _e('Best price', 'rehub_framework'); ?>
                                <span class="aff_tag mtinside"><?php echo rehub_get_site_favicon($items[0]['orig_url']); ?></span>
                            </a>
                            
                        </div>
                    </div>
                <?php endif ;?>
                <br />
            <?php endif ;?>                     
            <?php if (!empty($offer_desc_first)): ?>
                <p><?php rehub_truncate('maxchar=300&text='.$offer_desc_first.''); ?></p>
                <p><a class="color_link read_more_aff" href="<?php echo esc_url($offer_url_first) ?>"<?= $items[0]['ga_event'] ?> target="_blank" rel="nofollow"><?php _e('Read more on shop website ', 'rehub_framework'); ?>&#8594;</a></p>                  
            <?php endif; ?>             
        </div>           
    </div> 
</div>  

<div class="rehub_woo_review">
    
        <ul class="rehub_woo_tabs_menu">
            <li class="dealslist"><?php _e('Deals', 'rehub_framework') ?></li>
            <?php if (!empty ($attributes)) :?><li class="affspec"><?php _e('Specification', 'rehub_framework') ?></li><?php endif ;?>
            <?php if (!empty ($gallery_images)) :?><li class="pretty_woo"><?php _e('Photos', 'rehub_framework') ?></li><?php endif ;?>
            <?php if (!empty ($import_comments)) :?><li class="affrev"><?php _e('Last comments', 'rehub_framework') ?></li><?php endif ;?>                
        </ul>
    
    <div class="rehub_feat_block table_view_block">
        <div class="rehub_woo_review_tabs dealslist" style="display: table-row">
            <div class="egg_sort_list simple_sort_list"><a name="aff-link-list"></a>
                <div class="aff_offer_links">
                    <?php $i=0; foreach ($items as $key => $item): ?>
                        <?php $offer_price = str_replace(' ', '', $item['price']); if($offer_price =='0') {$offer_price = '';} ?>
                        <?php $offer_price_old = str_replace(' ', '', $item['old_price']); if($offer_price_old =='0') {$offer_price_old = '';}?>
                        <?php $afflink = $item['url'] ;?>
                        <?php $aff_thumb = $item['img'] ;?>
                        <?php $offer_title = wp_trim_words( $item['title'], 10, '...' ); ?>
                        <?php $offer_desc = $item['description'] ;?>
                        <?php $i++;?>  
                        <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>  
                        <div class="rehub_feat_block table_view_block<?php if ($i == 1){echo' best_price_item';}?>">
                            <div>
                                <div class="offer_thumb">   
                                    <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>"<?= $item['ga_event'] ?>>
                                        <?php if (!empty($aff_thumb) ) :?>  
                                            <img src="<?php $params = array( 'width' => 100 ); echo bfi_thumb( esc_attr($aff_thumb), $params ); ?>" alt="<?php echo esc_attr($offer_title); ?>" />
                                        <?php else :?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/default/noimage_100_70.png" alt="<?php echo esc_attr($offer_title); ?>" />
                                        <?php endif ;?>                                    
                                    </a>
                                </div>
                                <div class="desc_col">
                                    <div class="simple_title">
                                        <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>"<?= $item['ga_event'] ?>>
                                            <?php echo esc_attr($offer_title); ?>
                                        </a>
                                    </div>                                
                                </div>                    
                                <div class="desc_col price_simple_col">
                                    <?php if(!empty($offer_price)) : ?>
                                        <p itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                            <span class="price_count">
                                                <span><?php echo $item['currency']; ?></span> <?php echo $offer_price; ?>
                                                <?php if(!empty($offer_price_old)) : ?>
                                                <strike>
                                                    <span class="amount"><?php echo $offer_price_old ?></span>
                                                </strike>
                                                <?php endif ;?>                                      
                                            </span> 
                                            <meta itemprop="price" content="<?php echo $offer_price ?>">
                                            <meta itemprop="priceCurrency" content="<?php echo $item['currency']; ?>">
                                            <?php if ($item['in_stock']): ?>
                                                <link itemprop="availability" href="http://schema.org/InStock">
                                            <?php endif ;?>                         
                                        </p>
                                    <?php endif ;?>                        
                                </div>
                                <div class="desc_col shop_simple_col">
                                   <div class="aff_tag mt10"><?php echo rehub_get_site_favicon($item['orig_url']); ?></div> 
                                   <small class="small_size available_stock"><?php if ($item['in_stock']): ?><span class="yes_available"><?php _e('In stock', 'rehub_framework') ;?></span><?php endif; ?></small>
                                </div>
                                <div class="buttons_col">
                                    <div class="priced_block clearfix">
                                        <div>
                                            <a class="btn_offer_block" href="<?php echo esc_url($afflink) ?>"<?= $item['ga_event'] ?> target="_blank" rel="nofollow">
                                                <?php echo $btn_txt ; ?>
                                            </a>
                                            <?php $offer_coupon_mask = 1 ?>
                                            <?php if(!empty($item['extra']['coupon']['code_date'])) : ?>
                                                <?php 
                                                $timestamp1 = strtotime($item['extra']['coupon']['code_date']); 
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
                                            <?php  if(!empty($item['extra']['coupon']['code'])) : ?>
                                                <?php wp_enqueue_script('zeroclipboard'); ?>
                                                <?php if ($offer_coupon_mask !='1' && $offer_coupon_mask !='on') :?>
                                                    <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($item['extra']['coupon']['code_date'])) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $item['extra']['coupon']['code'] ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $item['extra']['coupon']['code'] ?></span></div>   
                                                <?php else :?>
                                                    <?php wp_enqueue_script('affegg_coupons'); ?>
                                                    <div class="rehub_offer_coupon masked_coupon <?php if(!empty($item['extra']['coupon']['code_date'])) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $item['extra']['coupon']['code'] ?>" data-codetext="<?php echo $item['extra']['coupon']['code'] ?>" data-dest="<?php echo esc_url($item['url']) ?>"<?= $item['ga_event'] ?>><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?><i class="fa fa-external-link-square"></i></div>   
                                                <?php endif;?>
                                                <?php if(!empty($item['extra']['coupon']['code_date'])) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>    
                                            <?php endif ;?> 
                                                                        
                                        </div>
                                    </div>
                                </div>
                            </div>                                                          
                        </div>
                    <?php endforeach; ?>
                    <div class="last_update"><?php _e('Last price update was in: ', 'rehub_framework'); ?><?php echo $product_price_update ;?></div>
                </div>
            </div>
            <div class="clearfix"></div>                
        </div>

        <?php if (!empty ($attributes)) :?>
            <div class="rehub_woo_review_tabs affspec">
                <div>
                    <table class="shop_attributes">
                        <tbody>
                        <?php foreach ($attributes as $feature): ?>
                            <tr>
                                <th><?php echo esc_html($feature['name']) ?></th>
                                <td><p><?php echo esc_html($feature['value']) ?></p></td>
                            </tr>
                        <?php endforeach; ?>                                        
                        </tbody>
                    </table>
                </div>                               
            </div>
        <?php endif ;?>


        <?php if (!empty ($gallery_images)) :?>
            <script>
            jQuery(document).ready(function($) {
                'use strict'; 
                $('.rehub_woo_review .pretty_woo a').attr('rel', 'prettyPhoto[rehub_product_gallery_<?php echo rand(1, 50);?>]');
                $(".rehub_woo_review .pretty_woo a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
            });
            </script>
            <div class="rehub_woo_review_tabs pretty_woo">
                <?php wp_enqueue_script('prettyphoto');
                    foreach ($gallery_images as $gallery_img) {
                        ?> 
                        <a href="<?php echo esc_attr($gallery_img) ;?>"> 
                        <img src="<?php $params = array( 'width' => 100, 'height' =>100 ); echo bfi_thumb( $gallery_img, $params ); ?>" alt="<?php echo esc_attr($offer_title_first); ?>" />  
                        </a>
                        <?php
                    }
                ?>
            </div>
        <?php endif ;?>
        <?php if (!empty ($import_comments)) :?>
            <div class="rehub_woo_review_tabs affrev">
                <?php foreach ($import_comments as $key => $comment): ?>
                    <div class="helpful-review black">
                        <div class="quote-top"><i class="fa fa-quote-left"></i></div>
                        <div class="quote-bottom"><i class="fa fa-quote-right"></i></div>
                        <div class="text-elips">
                            <span><?php echo $comment['comment']; ?></span>
                        </div>
                        <?php if (!empty($comment['date'])): ?>
                            <span class="helpful-date"><?php echo gmdate("F j, Y", $comment['date']); ?></span>
                        <?php endif ;?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif ;?>                        
    </div>        
</div>
<div class="clearfix"></div>      
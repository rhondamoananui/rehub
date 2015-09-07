<?php
/*
  Name: Just button
 */
?>
<?php foreach ($items as $item): ?>
<?php $afflink = $item['url'] ;?>  
<?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   	    
<a href="<?php echo esc_url($afflink) ?>" class="wpsm-button rehub_main_btn" target="_blank" rel="nofollow"<?= $item['ga_event'] ?>><span><strong><?php echo esc_html($btn_txt) ?></strong></span></a>                                                                  
<?php endforeach; ?>         
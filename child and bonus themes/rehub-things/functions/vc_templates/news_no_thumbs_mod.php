<?php
$module_cats = '';
$module_exclude = rehub_option('rehub_exclude_posts');
if(($module_exclude) == 1) {
	$exclude_posts = rehub_exclude_feature_posts();
}
else $exclude_posts = '';
extract(shortcode_atts(array(
'module_cats' => '',
), $atts));
if ($module_cats == 'all') {$module_cats = '';}
if ($module_cats != 'all' || $module_cats != '') {
    $category_link = get_category_link($module_cats);
    $category_name = get_cat_name($module_cats);
    $category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>';
}
else {
    $category_echo = '';
}


?>
<?php if( !is_paged()) : ?>
<div class="news_block clearfix">
    <?php $fivenews = new WP_Query(array( 'cat' => $module_cats, 'post_type' => 'post', 'showposts' => 5, 'post__not_in' => $exclude_posts, 'ignore_sticky_posts' => 1 )); $count = 0;
        if( $fivenews->have_posts() ) :
        while($fivenews->have_posts()) : $fivenews->the_post(); $count ++ ;
    ?>
        <?php if($count == 1) : ?>
            <div class="big_img">
                <figure>
                    <div class="pattern"></div>
                    <a href="<?php the_permalink();?>"><?php wpsm_thumb ('video_big') ?></a>
                    <div class="video_overlay">
                        <?php if (rehub_option('exclude_comments_meta') == 0) : ?><?php comments_popup_link( 0, 1, '%', 'comment', ''); ?><?php endif ;?>
                        <?php rehub_formats_icons() ?>
                        <div class="overlay_title">
                            <?php echo $category_echo ;?>
                            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                        </div>
                    </div>
                </figure>
            </div>
        <?php else :?>  
            <div class="right">
                <div class="news_no_thumbs">
                    <h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                    <div class="rcnt_meta">
                        <p><?php meta_small( true, false, true ); ?></p>
                    </div>
                </div>
            </div>
    <?php endif;?>
    <?php endwhile; endif; $count=0; wp_reset_query(); ?>
</div>
<?php endif ; ?>
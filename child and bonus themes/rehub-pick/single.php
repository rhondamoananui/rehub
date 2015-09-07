<?php get_header(); ?>

    <!-- CONTENT -->
    <div class="content" itemscope="" itemtype="http://schema.org/Article"> 
		<div class="clearfix">
		    <!-- Main Side -->
            <div class="main-side single<?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?> full_width<?php endif; ?> clearfix">            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post post-inner <?php $category = get_the_category($post->ID); if ($category) {$first_cat = $category[0]->term_id; echo 'category-'.$first_cat.'';} ?>" id="post-<?php the_ID(); ?>">
                    <!-- Title area -->
                    
                    <div class="top_single_area">
                        <?php if(vp_metabox('rehub_post_side.disable_top_offer') != '1')  : ?><?php rehub_create_top_btn('');?><?php endif; ?>
                        <div>                            
                            <h1 itemprop="name"><?php the_title(); ?></h1>
                        </div>                                
                        <div class="meta post-meta">
                            <?php 
                            if ($category) {
                                meta_small( true, $first_cat, true, false );
                            } 
                            else {
                                meta_small( true, false, true, false ); 
                            }
                            ?>                            
                        </div>
                        <meta itemprop="datePublished" content="<?php the_time('Y-m-d'); ?>">
                    </div> 
                    <?php echo getHotLike(get_the_ID()); ?>                                   	
                    <?php if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product' && vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_slider') =='1') :?>
                        <?php get_template_part('inc/parts/woo_slider'); ?>
                    <?php elseif(vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.rehub_review_slider') =='1') :?>                     
                        <?php get_template_part('inc/parts/review_slider'); ?>
                        <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                        <?php else :?>
                            <div class="top_share"><?php get_template_part('inc/parts/post_share'); ?></div>
                            <div class="clearfix"></div> 
                        <?php endif; ?>                        
                    <?php elseif(vp_metabox('rehub_post.rehub_framework_post_type') == 'video' || vp_metabox('rehub_post.rehub_framework_post_type') == 'gallery') :?> 
                        <?php get_template_part('inc/parts/top_image'); ?>
                        <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                        <?php else :?>
                            <div class="top_share"><?php get_template_part('inc/parts/post_share'); ?></div>
                            <div class="clearfix"></div> 
                        <?php endif; ?>                        
                    <?php else :?> 
                        <div<?php if(vp_metabox('rehub_post_side.disable_left_image') != '1' && vp_metabox('rehub_post_side.show_featured_image') != '1' && has_post_thumbnail())  : ?> class="left_pick_image"<?php endif; ?>>
                        <?php get_template_part('inc/parts/top_image'); ?>
                        <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                        <?php else :?>
                            <div class="top_share"><?php get_template_part('inc/parts/post_share'); ?></div>
                            <div class="clearfix"></div> 
                        <?php endif; ?>                        
                        </div>                        
                    <?php endif; ?>

                    <?php if(vp_metabox('rehub_post.rehub_framework_post_type') == 'music') : ?>
                        <?php if(vp_metabox('rehub_post.music_post.0.music_post_source') == 'music_post_soundcloud') : ?>
                            <div class="music_soundcloud">
                                <?php echo vp_metabox('rehub_post.music_post.0.music_post_soundcloud_embed'); ?>
                            </div>                       
                        <?php elseif(vp_metabox('rehub_post.music_post.0.music_post_source') == 'music_post_spotify') : ?>
                            <div class="music_spotify">
                                <iframe src="https://embed.spotify.com/?uri=<?php echo vp_metabox('rehub_post.music_post.0.music_post_spotify_embed'); ?>" width="100%" height="80" frameborder="0" allowtransparency="true"></iframe>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>

                    <?php the_content(); ?>                                             
                
                </article>

                <div class="clearfix"></div>
                <?php  if(vp_metabox('rehub_post_side.is_editor_choice') == '1') :?><div class="ed_choice"><span><i class="fa fa-thumbs-o-up"></i> <?php _e('Editor\'s choice', 'rehub_child') ;?></span></div><div class="clearfix"></div><?php endif; ?>
                <?php if(rehub_option('rehub_single_code') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="single_custom_bottom"><?php echo do_shortcode (rehub_option('rehub_single_code')); ?></div><div class="clearfix"></div><?php endif; ?>
               
                <div class="bottom_meta">               
                    <div class="left_meta">
                        <?php if(rehub_option('rehub_disable_tags') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                        <?php else :?>
                            <span class="tags_meta"><?php the_tags('<i class="fa fa-tags"></i>',", "); ?></span>
                        <?php endif; ?>
                        <?php if(rehub_option('exclude_author_meta') != 1) : ?>
                            <span class="admin_meta"><i class="fa fa-pencil"></i><a class="admin" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>"><?php echo get_the_author() ?></a></span>
                        <?php endif; ?>                        
                    </div>                  
                    <div class="right_meta">  
                        <?php if(rehub_option('rehub_disable_share') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                        <?php else :?>
                            <?php get_template_part('inc/parts/post_share'); ?>  
                        <?php endif; ?> 
                    </div>
                </div>
                
                <?php if(rehub_option('rehub_disable_prev') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                <?php else :?>
                    <?php get_template_part('inc/parts/prevnext'); ?>                   
                <?php endif; ?>                   

                <?php if(rehub_option('rehub_disable_relative') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                <?php else :?>
                    <?php get_template_part('inc/parts/related_posts'); ?>
                <?php endif; ?>                               

            <?php endwhile; endif; ?>

                <?php comments_template(); ?>

			</div>	
            <!-- /Main Side -->  

            <!-- Sidebar -->
            <?php if(vp_metabox('rehub_post_side.post_size') == 'full_post') : ?><?php else : ?><?php get_sidebar(); ?><?php endif; ?>
            <!-- /Sidebar --> 

        </div>
    </div>
    <!-- /CONTENT -->     

<!-- FOOTER -->
<?php get_footer(); ?>
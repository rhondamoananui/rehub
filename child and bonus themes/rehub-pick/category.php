<?php get_header(); ?>
<!-- CONTENT -->
<div class="content"> 
    <div class="clearfix">
        <!-- Main Side -->
        <div class="main-side no_bg_wrap clearfix<?php if (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_gridfull') : ?>  no_bg_wrap full_width<?php endif ;?>">
            <div class="heading"><h5><?php _e('Category:', 'rehub_framework'); ?> <span class="thin"><?php single_cat_title(); ?></span></h5></div>
            <article class='top_rating_text post'><?php echo category_description(); ?></article>
            <?php if (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_gridfull') : ?>
                <div class="masonry_grid_fullwidth three-col-gridhub">
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
            <?php elseif (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_grid') : ?>
                <div class="masonry_grid_fullwidth two-col-gridhub">
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
            <?php else : ?>
                <div>    
            <?php endif ;?>
                <?php $count = 0; $count_ad_descs = explode("\n", rehub_option('rehub_grid_ads_desc')); ?>            
                <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php              
                        $count++;
                        $count_ads = rehub_option('rehub_grid_ad_count');
                        $count_ad_code = rehub_option('rehub_grid_ads_code');                
                    ?>                    
                    <?php if (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_list') : ?>
                        <?php get_template_part('inc/parts/query_type1'); ?>
                    <?php elseif (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_grid') : ?>
                        <?php include(locate_template('inc/parts/query_type3.php')); ?>
                    <?php elseif (rehub_option('rehub_framework_category_layout') == 'rehub_framework_category_gridfull') : ?>
                        <?php include(locate_template('inc/parts/query_type3.php')); ?>                                      
                    <?php else : ?>
                        <?php include(locate_template('inc/parts/query_type3.php')); ?>	
                    <?php endif ;?>
                <?php endwhile; ?>

                <?php else : ?>		
                    <h5><?php _e('Sorry. No posts in this category yet', 'rehub_child'); ?></h5>			   
                <?php endif; ?>
                </div>
                <div class="clearfix"></div>    
            <?php if (rehub_option('index_pagination') =='2') :?> 
                <div class="more_post onclick index_next_pagination"><?php echo get_next_posts_link('' . __('Next posts', 'rehub_child') . ''); ?></div>
                <div class="more_post onclick index_previous_pagination"><?php echo get_previous_posts_link('' . __('Previous posts', 'rehub_child') . ''); ?></div>                                              
            <?php else :?>
                <div class="pagination"><?php rehub_pagination();?></div>
            <?php endif ;?>  	
        </div>	
        <!-- /Main Side -->
        <?php if (rehub_option('rehub_framework_category_layout') != 'rehub_framework_category_gridfull') : ?>
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 
        <?php endif ;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>
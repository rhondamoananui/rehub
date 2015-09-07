<?php get_header(); ?>
<!-- CONTENT -->
<div class="content">    
    <div class="clearfix">
          <!-- Main Side -->
          <div class="main-side no_bg_wrap clearfix<?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull') : ?> full_width<?php endif ;?>">
            <div class="heading"></div>
            <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                  'paged' => $paged,
                  'ignore_sticky_posts' => 1
                );
            ?>            
            <?php $query = new WP_Query( $args ); ?> 
            <?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_grid') : ?>
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth two-col-gridhub">
            <?php elseif (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull') : ?>   
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth three-col-gridhub"> 
            <?php elseif (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_list') : ?>
                <div> 
            <?php else : ?>   
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div class="masonry_grid_fullwidth three-col-gridhub">                                   
            <?php endif ;?>   
            <?php if ($query->have_posts()) : ?>
            <?php 
            $count = 0; 
            $count_ad_descs = explode("\n", rehub_option('rehub_grid_ads_desc'));
            while ($query->have_posts()) : $query->the_post(); ?>
                <?php              
                    $count++;
                    $count_ads = rehub_option('rehub_grid_ad_count');
                    $count_ad_code = rehub_option('rehub_grid_ads_code');                
                ?>
                <?php if (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_list') : ?>
                    <?php get_template_part('inc/parts/query_type1'); ?>
                <?php elseif (rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_grid' || rehub_option('rehub_framework_archive_layout') == 'rehub_framework_archive_gridfull') : ?>
                    <?php include(locate_template('inc/parts/query_type3.php')); ?>                    
                <?php else : ?>
                    <?php include(locate_template('inc/parts/query_type3.php')); ?>	
                <?php endif ;?>
            <?php endwhile; endif;?>
            </div>
            <div class="clearfix"></div>
            <?php if (rehub_option('index_pagination') =='2') :?> 
                <div class="more_post onclick index_next_pagination"><?php echo get_next_posts_link('' . __('Next posts', 'rehub_child') . ''); ?></div>
                <div class="more_post onclick index_previous_pagination"><?php echo get_previous_posts_link('' . __('Previous posts', 'rehub_child') . ''); ?></div>                                              
            <?php else :?>
                <div class="pagination"><?php rehub_pagination();?></div>
            <?php endif ;?> 	
            <?php wp_reset_query(); ?>
        </div>	
        <!-- /Main Side -->
        <?php if (rehub_option('rehub_framework_archive_layout') != 'rehub_framework_archive_gridfull') : ?>
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 
        <?php endif ;?>
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>
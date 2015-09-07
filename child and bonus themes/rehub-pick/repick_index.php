<?php
    
    /* Template Name: Grid with filters (for RE:pick theme) */

?>
<?php          
?>
<?php get_header(); ?>
    <!-- CONTENT -->
    <div class="content">    
		<div class="clearfix">
		    <!-- Main Side -->
            <div class="main-side page no_bg_wrap clearfix full_width"> 
                <div class="filter_home_pick">
                    <ul>       
                        <li class="label"><?php _e('Sort by:', 'rehub_child'); ?></li>
                        <li><span data-sorttype="latest" class="active"><?php _e('Latest', 'rehub_child'); ?></span></li>
                        <li><span data-sorttype="hot"><?php _e('Most Hot', 'rehub_child'); ?></span></li>
                        <li><span data-sorttype="popular"><?php _e('Popular', 'rehub_child'); ?></span></li>
                        <?php if (rehub_option('rehub_home_price')) :?>
                        <li><span data-sorttype="bestprice"><?php _e('Lowest Price', 'rehub_child'); ?></span></li>
                        <li><span data-sorttype="mostprice"><?php _e('Highest Price', 'rehub_child'); ?></span></li>
                        <?php endif ;?>
                        <li><span data-sorttype="random"><?php _e('Random', 'rehub_child'); ?></span></li>                           
                    </ul>
                </div> 
                <div class="clearfix"></div>    
                <?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded'); wp_enqueue_script('masonry_init'); ?>
                <div id="filter_container">
                    
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?><div class="top_rating_text"><?php the_content(); ?></div><?php endwhile; endif; ?>

                    <div class="masonry_grid_fullwidth three-col-gridhub">                
                    
                        <?php
                            $count_ads = rehub_option('rehub_grid_ad_count');
                            $per_page_grid = 12;
                            foreach ($count_ads as $count_ad) {
                                $per_page_grid--;
                            }
                            $args = array(
                              'ignore_sticky_posts' => 1,
                              'posts_per_page' => $per_page_grid
                            );
                        ?>
                        <?php $query = new WP_Query( $args ); ?>

                        <?php if ($query->have_posts()) : ?>
                        <?php 
                        $count = 0; 
                        $count_ad_descs = explode("\n", rehub_option('rehub_grid_ads_desc'));
                        while ($query->have_posts()) : $query->the_post(); ?>
                            <?php              
                                $count++;
                                $count_ad_code = rehub_option('rehub_grid_ads_code');                
                            ?>
                            <?php include(locate_template('inc/parts/query_type3.php')); ?> 
                        <?php endwhile; endif;?>                

                    </div>
                    <div class="clearfix"></div>
                    <div class="more_post onclick home_picker_next"><span data-sorttype="latest" data-offset="<?php echo $per_page_grid;?>"><?php _e('Next posts', 'rehub_child');?></span></div>     
                    <?php wp_reset_query(); ?> 
                </div>                                     		
                                
			</div>	
            <!-- /Main Side -->  
        </div>
    </div>
    <!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>
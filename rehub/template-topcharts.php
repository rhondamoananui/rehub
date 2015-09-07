<?php
    /* Template Name: Top charts constructor (NEW) */
?>
<?php 
    $type_chart = vp_metabox('rehub_top_chart.top_chart_type');
    $ids_chart = vp_metabox('rehub_top_chart.top_chart_ids');
    $module_ids = explode(',', $ids_chart);
    $module_width = vp_metabox('rehub_top_chart.top_chart_width'); 
    $module_enable = vp_metabox('rehub_top_chart.shortcode_charts_enable');   
    $rows = vp_metabox('rehub_top_chart.columncontents');  //Get the rows     
?>
<?php get_header(); ?>
    <!-- CONTENT -->
    <div class="content">     
		<div class="clearfix">
		    <!-- Main Side -->
            <div class="main-side page clearfix<?php if ($module_width =='1') : ?> full_width<?php endif;?>">
                <div class="title"><h1><?php the_title(); ?></h1></div>
                <?php if (!is_paged()) :?>  
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <article class="top_rating_text post"><?php the_content(); ?></article>
                            <div class="clearfix"></div>
                        <?php endwhile; endif; ?>                
                <?php endif; ?>
                <?php if ($module_enable !='1') :?>


                	<?php if ($module_ids !='') :?>
    	                <?php $query = array( 
    	                    'post_status' => 'publish', 
    	                    'ignore_sticky_posts' => 1, 
    	                    'orderby' => 'post__in',
    	                    'post__in' => $module_ids,
                            'posts_per_page'=> -1,

    	                );
    	                ?>
                	<?php else :?>
    	                <?php $query = array( 
                            'posts_per_page' => 5,  
    	                    'post_status' => 'publish', 
    	                    'ignore_sticky_posts' => 1, 
    	                );
    	                ?>                                		
                	<?php endif ;?>
                    <?php if (post_type_exists( $type_chart )) {$query['post_type'] = $type_chart;} ?>	

                    <?php 
                    if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){
         
                        $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
                        $_REQUEST['mdf_get_query_args_only'] = true;
                        do_shortcode('[meta_data_filter_results]');
                        $args = $_REQUEST['meta_data_filter_args'];
                        global $wp_query;
                        $wp_query=new WP_Query($args);
                        $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
                    }
                    else { $wp_query = new WP_Query($query); }    
                    $i=0; if ($wp_query->have_posts()) :?>
                    <?php wp_enqueue_script('carouFredSel'); wp_enqueue_script('touchswipe'); ?>                                       
                    <div class="top_chart<?php if ($wp_query->found_posts <= 3) {echo ' table_view_charts';} ;?>">
                        <div class="top_chart_controls">
                            <a href="/" class="controls prev"></a>
                            <div class="top_chart_pagination"></div>
                            <a href="/" class="controls next"></a>
                        </div>
                        <div class="top_chart_first">
                            <ul>
                            <?php if (!empty ($rows)) {
                                $nameid=0;                       
                                foreach ($rows as $row) {   
                                $element_type = $row['column_type'];                    
                                echo '<li class="row_chart_'.$nameid.' '.$element_type.'_row_chart"><div>'.esc_html($row["column_name"]).'</div></li>';
                                $nameid++;
                                } 
                            }
                            ?>
                            </ul>
                        </div>
                    <div class="top_chart_wrap"><div class="top_chart_carousel">
                    <?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i ++?>     
                        <div class="top_rating_item top_chart_item" id='rank_<?php echo $i?>'>
                            <?php if(vp_metabox('rehub_post_side.is_editor_choice') == '1') :?><div class="ed_choice_label"><img src="<?php echo get_template_directory_uri(); ?>/images/editor_badge.png" width="65" height="64" alt=""></div><?php endif; ?>                           
                            <ul>
                            <?php 
                            if (!empty ($rows)) {
                                $pbid=0;                       
                                foreach ($rows as $row) {                                                     
                                $element = $row['column_type'];
                                    echo '<li class="row_chart_'.$pbid.' '.$element.'_row_chart">';
                                    if ($element == 'meta_value') {                                
                                        include(locate_template('inc/top/metarow.php'));
                                    } else if ($element == 'image') {
                                        include(locate_template('inc/top/imagerow.php'));
                                    } else if ($element == 'title') {
                                        include(locate_template('inc/top/titlerow.php'));   
                                    } else if ($element == 'taxonomy_value') {
                                        include(locate_template('inc/top/taxonomyrow.php'));                                                                           
                                    } else if ($element == 'affiliate_btn') {
                                        include(locate_template('inc/top/btnrow.php'));
                                    } else if ($element == 'review_link') {
                                        include(locate_template('inc/top/reviewlinkrow.php'));
                                    } else if ($element == 'review_function') {
                                        include(locate_template('inc/top/reviewrow.php'));                                    
                                    } else if ($element == 'user_review_function') {
                                        include(locate_template('inc/top/userreviewcolumn.php'));                                                                          
                                    } else {   
                                    };
                                    echo '</li>';
                                $pbid++;
                                } 
                            }
                            ?>
                        </ul>
                        </div>
                    <?php endwhile; ?>
                    </div></div>
                    </div>
                    <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?> 


                <?php endif; ?>
			</div>	
            <!-- /Main Side -->  
            <?php if ($module_width !='1') : ?>
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 
            <?php endif;?>
        </div>
    </div>
    <!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>
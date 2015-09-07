<?php

    /* Template Name: Full width */

?>
<?php get_header(); ?>
    <!-- CONTENT -->
    <div class="content"> 
		<div class="clearfix">
		      <!-- Main Side -->
              <div class="main-side page clearfix full_width">
                <div class="title"><h1><?php the_title(); ?></h1></div>
                <article class="post" id="page-<?php the_ID(); ?>">				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                  <?php the_content(); ?>
                  <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rehub_child' ), 'after' => '</div>' ) ); ?>
                <?php endwhile; endif; ?>                 
                </article>
               <?php comments_template(); ?>
			</div>	
            <!-- /Main Side -->  
        </div>
    </div>
    <!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>
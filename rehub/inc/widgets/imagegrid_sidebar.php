<?php
/**
 * Plugin Name: News Widget
 */

add_action( 'widgets_init', 'rehub_postimageside_load_widget' );

function rehub_postimageside_load_widget() {
	register_widget( 'rehub_postimageside_widget' );
}

class rehub_postimageside_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function rehub_postimageside_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'postimageside', 'description' => __('Widget that displays custom featured slider of posts. Use only in sidebar!', 'rehub_framework') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'rehub_postimageside' );

		/* Create the widget. */
		$this->WP_Widget( 'rehub_postimageside', __('ReHub: Featured Slider', 'rehub_framework'), $widget_ops, $control_ops );
	}

/**
 * How to display the widget on the screen.
 */
function widget( $args, $instance ) {
	extract( $args );

	/* Our variables from the widget settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	$tags = $instance['tags'];
	$number = $instance['number'];
	global $post;
	
	if(!empty($tags)) :
		$query = array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'tag' => $tags);
	else :
		$query = array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
	endif;	
	$loop = new WP_Query($query);
	
	/* Before widget (defined by themes). */
	echo $before_widget;

	if ($loop->have_posts()) :

	/* Display the widget title if one was input (before and after defined by themes). */
	if ( $title )
		echo $before_title . $title . $after_title;
	?>
		<div class="postimageside">		
		<?php  while ($loop->have_posts()) : $loop->the_post(); ?>
		<?php $img = get_post_thumb(); ?>	
		<div class="wrap">
			<a href="<?php the_permalink();?>" class="view-link">
				<?php wpsm_thumb ('grid_news') ?>
				<h4><?php the_title();?></h4>
			</a>	
		</div>	
		<?php endwhile; ?>
		</div>
		<?php wp_reset_query(); ?>
		<?php endif; ?>
			
	<?php

	/* After widget (defined by themes). */
	echo $after_widget;
}


	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['tags'] = strip_tags($new_instance['tags']);
		$instance['number'] = strip_tags( $new_instance['number'] );

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Featured', 'rehub_framework'), 'number' => 5, 'tag' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tags' ); ?>"><?php _e('Enter tag slug:', 'rehub_framework'); ?></label>
			<input  type="text" class="widefat" id="<?php echo $this->get_field_id( 'tags' ); ?>" name="<?php echo $this->get_field_name( 'tags' ); ?>" value="<?php echo $instance['tags']; ?>"  />
		</p>

	<?php
	}
}

?>
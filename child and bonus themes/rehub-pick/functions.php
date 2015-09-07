<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_deregister_style('responsive');
    wp_deregister_style('rehub_shortcode');
    wp_enqueue_style('main_nav', '//fonts.googleapis.com/css?family=Open+Sans:400,700');
}
add_action( 'wp_enqueue_scripts', 'dequeue_parent_theme_style', 100 );
function dequeue_parent_theme_style() {
    wp_dequeue_style( 'default_font' );
}


// repick scripts
function repick_js_scripts() {
	wp_enqueue_script( 'repick_js', get_stylesheet_directory_uri().'/js/repick_js.js', array('jquery'), '1.0', 1 );
	wp_localize_script( 'repick_js', 'ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce'),
			'max_temp' => REHUB_MAX_TEMP,
			'min_temp' => REHUB_MIN_TEMP,

		)
	);
}
add_action('wp_enqueue_scripts','repick_js_scripts', 11);

//////////////////////////////////////////////////////////////////
// Translation
//////////////////////////////////////////////////////////////////
add_action('after_setup_theme', 'rehub_child_lang_setup');
function rehub_child_lang_setup(){
    load_child_theme_textdomain('rehub_child', get_stylesheet_directory() . '/lang');
}



if ( !function_exists( 'rehub_image_sizes' ) ) {
	function rehub_image_sizes() {
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1150, 0, false );
		if( rehub_option( 'aq_resize_crop') == '1') {
			//add_image_size( 'feature_slider', 785, 0, false );
			add_image_size( 'med_thumbs', 123, 0, false );	
			add_image_size( 'grid_news', 336, 0, true );

		}
		else {
			//add_image_size( 'feature_slider', 785, 510, true );
			add_image_size( 'med_thumbs', 123, 90, true );
			add_image_size( 'grid_news', 336, 220, true );				
		}
	}
}



//unregister some parent widgets
add_action( 'widgets_init', 'rehub_parent_unregister_widgets', 11 );
function rehub_parent_unregister_widgets() {
    unregister_widget( 'rehub_latest_videopost_widget' );
    unregister_widget( 'rehub_tabs_widget' );
}
include (STYLESHEETPATH . '/inc/widgets/tabs_widget.php');

if( !function_exists('rehub_top_offers_widget_block_post') ) {
function rehub_top_offers_widget_block_post($tags = '', $number = '5', $order = '') { ?>

	<?php $args = array (
			'showposts' => $number,
			'tag' => $tags,
			'ignore_sticky_posts' => '1'
		);
		if (!empty ($order)) {
			$args ['meta_key'] = $order;
			$args ['orderby'] = 'meta_value_num';
			$args ['order'] = 'DESC';
		}
	$offers = new WP_Query($args);
	if($offers->have_posts()): ?>
	
	<div class="tabs-item">
		<?php  while ($offers->have_posts()) : $offers->the_post(); ?>
		
			<div class="clearfix">
	            <figure><a href="<?php the_permalink();?>"><?php wpsm_thumb ('med_thumbs') ?></a></figure>
	            <div class="detail">
		            <h5><?php echo getHotLikeTitle(get_the_ID()); ?><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
	            	<div class="rcnt_meta">
	              		<?php $category = get_the_category(get_the_ID()); $first_cat = $category[0]->term_id;?>
	                	<?php meta_small( false, $first_cat, true, false );  ?>
	                </div>
	                <?php rehub_format_score('small') ?>

	            </div>
            </div>
		
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		<?php endif; ?>
	</div>

<?php
}
}

if( !function_exists('rehub_most_popular_widget_block') ) {
function rehub_most_popular_widget_block($basedby = 'hot', $sortby = '', $number = 5) { ?>

	<?php 
	if($sortby == 'this_week') {
	if( !function_exists('filter_where_week') ) {
		function filter_where_week($where = '') {
			//posts in the last 7 days
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
			return $where;
		}
	}
	add_filter('posts_where', 'filter_where_week');
	} elseif($sortby == 'this_month') {
	if( !function_exists('filter_where_month') ) {
		function filter_where_month($where = '') {
			//posts in the last 30 days
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
			return $where;
		}
	}
	add_filter('posts_where', 'filter_where_month');
	} elseif($sortby == 'three_month') {
	if( !function_exists('filter_where_t_month') ) {
		function filter_where_t_month($where = '') {
			//posts in the last 30 days
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-90 days')) . "'";
			return $where;
		}
	}
	add_filter('posts_where', 'filter_where_t_month');
	}
	else {}	
	global $post;
	if ($basedby == 'hot') {$popular_posts = new WP_Query('showposts='.$number.'&meta_key=post_hot_count&orderby=meta_value_num&order=DESC&ignore_sticky_posts=1');}
	elseif ($basedby == 'views') {$popular_posts = new WP_Query('showposts='.$number.'&meta_key=rehub_views&orderby=meta_value_num&order=DESC&ignore_sticky_posts=1');}
	else {$popular_posts = new WP_Query('showposts='.$number.'&orderby=comment_count&order=DESC&ignore_sticky_posts=1');}	
	if($popular_posts->have_posts()): ?>
	
	
		<?php  while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
			<div class="clearfix">
	            <figure><a href="<?php the_permalink();?>"><?php wpsm_thumb ('med_thumbs') ?></a></figure>
	            <div class="detail">
		            <h5><?php if ($basedby == 'hot') {echo getHotLikeTitle(get_the_ID());} ;?><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
	            	<div class="rcnt_meta">
	              		<?php $category = get_the_category($post->ID); $first_cat = $category[0]->term_id;?>
	                	<?php if ($basedby == 'views') {meta_small( false, $first_cat, false, true );} else {meta_small( false, $first_cat, true, false );}  ?>
	                </div>
					<?php
						$quick_price = get_post_meta( get_the_ID(), 'rehub_offer_product_price', true ); 
						$egg_price = get_post_meta( get_the_ID(), 'affegg_product_price', true );
						if (!empty ($quick_price)) {
							echo '<span class="price_count">'.$quick_price.'</span>';
						}
						elseif (!empty ($egg_price)) {
							$re_egg_currency = get_post_meta( get_the_ID(), 'affegg_product_currency', true );
					        $types = array("RUB" => "руб.", "UAH" => "грн.", "USD" => "$", "CAD" => "$", "GBP" => "&pound;", "EUR" => "&euro;", "JPY" => "&yen;", "CNY" => "&yen;", "INR" => "&#8377;");
					        if (key_exists($re_egg_currency, $types)) {
					            $re_egg_currency = $types[$re_egg_currency];
					        }
							echo '<span class="price_count">'.$re_egg_currency.$egg_price.'</span>';
						}	
					?>
	            </div>
            </div>
		
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		<?php endif; 
		remove_filter('posts_where', 'filter_where_month'); 
		remove_filter('posts_where', 'filter_where_t_month'); 
		remove_filter('posts_where', 'filter_where_week');?>


<?php
}
}


//VC init
if (class_exists('WPBakeryVisualComposerAbstract')) {
	function rehub_vc_styles() {
		wp_enqueue_style('rehub_vc', get_stylesheet_directory_uri() .'/functions/vc/vc.css', array(), time(), 'all');
	}	
}

//////////////////////////////////////////////////////////////////
// Hot meter
//////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_nopriv_hot-count', 'hot_count' );
add_action( 'wp_ajax_hot-count', 'hot_count' );

function hot_count() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
	
	if ( isset( $_POST['hot_count'] ) ) {	
		$post_id = $_POST['post_id']; // post id
		$post_hot_count = get_post_meta( $post_id, "post_hot_count", true ); // post like count		
		if ( is_user_logged_in() ) { // user is logged in
			global $current_user;
			$user_id = $current_user->ID; // current user
			$meta_POSTS = get_user_meta( $user_id, "_liked_posts" ); // post ids from user meta
			$meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
			$liked_POSTS = ""; // setup array variable
			$liked_USERS = ""; // setup array variable			
			if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
				$liked_POSTS = $meta_POSTS[0];
			}			
			if ( !is_array( $liked_POSTS ) ) // make array just in case
				$liked_POSTS = array();				
			if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
				$liked_USERS = $meta_USERS[0];
			}		
			if ( !is_array( $liked_USERS ) ) // make array just in case
				$liked_USERS = array();				
			$liked_POSTS['post-'.$post_id] = $post_id; // Add post id to user meta array
			$liked_USERS['user-'.$user_id] = $user_id; // add user id to post meta array
			$user_likes = count( $liked_POSTS ); // count user likes

			if ($_POST['hot_count'] =='hot') {				
				if ( !AlreadyHot( $post_id ) ) {
					update_post_meta( $post_id, "post_hot_count", ++$post_hot_count ); // +1 count post meta
					update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Add user ID to post meta
					update_user_meta( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_meta( $user_id, "_user_like_count", $user_likes ); // +1 count user meta					
				} 
				else {
					update_post_meta( $post_id, "post_hot_count", $post_hot_count+2 );
				}		
			}
			if ($_POST['hot_count'] =='cold') {
				if ( !AlreadyHot( $post_id ) ) {
					update_post_meta( $post_id, "post_hot_count", --$post_hot_count ); // -1 count post meta
					update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Add user ID to post meta
					update_user_meta( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_meta( $user_id, "_user_like_count", $user_likes ); // +1 count user meta					
				} 
				else {
					update_post_meta( $post_id, "post_hot_count", $post_hot_count-2 );
				}										
			}			
			
		} else { // user is not logged in (anonymous)
			$ip = $_SERVER['REMOTE_ADDR']; // user IP address
			$meta_IPS = get_post_meta( $post_id, "_user_IP" ); // stored IP addresses
			$liked_IPS = ""; // set up array variable			
			if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
				$liked_IPS = $meta_IPS[0];
			}	
			if ( !is_array( $liked_IPS ) ) // make array just in case
				$liked_IPS = array();				
			if ( !in_array( $ip, $liked_IPS ) ) // if IP not in array
				$liked_IPS['ip-'.$ip] = $ip; // add IP to array	

			if ($_POST['hot_count'] =='hot') {				
				if ( !AlreadyHot( $post_id ) ) {
					update_post_meta( $post_id, "post_hot_count", ++$post_hot_count ); // +1 count post meta
					update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Add user IP to post meta					
				} 
				else {
					update_post_meta( $post_id, "post_hot_count", $post_hot_count+2 );
				}		
			}
			if ($_POST['hot_count'] =='cold') {
				if ( !AlreadyHot( $post_id ) ) {
					update_post_meta( $post_id, "post_hot_count", --$post_hot_count ); // -1 count post meta
					update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Add user IP to post meta					
				} 
				else {
					update_post_meta( $post_id, "post_hot_count", $post_hot_count-2 );
				}										
			}
		}
	}
	exit;
}

function AlreadyHot( $post_id ) { // test if user liked before
	
	if ( is_user_logged_in() ) { // user is logged in
		global $current_user;
		$user_id = $current_user->ID; // current user
		$meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
		$liked_USERS = ""; // set up array variable		
		if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
			$liked_USERS = $meta_USERS[0];
		}		
		if( !is_array( $liked_USERS ) ) // make array just in case
			$liked_USERS = array();			
		if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
			return true;
		}
		return false;		
	} 
	else { // user is anonymous, use IP address for voting	
		$meta_IPS = get_post_meta($post_id, "_user_IP"); // get previously voted IP address
		$ip = $_SERVER["REMOTE_ADDR"]; // Retrieve current user IP
		$liked_IPS = ""; // set up array variable
		if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
			$liked_IPS = $meta_IPS[0];
		}
		if ( !is_array( $liked_IPS ) ) // make array just in case
			$liked_IPS = array();
		if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
			return true;
		}
		return false;
	}	
}

function getHotLike( $post_id ) {
	$max_temp= REHUB_MAX_TEMP; //max temperature
	$min_temp= REHUB_MIN_TEMP; //min temperature	
	$like_count = get_post_meta( $post_id, "post_hot_count", true ); // get post likes
	if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
		$temp = '0';
	} elseif ( $like_count && $like_count != "0" ) { // there are votes!
		$temp = esc_attr( $like_count );
	}
	$output = '<div class="hotmeter_wrap"><div class="hotmeter"><span class="table_cell_hot first_cell"><span id="temperatur'.$post_id.'" class="temperatur';
	if ($temp < 0) :
		$output .= ' cold_temp';
	endif;
	$output .= '">'.$temp.'&deg;</span></span> ';
	$output .= '<span class="table_cell_hot">';
	if ( AlreadyHot( $post_id ) ) { // already liked, set up unlike addon
		$output .= '<button class="hotminus alreadyhot" alt="Vote Down" title="Vote Down" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
	} else { // normal like button
		$output .= '<button class="hotminus" alt="Vote Down" title="Vote Down" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
	}
	$output .= '</span><span class="table_cell_hot">';
	if ( AlreadyHot( $post_id ) ) { // already liked, set up unlike addon
		$output .= '<button class="hotplus alreadyhot" alt="Vote Up" title="Vote Up" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
	} else { // normal like button
		$output .= '<button class="hotplus" alt="Vote Up" title="Vote Up" data-post_id="'.$post_id.'" data-informer="'.$temp.'"></button>';
	}
	$output .= '</span>';
    $output .= '<span id="textinfo'.$post_id.'" class="textinfo table_cell_hot"></span>';

	$output .= '<div class="table_cell_hot fullwidth_cell">';
	if ($temp >= $max_temp) :
		$temp = $max_temp;
	    $output .= '<span class="temp_image hot_image"></span>';
	elseif ($temp <= $min_temp) :
		$temp = $min_temp;
	    $output .= '<span class="temp_image cold_image"></span>';
	endif;
	$output .= '<div id="fonscale'.$post_id.'" class="fonscale">';		
	$output .= '<div id="scaleperc'.$post_id.'" class="scaleperc';
	if ($temp < 0) :
		$output .= ' cold_bar';
	endif;
	$output .= '" style="width:';
 	if ($temp >= 0) :
 		$output .= ''.($temp / $max_temp * 100).'%">';
 	else:
 		$output .= ''.($temp / $min_temp * 100).'%">';
 	endif;
 	$output .= '</div></div></div></div></div>';	

	if (rehub_option('exclude_hotmeter') !='1') {
		return $output;
	}
	else {
		return false;
	}
}
function getHotLikeTitle( $post_id ) {
	$like_count = get_post_meta( $post_id, "post_hot_count", true ); // get post likes
	if ( ( !$like_count ) || ( $like_count && $like_count == "0" ) ) { // no votes, set up empty variable
		$temp = '0';
	} elseif ( $like_count && $like_count != "0" ) { // there are votes!
		$temp = esc_attr( $like_count );
	}
	$output = '<span id="temperatur'.$post_id.'" class="temperatur';
	if ($temp < 0) :
		$output .= ' cold_temp';
	endif;
	$output .= '">'.$temp.'&deg;</span> ';
	return $output;
}

/*-----------------------------------------------------------------------------------*/
# 	Hook offer after content 
/*-----------------------------------------------------------------------------------*/
if( !function_exists('set_content_end') ) {
function set_content_end($content) {
	global $post;
	
	if( is_feed() ) return $content;
	
	$output = '';
		ob_start();
		wp_link_pages(array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rehub_child' ), 'after' => '</div>' ));
		$output .= ob_get_clean(); 

	$offer_url_exist = get_post_meta( $post->ID, 'rehub_offer_product_url', true );
	if (!empty($offer_url_exist)) :
		$offer_shortcode = get_post_meta( $post->ID, 'rehub_offer_shortcode', true );
		if (empty($offer_shortcode)) :
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';
			rehub_quick_offer();
			$output .= ob_get_clean();
		endif;
	elseif(vp_metabox('rehub_post.rehub_framework_post_type') == 'review') :
		if(vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_offer_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_post_review_product') :
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';
			rehub_get_offer();
			$output .= ob_get_clean();
		endif;
		if(vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_offer_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_aff_product') :
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';		
			rehub_get_aff_offer();
			$output .= ob_get_clean();
		endif;
		if(vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_offer_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') :
			$review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';			
			rehub_get_woo_offer($review_woo_link);
			$output .= ob_get_clean();		
		endif;
		if(vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_list') :	
			$review_woo_list_links = vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_links');
			if (is_array($review_woo_list_links)) { $review_woo_list_links = implode(',', $review_woo_list_links); }
			ob_start();
			echo '<div class="lined_r_title">'.__('Where to buy', 'rehub_child').'</div>';
			rehub_get_woo_list($data_source = 'ids', $type ='', $cat = '', $tag = '', $ids = $review_woo_list_links);
			$output .= ob_get_clean();			
		endif;
	endif; 

	if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_product_shortcode') == '0') :
		$overal_score = rehub_get_overall_score(); 
		$postAverage = get_post_meta(get_the_ID(), 'post_user_average', true);
		ob_start();
		if ((rehub_option('type_user_review') == 'full_review') && ($postAverage !='0' && $postAverage !='' )) :
			echo '<div class="lined_r_title">'.__('Review Score', 'rehub_child').'</div>';
		elseif ($overal_score !='0' && $overal_score !=''):
			echo '<div class="lined_r_title">'.__('Review Score', 'rehub_child').'</div>';
		endif;	
		rehub_get_review();
		$output .= ob_get_clean();
	endif;	

	return $content.$output;
}
}

if( !function_exists('rehub_create_top_btn') ) {
function rehub_create_top_btn () {
	?>
		<?php 
			$aff_url_exist = get_post_meta( get_the_ID(), 'affegg_product_orig_url', true ); 
			$offer_url_exist = get_post_meta( get_the_ID(), 'rehub_offer_product_url', true );
			$amazon_search_words = vp_metabox('rehub_post_side.amazon_search_words'); 
			$ebay_search_words = vp_metabox('rehub_post_side.ebay_search_words');
			if (!empty($amazon_search_words)) {
				$rehub_amazon_btn = (rehub_option('rehub_amazon_btn') !='') ? rehub_option('rehub_amazon_btn') : __('Search on Amazon', 'rehub_child');
				$rehub_amazon_surl = (rehub_option('rehub_amazon_surl') !='') ? rehub_option('rehub_amazon_surl') : 'http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=aps&linkCode=ur2&tag=wpsoul-20';
				$amazon_link = '<a href="'.$rehub_amazon_surl.'&keywords='.esc_html($amazon_search_words).'" target="_blank" rel="nofollow">'.$rehub_amazon_btn.'</a>';
			}
			else {
				$amazon_link ='';
			}
			if (!empty($ebay_search_words)) {
				$rehub_ebay_btn = (rehub_option('rehub_ebay_btn') !='') ? rehub_option('rehub_ebay_btn') : __('Search on Ebay', 'rehub_child');
				$rehub_ebay_surl = (rehub_option('rehub_ebay_surl') !='') ? rehub_option('rehub_ebay_surl') : 'http://rover.ebay.com/rover/1/711-53200-19255-0/1?icep_ff3=9&pub=5575130199&toolid=10001&campid=5337712872&customid=&icep_sellerId=&icep_ex_kw=&icep_sortBy=12&icep_catId=&icep_minPrice=&icep_maxPrice=&ipn=psmain&icep_vectorid=229466&kwid=902099&mtid=824&kw=lg';
				$ebay_link = '<a href="'.$rehub_ebay_surl.'&icep_uq='.esc_html($ebay_search_words).'" target="_blank" rel="nofollow">'.$rehub_ebay_btn.'</a>';
			}	
			else {
				$ebay_link ='';
			}					

		if (!empty($aff_url_exist)) : ?>

			<?php if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
				include(locate_template( 'inc/parts/affeggbuttontop.php' ) );
			} ?>	 
		
		<?php elseif (!empty($offer_url_exist)) : ?>

			<?php
				$offer_url = $offer_url_exist;  
			 	$offer_price = get_post_meta( get_the_ID(), 'rehub_offer_product_price', true ); 
			 	$offer_btn_text = get_post_meta( get_the_ID(), 'rehub_offer_btn_text', true ); 		 	
			?>
			<div class="right_aff">			
		        <div class="priced_block clearfix">
		            <?php if(!empty($offer_price)) : ?>
		            	<p> 
		            		<span class="price_count">
		            			<span class="amount"><?php echo esc_html($offer_price) ?></span>
		            		</span>
		            	</p>
		            <?php endif ;?>            
			            <div>
				            <a href="<?php echo esc_url ($offer_url) ?>" class="btn_offer_block" target="_blank" rel="nofollow">
				            <?php if($offer_btn_text !='') :?>
				            	<?php echo esc_html ($offer_btn_text); ?>
				            <?php elseif(rehub_option('rehub_btn_text') !='') :?>
				            	<?php echo rehub_option('rehub_btn_text') ; ?>
				            <?php else :?>
				            	<?php _e('Buy now', 'rehub_child') ?>
				            <?php endif ;?>
				            </a>
			            </div>
		        </div>
		        <div class="ameb_search"><?php echo $amazon_link; echo $ebay_link;?></div>		        
	        </div>

		<?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') :?>
        	<?php $review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');?>
        	<?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_child') ;?><?php endif ;?>
        	<?php global $woocommerce; global $post;$backup=$post; if($woocommerce) :?>
				<?php 	
					$args = array(
						'post_type' 		=> 'product',
						'posts_per_page' 	=> 1,
						'no_found_rows' 	=> 1,
						'post_status' 		=> 'publish',
						'p'					=> $review_woo_link,

					);
				?>
				<?php $products = new WP_Query( $args ); if ( $products->have_posts() ) : ?>
					<?php while ( $products->have_posts() ) : $products->the_post(); global $product?>
					<?php $offer_price = $product->get_price_html() ?>	
					<div class="right_aff">
						<div class="priced_block clearfix">
			                <?php if(!empty($offer_price)) : ?><p> <span class="price_count"><?php echo $offer_price ?></span></p><?php endif ;?>
			                <div>
			                	<?php if ($product->product_type =='external' && $product->add_to_cart_url() =='') :?>
			                		<a class='btn_offer_block' href="<?php the_permalink();?>" target="_blank"><?php _e('Prices', 'rehub_child') ;?></a>
			                	<?php else :?>
			                    	<?php if ( $product->is_in_stock() ) : ?>
										<?php  
											echo apply_filters( 'woocommerce_loop_add_to_cart_link',
											sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="btn_offer_block %s product_type_%s">%s</a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( $product->id ),
											esc_attr( $product->get_sku() ),
											$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
											esc_attr( $product->product_type ),
											esc_html( $btn_txt )
											), $product );
										?>
	    							<?php endif; ?>
								<?php endif; ?>
			                </div>
			            </div>
		        		<div class="ameb_search"><?php echo $amazon_link; echo $ebay_link;?></div>			            
		            </div>
				<?php endwhile; endif;  wp_reset_postdata(); $post=$backup; ?> 
        	<?php endif ;?>


	    <?php endif ;?>
	<?php
}
}

//////////////////////////////////////////////////////////////////
// Home filter ajax
//////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_picker_home', 'ajax_action_picker_home' );
add_action( 'wp_ajax_nopriv_picker_home', 'ajax_action_picker_home' );
if( !function_exists('ajax_action_picker_home') ) {
function ajax_action_picker_home() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );   
		$data = $_POST; 
		$query_args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 12,
			'ignore_sticky_posts' => 1,
		);
		if ($data['sorttype'] =='hot') {
			$query_args['meta_key'] = 'post_hot_count';
			$query_args['orderby'] = 'meta_value_num';
		}
		elseif ($data['sorttype'] =='popular') {
			$query_args['meta_key'] = 'rehub_views';
			$query_args['orderby'] = 'meta_value_num';
		}
		elseif ($data['sorttype'] =='bestprice') {
			$query_args['meta_key'] = rehub_option('rehub_home_price');
			$query_args['orderby'] = 'meta_value_num';
			$query_args['order'] = 'ASC';
		}	
		elseif ($data['sorttype'] =='mostprice') {
			$query_args['meta_key'] = rehub_option('rehub_home_price');
			$query_args['orderby'] = 'meta_value_num';
			$query_args['order'] = 'DESC';
		}
		elseif ($data['sorttype'] =='random') {
			$query_args['orderby'] = 'rand';
		}
		if (isset ($data['offset']) && !empty ($data['offset'])) {$query_args['offset'] = $data['offset'];}	
		$offset = (isset ($data['offset']) && !empty ($data['offset'])) ? $data['offset'] + 12 : 12;						
		$wp_query = new WP_Query($query_args);
        $count = 0; 		
		if ( $wp_query->have_posts() ) {
			$response = '<div class="masonry_grid_fullwidth three-col-gridhub">';
			while ($wp_query->have_posts() ) {
				$wp_query->the_post(); 				
				ob_start();
                $count++; 				
				include(locate_template('inc/parts/query_type3.php'));
				$response .= ob_get_clean();	
			}
				$response .='</div><div class="clearfix"></div>';
				$response .='<div class="more_post onclick home_picker_next"><span data-sorttype="'.$data['sorttype'].'" data-offset="'.$offset.'">' . __('Next posts', 'rehub_child') . '</span></div>';						
		} else {
			$response = '<div><span class="no_more_posts">'.__('No more posts!', 'rehub_child').'<span></div><div class="clearfix"></div>';
		}
		
		
		wp_reset_postdata();		

		echo $response ;
		exit;
}
}
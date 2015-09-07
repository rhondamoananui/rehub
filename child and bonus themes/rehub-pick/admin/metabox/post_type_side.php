<?php

return array(
	'id'          => 'rehub_post_side',
	'types'       => array('post'),
	'title'       => __('Post settings', 'rehub_child'),
	'priority'    => 'low',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'context'     => 'side',
	'template'    => array(

		array(
			'type' => 'textbox',
			'name' => 'read_more_custom',
			'label' => __('Read More custom text', 'rehub_child'),
			'description' => __('Will be used in some blocks instead of default read more text', 'rehub_child'),
			'default' => '',
		),	

		array(
			'type' => 'textbox',
			'name' => 'amazon_search_words',
			'label' => __('Search on amazon keyword', 'rehub_child'),
			'description' => __('Will be used in top offer block', 'rehub_child'),
			'default' => '',
		),	

		array(
			'type' => 'textbox',
			'name' => 'ebay_search_words',
			'label' => __('Search on ebay keyword', 'rehub_child'),
			'description' => __('Will be used in top offer block', 'rehub_child'),
			'default' => '',
		),			

		array(
			'type' => 'toggle',
			'name' => 'disable_left_image',
			'label' => __('Disable Left align of featured image', 'rehub_child'),
			'default' => '0',
		),	

		array(
			'type' => 'toggle',
			'name' => 'disable_top_offer',
			'label' => __('Disable top offer block', 'rehub_child'),
			'default' => '0',
		),					

		array(
			'type' => 'radiobutton',
			'name' => 'post_size',
			'label' => __('Post w/ sidebar or Full width', 'rehub_child'),
			'description' => __('Note, normal post width - 765px, full width - 1130px', 'rehub_child'),
			'default' => 'full_post',
			'items' => array(
				array(
					'value' => 'normal_post',
					'label' => __('Post w/ Sidebar', 'rehub_child'),
				),
				array(
					'value' => 'full_post',
					'label' => __('Full Width Post', 'rehub_child'),
				)
			),
	        'default' => array(
	            'normal_post',
	        ),			
		),

 		array(
			'type' => 'toggle',
			'name' => 'is_editor_choice',
			'label' => __('Editor choice label', 'rehub_child'),
			'description' => __('Check this box if you want to show "Editor\'s Choice" label', 'rehub_child'),
		),

		array(
			'type' => 'toggle',
			'name' => 'show_featured_image',
			'label' => __('Disable Featured Image, Video or Gallery in top part on post page', 'rehub_child'),
			'default' => '0',
		),	
		array(
			'type' => 'toggle',
			'name' => 'disable_parts',
			'label' => __('Disable parts?', 'rehub_framework'),
			'description' => __('Check this box if you want to disable tags, breadcrumbs, author box, share buttons in post', 'rehub_child'),
		), 						
		array(
			'type' => 'toggle',
			'name' => 'show_banner_ads',
			'label' => __('Disable global ads in this post', 'rehub_child'),
			'description' => '',
			'default' => '0',		
		),		
	),
);

/**
 * EOF
 */
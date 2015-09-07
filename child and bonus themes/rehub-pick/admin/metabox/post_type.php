<?php

return array(
	'id'          => 'rehub_post',
	'types'       => array('post'),
	'title'       => __('Post Type', 'rehub_child'),
	'priority'    => 'high',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(
		array(
			'type' => 'radioimage',
			'name' => 'rehub_framework_post_type',
			'label' => __('Choose Type of Post', 'rehub_child'),
			'description' => '',
			'items' => array(
				array(
					'value' => 'regular',
					'label' => __('Regular', 'rehub_child'),
					'img' => REHUB_ADMIN_URI . '/public/img/regular_post_icon.png',
				),
				array(
					'value' => 'video',
					'label' => __('Video', 'rehub_child'),
					'img' => REHUB_ADMIN_URI . '/public/img/video_post_icon.png',
				),
				array(
					'value' => 'gallery',
					'label' => __('Gallery', 'rehub_child'),
					'img' => REHUB_ADMIN_URI . '/public/img/gallery_post_icon.png',
				),
				array(
					'value' => 'review',
					'label' => __('Review', 'rehub_child'),
					'img' => REHUB_ADMIN_URI . '/public/img/review_post_icon.png',
				),
				array(
					'value' => 'music',
					'label' => __('Music', 'rehub_child'),
					'img' => REHUB_ADMIN_URI . '/public/img/music_post_icon.png',
				),			
			),
			'default' => 'regular'
		),
		
		
		// video group
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'video_post',
			'title'     => __('Video Post', 'rehub_child'),
			'dependency' => array(
				'field'    => 'rehub_framework_post_type',
				'function' => 'rehub_framework_post_type_is_video',
			),
			'fields'    => array(
				// embed
				array(
					'type' => 'textbox',
					'name' => 'video_post_embed_url',
					'description' => __('Insert youtube or vimeo link on page with video', 'rehub_child'),
					'label' => __('Video Url', 'rehub_child'),
				),				

				array(
					'type' => 'toggle',
					'name' => 'video_post_schema',
					'label' => __('Enable schema.org for video?', 'rehub_child'),
					'description' => __('Check this box if you want to enable videoobject schema', 'rehub_child'),
				),	
				array(
					'type' => 'textbox',
					'name' => 'video_post_schema_title',
					'label' => __('Title', 'rehub_child'),
					'description' => __('Set title of video block or leave blank to use post title', 'rehub_child'),					
					'dependency' => array(
                         'field' => 'video_post_schema',
                         'function' => 'vp_dep_boolean',
                    ),
					'default' => '',
				),
				array(
					'type' => 'textbox',
					'name' => 'video_post_schema_desc',
					'label' => __('Description', 'rehub_child'),
					'description' => __('Set description of video block or leave blank to use post excerpt', 'rehub_child'),					
					'dependency' => array(
                         'field' => 'video_post_schema',
                         'function' => 'vp_dep_boolean',
                    ),
					'default' => '',
				),
				array(
					'type' => 'toggle',
					'name' => 'video_post_schema_thumb',
					'label' => __('Auto thumbnail', 'rehub_child'),
					'description' => __('Enable auto thumbnails or use post thumbnail. Note, that this thumbnail is not visible in post but can be use in seo snippet', 'rehub_child'),
					'dependency' => array(
                         'field' => 'video_post_schema',
                         'function' => 'vp_dep_boolean',
                    ),					
				),																			
			),
		),
		// gallery group
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'gallery_post',
			'title'     => __('Gallery Post', 'rehub_child'),
			'dependency' => array(
				'field'    => 'rehub_framework_post_type',
				'function' => 'rehub_framework_post_type_is_gallery',
			),
			
			'fields'    => array(
				array(
					'type' => 'toggle',
					'name' => 'gallery_post_images_resize',
					'label' => __('Disable height resize for slider', 'rehub_child'),
					'description' => __('This option disable resize of photo. By default, photos are resized for 400 px height', 'rehub_child'),												
				),				
				array(
					'type'      => 'group',
					'repeating' => true,
					'sortable'  => true,
					'name'      => 'gallery_post_images',
					'title'     => __('Image', 'rehub_child'),
					'fields'    => array(
						array(
							'type'      => 'upload',
							'name'      => 'gallery_post_image',
							'label'     => __('Add Image', 'rehub_child'),
						),
						array(
							'type'      => 'textbox',
							'name'      => 'gallery_post_image_caption',
							'label'     => __('Caption', 'rehub_child'),
						),
						array(
							'type' => 'textbox',
							'name' => 'gallery_post_video',
							'description' => __('Insert youtube link of page with video. If you set this field, image and caption will be ignored for this slide', 'rehub_child'),
							'label' => __('Video Url', 'rehub_child'),
						),													
					),
				),
			),
		),
		// review group
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'review_post',
			'title'     => 'Review Post',
			'dependency' => array(
				'field'    => 'rehub_framework_post_type',
				'function' => 'rehub_framework_post_type_is_review',
			),
			'fields'    => array(
				array(
					'type' => 'toggle',
					'name' => 'rehub_review_slider',
					'label' => __('Add slider of images to top of review page?', 'rehub_child'),
					'default' => '0',
				),
				array(
					'type' => 'toggle',
					'name' => 'rehub_review_slider_resize',
					'label' => __('Disable height resize for slider', 'rehub_child'),
					'description' => __('This option disable resize of photo. By default, photos are resized for 400 px height', 'rehub_child'),
					'dependency' => array(
                         'field' => 'rehub_review_slider',
                         'function' => 'vp_dep_boolean',
                    ),										
				),				
				array(
					'type'      => 'group',
					'repeating' => true,
					'name'      => 'rehub_review_slider_images',
					'title'     => __('Images', 'rehub_child'),
					'fields'    => array(
						array(
							'type'      => 'upload',
							'name'      => 'review_post_image',
							'label'     => __('Add Image', 'rehub_child'),
						),
						array(
							'type'      => 'textbox',
							'name'      => 'review_post_image_caption',
							'label'     => __('Caption', 'rehub_child'),
						),
						array(
							'type'      => 'textbox',
							'name'      => 'review_post_image_url',
							'label'     => __('Url for image', 'rehub_framework'),
						),							
						array(
							'type' => 'textbox',
							'name' => 'review_post_video',
							'description' => __('Insert youtube link of page with video. If you set this field, image and caption will be ignored for this slide', 'rehub_child'),
							'label' => __('Video Url', 'rehub_child'),
						),											
					),
					'dependency' => array(
                         'field' => 'rehub_review_slider',
                         'function' => 'vp_dep_boolean',
                    ),					
				),

				 array(
					'type' => 'select',
					'name' => 'review_post_schema_type',
					'label' => __('Type of review', 'rehub_child'),
					'items' => array(
						array(
						'value' => 'review_post_review_simple',
						'label' => __('Simple Review', 'rehub_child'),
						),
						array(
						'value' => 'review_woo_product',
						'label' => __('Woocommerce product review', 'rehub_child'),
						),
						array(
						'value' => 'review_woo_list',
						'label' => __('Product review with woocommerce offers list', 'rehub_framework'),
						),																	
					),
					'default' => array(
						'review_post_review_simple',
					),
				),

				array(
					'type' => 'notebox',
					'name' => 'review_countdown_note',
					'label' => __('Note', 'rehub_framework'),
					'description' => __('You can add countdown before offer with shortcode. Example - [wpsm_countdown year="2015" month="04" day="03" hour="14"]', 'rehub_framework'),
					'status' => 'normal',
				),				 	

				array(
					'type'      => 'group',
					'repeating' => false,
					'length'    => 1,
					'name'      => 'review_woo_product',
					'title'     => __('Woocommerce product review', 'rehub_child'),
					'dependency' => array(
						'field'    => 'review_post_schema_type',
						'function' => 'review_post_schema_type_is_woo',
					),
					'fields'    => array(
						
						rehub_woo_select_one(),

						array(
							'type' => 'toggle',
							'name' => 'review_woo_slider',
							'label' => __('Enable slider', 'rehub_child'),
							'description' => __('This option enables slider in top of review page with images from woocommerce gallery', 'rehub_child'),					
						),	

						array(
							'type' => 'toggle',
							'name' => 'review_woo_slider_resize',
							'label' => __('Disable height resize for slider', 'rehub_child'),
							'description' => __('This option disable resize of photo. By default, photos are resized for 400 px height', 'rehub_child'),
							'dependency' => array(
		                         'field' => 'review_woo_slider',
		                         'function' => 'vp_dep_boolean',
		                    ),												
						),																								

						array(
							'type' => 'toggle',
							'name' => 'review_woo_offer_shortcode',
							'label' => __('Enable shortcode inserting', 'rehub_child'),
							'description' => __('If enable you can insert offer box in any place of content with shortcode [woo_offer_product]. If disable - it will be before review box.', 'rehub_child'),					
						),																																																

					),
				),

				array(
					'type'      => 'group',
					'repeating' => false,
					'length'    => 1,
					'name'      => 'review_woo_list',
					'title'     => __('Product review with woocommerce offers list', 'rehub_child'),
					'dependency' => array(
						'field'    => 'review_post_schema_type',
						'function' => 'review_post_schema_type_is_woo_list',
					),
					'fields'    => array(
						
						rehub_woo_select_two(),						

						array(
							'type' => 'toggle',
							'name' => 'review_woo_list_shortcode',
							'label' => __('Enable shortcode inserting', 'rehub_child'),
							'description' => __('If enable you can insert offers list in any place of content with shortcode [woo_offer_list]. If disable - it will be before review box.', 'rehub_child'),					
						),																																																

					),
				),					
								 

				array(
					'type'      => 'textbox',
					'name'      => 'review_post_heading',
					'label'     => __('Review Heading', 'rehub_child'),
					'description' => __('Short review heading (e.g. Excellent!)', 'rehub_child'),
				),
				array(
					'type'      => 'textarea',
					'name'      => 'review_post_summary_text',
					'label'     => __('Summary Text', 'rehub_child'),
				),

				array(
					'type' => 'toggle',
					'name' => 'review_post_product_shortcode',
					'label' => __('Enable shortcode inserting', 'rehub_child'),
					'description' => __('If enable you can insert review box in any place of content with shortcode [review]. If disable - it will be after content.', 'rehub_child'),					
				),

				array(
					'type'      => 'slider',
					'name'      => 'review_post_score_manual',
					'label'     => __('Set overall score', 'rehub_child'),
					'description' => __('Enter overall score of review or leave blank to auto calculation based on criterias score', 'rehub_child'),
					'min'       => 0,
					'max'       => 10,
					'step'      => 0.5,					
				),

				array(
					'type'      => 'group',
					'repeating' => true,
					'sortable'  => true,
					'name'      => 'review_post_criteria',
					'title'     => __('Review Criterias', 'rehub_child'),
					'fields'    => array(
						array(
							'type'      => 'textbox',
							'name'      => 'review_post_name',
							'label'     => __('Name', 'rehub_child'),
						),
						array(
							'type'      => 'slider',
							'name'      => 'review_post_score',
							'label'     => __('Score', 'rehub_child'),
							'min'       => 0,
							'max'       => 10,
							'step'      => 0.5,
						),
					),
				),
			),
		),
		
		// music group
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'music_post',
			'title'     => __('Music Post', 'rehub_child'),
			'dependency' => array(
				'field'    => 'rehub_framework_post_type',
				'function' => 'rehub_framework_post_type_is_music',
			),
			'fields'    => array(
				array(
					'type' => 'radiobutton',
					'name' => 'music_post_source',
					'label' => __('Music Source', 'rehub_child'),
					'items' => array(
						array(
							'value' => 'music_post_soundcloud',
							'label' => __('Music from Soundcloud', 'rehub_child'),
						),
						array(
							'value' => 'music_post_spotify',
							'label' => __('Music from Spotify', 'rehub_child'),
						),
					),
				),

				array(
					'type' => 'textarea',
					'name' => 'music_post_soundcloud_embed',
					'description' => __('Insert full Soundcloud embed code.', 'rehub_child'),
					'label' => __('Soundcloud embed code', 'rehub_child'),
					'dependency' => array(
						'field'    => 'music_post_source',
						'function' => 'rehub_framework_post_music_is_soundcloud',
					),
				),
				array(
					'type' => 'textbox',
					'name' => 'music_post_spotify_embed',
					'description' => __('To get the Spotify Song URI go to <strong>Spotify</strong> > Right click on the song you want to embed > Click <strong>Copy Spotify URI</strong> > Paste code in this field.)', 'rehub_framework'),
					'label' => __('Spotify Song URI', 'rehub_child'),
					'dependency' => array(
						'field'    => 'music_post_source',
						'function' => 'rehub_framework_post_music_is_spotify',
					),
				),

			),
		),
		
	),
);

/**
 * EOF
 */
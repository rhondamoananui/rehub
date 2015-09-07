<?php

return array(
	'id'          => 'rehub_top_table',
	'types'       => array('page'),
	'title'       => __('Top table settings', 'rehub_framework'),
	'priority'    => 'low',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(
		array(
			'type' => 'select',
			'name' => 'top_review_choose',
			'label' => __('Choose by', 'rehub_framework'),
			'items' => array(
				array(
					'value' => 'cat_choose',
					'label' => __('Category and/or tag', 'rehub_framework'),
				),
				array(
					'value' => 'manual_choose',
					'label' => __('Manual select and order', 'rehub_framework'),
				),
			),
			'default' => 'cat_choose',
		),		
		array(
			'type' => 'select',
			'name' => 'top_review_cat',
			'label' => __('Choose category', 'rehub_framework'),
			'description' => __('Choose the category that you\'d like to include to top review page', 'rehub_framework'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value'  => 'vp_get_categories',
					),
				),
			),
			'default' => '',
			'dependency' => array(
				'field'    => 'top_review_choose',
				'function' => 'top_review_choose_is_cat',
			),			
		),
		array(
			'type' => 'textbox',
			'name' => 'top_review_tag',
			'label' => __('Enter tag', 'rehub_framework'),
			'description' => __('Leave blank or set tag of posts', 'rehub_framework'),
			'dependency' => array(
				'field'    => 'top_review_choose',
				'function' => 'top_review_choose_is_cat',
			),			
		),
		array(
			'type' => 'textbox',
			'name' => 'top_review_fetch',
			'label' => __('Fetch Count', 'rehub_framework'),
			'description' => __('How much posts you\'d like to display?', 'rehub_framework'),
			'default' => '',
			'validation' => 'numeric',
			'dependency' => array(
				'field'    => 'top_review_choose',
				'function' => 'top_review_choose_is_cat',
			),			
		),					
		array(
			'type' => 'sorter',
			'name' => 'manual_ids',
			'label' => __('Choose posts', 'rehub_framework'),
			'description' => __('Choose posts and order', 'rehub_framework'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value'  => 'rehub_manual_ids_func',
					),
				),
			),
			'dependency' => array(
				'field'    => 'top_review_choose',
				'function' => 'top_review_choose_is_manual',
			),			
		),		

		array(
			'type' => 'textbox',
			'name' => 'top_review_field_sort',
			'label' => __('Base of sorting', 'rehub_framework'),
			'description' => __('By default all posts are sorting by date. But you can set name of custom field for sorting. Important! If you want to show only posts with reviews - set name <strong>rehub_review_overall_score</strong>', 'rehub_framework'),			
		),

		array(
			'type' => 'select',
			'name' => 'top_review_order',
			'label' => __('Order of sorting:', 'rehub_framework'),
			'items' => array(
				array(
					'value' => 'desc',
					'label' => __('from highest to lowest', 'rehub_framework'),
				),
				array(
					'value' => 'asc',
					'label' => __('from lowest to highest', 'rehub_framework'),
				),
			),
			'default' => array(
				'desc',
			),			
		),
		array(
			'type' => 'toggle',
			'name' => 'top_review_pagination',
			'label' => __('Enable pagination?', 'rehub_framework'),
			'default' => '0',
		),

	    array(
	        'type' => 'notebox',
	        'name' => 'nb_1',
	        'label' => __('Set your content below', 'rehub_framework'),
	        'description' => __('Do not use more than 6 columns', 'rehub_framework'),
	        'status' => 'normal',
	    ),

		array(
			'type' => 'toggle',
			'name' => 'first_column_enable',
			'label' => __('Enable first column with thumbnail?', 'rehub_framework'),
			'default' => '1',
		),

		array(
			'type' => 'textbox',
			'name' => 'first_column_name',
			'label' => __('Set heading name for first column', 'rehub_framework'),
			'description' => __('By default - Product', 'rehub_framework'),	
			'dependency' => array(
				'field' => 'first_column_enable',
				'function' => 'vp_dep_boolean',
		 	),					
		),	
		array(
			'type' => 'toggle',
			'name' => 'first_column_rank',
			'label' => __('Enable rank on thumbnail?', 'rehub_framework'),
			'default' => '1',
			'dependency' => array(
				'field' => 'first_column_enable',
				'function' => 'vp_dep_boolean',
		 	),			
		),
		array(
			'type' => 'toggle',
			'name' => 'first_column_link',
			'label' => __('Enable link on affiliate product from thumbnail?', 'rehub_framework'),
			'default' => '0',
			'dependency' => array(
				'field' => 'first_column_enable',
				'function' => 'vp_dep_boolean',
		 	),			
		),			

	    array(
			'type'      => 'group',
			'repeating' => true,
			'sortable'  => true,
			'name'      => 'columncontents',
			'title'     => __('Column', 'rehub_framework'),
			'fields'    => array(
				array(
					'type' => 'textbox',
					'name' => 'column_name',
					'label' => __('Set heading name for column', 'rehub_framework'),				
				),
				array(
					'type' => 'textarea',
					'name' => 'column_html',
					'label' => __('Insert html and shortcode function', 'rehub_framework'),	
				),
			    array(
			        'type' => 'notebox',
			        'name' => 'nb_1',
			        'label' => __('Possible shortcodes functions', 'rehub_framework'),
			        'description' => __('[rehub_title] generates title of post. <br />[rehub_title link="post"] generates title with link on post. <br />[rehub_title link="affiliate"] generates title with link on affiliate product. <br /> [rehub_exerpt lenght="120"] generates exerpt with 120 symbols. <br />[rehub_exerpt lenght="120" reviewtext="1"] will grab description from your review. <br />Also, you can wrap shortcode with html tags. Example, &lt;h2&gt;[rehub_title]&lt;/h2&gt;&lt;p&gt;[rehub_exerpt lenght="120"]&lt;/p&gt;', 'rehub_framework'),
			        'status' => 'normal',
			    ),
				array(
					'type' => 'toggle',
					'name' => 'column_center',
					'label' => __('Enable center alignment in column?', 'rehub_framework'),
					'default' => '0',
				),			    				
				array(
					'type' => 'select',
					'name' => 'column_type',
					'label' => __('Select generated content:', 'rehub_framework'),
					'items' => array(
						array(
							'value' => 'meta_value',
							'label' => __('Set or single meta value', 'rehub_framework'),
						),				
						array(
							'value' => 'review_function',
							'label' => __('Review score', 'rehub_framework'),
						),	
						array(
							'value' => 'user_review_function',
							'label' => __('User stars rating', 'rehub_framework'),
						),
						array(
							'value' => 'none',
							'label' => __('No generated content', 'rehub_framework'),
						),																	
					),
					'default' => array(
						'exerpt',
					),
				),
				array(
					'type'      => 'group',
					'repeating' => true,
					'sortable'  => true,
					'name'      => 'column_meta_fields',
					'dependency' => array(
						'field'    => 'column_type',
						'function' => 'rehub_column_is_meta_value',
					),					
					'title'     => __('Value from custom field', 'rehub_framework'),
					'fields'    => array(
						array(
							'type' => 'select',
							'name' => 'column_meta_type',
							'label' => __('Type of meta value', 'rehub_framework'),					
							'items' => array(
								array(
									'value' => 'text',
									'label' => __('Text value', 'rehub_framework'),
								),
								array(
									'value' => 'checkbox',
									'label' => __('Checkbox (true or false)', 'rehub_framework'),
								),				
							),
							'default' => 'text',
						),
						array(
							'type'      => 'textbox',
							'name'      => 'column_meta_name',
							'label'     => __('Name (slug) of custom field', 'rehub_framework'),
						),																												
						array(
							'type'      => 'textbox',
							'name'      => 'column_meta_label',
							'label'     => __('Label before value', 'rehub_framework'),
							'description' => __('Set label before value or leave blank', 'rehub_framework'),
						),
						array(
							'type' => 'fontawesome',
							'name' => 'column_meta_icon',
							'label' => __('Choose icon', 'rehub_framework'),
							'description' => __('Choose icon or leave blank', 'rehub_framework'),							
							'default' => '',										
						),						
						array(
							'type' => 'toggle',
							'name' => 'column_customize',
							'label' => __('Customize font size and colors of column?', 'rehub_framework'),
							'default' => '0',
						),
						array(
						    'type' => 'slider',
						    'name' => 'column_meta_value_size',
						    'label' => __('Meta Value Font size', 'rehub_framework'),
						    'description' => __('Default - 15px', 'rehub_framework'),
						    'min' => '10',
						    'max' => '36',
						    'step' => '1',
						    'default' => '',
							'dependency' => array(
								'field' => 'column_customize',
								'function' => 'vp_dep_boolean',
						 	),						    
						),
						array(
						    'type' => 'color',
						    'name' => 'column_meta_value_color',
						    'label' => __('Meta Value Font Color', 'rehub_framework'),
						    'description' => __('Default - #111111', 'rehub_framework'),
						    'default' => '',
						    'format' => 'hex',	
							'dependency' => array(
								'field' => 'column_customize',
								'function' => 'vp_dep_boolean',
						 	),						    					    
						),
						array(
						    'type' => 'slider',
						    'name' => 'column_meta_label_size',
						    'label' => __('Label Font size', 'rehub_framework'),
						    'description' => __('Default - 15px', 'rehub_framework'),
						    'min' => '10',
						    'max' => '36',
						    'step' => '1',
						    'default' => '',
							'dependency' => array(
								'field' => 'column_customize',
								'function' => 'vp_dep_boolean',
						 	),						    
						),
						array(
						    'type' => 'color',
						    'name' => 'column_meta_label_color',
						    'label' => __('Label Font Color', 'rehub_framework'),
						    'description' => __('Default - #111111', 'rehub_framework'),
						    'default' => '',
						    'format' => 'hex',	
							'dependency' => array(
								'field' => 'column_customize',
								'function' => 'vp_dep_boolean',
						 	),						    					    
						),	
						array(
						    'type' => 'slider',
						    'name' => 'column_meta_icon_size',
						    'label' => __('Icon Font size', 'rehub_framework'),
						    'description' => __('Default - 15px', 'rehub_framework'),
						    'min' => '10',
						    'max' => '36',
						    'step' => '1',
						    'default' => '',
							'dependency' => array(
								'field' => 'column_customize',
								'function' => 'vp_dep_boolean',
						 	),							    
						),
						array(
						    'type' => 'color',
						    'name' => 'column_meta_icon_color',
						    'label' => __('Icon Font Color', 'rehub_framework'),
						    'description' => __('Default - #111111', 'rehub_framework'),
						    'default' => '',
						    'format' => 'hex',
							'dependency' => array(
								'field' => 'column_customize',
								'function' => 'vp_dep_boolean',
						 	),						    						    
						),																					
					),
				),	
				array(
					'type' => 'select',
					'name' => 'top_review_circle',
					'label' => __('Design of rating', 'rehub_framework'),
					'dependency' => array(
						'field'    => 'column_type',
						'function' => 'rehub_column_is_review_function',
					),					
					'items' => array(
						array(
							'value' => '0',
							'label' => __('Simple text', 'rehub_framework'),
						),
						array(
							'value' => '1',
							'label' => __('Circle design', 'rehub_framework'),
						),
						array(
							'value' => '2',
							'label' => __('Square design', 'rehub_framework'),
						),				
					),
					'default' => '1',
				),											


			),
		),

		array(
			'type' => 'toggle',
			'name' => 'last_column_enable',
			'label' => __('Enable last column with button?', 'rehub_framework'),
			'default' => '1',
		),

		array(
			'type' => 'textbox',
			'name' => 'last_column_name',
			'label' => __('Set heading name for last column', 'rehub_framework'),
			'description' => __('By default - empty', 'rehub_framework'),	
			'dependency' => array(
				'field' => 'last_column_enable',
				'function' => 'vp_dep_boolean',
		 	),					
		),	
		array(
			'type' => 'textarea',
			'name' => 'column_after_block',
			'label' => __('Insert content after block', 'rehub_framework'),
			'description' => __('Add content which you want to display after module or leave blank', 'rehub_framework'),				
		),
		array(
			'type' => 'toggle',
			'name' => 'top_review_width',
			'label' => __('Full width?', 'rehub_framework'),
			'default' => '1',
		),										
		array(
			'type' => 'html',
			'name' => 'shortcode_top',
			'label' => __('Shortcode', 'rehub_framework'),
			'description' => __('Shortcode', 'rehub_framework'),
			'binding' => array(
				'field' => '',
				'function' => 'top_table_shortcode',
			)
		),							
	),
    'include_template' => 'template-toptable.php',
);

/**
 * EOF
 */
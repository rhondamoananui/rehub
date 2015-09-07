<?php

return array(
	'id'          => 'rehub_top_chart',
	'types'       => array('page'),
	'title'       => __('Comparison chart settings', 'rehub_framework'),
	'priority'    => 'low',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'template'    => array(		
		array(
			'type' => 'textbox',
			'name' => 'top_chart_ids',
			'label' => __('Enter post ids for comparison', 'rehub_framework'),
			'description' => __('Set with comma without spaces, example: 2,34,67,88', 'rehub_framework'),			
		),	
		array(
			'type' => 'textbox',
			'name' => 'top_chart_type',
			'label' => __('Enter name of custom post type or leave blank (default, post)', 'rehub_framework'),			
		),												
	    array(
			'type'      => 'group',
			'repeating' => true,
			'sortable'  => true,
			'name'      => 'columncontents',
			'title'     => __('Row', 'rehub_framework'),
			'fields'    => array(
				array(
					'type' => 'textbox',
					'name' => 'column_name',
					'label' => __('Set heading name for row', 'rehub_framework'),				
				),			    				
				array(
					'type' => 'select',
					'name' => 'column_type',
					'label' => __('Select generated content:', 'rehub_framework'),
					'items' => array(
						array(
							'value' => 'heading',
							'label' => __('Row heading', 'rehub_framework'),
						),						
						array(
							'value' => 'image',
							'label' => __('Thumbnail', 'rehub_framework'),
						),
						array(
							'value' => 'title',
							'label' => __('Title', 'rehub_framework'),
						),																		
						array(
							'value' => 'meta_value',
							'label' => __('Meta value', 'rehub_framework'),
						),
						array(
							'value' => 'taxonomy_value',
							'label' => __('Taxonomy value', 'rehub_framework'),
						),																
						array(
							'value' => 'review_function',
							'label' => __('Editor\'s Review score', 'rehub_framework'),
						),	
						array(
							'value' => 'user_review_function',
							'label' => __('User stars rating', 'rehub_framework'),
						),
						array(
							'value' => 'review_link',
							'label' => __('Link on post review', 'rehub_framework'),
						),						
						array(
							'value' => 'affiliate_btn',
							'label' => __('Affiliate button', 'rehub_framework'),
						),																							
					),
				),
			    array(
			        'type' => 'notebox',
			        'name' => 'nb_1',
			        'label' => __('Note', 'rehub_framework'),
			        'description' => __('By default button will grab data from product review, but you can set your own meta names where data are stored', 'rehub_framework'),
			        'status' => 'normal',
					'dependency' => array(
						'field'    => 'column_type',
						'function' => 'rehub_column_is_btn',
					),			        
			    ),
				array(
					'type' => 'textbox',
					'name' => 'btn_text',
					'label' => __('Insert button text or leave blank', 'rehub_framework'),	
					'dependency' => array(
						'field'    => 'column_type',
						'function' => 'rehub_column_is_btn',
					),					
				),	
				array(
					'type' => 'textbox',
					'name' => 'btn_url',
					'label' => __('Insert meta value where affiliate url is stored', 'rehub_framework'),	
					'dependency' => array(
						'field'    => 'column_type',
						'function' => 'rehub_column_is_btn',
					),					
				),
				array(
					'type' => 'textbox',
					'name' => 'btn_price',
					'label' => __('Insert meta value where affiliate price is stored', 'rehub_framework'),	
					'dependency' => array(
						'field'    => 'column_type',
						'function' => 'rehub_column_is_btn',
					),					
				),															
				array(
					'type' => 'textbox',
					'name' => 'tax_name',
					'label' => __('Enter taxonomy slug', 'rehub_framework'),
					'description' => __('Enter slug of your taxonomy. Example, taxonomy for posts - is category.', 'rehub_framework'),
					'dependency' => array(
						'field'    => 'column_type',
						'function' => 'rehub_column_is_tax',
					),					
				),			    
				array(
					'type' => 'toggle',
					'name' => 'image_link_affiliate',
					'label' => __('Enable link on affiliate product from thumbnail?', 'rehub_framework'),
					'default' => '0',
					'dependency' => array(
						'field'    => 'column_type',
						'function' => 'rehub_column_is_image',
					),					
				),				    
				array(
					'type'      => 'group',
					'repeating' => false,
					'sortable'  => false,
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
							'label' => __('Star design', 'rehub_framework'),
						),															
					),
					'default' => '2',
				),											


			),
		),	
		array(
			'type' => 'toggle',
			'name' => 'top_chart_width',
			'label' => __('Full width?', 'rehub_framework'),
			'default' => '1',
		),												
		array(
			'type' => 'html',
			'name' => 'shortcode_charts',
			'label' => __('Shortcode', 'rehub_framework'),
			'description' => __('Shortcode', 'rehub_framework'),
			'binding' => array(
				'field' => '',
				'function' => 'top_charts_shortcode',
			)
		),
		array(
			'type' => 'toggle',
			'name' => 'shortcode_charts_enable',
			'label' => __('If enabled - content of chart will be inserted on page only by shortcode above', 'rehub_framework'),
			'default' => '0',
		),									
	),
    'include_template' => 'template-topcharts.php',
);

/**
 * EOF
 */
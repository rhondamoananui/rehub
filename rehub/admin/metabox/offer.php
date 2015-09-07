<?php

return array(
	'id'          => 'rehub_offer_main',
	'types'       => array('post'),
	'title'       => __('Post offer', 'rehub_framework'),
	'priority'    => 'high',
	'mode'        => WPALCHEMY_MODE_EXTRACT,
	'view' => WPALCHEMY_VIEW_START_CLOSED,	
	'template'    => array(
		array(
			'type'      => 'textbox',
			'name'      => 'rehub_offer_product_url',
			'label'     => __('Offer url', 'rehub_framework'),
			'description' => __('Insert url of offer', 'rehub_framework'),							
		),		
		array(
			'type'      => 'textbox',
			'name'      => 'rehub_offer_name',
			'label'     => __('Name of product', 'rehub_framework'),
			'description' => __('Insert title or leave blank for using post title', 'rehub_framework'),						
		),	

		array(
			'type'      => 'textbox',
			'name'      => 'rehub_offer_product_desc',
			'label'     => __('Short description of product', 'rehub_framework'),
			'description' => __('Enter description of product or leave blank', 'rehub_framework'),								
		),

		
		array(
			'type'      => 'textbox',
			'name'      => 'rehub_offer_product_price',
			'label'     => __('Offer sale price', 'rehub_framework'),
			'description' => __('Insert sale price of offer (example, $55) or any text', 'rehub_framework'),							
		),	

		array(
			'type'      => 'textbox',
			'name'      => 'rehub_offer_product_price_old',
			'label'     => __('Offer old price', 'rehub_framework'),
			'description' => __('Insert old price of offer or leave blank', 'rehub_framework'),							
		),

		array(
			'type'      => 'textbox',
			'name'      => 'rehub_offer_product_coupon',
			'label'     => __('Set coupon code', 'rehub_framework'),
			'description' => __('Set coupon code or leave blank', 'rehub_framework'),							
		),

	    array(
	        'type' => 'date',
	        'name' => 'rehub_offer_coupon_date',
	        'label' => __('Coupon End Date', 'rehub_framework'),
	        'format' => 'yy-mm-dd',
	    ),

		array(
			'type' => 'toggle',
			'name' => 'rehub_offer_coupon_mask',
			'label' => __('Mask coupon code?', 'rehub_framework'),
			'description' => __('If this option is enabled, coupon code will be hidden.', 'rehub_framework'),
			'default' => '0',
		),	    																		

		array(
			'type'      => 'textbox',
			'name'      => 'rehub_offer_btn_text',
			'label'     => __('Button text', 'rehub_framework'),
			'description' => __('Insert text on button or leave blank to use default text. Use short names', 'rehub_framework'),
			'validation' => 'maxlength[14]',														
		),						

		array(
			'type' => 'upload',
			'name' => 'rehub_offer_product_thumb',
			'label' => __('Upload thumbnail', 'rehub_framework'),
			'description' => __('Upload thumbnail of product or leave blank to use post thumbnail', 'rehub_framework'),							
		),	

		array(
			'type' => 'toggle',
			'name' => 'rehub_offer_shortcode',
			'label' => __('Enable shortcode inserting', 'rehub_framework'),
			'description' => __('If enable you can insert offer box in any place of content with shortcode [quick_offer]. If disable - it will be before review box.', 'rehub_framework'),					
		),		

	),
);

/**
 * EOF
 */
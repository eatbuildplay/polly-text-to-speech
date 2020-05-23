<?php

acf_add_local_field_group(array(
	'key' => 'group_5ebff754d4d54',
	'title' => 'Saber TTS Conversion',
	'fields' => array(
		array(
			'key' => 'field_5ebff76548691',
			'label' => 'S3 Url',
			'name' => 's3_url',
			'type' => 'url',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'text_conversion',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

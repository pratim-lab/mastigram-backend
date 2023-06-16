<?php
return[
    'website_title'  	=> env('WEBSITE_TITLE','Mastigram+'),
    'website_url'  	 	=> env('WEBSITE_URL','https://mastigram.com/'),
    'website_tag_line'  => env('WEBSITE_TAG_LINE','Mastigram+'),
    'admin_email_id' 	=> env('ADMIN_EMAIL_ID','info@mastigram.com'),
    'currency' 			=> env('CURRENCY','INR'),
    'currency_html_code'=> env('CURRENCY_HTML_CODE','&#8377;'),
    'currency_symbol' 	=> env('CURRENCY_SYMBOL','<i class="fa fa-inr"></i>'),
    'no_image' 			=> env('NO_IMAGE','/images/no_image.jpg'),
    'no_image_thumb' 	=> env('NO_IMAGE_THUMB','/images/no_image_thumb.jpg'),
    'email_regards'     => env('email_regards','Team Mastigram+'),
    'website_title_camel_case' => env('website_title_camel_case','Mastigram+'),
    'number_format_limit'=> env('NUMBER_FORMAT_LIMIT',2),
	
];
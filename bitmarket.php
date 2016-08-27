<?php
/*
Plugin Name: Bitmarket
Plugin URI: https://ukulilandia.lol
Description: Experimental Bitcoin Escrow plugin for WordPress
Version: 0.1
Author: Tomi Toivio
Author URI: https://ukulilandia.lol
License: GPL2
*/

add_action( 'admin_menu', 'bitmarket_add_admin_menu' );
add_action( 'admin_init', 'bitmarket_settings_init' );

function bitmarket_add_admin_menu(  ) { 
	add_menu_page( 'Bitmarket', 'Bitmarket', 'manage_options', 'bitmarket', 'bitmarket_options_page' );
}


function bitmarket_settings_init(  ) { 

	register_setting( 'pluginPage', 'bitmarket_settings' );

	add_settings_section(
		'bitmarket_pluginPage_section', 
		__( 'Your section description', 'bitmarket' ), 
		'bitmarket_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'bitmarket_text_field_0', 
		__( 'Settings field description', 'bitmarket' ), 
		'bitmarket_text_field_0_render', 
		'pluginPage', 
		'bitmarket_pluginPage_section' 
	);

	add_settings_field( 
		'bitmarket_text_field_1', 
		__( 'Settings field description', 'bitmarket' ), 
		'bitmarket_text_field_1_render', 
		'pluginPage', 
		'bitmarket_pluginPage_section' 
	);

	add_settings_field( 
		'bitmarket_text_field_2', 
		__( 'Settings field description', 'bitmarket' ), 
		'bitmarket_text_field_2_render', 
		'pluginPage', 
		'bitmarket_pluginPage_section' 
	);

	add_settings_field( 
		'bitmarket_text_field_3', 
		__( 'Settings field description', 'bitmarket' ), 
		'bitmarket_text_field_3_render', 
		'pluginPage', 
		'bitmarket_pluginPage_section' 
	);


}


function bitmarket_text_field_0_render(  ) { 

	$options = get_option( 'bitmarket_settings' );
	?>
	<input type='text' name='bitmarket_settings[bitmarket_text_field_0]' value='<?php echo $options['bitmarket_text_field_0']; ?>'>
	<?php

}


function bitmarket_text_field_1_render(  ) { 

	$options = get_option( 'bitmarket_settings' );
	?>
	<input type='text' name='bitmarket_settings[bitmarket_text_field_1]' value='<?php echo $options['bitmarket_text_field_1']; ?>'>
	<?php

}


function bitmarket_text_field_2_render(  ) { 

	$options = get_option( 'bitmarket_settings' );
	?>
	<input type='text' name='bitmarket_settings[bitmarket_text_field_2]' value='<?php echo $options['bitmarket_text_field_2']; ?>'>
	<?php

}


function bitmarket_text_field_3_render(  ) { 

	$options = get_option( 'bitmarket_settings' );
	?>
	<input type='text' name='bitmarket_settings[bitmarket_text_field_3]' value='<?php echo $options['bitmarket_text_field_3']; ?>'>
	<?php

}


function bitmarket_settings_section_callback(  ) { 

	echo __( 'This section description', 'bitmarket' );

}


function bitmarket_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<h2>Bitmarket</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}

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

/*  Copyright 2016 Tomi Toivio (email: tomi@sange.fi)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function bitmarket_bitwallet() {
        global $user_ID;
        global $wpdb;
        $current_user_ID = get_current_user_id();
        if(is_user_logged_in()) {
        require_once('easybitcoin.php');
        $options = get_option( 'bitmarket_settings' );
        $bitcoinduser = $options['bitmarket_text_field_0'];
        $bitcoindpassword = $options['bitmarket_text_field_1'];
        $bitcoindip = $options['bitmarket_text_field_2'];
        $bitcoindport = $options['bitmarket_text_field_3'];
	if (!empty($_POST["to"])) {
	if (!empty($_POST["amount"])) {
	$to = $_POST["to"];
	$bitcoin = new Bitcoin($bitcoinduser,$bitcoindpassword,$bitcoindip,$bitcoindport);
	$user_info = get_userdata($current_user_ID);
	$username = $user_info->user_login;
	$to_addresses = $_POST["to"];
	$amounts = $_POST["amount"];
	$amounts = floatval($amounts);
	$amounts = round($amounts, 4);
	$bitcoin->sendfrom($username,$to_addresses,$amounts);
	$bitcoin = new Bitcoin($bitcoinduser,$bitcoindpassword,$bitcoindip,$bitcoindport);
	$user_info = get_userdata($current_user_ID);
	$username = $user_info->user_login;
	$bitcoin->getbalance($username);
	$bitcoin_balance = $bitcoin->response;
	$bitcoin_balance = $bitcoin_balance["result"];
	$bitcoin_balance = round($bitcoin_balance, 4);
	$bitcoin_balance = strval($bitcoin_balance);
	update_user_meta($current_user_ID,"btc_available",$bitcoin_balance);

        echo "<script type='text/javascript'>
                   window.location.assign('/bitwallet/');
        </script>";
	}
	}
   	$bitcoin_balance = get_user_meta($current_user_ID,"btc_available",true);
   	$bitcoin_balance = round($bitcoin_balance, 4);
   	$bitcoin_balance = strval($bitcoin_balance);
   	echo "<h3>Your Bitcoin wallet</h3>";
   	echo "<p>BTC balance: " . $bitcoin_balance . "</p>";
   	echo "<p>BTC address: " . get_user_meta($current_user_ID,"btc_address",true) . "</p>";
   	echo "<p>BTC/EUR: " . get_option("btc_eur") . "</p>";
   	echo '<p><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . get_user_meta($current_user_ID,"btc_address",true) . '&choe=UTF-8" title="' . get_user_meta($current\
_user_ID,"btc_address",true) . '" /></p>';
   	$maxval = get_user_meta($current_user_ID,"btc_available",true);
   	$maxval = round($maxval, 4);
   	echo "<h1>Send BTC</h1>";
   	echo '<form name="bitwallet" method="post" action="">';
   	echo 'BTC Address: <input type="text" name="to" required/> <br />';
   	echo 'BTC Amount: <input type="number" name="amount" max="' . $maxval . '" min="0" step="0.0001" required/><br />';
   	echo '<input type="submit"  value="send"/>';
   	echo '</form>';
   }


add_action( 'admin_menu', 'bitmarket_add_admin_menu' );
add_action( 'admin_init', 'bitmarket_settings_init' );

function bitmarket_add_admin_menu(  ) { 
	add_menu_page( 'Bitmarket', 'Bitmarket', 'manage_options', 'bitmarket', 'bitmarket_options_page' );
}


function bitmarket_settings_init(  ) { 

	register_setting( 'pluginPage', 'bitmarket_settings' );

	add_settings_section(
		'bitmarket_pluginPage_section', 
		__( 'Settings for your Bitcoind', 'bitmarket' ), 
		'bitmarket_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'bitmarket_text_field_0', 
		__( 'Bitcoind username', 'bitmarket' ), 
		'bitmarket_text_field_0_render', 
		'pluginPage', 
		'bitmarket_pluginPage_section' 
	);

	add_settings_field( 
		'bitmarket_text_field_1', 
		__( 'Bitcoind password', 'bitmarket' ), 
		'bitmarket_text_field_1_render', 
		'pluginPage', 
		'bitmarket_pluginPage_section' 
	);

	add_settings_field( 
		'bitmarket_text_field_2', 
		__( 'Bitcoind IP', 'bitmarket' ), 
		'bitmarket_text_field_2_render', 
		'pluginPage', 
		'bitmarket_pluginPage_section' 
	);

	add_settings_field( 
		'bitmarket_text_field_3', 
		__( 'Bitcoind port', 'bitmarket' ), 
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

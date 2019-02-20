<?php
/*
Plugin Name: KIPR LMS
Plugin URI:
Description: Grades documentation
Author: Tim Corbly
Author URI: https://kipr.org/
Version: 0.0.0
Text Domain: kiprlms
License GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

//Includes
include( plugin_dir_url(__FILE__) . 'D:/xampp/htdocs/test-site/wordpress/wp-content\plugins\kiprlms\'

// Create a link to the settings page unde Wordpress Settings in the dashboard
add_action( 'admin_menu', 'kipr_lms_general_settings_page' );
function kipr_lms_general_settings_page(){
	add_submenu_page(
	'options-general.php',
	__( 'KIPR LMS', 'kiprlms' ),
	__( 'KIPR LMS Grading', 'kiprlms' ),
	'manage_options',
	'kiprlms_lms',
	'kiprlms_render_settings_page'
	);
}
function kiprlms_render_settings_page(){
	?>
	<!-- Create a header in the default WordPress 'wrap' container -->
	<div class="wrap">
		<h2><?php _e( 'KIPR LMS Settings', 'kiprlms' ); ?></h2>
		<form method="post" action="options.php">
			<?php
			//Get settings for the plugin to display in the form
			settings_fields( 'kiprlms_general_settings' );
			do_settings_sections( 'kiprlms_general_settings' );
			
			//Form submit button
			submit_button();
			?>
		</form>
	</div>
<?php
}

//Creates settings for plugin
add_action( 'admin_init', 'kiprlms_initialize_settings' );
function kiprlms_initialize_settings(){
	
	add_settings_section(
		'general_section',						//Section identifier
		__( 'General Settings', 'kiprlms' ),	//Title
		'general_settings_callback',			//Callback for description
		'kiprlms_general_settings'				//Page to add to
	);
	add_settings_field(
		'grading_page_name',
		__( 'Grading Page Name', 'kiprlms' ),
		'text_input_callback',
		'kiprlms_general_settings',
		'general_section',
		array(
			'label_for' => 'grading_page_name',
			'option_group' => 'kiprlms_general_settings',
			'option_id' => 'grading_page_name'
		)
	);
	add_settings_field(
		'display_location',
		__( 'Display Location', 'kiprlms' ),
		'radio_input_callback',
		'kiprlms_general_settings',
		'general_section',
		array(
			'label_for' => 'display_location',
			'option_group' => 'kiprlms_general_settings',
			'option_id' => 'display_location',
			'option_description' => 'Display at bottom',
			'radio_options' => array(
				'display_none' => 'Do not display',
				'display_top' => 'Display at top',
				'display_bottom' => 'Display at bottom'
			)
		)
	);
	register_setting(
		'kiprlms_general_settings',
		'kiprlms_general_settings'
	);
}

function general_settings_callback(){
	_e( 'KIPR LMS Settings', 'kiprlms' );
}

function text_input_callback( $text_input ){
	$option_group = $text_input['option_group'];
	$option_id = $text_input['option_id'];
	$option_name = "{$option_group}[{$option_id}]";
	
	$options = get_option( $option_group );
	$option_value = isset( $options[$option_id] ) ? $options[$option_id] : "";
	
	echo "<input type='text' size='50' id='{$option_id}' name='{$option_name}' value='{$option_value}' />";
}

function radio_input_callback($radio_input){
	
	//Get arguments from setting
	$option_group = $radio_input['option_group'];
	$option_id = $radio_input['option_id'];
	$radio_options = $radio_input['radio_options'];
	$option_name = "{$option_group}[{$option_id}]";
	
	//Get exisiting option from database
	$options = get_option( $option_group );
	$option_value = isset( $options[$option_id] ) ? $options[$option_id] : "";
	
	// Render output
	$input = '';
	foreach( $radio_options as $radio_option_id => $radio_option_value){
		$input .= "<input type='radio' i='{$radio_option_id}' name='{$option_name}' value='{$radio_option_id}' " . checked( $radio_option_id, $option_value, false ) . " />";
		$input .= "<label for='{$radio_option_id}'>{$radio_option_value}</label><br />";
	}
	
	echo $input;
}

add_action( 'wp_footer', 'kiprlms_display_grading' );
function kiprlms_display_grading(){
	if( !null == get_option( 'kiprlms_general_settings' )){
		$options = get_option( 'kiprlms_general_settings' );
		?>
		<div class="kiprlms-display <?php echo $options['display_location']; ?>">
			<div class="kiprlms-text"><?php echo $options['grading_page_name']; ?></div>
		</div>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', 'kiprlms_scripts' );
function kiprlms_scripts(){
	
	wp_enqueue_style(
		'kiprlms-css',
		plugin_dir_url( __FILE__ ) . 'kiprlms.css',
		array(),
		'1.0.0'
	);
}

add_filter( 'body_class', 'kiprweb_body_class' , 20);
function kiprweb_body_class( $classes ){
	
	if( !null == get_option( 'kiprlms_general_settings' )){
		$options = get_option( 'kipr_lms_general_settings' );
		if( $options['display_location'] === 'display_top' || $options['display_location'] === 'display_bottom'){
			$classes[] = 'kiprlms-classes';
		}
	}
	
	return $classes;
}









?>
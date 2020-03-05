<?php
function amadeus_api_settings_init() {
  register_setting( 'amadeus_api', 'amadeus_api_options' );
  add_settings_section(
	  'amadeus_api_section',
	  'Client Credentials',
	  'amadeus_api_section_callback',
	  'amadeus_api'
  );
  add_settings_field(
	  'api_key_text_field_0',
	  'API Key',
	  'api_key_text_field_0_render',
	  'amadeus_api',
	  'amadeus_api_section'
  );
  add_settings_field(
	  'api_secret_text_field_1',
	  'API Secret',
	  'api_secret_text_field_1_render',
	  'amadeus_api',
	  'amadeus_api_section'
  );
}
function amadeus_api_section_callback() {
  echo 'Enter the API key and API secret of your app obtained from Amadeus for Developers portal.', 'amadeus_api';
}
function api_key_text_field_0_render() {
  $options = get_option( 'amadeus_api_options' );
  echo '<input type="text" name="amadeus_api_options[api_key_text_field_0]" value="' . $options[ 'api_key_text_field_0' ] . '">';
}
function api_secret_text_field_1_render() {
  $options = get_option( 'amadeus_api_options' );
  echo '<input type="text" name="amadeus_api_options[api_secret_text_field_1]" value="' . $options[ 'api_secret_text_field_1' ] . '">';
}
add_action( 'admin_init', 'amadeus_api_settings_init' );
function add_amadeus_api_options_page() {
  add_options_page( 'Amadeus API Settings Page', 'Amadeus API Settings Menu', 'manage_options', 'amadeus_api', 'amadeus_api_options_page' );
}
function amadeus_api_options_page() {
  if ( ! current_user_can( 'manage_options' ) ) {
	  wp_die( 'You do not have sufficient permissions to access this page.' );
  }
?>
<h1><?php echo esc_html( get_admin_page_title( ) ); ?></h1>
<form action="options.php" method="post">
<?php
settings_fields( 'amadeus_api' );
do_settings_sections( 'amadeus_api' );
submit_button( 'Save Settings' );
?>
</form>
<?php
}

add_action( 'admin_menu', 'add_amadeus_api_options_page' );

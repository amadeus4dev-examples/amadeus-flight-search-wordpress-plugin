<?php
function get_flight_offers() {
  Requests::register_autoloader();
  $url = 'https://test.api.amadeus.com/v1/security/oauth2/token';
  $options = get_option( 'amadeus_api_options' ); 
  $auth_data = array();
  $auth_data[ 'client_id' ] = $options[ 'api_key_text_field_0' ];
  $auth_data[ 'client_secret' ] = $options[ 'api_secret_text_field_1' ];
  $auth_data[ 'grant_type' ] = 'client_credentials';
  $headers = array( 'Content-Type' => 'application/x-www-form-urlencoded' );
try {
  $requests_response = Requests::post( $url, $headers, $auth_data );
  $response_body = json_decode( $requests_response->body );
  if ( property_exists($response_body, 'error') ) {
    die( '<p>' . ( $response_body -> error_description ) . '.</p>' );
  }
  $access_token = $response_body->access_token;
} catch (Exception $e) {
   die( '<p>' . ( $e -> getMessage() ) . '.</p>' );
   
}
try {
  $requests_response = Requests::post( $url, $headers, $auth_data );
  $response_body = json_decode( $requests_response -> body );
  if ( property_exists( $response_body, 'error' ) ) {
	die( '<p>' . ( $response_body -> error_description ) . '.</p>' );
  }
  $access_token = $response_body -> access_token;
} catch ( Exception $e ) {
  die( '<p>' . ( $e -> getMessage() ) . '.</p>' );
}
if ( isset( $access_token ) ) {
  $endpoint = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
  $travel_data = array(
	'originLocationCode' 	  => sanitize_text_field( $_POST["originLocationCode"] ),
	'destinationLocationCode' => sanitize_text_field( $_POST["destinationLocationCode"] ),
	'departureDate' 	      => sanitize_text_field( $_POST["departureDate"] ),
	'adults'                  => sanitize_text_field( $_POST["adults"] ),
  );
  if ( $_POST["returnDate"] !== '' ) {
	$travel_data['returnDate'] = sanitize_text_field( $_POST["returnDate"] );
  }
  $params = http_build_query( $travel_data );
  $url = $endpoint.'?'.$params;
  $headers = array( 'Authorization' => 'Bearer '.$access_token );
  $options = array(
	  'timeout' => 10,
  );
  try {
	$requests_response = Requests::get( $url, $headers, $options );
	$response_body = json_decode( $requests_response->body );
	if ( property_exists($response_body, 'error') ) {
		die( '<p>' . ( $response_body -> error_description ) . '.</p>' );
	}
	echo json_encode($requests_response->body);
	} catch ( Exception $e ) {
		die( '<p>' . ( $e -> getMessage() ) . '.</p>' );
	}
  }
  wp_die();
}

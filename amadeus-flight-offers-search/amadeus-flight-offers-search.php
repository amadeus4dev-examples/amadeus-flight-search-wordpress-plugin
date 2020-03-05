<?php
/**
 * Plugin Name:     Amadeus Flight Offers Search
 * Plugin URI:      https://developers.amadeus.com
 * Description:     Connecting to Flight Offers Search API.
 * Version:         1.0.0
 * Requires PHP:    5.2
 * Author:          Amadeus for Developers
 * Author URI:      https://developers.amadeus.com
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 */
require_once( 'amadeus-api-settings.php' );
require_once( 'flight-offers-form.php' );
require_once( 'get-flight-offers.php' );
function enqueue_amadeus_script() {
    wp_enqueue_script( 'ajax-request-amadeus-flight-offers', plugins_url( 'js/amadeus-flight-offers-search.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), True );
    wp_enqueue_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css'  );
    wp_localize_script( 'ajax-request-amadeus-flight-offers', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_amadeus_script' );
add_action( 'wp_ajax_get_flight_offers_action', 'get_flight_offers' );
add_action( 'wp_ajax_nopriv_get_flight_offers_action', 'get_flight_offers' );
function amadeus_flight_offers_search_shortcode() {
    flight_offers_form();
}
add_shortcode( 'amadeus-flight-offers-search', 'amadeus_flight_offers_search_shortcode' );
?>

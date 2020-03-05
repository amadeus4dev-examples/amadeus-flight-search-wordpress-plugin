<?php
function flight_offers_form() {

    echo '<p>Look up flight deals from the Amadeus Flight Offers Search API.</p>';
    
    echo '<form id="flight_offers_request_form">';

    echo '<input type="hidden" name="action" value="get_flight_offers_action">';
 
    echo '<p>';
    echo 'Origin Location Code (required): ';
    echo '<input type="text" id="originLocationCode" name="originLocationCode" pattern="[A-Z]{3}" required>';
    echo '</p>';

    echo '<p>';
    echo 'Destination Location Code (required): ';
    echo '<input type="text" id="destinationLocationCode" name="destinationLocationCode" pattern="[A-Z]{3}" required>';
    echo '</p>';

    echo '<p>';    
    echo 'Departure Date (required): ';
    echo '<input type="text" id="departureDate" name="departureDate" id="departureDate" required>';
    echo '</p>';
    
    echo '<p>';    
    echo 'Return Date: ';
    echo '<input type="text" id="returnDate" name="returnDate" id="returnDate">';
    echo '</p>';    
    
    echo '<p>';
    echo 'No of Travelling Adults (required): ';
    echo '<input type="text" id="adults" name="adults" pattern="[0-9]+" required>';
    echo '</p>';

    echo '<p><input type="submit" value="Search"></p>';
    
    echo '</form>';
    
    echo '<div id="response"></div>';
}
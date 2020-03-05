jQuery(function($){
  $( "#departureDate" ).datepicker( { dateFormat: "yy-mm-dd" } );
  $( "#returnDate" ).datepicker( { dateFormat: "yy-mm-dd" } );
  $( "#flight_offers_request_form" ).submit( function( event ) {
    event.preventDefault();
    $( "#response" ).html( '' );
    $.ajax({
        url: ajax_object.ajax_url,
        type: "post",
        dataType: 'JSON',
        data: $( this ).serialize(),
    })
    .done ( function( response ) {
      var responseObj = $.parseJSON( response );
      var content = '';
      content += '<p>Flight offers from ' +
            $( '#originLocationCode' ).val() +
            ' to ' + $( '#destinationLocationCode' ).val() +
            ' departing on ' + $( '#departureDate' ).val() +
            ( ( $( '#returnDate' ).val() !== '' ) ? ( ' and returning on ' + $( '#returnDate' ).val() ) : '') +
            ' for ' + $( '#adults' ).val() +
            ' adult' + ( $( '#adults' ).val() > 1 ? 's.' : '.' ) +
            '</p>';
      content += '<table>';
      content += '<tr><th>ID</th><th>Departure Place</th><th>Departure Time</th><th>Arrival Place</th><th>Arrival Time</th><th>Flight No</th><th>Duration</th><th>Total Price</th></tr>';
      $.each( responseObj.data, function( idx, data ) {
        var id = data.id;
        var currency = data.price.currency;
        var total = data.price.total;
        var segment_count = 0;
        $.each( data.itineraries, function( idx, itinerary ) {
          $.each( itinerary.segments, function( idx, segment ) {
            var departure_from = segment.departure.iataCode;
            var departure_time = segment.departure.at;
            var arrival_at = segment.arrival.iataCode;
            var arrival_time = segment.arrival.at;
            var carrierCode = segment.carrierCode;
            var number = segment.number;
            var duration = segment.duration;
            content += '<tr>';
            content += '<td>' + ( ( segment_count === 0 ) ? id : '' ) + '</td><td>';
            content += departure_from + '</td><td>' +
                        departure_time + '</td><td>' +
                        arrival_at + '</td><td>' +
                        arrival_time + '</td><td>' +
                        carrierCode + ' ' + number +
                        '</td><td>' +
                        duration + '</td>';
            content += '<td>' + ( ( segment_count === 0 ) ? currency + ' ' + total : '' ) + '</td><td>';       
            content += '</tr>';	
            segment_count++;
          })
        })
      })
      content += '</table>';
      $( '#response' ).html( content );
    })
    .fail(function( jqXHR, textStatus ) {
        $( "#response" ).html( '<p>' + jqXHR.responseText + '</p>' );
    })
  })
});
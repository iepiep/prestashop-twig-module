$(document).ready(function() {
    $('.generate-itinerary').on('click', function() {
        var customerId = $(this).data('customer-id');
        var button = $(this); // Store the button element
        button.prop('disabled', true).text('Generating...'); // Disable and change text


        $.ajax({
            url: '/admin-dev/dimsymfony/api', // Replace with your actual admin URL
            method: 'POST',
            data: { id: customerId },
            dataType: 'json',
            success: function(response) {
              // Find the <td> element for the itinerary in the same row as the button
              button.closest('tr').find('td:eq(4)').text(response.itinerary);
                //alert('Itinerary generated: ' + response.itinerary);
                console.log(response);
            },
            error: function(xhr, status, error) {
                alert('Error generating itinerary: ' + xhr.responseJSON.error);
            },
            complete: function() {
               button.prop('disabled', false).text('Generate Itinerary'); // Re-enable and restore text
            }
        });
    });
});

	

	jQuery(function($) {
	  	$('#payment-form').on('beforeSubmit', function (event) {
	  		var form = $(this);

		    // Disable the submit button to prevent repeated clicks
		    form.find('button').prop('disabled', true);

		    Stripe.card.createToken(form, stripeResponseHandler);

		    // Prevent the form from submitting with the default action
		    return false;
		});
  	});

	function stripeResponseHandler(status, response) {
	  	var form = $('#payment-form');

	  	if (response.error) {
	  		console.log(response.error.message);
		    // Show the errors on the form
		    form.find(".payment-errors").fadeIn();
		    form.find(".payment-errors").html('There was an error processing your card. Please check your information and try again.<div class="spacer15"></div>');
		    form.find('button').prop('disabled', false);

		} else {
		    // response contains id and card, which contains additional card details
		    var token = response.id;

		    // Insert the token into the form so it gets submitted to the server
		    form.append($('<input type="hidden" name="stripeToken" />').val(token));
		    
		    // and submit
		    form.get(0).submit();
		}
	};
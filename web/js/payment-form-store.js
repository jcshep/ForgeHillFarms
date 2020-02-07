	

	jQuery(function($) {

		var submitted = false;

	  	$('#payment-form').on('beforeSubmit', function (event) {
	  		
	  		event.preventDefault();
	  			  		
	  		var form = $(this);

		    // Disable the submit button to prevent repeated clicks
		    form.find('button').prop('disabled', true);
		    
		    if(submitted == false)
		    	Stripe.card.createToken(form, stripeResponseHandler);

		    submitted = true;
		    
		    // Prevent the form from submitting with the default action
		    return false;

		});


	  	function stripeResponseHandler(status, response) {
		  	var form = $('#payment-form');


		  	if (response.error) {
		  		console.log(response.error.message);
			    // Show the errors on the form
			    form.find(".payment-errors").fadeIn();
			    form.find(".payment-errors").html('There was an error processing your card. Please check your information and try again.<div class="spacer15"></div>');
			    form.find('button').prop('disabled', false);
			    submitted = false;

			} else {
			    // response contains id and card, which contains additional card details
			    var token = response.id;

			    // Insert the token into the form so it gets submitted to the server
			    form.append($('<input type="hidden" name="stripeToken" />').val(token));
			    
			    // and submit
			    form.get(0).submit();
			}
		};

  	});

	
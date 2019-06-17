$(document).ready(function() {

	checkIfPaymentNeeded();

	$('.purchaseble-add-on').change(function() {
		checkIfPaymentNeeded();
	});

	function checkIfPaymentNeeded() {
		
		if ($(".purchaseble-add-on:checkbox:checked").length > 0) {
	    	$('#addon-modal').removeClass('hidden');
	    	$('.btn-submit').addClass('hidden');	
	    	doStripeStuff(); 

		} else {
		   $('#addon-modal').addClass('hidden');
		   $('.btn-submit').removeClass('hidden');		
		   $(".charge-amount").val(null);  
		   eliminateStripeStuff();
		}
	}


	$('#addon-modal').click(function(evt) {

		var size = $('#pickup-selection .size.active').data('size');
		var total = 0;


		// Loop through addons
		$('.purchaseble-add-on').each(function () {
			if(this.checked) {
				var addonPrice = $(this).data('price');
				total = addonPrice + total;
			}
		});

		
		$(".charge-amount").val(total.toFixed(2));
		console.log(total.toFixed(2));

	});

});



function eliminateStripeStuff() {
	$('#pickup-form').off('beforeSubmit');
}



function doStripeStuff() {
	
  	$('#pickup-form').on('beforeSubmit', function (event) {
  		
  		var form = $('#pickup-form');

	    Stripe.card.createToken(form, stripeResponseHandler);

	    return false;
	});

};
	
	
function stripeResponseHandler(status, response) {
  	
  	var form = $('#pickup-form');

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

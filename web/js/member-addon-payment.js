$(document).ready(function() {

	var membershipType = $('#membership-type').val();

	checkIfPaymentNeeded();
	

	$('.addon-number').change(function() {
		checkIfPaymentNeeded();
	});

	$('.addon-number').on('keypress', function(e) {
		if ($(this).val() == 0) 			
			$(this).val() = '';
	});


	var hasAddOns;
	var total = 0;
	
	function checkIfPaymentNeeded() {

		var totalQuantity = 0;
		total = 0;
		var items = [];


		if(membershipType == 'free') {

			$('#pay-modal').click(function(evt) {

			});

		} //end if membership is free


		// Loop through addons
		$('.addon-number').each(function () {
			
			if($(this).val()) {
				var quantity = parseInt($(this).val());
				var price = parseFloat($(this).data('price')); 
				var title = $(this).data('product');

				totalQuantity = totalQuantity + quantity;
				totalThisItem = price * quantity;
				total = total + totalThisItem;

				items.push(title + ' (QTY:' + quantity + ')');  
			}
			
		}); //End the loop

		// Do stuff if addons are added
		if (totalQuantity > 0 || membershipType == 'free') {
			hasAddOns = true;
			$('#addon-modal').removeClass('hidden');
			$('.btn-submit').addClass('hidden');
			$('.items-json').val(JSON.stringify(items))
			$(".charge-amount").val(total.toFixed(2));
		
		} else {
			hasAddOns = false;
			$('#addon-modal').addClass('hidden');
			$('.btn-submit').removeClass('hidden');		
			$(".charge-amount").val(null);  
		}
	
		// console.log(items);
	}


	$('#addon-modal').click(function(evt) {

		if(!$('input[name="Pickup[day]"]').is(':checked')) {
			alert("Please select a Pickup Day"); 
			return false;
		} 

		if(membershipType == 'free') {
			if(!$('input[name="Pickup[size]"]').is(':checked')) { 
				alert("Please select a Size"); 
				return false;
			}

			if($('#pickup-selection .size.active').data('size') == "half") {
				total = total + parseInt($('#half-value').html());
				$(".charge-amount").val(total.toFixed(2));
			} else {
				total = total + parseInt($('#full-value').html());
				$(".charge-amount").val(total.toFixed(2));
			}

			if ($('.using-saved-cc').val() != 1) {
				doStripeStuff(); 
			} else {
				eliminateStripeStuff();
			}

		} //End if membership is free
					

		if(membershipType != 'free') {
			if (hasAddOns && $('.using-saved-cc').val() != 1) {
				// if($('.using-saved-cc').val() != 1)
				doStripeStuff(); 	
				console.log('doing stripe stuff');	
			} else {
				eliminateStripeStuff();
				console.log('eliminated stripe stuff');	
			}
		}
	});



	// $('#addon-modal').click(function(evt) {

	// 	var total = 0;

	// 	// Loop through addons
	// 	$('.purchaseble-add-on').each(function () {
	// 		if(this.checked) {
	// 			var addonPrice = $(this).data('price');
	// 			total = addonPrice + total;
	// 		}
	// 	});

		
	// 	$(".charge-amount").val(total.toFixed(2));
	// 	console.log(total.toFixed(2));

	// });

});



function eliminateStripeStuff() {
	console.log('disabling stripe');
	$('#pickup-form').off('beforeSubmit');
}



function doStripeStuff() {
	console.log('initiating stripe');
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

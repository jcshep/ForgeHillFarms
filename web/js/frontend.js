


$(document).ready(function() {

	$('.membership-selection .modal-radio').click(function(evt) {

		var membership = $(this).data('membership-type');

		// console.log(membership);

		$(this).addClass('checked');
		$('.membership-selection .modal-radio').not(this).removeClass('checked');

		if(membership == 'full' || membership == 'half') {
			$('.credit-card-form').slideDown();
		} else {
			$('.credit-card-form').slideUp();
		}

		$('.user-create .submit-group').fadeIn();

	});



	// Free member checkout
	$('#pay-modal').click(function(evt) {

		if(!$('input[name="Pickup[day]"').is(':checked')) { 
			alert("Please select a Pickup Day"); 
			return false;
		}

		if(!$('input[name="Pickup[size]"').is(':checked')) { 
			alert("Please select a Share Size"); 
			return false;
		}

		var size = $('#pickup-selection .size.active').data('size');
		var total;


		if(size=="half") {
			total = parseInt($('#half-value').html());
		} else {
			total = parseInt($('#full-value').html());
		}

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





	// Newsletter submit form
	$("#newsletter-signup").submit(function(e) {
			
			var url = "site/newsletter-signup"; 

			$.ajax({
				type: "POST",
				url: url,
	           	data: $("#newsletter-signup").serialize(), // serializes the form's elements.
	           	success: function(data) {
	           		if(data == 'success') {
	           			$("#newsletter-signup .alert").fadeIn();
	           			$("#newsletter-signup input").val('');
	           		}
	           	}
	       });

	    e.preventDefault(); // avoid to execute the actual submit of the form.
	})





	// Editor functions
	$('a.edit').click(function(ev){

		ev.preventDefault(); // avoid to execute the actual submit of the form.

		var slug = $(this).data('slug');
		var type = $(this).data('type');   
		var anchor = $(this).data('anchor');       
		var url = '/page/get-content?slug='+slug+'&anchor='+anchor+'&type='+type;
		
		console.log(url);

		$('#edit-modal').modal().find('.modal-body').load(url, function () {	
			
			setTimeout(function() {
					$('.wysiwyg').trumbowyg();
			  }, 600);
		});

		return false;
     });



	// Slide Out Menu
	$("#hamburger").click(function() {
		if($("#slide-out").hasClass("expanded")) {
			$('#slide-out').animate({right: '-60%'}, 200, function() {
			    $("#slide-out").removeClass("expanded");
			  });
			$('body').animate({left: '0%'}, 200);
		} else {
			$('#slide-out').animate({right: '0%'}, 200, function() {
			    $("#slide-out").addClass("expanded");
			  });
			$('body').animate({left: '-60%'}, 200);
			// $('body').animate({marginRight: '60%'}, 200);
		}
	});



	// Account - Select Pickup Day
	$("#pickup-selection .day").click(function() {
		var day = $(this).data('day');

		$("#pickup-selection .day").not(this).removeClass('active');
		$(this).addClass('active');
		
		$("input[type=radio]."+day).prop("checked", true);

		return false;
	});


	// Account - Select Pickup Size
	$("#pickup-selection .size").click(function() {
		var size = $(this).data('size');
		// var total;

		$("#pickup-selection .size").not(this).removeClass('active');
		$(this).addClass('active');
		
		$("input[type=radio]."+size).prop("checked", true);


		// if(size=="half") {
		// 	total = parseInt($('#half-value').html());

		// } else {
		// 	total = parseInt($('#half-value').html());
		// }

		// // Loop through addons
		// $('.purchaseble-add-on').each(function () {
		// 	if(this.checked) {
		// 		var addonPrice = $(this).data('price');
		// 		total = addonPrice + total;
		// 	}
		// });
		

		// console.log(total);
		// $(".charge-amount").val(total);

		return false;
	});


});
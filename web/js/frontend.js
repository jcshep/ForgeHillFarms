


$(document).ready(function() {

	$('.membership-selection .modal-radio').click(function(evt) {

		var membership = $(this).data('membership-type');

		console.log(membership);

		$(this).addClass('active');
		$('.membership-selection .modal-radio').not(this).removeClass('active');

		if(membership == 'full' || membership == 'half') {
			$('.credit-card-form').slideDown();
		} else {
			$('.credit-card-form').slideUp();
		}

		$('.user-create .submit-group .btn-primary').fadeIn();

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




});
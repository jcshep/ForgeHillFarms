


$(document).ready(function() {

	$('.wysiwyg').trumbowyg({
		autogrow: true,
		removeformatPasted: true,
		btns: [
	        ['viewHTML'],
	        ['fontsize'],
	        ['underline'],
	        ['upload'],
	        // ['undo', 'redo'], // Only supported in Blink browsers
	        ['formatting'],
	        ['strong', 'em'],
	        // ['superscript', 'subscript'],
	        ['link'],
	        // ['insertImage'],
	        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
	        ['unorderedList', 'orderedList'],
	        // ['horizontalRule'],
	        // ['removeformat'],
	    ],
	    plugins: {
	        upload: {
	            serverPath: '/admin/upload-file'
	        }
	    }
	});



});
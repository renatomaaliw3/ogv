$(document).ready(function() {

	

	$('div#grades').on("click","td.update a", function(e) {

		e.preventDefault();

		var $this = $(this);
		var overlay = $('div.overlay');

		var entryid = $this.parent().siblings("td.entryid").text();
		var studentid = $this.parent().siblings("td.studentid").text();

		var viewportWidth = $(window).width(); //width of browser viewport
		var halfWidth = viewportWidth / 2;	
		var overlaywidth = overlay.width(); //width of overlay

		var update_position = $this.position(); //position of update button "e"
		var tr_height = $this.parent().innerHeight(); //height of parent tr including padding

		overlay.fadeIn();
		overlay.css({
					 'top': update_position.top + tr_height,
					 'left': update_position.left - overlaywidth - 18
					}); //these are css settings


		$.ajax({

			url:'overlay.php',
			type: 'GET',
			data: {entryid: entryid},

			success: function(response) {

				overlay.html(response);
				
			}

		}); //ajax

	}); //event click

	$('div.overlay').on('click', 'p.close', function(e) {

		e.preventDefault();

		var overlay = $('div.overlay');

		overlay.empty(); //empty contents of div.overlay
		overlay.fadeOut(); //fade out form
	

	});

	$('div.overlay').on('submit','form#update_form', function(e) {

		e.preventDefault();

		var $this = $(this);
		var overlay = $('div.overlay');
		var grades = $('div#grades');

		$.ajax({

			url:'executeupdate.php',
			type: 'POST',
			data: $this.serialize(),

			beforeSend: function() {

				overlay.find('p').text('Saving Data ...'); //change p text beforeSend of AJAX
				
			},

			success: function(response) {

				grades.html("<p> Loading Updated Data ... </p>");
				grades.load('viewgrade.php?studentid=' + response + ' #gradescontent', function() {

					overlay.find('p').text('Close');
					copy_gwa(); //custom function
					
				}); //callback function after loading viewgrade.php?studentid={number}, function()

			}

		}); //ajax

	}); //submit

	$('div#branding2').on('keyup','input#student_search', function() {

		$this = $(this);

		var search_string = $.trim($this.val());

		if (search_string.length >= 2) { //check if search_string value is 2 or more

			currentRequest = $.ajax({ //ajax is assign to a variable to use the abort() method

					url: 'search.php',
					type: 'POST',
					data: {student_search : search_string}, //$_POST['student_search'], var search_string


					beforeSend: function() {

						if (currentRequest != null) { 

							$('div.overlay_search ol').html("<li> Retrieving Data ... </li>"); //if still requesting
							currentRequest.abort(); //abort ajax request if a previous ajax request is in queue

						}

						
					},

					success: function(response) {

						$('div.overlay_search').show(); //show overlay_search
						$('div.overlay_search ol').html(response); //response from search.php

					}

			}); //ajax


		} else {

			$('div.overlay_search').hide(); //if search string is less than 2 hide the overlay

		}

	}); //keyup

	$(document).on('keyup','form.profile :input', function() {

		student_profile_validation();

	});

	$('td.viewgrade a').hover( //mouseover, mouseout

		function() { //mouseover

			$this = $(this);
			p_gwa = $('p#gwaonhover');

			gwa_hover($this, p_gwa);

		}, function() { //mouseout

			p_gwa.hide();
	
		}

	);

	copy_gwa(); //custom functions
	
}); //document ready

// CUSTOMIZED FUNCTIONS HERE //

var currentRequest = null;

function copy_gwa() { //copy gwa on top adjacent to student name

	var gradescontent = $('div#gradescontent');
	var orig_gwa = gradescontent.find('td#gwa').text();
	var copy_gwa = gradescontent.find('span#copy_gwa').text(orig_gwa);

	if (orig_gwa >= parseFloat(3.00)) { //if >= 3.00 set to red

		copy_gwa.css('color','red');

	} else if (orig_gwa <= parseFloat(1.75)) { //if 1.75 below set to blue

		copy_gwa.css('color','blue');

	}

}

function student_profile_validation() { //validate form student profile in Admin

	var student_profile_fields = $('form.profile').find(':input'); // find all input fields
	var errorExists = false; //if no errors in input
	var errorMessages = ''; //consolidate errors in this variable

	//var fields = new Array('lastname','firstname','middlename','username','passkey');

	student_profile_fields.each(function() {

		var $this = $(this); //the input fields
		var value_length = $this.val().length; //length of input values

		switch ($this.attr('name')) {

			case 'lastname':

				if (value_length <= 1 || $.trim($this.val()) === '') {

					errorMessages += "<li>" + $this.siblings('label').text() + "must be 2 or more characters </li>";
					errorExists = true;
		
				}

			break;

			case 'firstname':

				if (value_length <= 1 || $.trim($this.val()) === '') {

					errorMessages += "<li>" + $this.siblings('label').text() + "must be 2 or more characters </li>";
					errorExists = true;
		
				}

			break;

			case 'username':

				if (value_length <= 3 || $.trim($this.val()) === '') {

					errorMessages += "<li>" + $this.siblings('label').text() + "must be 4 or more characters </li>";
					errorExists = true;
		
				}



			break;

			case 'passkey':

				if (value_length <= 4 || $.trim($this.val()) === '') {

					errorMessages += "<li>" + $this.siblings('label').text() + "must be 5 or more characters </li>";
					errorExists = true;
		
				}

			break;

			case 'confirmpasskey':

				if (value_length <= 4 || $.trim($this.val()) === '') {

					errorMessages += "<li>" + $this.siblings('label').text() + "must be 5 or more characters </li>";
					errorExists = true;
		
				}

				if ($('form.profile').find('input#passkey').val() != $.trim($this.val())) { //must match the password

					errorMessages += "<li> Passwords must match! </li>";
					errorExists = true;

				}

			break;

		}
	
	});

	
	if (errorExists == true) {

		$('div#gradescontent').find('ol#errormessages').html(errorMessages).prepend("<h4>Error:</h4>");
		$('div#gradescontent').find('ol#errormessages').show();

	} else {

		$('div#gradescontent').find('ol#errormessages').hide();

	}


}

function gwa_hover($this, p_gwa) {

		position_gwa_top = $this.position().top;
		position_gwa_left = $this.position().left;

		currentRequest = $.ajax({

			beforeSend: function() {

				p_gwa.fadeIn().text('loading...');

				if (currentRequest != null) {

					currentRequest.abort();

				}

			},

			success: function() {

				gwa_value = p_gwa.load($this.attr('href') + ' td#gwa').text();

			}


		}); 

	
		p_gwa.css({

				 'top': position_gwa_top - 9,
				 'left': position_gwa_left + 48
				
				 }); //these are css settings
		

}
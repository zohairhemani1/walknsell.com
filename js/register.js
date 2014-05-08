$(document).ready(function(e) 
{
    
	//alert('hello world');
	signupForm();
	
	
	
});

// register form ajax

document.getElementById('signup').onclick = function()
{
	
}


function signupForm()
{
	
		
	
		// variable to hold request
		var request;
		// bind to the submit event of our form
		$("#signup").submit(function(event){
		// show loading bar until the json is recieved
		$('#loading').html('<img src="img/loading.gif">');
		validation();
    // abort any pending request
		if (request) {
			request.abort();
		}
		// setup some local variables
		var $form = $(this);
		// let's select and cache all the fields
		var $inputs = $form.find("input, select, button, textarea");
		// serialize the data in the form
		var serializedData = $form.serialize();
		
		
		// let's disable the inputs for the duration of the ajax request
		// Note: we disable elements AFTER the form data has been serialized.
		// Disabled form elements will not be serialized.
		
			
		//if(validation()==true)
		//{
			$inputs.prop("disabled", true);
		// fire off the request to /form.php
			request = $.ajax({
				url: "http://www.fajjemobile.info/korkster/signup_form.php",
				type: "post",
				data: serializedData
			});
			
				// callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
				// log a message to the console
				console.log("Hooray, it worked!");
				$('loading').html('');
				window.location.href = "your-questions.html";
			});
		
			// callback handler that will be called on failure
			request.fail(function (jqXHR, textStatus, errorThrown){
				// log the error to the console
				$('#loading').html('');
				alert('Request Failed!');
				console.error(
					"The following error occured: "+
					textStatus, errorThrown
				);
			});
	
			// callback handler that will be called regardless
			// if the request failed or succeeded
			request.always(function () {
				// reenable the inputs
				$inputs.prop("disabled", false);
			});
			
			
		//} // if clause end's here of validation
	
		// prevent default posting of form
		event.preventDefault();
	});
	
}



function validation()

{
	var error = document.getElementById('error');
	var username = document.getElementById('username').value;
	var firstName = document.getElementById('firstName').value;
	var lastName = document.getElementById('lastName').value;
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;
	var verifyPassword = document.getElementById('verifyPassword').value;
	
	if(password != verifyPassword)
	{error.innerHTML = "Password doesn't match!";}
	else if (username!=null || firstName !=null lastName !=){error.innerHTML = "";}
	else { error.innerHTML = "All good!"; }
	
}
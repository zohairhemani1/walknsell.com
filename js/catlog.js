var error;

$(document).ready(function(e) 
{
    
alert('dfdf');
sendMessage();

	
});


function sendMessage()
{
	
	
	
		// variable to hold request
		var request;
		// bind to the submit event of our form
		$("#msg-form").submit(function(event){
		// show loading bar until the json is recieved
		
alert('dfdf');

		
    	// abort any pending request
		if (request) {
			request.abort();
		}
		
		
			request = $.ajax({
				url: "http://www.fajjemobile.info/korkster.com/catlog_sendmsg.php",
				type: "post",
				data: serializedData
			});
			
				// callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
				// log a message to the console
				
				
					$('#loading').html('Message Sent');
				
				
				//window.location.href = "your-questions.html";
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
			});
			
			
		// prevent default posting of form
		event.preventDefault();
	});
	
}


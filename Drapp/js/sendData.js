function sendMessage()
{
		var request;
		
        $("#msgForm").on('submit',function(){
		$(document).ajaxSend(function(e, jqXHR){
            $('#msgForm *').attr('disabled', true);
            $('.gif_image').show();
            });
            var formData = new FormData($(this)[0]);
            formData.append("sender",sender);
            formData.append("receiver",receiver);
			request = $.ajax({
				url: "inbox_sendmsg.php",
                contentType: false,
                processData: false,
				type: "post",
                cache: false,
                data: formData
				//data: {msg:$('#reply_texts').val(),sender:sender,receiver:receiver}
			});
				// callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
                   $('#msgForm *').attr('disabled', false);
                $('.gif_image').hide();
					if(response.request=="Message Sent!"){
                        $(document).ajaxComplete(function(e, jqXHR){
                        //remove the div here
                        });
                        var files = $('#FileUpload')[0].files;
                        var filenames = [];
                         
                        var datetime = moment().format('HH:mm MMMM,Do,YYYY');
                        for (var i = 0; i < files.length; i++) {
                            filenames.push(files[i].name);
                        }
                        if (filenames.length === 0){
                            $( "<div class='msg_wrap_2'> <div class='messege_push'><span class='user-pict_50'>"
                            +"<a href='/"+username+"'><img src='img/users/"+img+"' width='50' height='50' /></a></span>"
                            +"<h4><a href='/"+username+"'>"+fname + " "+lname+"</a></h4> <div class='msg_body'>"
                             +" <p class='texttype'>"+$('#reply_texts').val()+"</p></div></div>"
                              +"<div class='msgtime'>"
			                 +"<p>"+datetime+"</p></div>"
			                 +"<div class='clear'></div></div>"
                           +"<div class='clear'></div>" ).insertBefore( ".reply_box_22" );
                        }else{
                            filenames_final = response.files;
                            var filename ="";
                            for (var i = 0; i < filenames.length; i++) {
                                filename += "<p class='attachment-para'><a class='attachment-anchor' href='assets/inboxData/"+filenames_final[i]+"' download>"+filenames[i]+"</a></p>";
                            }
                            
                            $( "<div class='msg_wrap_2'> <div class='messege_push'><span class='user-pict_50'>"
                            +"<a href='/"+username+"'><img src='img/users/"+img+"' width='50' height='50' /></a></span>"
                            +"<h4><a href='/"+username+"'>"+fname + " "+lname+"</a></h4> <div class='msg_body'>"
                             +" <p class='texttype'>"+$('#reply_texts').val()+"</p>"+filename+"</div></div>"
                           +"<div class='clear'></div>" ).insertBefore( ".reply_box_22" );
                        }
							
						//location.reload();
						$('#reply_texts').val('');
                        $("#FileUpload").replaceWith($("#FileUpload").val('').clone(true));
                        $('#fileAttach').html("<span class='fa fa-file'> &nbsp;</span>ATTACH FILE");
					}else{
                        alert(response);
                    }
				//window.location.href = "your-questions.html";
			});
		
			// callback handler that will be called on failure
			request.fail(function (jqXHR, textStatus, errorThrown){
				// log the error to the console
				alert('Request Failed!');
				console.error("The following error occured: "+textStatus, errorThrown);
			});
	
			// callback handler that will be called regardless
			// if the request failed or succeeded
			request.always(function () {
				// reenable the inputs
			});
			}else{
				$(".error-alert").text("Your message should contain atleast 4 characters.");
			}
	       return false;
	});
	
}
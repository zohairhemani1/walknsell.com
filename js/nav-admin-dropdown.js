
$(function() {      
          $("nav.main_nav li#admin > ul, div#sidr li#admin > ul").css("display","none");
        
			       
           			$("nav.main_nav li#admin, div#sidr li#admin").hover(function () {   
         							  $( "nav.main_nav li#admin > ul, div#sidr li#admin > ul" ).css( "display", "block" );
	            },          
            	function () {      
							           $( "nav.main_nav li#admin > ul, div#sidr li#admin > ul" ).css( "display", "none" );
				        });   
		});
					 
					 
					 function closeMenu() {
       
	   $.sidr('close', 'sidr');
	    return true;
	}
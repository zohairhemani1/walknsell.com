 $(document).ready(function(){
 var booleanvalue = true;

 });
 
$('#search').keyup(function(e)
{
      
	
	    var key = e.keyCode;
    if(key == 13) {
        $("#results").css("display", "none");
		window.location.href = $('#search_url').val();
      }

    if ( key == 40 || key == 38  || key == 37 || key == 39 || key == 33 || key == 13 || key == 9) return;

		$("#results").css("display", "block");
		document.getElementById('results').innerHTML = 'Loading..';
		
		if(window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}

		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
			
			//var ul = document.getElementById("results");
			//var li = document.createElement("li");
			//li.appendChild(document.createTextNode(xmlhttp.responseText));
			//ul.appendChild(li);
			
			document.getElementById('results').innerHTML = xmlhttp.responseText;
			}
		}
			
			xmlhttp.open('GET','search_list.inc.php?search_text='+document.search.search_text.value+'&mode=search',true);
			xmlhttp.send();
			

});
		
$(document).on('click','#results li' , function() {
	$('#submit-all').val($(this).text());

});


$(document).on('click','#submit-all' , function() {
	console.log( booleanvalue);
	$('#general_submit').submit();

});

$('#regsearch').keyup(function(event)
{

	    var key = event.keyCode;

    if(key == 13){
    $("#regresults").css("display", "none");
    }

    if ( key == 40 || key == 38  || key == 37 || key == 39 || key == 9) return;


		document.getElementById('regresults').innerHTML = 'Loading..';
		
		if(window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
			
			//var ul = document.getElementById("results");
			//var li = document.createElement("li");
			//li.appendChild(document.createTextNode(xmlhttp.responseText));
			//ul.appendChild(li);
			/*if(xmlhttp.responseText == "No results found!"){
				$('#regsearch').val('');
			}*/
			document.getElementById('regresults').innerHTML = xmlhttp.responseText;
			}
		}

			
			xmlhttp.open('GET','/search_list.inc.php?search_text='+$('#regsearch').val()+'&mode=register',true);
			xmlhttp.send();
});


$(document).on('click','#regresults li' , function() {
    booleanvalue = true;
    //console.log(booleanvalue);
	$('#regsearch').val($(this).text());
	$('#regresults').empty();
});
$(document).on('click','#results li' , function() {     
	$('.tftextinput').val($(this).text());
    $("#results").css("display", "none");
    $('#search_url').val($(this).attr('id'));
});
$(document).on('click','.tfbutton' , function(e) {
    if($('#search').val() == null){
        e.preventDefault();
        return false;
    }else{
	window.location.href = $('#search_url').val();
    //$("#search").attr("action", $('#school_url_hidden').val());
    }
    });

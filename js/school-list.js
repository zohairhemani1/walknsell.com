function findmatch()
{
		
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
			
}
		


$(document).on('click','#results li' , function() {
	$('#uni').val($(this).text());

});



function regfindmatch()
{
	
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
			
			document.getElementById('regresults').innerHTML = xmlhttp.responseText;
			}
		}
			
			xmlhttp.open('GET','search_list.inc.php?search_text='+$('#regsearch').val()+'&mode=register',true);
			xmlhttp.send();
}
		


$(document).on('click','#regresults li' , function() {
	$('#regsearch').val($(this).text());
	$('#regresults').empty();
	

});

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
			
			xmlhttp.open('GET','search_list.inc.php?search_text='+document.search.search_text.value,true);
			xmlhttp.send();
			
}
		


$(document).on('click','#results li' , function() {
	$('#uni').val($(this).text());

});

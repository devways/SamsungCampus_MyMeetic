var timer;
function ajax_region(val) {
	$.ajax({
		type: 'post',
		url: 'region.php',
		data: {
		pays:val
		},
		success: function (response) {
		document.getElementById("region").innerHTML=response;
		document.getElementById("departement").innerHTML=""; 
		document.getElementById("ville").innerHTML="";  
		}
	});
}
function ajax_departement(val) {
	$.ajax({
		type: 'post',
		url: 'departement.php',
		data: {
		region:val
		},
		success: function (response) {
		document.getElementById("departement").innerHTML=response; 
		document.getElementById("ville").innerHTML=""; 
		}
	});
}
function ajax_ville(val) {
	$.ajax({
		type: 'post',
		url: 'ville.php',
		data: {
		departement:val
		},
		success: function (response) {
		document.getElementById("ville").innerHTML=response; 
		}
	});
}
function search_contact(val) {
	$.ajax({
		type: 'post',
		url: 'searchContact.php',
		data: {
		contact:val,
		},
		success: function (response) {
		document.getElementById("contact").innerHTML=response; 
		}
	});	
}
function discution(val) {
	clearInterval(timer);
	timer = setInterval(discution, 500);
	$.ajax({
		type: 'post',
		url: 'discution.php',
		data: {
		contact:val,
		},
		success: function (response) {
		document.getElementById("message").innerHTML=response; 
		}
	});	
}
function insertMsg(val) {
	$.ajax({
		type: 'post',
		url: 'insertMsg.php',
		data: {
		Msg:val,
		},
		success: function (response) {
		document.getElementById("form").innerHTML=response;
		}
	});	
}
function deletMsg(val) {
	$.ajax({
		type: 'post',
		url: 'deletMsg.php',
		data: {
		Msg:val,
		}
	});		
}
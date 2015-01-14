var catSelected = 'All';
var comSelected = 'All';
var siteSelected = 'All';


$(document).ready(function(){
	
	//Initialize UI Elements
	$("table") .tablesorter({widthFixed: true})
	.tablesorterPager({container: $("#pager")}); 	
	$("#radio").buttonset();
	
	$("#intro").dialog({
		height: 120,
		position: 'top',
		modal: true,
		width: 370
	});	
	
	//Initialize Selectable li's
	$("#selCategories").selectable({
		stop: function(){
			$(".ui-selected", this).each(function(){
				updateCategories(this.id);
			});
		}
	});
	
	$("#selCompanies").selectable({
		stop: function(){
			$(".ui-selected", this).each(function(){
				updateCompanies(this.id);
			});
		}
	});

	//Initialize Buttons
	$("#radio").buttonset({
		ajaxOptions: {
			error: function(xhr, status, index, anchor) {
				$(anchor.hash).html("Couldn't load this tab. We'll try to fix this as soon as possible. If this wouldn't be a demo.");
			}
		}
	});
		
});

// End of jQuery init

function displayLoading(){
	document.getElementById('output').innerHTML = '<center><img src="css/images/loading1.gif" /></center>';
}

function search(query){
	if(query.value.length > 2){
	$.ajax({
		type: "get",
		url: "backend.php",
		data: "query=" + query.value + "&table=" + query.name,
		success: function(resp){  
		   document.getElementById('output').innerHTML = resp;
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	}
}

function getSelectedSite(site){
	updateSites(site.id);
}

function initTable(){
	$("table") .tablesorter({widthFixed: true})
	.tablesorterPager({container: $("#pager")}); 
}

function initCats(){
	$("#selCategories").selectable({
		stop: function(){
			$(".ui-selected", this).each(function(){
				updateCategories(this.id);
			});
		}
	});

}

function initCompanies(){
	$("#selCompanies").selectable({
		stop: function(){
			$(".ui-selected", this).each(function(){
				updateCompanies(this.id);
			});
		}
	});
}

function initSites(){
	$("#radio").buttonset({
		ajaxOptions: {
			error: function(xhr, status, index, anchor) {
				$(anchor.hash).html("Couldn't load this tab. We'll try to fix this as soon as possible. If this wouldn't be a demo.");
			}
		}
	});
}

function updateCategories(selection){
	
	displayLoading();
	var table = document.getElementById('table').value;
	catSelected = selection;
	
	$.ajax({
		type: "get",
		url: "setCategories.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('catResults').innerHTML = resp;
		  initCats();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	
	$.ajax({
		type: "get",
		url: "setCompanies.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('companyResults').innerHTML = resp;
		  initCompanies();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	
	$.ajax({
		type: "get",
		url: "setSite.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('siteResults').innerHTML = resp;
		  initSites();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	
	updateState(table);
}

function updateCompanies(selection){

	displayLoading();
	var table = document.getElementById('table').value;
	comSelected = selection;
	
	$.ajax({
		type: "get",
		url: "setCompanies.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('companyResults').innerHTML = resp;
		  initCompanies();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	
	$.ajax({
		type: "get",
		url: "setCategories.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('catResults').innerHTML = resp;
		  initCats();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	
	$.ajax({
		type: "get",
		url: "setSite.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('siteResults').innerHTML = resp;
		  initSites();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	
	updateState(table);
}

function updateSites(selection){
	
	displayLoading();
	var table = document.getElementById('table').value;
	siteSelected = selection;

	$.ajax({
		type: "get",
		url: "setSite.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('siteResults').innerHTML = resp;
		  initSites();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	
	$.ajax({
		type: "get",
		url: "setCategories.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('catResults').innerHTML = resp;
		  initCats();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	
	$.ajax({
		type: "get",
		url: "setCompanies.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('companyResults').innerHTML = resp;
		  initCompanies();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
	
	updateState(table);
}

function updateState(table){

	$.ajax({
		type: "get",
		url: "backend.php",
		data: "table=" + table + "&category=" + catSelected + "&company=" + comSelected + "&site=" + siteSelected,
		success: function(resp){  
		  document.getElementById('output').innerHTML = resp;
		  initTable();
		},  
		error: function(e){  
		  alert('Error: ' + e);  
		}  
	})
}

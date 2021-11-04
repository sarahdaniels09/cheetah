$( document ).ready(function() {
	load(1); 


});




//Cargar datos AJAX
function load(page){
	var search=$("#search").val();
	var status_courier=$("#status_courier").val();
	var filterby=$("#filterby").val();
	// var per_page=$("#per_page").val();
	var parametros = {"page":page,'search':search, 'status_courier':status_courier, 'filterby':filterby};
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/pre_alerts/prealert_list_ajax.php',
		data: parametros,
		 beforeSend: function(objeto){
		// $("#loader").html("<img src='./img/ajax-loader.gif'>");
	  },
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			// $("#loader").html("");
		}
	})
}


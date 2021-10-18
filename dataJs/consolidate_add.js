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
		url:'./ajax/consolidate/courier_list_add_ajax.php',
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


$( "#save_data" ).submit(function( event ) {
	var parametros = $(this).serialize();

	$.ajax({
			type: "POST",
			url: "ajax/tools/category/category_add_ajax.php",
			data: parametros,			
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Please wait...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);

			$('html, body').animate({
	            scrollTop: 0
	        }, 600);

						
		  }
	});
  event.preventDefault();
	
})





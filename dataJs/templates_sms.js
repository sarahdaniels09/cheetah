$( document ).ready(function() {
	load(1);  

});


//Cargar datos AJAX
function load(page){
	var search=$("#search").val();
	// var per_page=$("#per_page").val();
	var parametros = {"page":page,'search':search};
	$("#loader").fadeIn('slow');
	$.ajax({
		url: "ajax/tools/templates_sms/templates_sms_ajax.php",
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


//Registro de datos

$( "#save_data" ).submit(function( event ) {
	    var parametros = $(this).serialize();

	$.ajax({
			type: "POST",
			url: "ajax/tools/templates_sms/templates_sms_edit_ajax.php",
			data: parametros,			
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Please wait...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);

			$('html, body').animate({
	            scrollTop: 0
	        }, 600);

			// window.setTimeout(function() {
			// $(".alert").fadeTo(500, 0).slideUp(500, function(){
			// $(this).remove();});}, 5000);				
		  }
	});
  event.preventDefault();
	
})



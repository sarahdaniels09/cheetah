

$( "#save_data" ).submit(function( event ) {
	var parametros = $(this).serialize();

	$.ajax({
			type: "POST",
			url: "ajax/tools/payment_gateways/paystack_config_ajax.php",
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



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
		url:'./ajax/tools/status_courier/status_courier_list_ajax.php',
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

	
//Eliminar
	function eliminar(id){

      // $('body').on('click',id, function () {
          // var id = $(this).attr('id').replace('item_', '')
          var parent = $('#item_'+id).parent().parent();
          var name = $(this).attr('data-rel');
          new Messi('<p class="messi-warning"><i class="icon-warning-sign icon-3x pull-left"></i>Are you sure you want to delete this record?<br /><strong>This action cannot be undone!!!</strong></p>', {
              title: 'Delete User',
              titleClass: '',
              modal: true,
              closeButton: true,
              buttons: [{
                  id: 0,
                  label: 'Delete',
                  class: '',
                  val: 'Y'
              }],
              	callback: function (val) {
                  	if (val === 'Y') {
                      	$.ajax({
                          type: 'post',
                          url:'./ajax/tools/status_courier/status_courier_delete_ajax.php',
                          data: {		                          	
							  'id': id,								  
						  },
                          beforeSend: function () {
                              parent.animate({
                                  'backgroundColor': '#FFBFBF'
                              }, 400);
                          },
                          success: function (data) {
                              // parent.fadeOut(400, function () {
                              //     parent.remove();
                              // });
                              $('html, body').animate({
                                  scrollTop: 0
                              }, 600);
                              $('#resultados_ajax').html(data);
                              // console.log(data);

                              load(1);
                          }
                      	});
                  	}
              	}

          // });
      });		
	}
//Registro de datos

$( "#save_data" ).submit(function( event ) {
	var parametros = $(this).serialize();

	$.ajax({
			type: "POST",
			url: "ajax/tools/status_courier/status_courier_add_ajax.php",
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



$( "#update_data" ).submit(function( event ) {
	var parametros = $(this).serialize();

	$.ajax({
			type: "POST",
			url: "ajax/tools/status_courier/status_courier_edit_ajax.php",
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



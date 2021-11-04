$( document ).ready(function() {
	load(1);  

});


//Cargar datos AJAX
function load(page){
	
	$.ajax({
		url:'./ajax/notifications_list_ajax.php',
		 beforeSend: function(objeto){
		// $("#loader").html("<img src='./img/ajax-loader.gif'>");
	  },
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			// $("#loader").html("");
		}
	})
}


function updateNotificationsRead(){

      var name = $(this).attr('data-rel');
     	new Messi('<p class="messi-info"><i class="icon-warning-sign icon-3x pull-left"></i>Are you sure to mark all notifications as readed?</p>', {
          title: 'Update Notifications',
          titleClass: '',
          modal: true,
          closeButton: true,
          buttons: [{
              id: 0,
              label: 'Update',
              class: '',
              val: 'Y'
          }],
          	callback: function (val) {
              	if (val === 'Y') {
                  	$.ajax({
                      type: 'post',
		url:'./ajax/notifications_update_read_ajax.php',				
                      
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

      	});
}






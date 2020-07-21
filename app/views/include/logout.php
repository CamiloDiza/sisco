<script>
	$(document).ready(function(){
		$('.logout').on('click', function(e){
			e.preventDefault();
			swal({
				title: '¿Deseas salir?',
				text: 'La sesión actual se cerrará',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#03A9F4',
				cancelButtonColor: '#F44336',
				confirmButtonText: '<i class="zmdi zmdi-run"></i> Si, salir',
				cancelButtonText: '<i class="zmdi zmdi-run"></i> No, cancelar'
			}).then(function(){
				
				$.ajax({
					url: "<?php echo SERVER_URL ?>app/ajax/logAjax.php?action=logout",
					success: function(data){
						if(data == true)
						{
							window.location.href="<?php echo SERVER_URL ?>login/";
						}else{
							swal(
								"Ocurrio un error",
								"No se pudo cerrar la sesión",
								"error"
								);
						}
					}
				});
			});
		});
	});
</script>
<?php

	/*
		Types: warning, error, success, info, and question
	*/

	class Alerts
	{
		public function incomplete_alert()
		{
			return $alert = "
				<script>
					swal(
					  'Formulario incompleto',
					  'Debe llenar todos los campos requeridos',
					  'warning'
					)
				</script>
			";
		}

		public function sweet_alert($type, $dates)
		{
			switch($type) 
			{
				case 'basic':
					return $alert = "
						<script>
							Swal.fire('".$dates['text']."')
						</script>
					";
				break;

				case 'simple':
					return $alert = "
						<script>
							swal(
							  '".$dates['title']."',
							  '".$dates['text']."',
							  '".$dates['type']."'
							)
						</script>
					";
				break;
				
				case 'link':
					$alert = "
						<script>
							swal({
							  icon: '".$dates['type']."',
							  title: '".$dates['title']."',
							  text: '".$dates['text']."',
							  footer: '<a href='".$dates['url']."'>".$dates['url_text']."</a>'
							})
						</script>
					";
				break;

				case 'clear':
					return $alert = "
						<script>
							swal({
								title: '".$dates['title']."',
								text: '".$dates['text']."',
								type: '".$dates['type']."',
								confirmButtonText: 'Aceptar'
								}).then(function(){
									$('.FormularioAjax')[0].reset();
									});
						</script>
					";
				break;

				case 'reload':
					return $alert = "
						<script>
							swal({
								title: '".$dates['title']."',
								text: '".$dates['text']."',
								type: '".$dates['type']."',
								confirmButtonText: 'Aceptar'
								}).then(function(){
									location.reload();
									});
						</script>
					";
				break;

				case 'close':
					return $alert = "
						<script>
							swal({
								title: '".$dates['title']."',
								text: '".$dates['text']."',
								type: '".$dates['type']."',
								confirmButtonText: 'Aceptar'
								}).then(function(){
									window.close();
									});
						</script>
					";
				break;

				/*case 'confirm':
					$alert = "
						<script>
							Swal.fire({
							  title: '".$dates['type']."',
							  text: '".$dates['text']."',
							  icon: '".$dates['type']."',
							  showCancelButton: ".$dates['cancel'].",
							  confirmButtonColor: '#3085d6',
							  cancelButtonColor: '#d33',
							  confirmButtonText: '".$dates['confirm_text']."'
							}).then((result) => {
							  if (result.value) {
							    ".sweet_alert($dates)."
							  }
							})
						</script>
					";
				break;

				case '':
					$alert = "
						<script>
						</script>
					";
				break;*/
			}
		}
	}
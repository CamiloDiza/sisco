$('#selecprof').change(function(){
	$.ajax({
		type: 'POST',
		url: 'http://localhost/sisco/app/views/pages/table-horary.php',
		data: 'id=' + $('#selecprof').val(),
		success:function(data){
			$('.table-horary').html(data);
		}
	});
});
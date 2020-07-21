$('#tipo_usuario').change(function(){
  
  var opcion = $(this).val();

  if(opcion == 2) 
  {
    $.ajax({
      async: true,
      url: "http://localhost/sisco/app/views/pages/register-profesional.php",
      success: function(data){
        $('#contenido').css('display','flex');
        $('#contenido').html(data);
      }
    });
  }
  else if(opcion == 3) 
  {
    $.ajax({
      async: true,
      url: "http://localhost/sisco/app/views/pages/register-paciente.php",
      success: function(data){
        $('#contenido').css('display','flex');
        $('#contenido').html(data);
      }
    });
  }else{
      $('#contenido').css('display','none');
    }
});
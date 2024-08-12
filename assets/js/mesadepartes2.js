function closeProfileForm() {
    //esta funcion cierra el apartado de la muestra de datos del perfil
    window.location.href = "./../../../mesadepartes.php";
}

$(document).ready(function() {  
    $('#uploadButton').click(async function() {  
        // Obtener los valores de los inputs  
        var fechaInforme1 = $('#fechaInforme1').val();
  
        // Crear FormData 
        var formData = new FormData();  
        formData.append('fechaInforme1', fechaInforme1);  
  
        var input = document.getElementById('informe1');  
        formData.append(input.name, input.files[0]); // Añade el archivo al FormData  
    
        // Enviar los datos a un script PHP usando AJAX  
        $.ajax({  
            url: 'assets/controladores/informe1.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);  
                window.location = "./../../informes.php";   
            },  
            error: function(xhr, status, error) {  
                alert('Error al guardar los datos: ' + xhr.responseText); // Proporciona más información sobre el error  
            }    
        });  
    });  
  });

  $(document).ready(function() {  
    $('#uploadButton2').click(async function() {  
        // Obtener los valores de los inputs  
        var fechaInforme2 = $('#fechaInforme2').val();
  
        // Crear FormData 
        var formData = new FormData();  
        formData.append('fechaInforme2', fechaInforme2);  
  
        var input = document.getElementById('informe2');  
        formData.append(input.name, input.files[0]); // Añade el archivo al FormData  
    
        // Enviar los datos a un script PHP usando AJAX  
        $.ajax({  
            url: 'assets/controladores/informe2.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);  
                window.location = "./../../informes.php";   
            },  
            error: function(xhr, status, error) {  
                alert('Error al guardar los datos: ' + xhr.responseText); // Proporciona más información sobre el error  
            }    
        });  
    });  
  });

  $(document).ready(function() {  
    $('#uploadButton3').click(async function() {  
        // Obtener los valores de los inputs  
        var fechaInforme3 = $('#fechaInforme3').val();
  
        // Crear FormData 
        var formData = new FormData();  
        formData.append('fechaInforme3', fechaInforme3);  
  
        var input = document.getElementById('informe3');  
        formData.append(input.name, input.files[0]); // Añade el archivo al FormData  
    
        // Enviar los datos a un script PHP usando AJAX  
        $.ajax({  
            url: 'assets/controladores/informe3.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);  
                window.location = "./../../informes.php";   
            },  
            error: function(xhr, status, error) {  
                alert('Error al guardar los datos: ' + xhr.responseText); // Proporciona más información sobre el error  
            }    
        });  
    });  
  });

  $(document).ready(function() {  
    $('#uploadButton4').click(async function() {  
        // Obtener los valores de los inputs  
        var fechaInforme4 = $('#fechaInforme4').val();
  
        // Crear FormData 
        var formData = new FormData();  
        formData.append('fechaInforme4', fechaInforme4);  
  
        var input = document.getElementById('informe4');  
        formData.append(input.name, input.files[0]); // Añade el archivo al FormData  
    
        // Enviar los datos a un script PHP usando AJAX  
        $.ajax({  
            url: 'assets/controladores/informe4.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);  
                window.location = "./../../informes.php";   
            },  
            error: function(xhr, status, error) {  
                alert('Error al guardar los datos: ' + xhr.responseText); // Proporciona más información sobre el error  
            }    
        });  
    });  
  });

  $(document).ready(function() {  
    $('#uploadButton5').click(async function() {  
        // Obtener los valores de los inputs  
        var fechaInforme5 = $('#fechaInforme5').val();
  
        // Crear FormData 
        var formData = new FormData();  
        formData.append('fechaInforme5', fechaInforme5);  
  
        var input = document.getElementById('informe5');  
        formData.append(input.name, input.files[0]); // Añade el archivo al FormData  
    
        // Enviar los datos a un script PHP usando AJAX  
        $.ajax({  
            url: 'assets/controladores/informe5.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);  
                window.location = "./../../informes.php";   
            },  
            error: function(xhr, status, error) {  
                alert('Error al guardar los datos: ' + xhr.responseText); // Proporciona más información sobre el error  
            }    
        });  
    });  
  });

  $(document).ready(function() {  
    $('#upload_Examen').click(async function() {  
        // Obtener los valores de los inputs  
        var fechaExamen = $('#fechaExamen').val();
  
        // Crear FormData 
        var formData = new FormData();  
        formData.append('fechaExamen', fechaExamen);  
  
        var input = document.getElementById('examen');  
        formData.append(input.name, input.files[0]); // Añade el archivo al FormData  
    
        // Enviar los datos a un script PHP usando AJAX  
        $.ajax({  
            url: 'assets/controladores/exam-final.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);  
                window.location = "./../../evaluacion.php";   
            },  
            error: function(xhr, status, error) {  
                alert('Error al guardar los datos: ' + xhr.responseText); // Proporciona más información sobre el error  
            }    
        });  
    });  
  });

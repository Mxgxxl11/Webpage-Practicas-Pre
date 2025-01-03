function closeProfileForm() {
    //esta funcion cierra el apartado de la muestra de datos del perfil
    window.location.href = "./../../../ver-alumno.php";
}

$(document).ready(function() {  
    $('#d_i_f').click(function() {  
        // Obtener los valores de los inputs  
        var id_alumno = $('#id_alumno').val();  
        
        // Redirigir a la URL de descarga  
        window.location.href = 'assets/controladores/descargar_informe_final.php?codigo_a=' + encodeURIComponent(id_alumno);  
    });  
});

$(document).ready(function() {  
    $('#envi').click(async function() {  
        var calificacion_reporte = $('#calificacion_reporte').val();
        var codigo_a = $('#codigo_a').val();
    
        var formData = new FormData();  
        formData.append('calificacion_reporte', calificacion_reporte); 
        formData.append('codigo_a', codigo_a); 

        $.ajax({  
            url: 'assets/controladores/subir_nota_informe_final.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);   
                window.location = "./../../docente-evalua.php?codigo=" + codigo_a;  
            },  
            error: function() {  
                alert('Error al guardar los datos');  
            }  
        });  
    });  
});

$(document).ready(function() {  
    $('#d_e_f_r').click(function() {  
        // Obtener los valores de los inputs  
        var id_alumno = $('#id_alumno').val();  
        
        // Redirigir a la URL de descarga  
        window.location.href = 'assets/controladores/descargar_exam_final_resuelto.php?codigo_a=' + encodeURIComponent(id_alumno);  
    });  
});

$(document).ready(function() {  
    $('#calificar').click(async function() {  
        var nota_e = $('#nota_e').val();
        var codigo_a = $('#codigo_a').val();
    
        var formData = new FormData();  
        formData.append('nota_e', nota_e); 
        formData.append('codigo_a', codigo_a); 

        $.ajax({  
            url: 'assets/controladores/subir_nota_exam_final.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);   
                window.location = "./../../docente-evalua.php?codigo=" + codigo_a;  
            },  
            error: function() {  
                alert('Error al guardar los datos');  
            }  
        });  
    });  
}); 

$(document).ready(function() {  
    $('#apreciacion').click(async function() {  
        var codigo_a = $('#codigo_a').val();
        var nota_a = $('#nota_a').val();
    
        var formData = new FormData();  
        formData.append('codigo_a', codigo_a); 
        formData.append('nota_a', nota_a); 

        $.ajax({  
            url: 'assets/controladores/subir_nota_aprec_final.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);   
                window.location = "./../../docente-evalua.php?codigo=" + codigo_a;  
            },  
            error: function() {  
                alert('Error al guardar los datos');  
            }  
        });  
    });  
}); 

$(document).ready(function() {  
    $('#e_comentario').click(async function() {  
        var comentario = $('#comentario').val();
        var codigo_a = $('#codigo_a').val();
    
        var formData = new FormData();  
        formData.append('comentario', comentario); 
        formData.append('codigo_a', codigo_a); 

        $.ajax({  
            url: 'assets/controladores/subir_comentario_final.php',  
            type: 'POST',  
            data: formData,  
            contentType: false, // Importante: desactivamos el contenido  
            processData: false, // Importante: desactivamos el procesamiento de datos  
            success: function(response) {  
                alert(response);   
                window.location = "./../../docente-evalua.php?codigo=" + codigo_a;  
            },  
            error: function() {  
                alert('Error al guardar los datos');  
            }  
        });  
    });  
});

function loadPDF2(event) {  
    const file = event.target.files[0];  
    const fileURL = URL.createObjectURL(file);  
    const pdfPreview = document.getElementById('pdf-preview3');  
    const previewContainer = document.getElementById('preview-container3');  

    if (file) {  
        pdfPreview.src = fileURL;  
        previewContainer.style.display = 'block'; // Mostrar el contenedor al cargar el PDF  
    }  
}

function loadPDF3(event) {  
    const file = event.target.files[0];  
    const fileURL = URL.createObjectURL(file);  
    const pdfPreview = document.getElementById('pdf-preview4');  
    const previewContainer = document.getElementById('preview-container4');  

    if (file) {  
        pdfPreview.src = fileURL;  
        previewContainer.style.display = 'block'; // Mostrar el contenedor al cargar el PDF  
    }  
}

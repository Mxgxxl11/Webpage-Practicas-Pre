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

// Para previsualizar el FUT 

let pdfBlobUrl = null;
let tempPdfDoc = null;
let blob1 = null;

document.getElementById('subir').addEventListener('click', async function() {
const text1 = document.getElementById('estudiante').value;
const text2 = document.getElementById('escuela').value;
const text3 = document.getElementById('empresa').value;
const text4 = document.getElementById('coordinador').value;

// Variables para los criterios del 1 al 56  
const text5 = document.querySelector('input[name="criterio1"]:checked')?.value || null;  
const text6 = document.querySelector('input[name="criterio2"]:checked')?.value || null;  
const text7 = document.querySelector('input[name="criterio3"]:checked')?.value || null;  
const text8 = document.querySelector('input[name="criterio4"]:checked')?.value || null;  
const text9 = document.querySelector('input[name="criterio5"]:checked')?.value || null;  
const text10 = document.querySelector('input[name="criterio6"]:checked')?.value || null;  
const text11 = document.querySelector('input[name="criterio7"]:checked')?.value || null;  
const text12 = document.querySelector('input[name="criterio8"]:checked')?.value || null;  
const text13 = document.querySelector('input[name="criterio9"]:checked')?.value || null;  
const text14 = document.querySelector('input[name="criterio10"]:checked')?.value || null;  
const text15 = document.querySelector('input[name="criterio11"]:checked')?.value || null;  
const text16 = document.querySelector('input[name="criterio12"]:checked')?.value || null;  
const text17 = document.querySelector('input[name="criterio13"]:checked')?.value || null;  
const text18 = document.querySelector('input[name="criterio14"]:checked')?.value || null;  
const text19 = document.querySelector('input[name="criterio15"]:checked')?.value || null;  
const text20 = document.querySelector('input[name="criterio16"]:checked')?.value || null;  
const text21 = document.querySelector('input[name="criterio17"]:checked')?.value || null;  
const text22 = document.querySelector('input[name="criterio18"]:checked')?.value || null;  
const text23 = document.querySelector('input[name="criterio19"]:checked')?.value || null;  
const text24 = document.querySelector('input[name="criterio20"]:checked')?.value || null;  
const text25 = document.querySelector('input[name="criterio21"]:checked')?.value || null;  
const text26 = document.querySelector('input[name="criterio22"]:checked')?.value || null;  
const text27 = document.querySelector('input[name="criterio23"]:checked')?.value || null;  
const text28 = document.querySelector('input[name="criterio24"]:checked')?.value || null;  
const text29 = document.querySelector('input[name="criterio25"]:checked')?.value || null;  
const text30 = document.querySelector('input[name="criterio26"]:checked')?.value || null;  
const text31 = document.querySelector('input[name="criterio27"]:checked')?.value || null;  
const text32 = document.querySelector('input[name="criterio28"]:checked')?.value || null;  
const text33 = document.querySelector('input[name="criterio29"]:checked')?.value || null;  
const text34 = document.querySelector('input[name="criterio30"]:checked')?.value || null;  
const text35 = document.querySelector('input[name="criterio31"]:checked')?.value || null;  
const text36 = document.querySelector('input[name="criterio32"]:checked')?.value || null;  
const text37 = document.querySelector('input[name="criterio33"]:checked')?.value || null;  
const text38 = document.querySelector('input[name="criterio34"]:checked')?.value || null;  
const text39 = document.querySelector('input[name="criterio35"]:checked')?.value || null;  
const text40 = document.querySelector('input[name="criterio36"]:checked')?.value || null;  
const text41 = document.querySelector('input[name="criterio37"]:checked')?.value || null;  
const text42 = document.querySelector('input[name="criterio38"]:checked')?.value || null;  
const text43 = document.querySelector('input[name="criterio39"]:checked')?.value || null;  
const text44 = document.querySelector('input[name="criterio40"]:checked')?.value || null;  
const text45 = document.querySelector('input[name="criterio41"]:checked')?.value || null;  
const text46 = document.querySelector('input[name="criterio42"]:checked')?.value || null;  
const text47 = document.querySelector('input[name="criterio43"]:checked')?.value || null;  
const text48 = document.querySelector('input[name="criterio44"]:checked')?.value || null;  
const text49 = document.querySelector('input[name="criterio45"]:checked')?.value || null;  
const text50 = document.querySelector('input[name="criterio46"]:checked')?.value || null;  
const text51 = document.querySelector('input[name="criterio47"]:checked')?.value || null;  
const text52 = document.querySelector('input[name="criterio48"]:checked')?.value || null;  
const text53 = document.querySelector('input[name="criterio49"]:checked')?.value || null;  
const text54 = document.querySelector('input[name="criterio50"]:checked')?.value || null;  
const text55 = document.querySelector('input[name="criterio51"]:checked')?.value || null;  
const text56 = document.querySelector('input[name="criterio52"]:checked')?.value || null;  
const text57 = document.querySelector('input[name="criterio53"]:checked')?.value || null;  
const text58 = document.querySelector('input[name="criterio54"]:checked')?.value || null;  
const text59 = document.querySelector('input[name="criterio55"]:checked')?.value || null;  
const text60 = document.querySelector('input[name="criterio56"]:checked')?.value || null;

const text61 = document.getElementById('fechaRegistro').value;
const text62 = document.getElementById('nota_informes').value;
const text63 = document.getElementById('nota_examen').value;
const text64 = document.getElementById('nota_docente').value;
const text65 = document.getElementById('promedio').value;
const fileInput = document.getElementById('firma');
const file = fileInput.files[0];

if (!text61){
  alert('Seleccionar la fecha de hoy');
  return;
}

if (!file) {
  alert('Por favor, selecciona una imagen primero.');
  return;
}

// Mapeo de valores a letras/símbolos  
const conversionMap = {  
    1: 'X',   // Reemplaza 1 con 'X'  
    2: 'X',   
    3: 'X',    
    4: 'X',    
    5: 'X'    
};  

// Función para convertir y retornar el valor  
function convertValue(value) {  
    return conversionMap[value] || ''; // Devuelve la letra correspondiente o cadena vacía si no hay coincidencia  
}  

// Crear un array para los textos convertidos  
const convertedTexts = [];  

// Reemplazar cada textX con su conversión  
for (let i = 5; i <= 60; i++) {  
    const text = window[`text${i}`]; // Obtener el valor de cada variable textX  
    convertedTexts.push(convertValue(text)); // Convertir y agregar al array  
}  

// Cargar el PDF existente
const url = 'assets/pdf/formato_5.pdf'; // Cambia esto a la ruta de tu PDF
const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());

// Cargar el PDF en PDF-lib
const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes);
const page1 = pdfDoc.getPage(0); // Obtener la primera página
const page2 = pdfDoc.getPage(1);
const page3 = pdfDoc.getPage(2);
const page4 = pdfDoc.getPage(3);
const page5 = pdfDoc.getPage(4);
const page6 = pdfDoc.getPage(5);
const page7 = pdfDoc.getPage(6);

// Agregar el texto en la posición deseada
page1.drawText(text1, {x: 230, y: 636, size: 12, color: PDFLib.rgb(0, 0, 0), });
page1.drawText(text2, {x: 230, y: 620,  size: 12, color: PDFLib.rgb(0, 0, 0), });
page1.drawText(text3, {x: 230, y: 604, size: 12, color: PDFLib.rgb(0, 0, 0), });
page1.drawText(text4, {x: 230, y: 587, size: 12, color: PDFLib.rgb(0, 0, 0), });
page1.drawText(text61, {x: 230, y: 571, size: 12, color: PDFLib.rgb(0, 0, 0), });

page7.drawText(text57, {x: 397, y: 550, size: 11, color: PDFLib.rgb(0, 0, 0), });
page7.drawText(text58, {x: 355, y: 525, size: 11, color: PDFLib.rgb(0, 0, 0), });
page7.drawText(text59, {x: 480, y: 502, size: 11, color: PDFLib.rgb(0, 0, 0), });
page7.drawText(text60, {x: 437, y: 475, size: 11, color: PDFLib.rgb(0, 0, 0), });

page7.drawText(text62, {x: 310, y: 274, size: 11, color: PDFLib.rgb(0, 0, 0), });
page7.drawText(text63, {x: 310, y: 242, size: 12, color: PDFLib.rgb(0, 0, 0), });
page7.drawText(text64, {x: 310, y: 205, size: 12, color: PDFLib.rgb(0, 0, 0), });
page7.drawText(text65, {x: 310, y: 183, size: 12, color: PDFLib.rgb(0, 0, 0), });

const imgBytes = await file.arrayBuffer();
  let image;  
  const fileType = file.type; // Obtenemos el tipo de archivo  

  if (fileType === 'image/jpeg') {  
    image = await pdfDoc.embedJpg(imgBytes); // Utilizar embedJpg si es un `.jpg`  
  } else if (fileType === 'image/png') {  
    image = await pdfDoc.embedPng(imgBytes); // Utilizar embedPng si es un `.png`  
  } else if (fileType === 'image/jpg') {  
    image = await pdfDoc.embedJpg(imgBytes);
  } else {  
    alert('Por favor, selecciona una imagen en formato JPG o PNG.');  
    return;  
  } 

page7.drawImage(image, {x: 90, y: 75, width: 150, height: 50 });

// Guardar el PDF modificado
const pdfBytes = await pdfDoc.save();
tempPdfDoc = await PDFLib.PDFDocument.load(pdfBytes);
blob1 = new Blob([pdfBytes], { type: 'application/pdf' });
pdfBlobUrl = URL.createObjectURL(blob1);

// Previsualizar
document.getElementById('pdf-preview').setAttribute('src', pdfBlobUrl);
});

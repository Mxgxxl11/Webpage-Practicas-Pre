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
  
  function previewImage(event) {  
    const file = event.target.files[0];  
    const imagePreview = document.getElementById('imagePreview');  
    
    if (file) {  
        const reader = new FileReader();  
        
        reader.onload = function(e) {  
            imagePreview.src = e.target.result;  
            imagePreview.style.display = 'block';  // Mostrar la imagen  
        };  
        
        reader.readAsDataURL(file); // Leer el archivo como URL de datos  
    } else {  
        imagePreview.src = '';  
        imagePreview.style.display = 'none'; // Ocultar la imagen si no hay archivo  
    }  
  }

  let pdfBlobUrl = null;
  let tempPdfDoc = null;
  let blob1 = null;
  
  document.getElementById('pre').addEventListener('click', async function() {
  const text1 = document.getElementById('dependencia').value;
  const text2 = document.getElementById('nro_tramite').value;
  const text3 = document.getElementById('datos_solicitante').value;
  const text4 = document.getElementById('nombre_fut').value;
  const text5 = document.getElementById('facultad').value;
  const text6 = document.getElementById('escuela_profesional').value;
  const text7 = document.getElementById('codigo_ins').value;
  const text8 = document.getElementById('dni').value;
  const text9 = document.getElementById('direccion').value;
  const text10 = document.getElementById('nro_dpto').value;
  const text11 = document.getElementById('distrito').value;
  const text12 = document.getElementById('celular').value;
  const text13 = document.getElementById('correo').value;
  const text14 = document.getElementById('fundamentacion').value;
  const text15 = document.getElementById('doc1').value;
  const text16 = document.getElementById('doc2').value;
  const text17 = document.getElementById('doc3').value;
  const text18 = document.getElementById('doc4').value;
  const text19 = document.getElementById('firma').value;
  const text20 = document.getElementById('folios').value;
  const text21 = document.getElementById('Fechaconstancia').value;
  const text22 = document.getElementById('nt').value;
  const fileInput = document.getElementById('firma');
  const file = fileInput.files[0];
  
  if (!text21){
    alert('Seleccionar la fecha de hoy');
    return;
  }
  
  if (!file) {
    alert('Por favor, selecciona una imagen primero.');
    return;
  }
  
  // Cargar el PDF existente
  const url = 'assets/pdf/FUT_SG_plantilla.pdf'; // Cambia esto a la ruta de tu PDF
  const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());
  
  // Cargar el PDF en PDF-lib
  const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes);
  const page = pdfDoc.getPage(0); // Obtener la primera página
  
  // Agregar el texto en la posición deseada
  page.drawText(text1, {
  x: 75, // Cambia esto a la posición X deseada
  y: 647, // Cambia esto a la posición Y deseada
  size: 12, // Tamaño de la fuente
  color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text2, {
    x: 380, // Cambia esto a la posición X deseada
    y: 645, // Cambia esto a la posición Y deseada
    size: 10, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text3, {
    x: 122, // Cambia esto a la posición X deseada
    y: 580, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text4, {
    x: 70, // Cambia esto a la posición X deseada
    y: 540, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text5, {
    x: 70, // Cambia esto a la posición X deseada
    y: 500, // Cambia esto a la posición Y deseada
    size: 8, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text6, {
    x: 250, // Cambia esto a la posición X deseada
    y: 500, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text7, {
    x: 462, // Cambia esto a la posición X deseada
    y: 500, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text8, {
    x: 72, // Cambia esto a la posición X deseada
    y: 445, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text9, {
    x: 172, // Cambia esto a la posición X deseada
    y: 445, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text10, {
    x: 425, // Cambia esto a la posición X deseada
    y: 445, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text11, {
    x: 464, // Cambia esto a la posición X deseada
    y: 445, // Cambia esto a la posición Y deseada
    size: 10, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text12, {
    x: 172, // Cambia e2sto a la posición X deseada
    y: 405, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text13, {
    x: 300, // Cambia esto a la posición X deseada
    y: 405, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text14, {
    x: 70, // Cambia esto a la posición X deseada
    y: 355, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text15, {
    x: 70, // Cambia esto a la posición X deseada
    y: 232, // Cambia esto a la posición Y deseada
    size: 11, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text16, {
    x: 70, // Cambia esto a la posición X deseada
    y: 217, // Cambia esto a la posición Y deseada
    size: 11, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text17, {
    x: 70, // Cambia esto a la posición X deseada
    y: 202, // Cambia esto a la posición Y deseada
    size: 11, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text18, {
    x: 70, // Cambia esto a la posición X deseada
    y: 187, // Cambia esto a la posición Y deseada
    size: 10, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text19, {
    x: 390, // Cambia esto a la posición X deseada
    y: 115, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text20, {
    x: 460, // Cambia esto a la posición X deseada
    y: 230, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text21, {
    x: 70, // Cambia esto a la posición X deseada
    y: 115, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });

  page.drawText(text22, {
    x: 400, // Cambia esto a la posición X deseada
    y: 795, // Cambia esto a la posición Y deseada
    size: 24, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
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
  
  page.drawImage(image, {
  x: 390,
  y: 92,
  width: 150,
  height: 50
  });
  
  // Guardar el PDF moqdificado
  const pdfBytes = await pdfDoc.save();
  tempPdfDoc = await PDFLib.PDFDocument.load(pdfBytes);
  blob1 = new Blob([pdfBytes], { type: 'application/pdf' });
  pdfBlobUrl = URL.createObjectURL(blob1);
  
  // Previsualizar
  document.getElementById('pdf-preview').setAttribute('src', pdfBlobUrl);
  });

  // Ver los PDFs subidos

function loadPDF(event) {  
    const file = event.target.files[0];  
    const fileURL = URL.createObjectURL(file);  
    const pdfPreview = document.getElementById('pdf-preview2');  
    const previewContainer = document.getElementById('preview-container2');  

    if (file) {  
        pdfPreview.src = fileURL;  
        previewContainer.style.display = 'block'; // Mostrar el contenedor al cargar el PDF  
    }  
}

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

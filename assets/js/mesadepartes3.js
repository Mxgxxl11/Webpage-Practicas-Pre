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

//imagenes 

// Para previsualizar el FUT 
let pdfBlobUrl = null;
let pdfBlobUrl2 = null;
let tempPdfDoc = null;
let tempPdfDoc2 = null;
let blob1 = null;
let blob2 = null;

document.getElementById('futapertura').addEventListener('click', async function() {
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
  const text20 = document.getElementById('firma').value;
  const text21 = document.getElementById('folios').value;
  const text22 = document.getElementById('fechaRegistroS').value;
  const text23 = document.getElementById('nt').value;
  const fileInput = document.getElementById('firma');
  const file = fileInput.files[0];
  
  if (!text22){
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
    size: 12, // Tamaño de la fuente
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
    size: 11, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text20, {
    x: 390, // Cambia esto a la posición X deseada
    y: 115, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text21, {
    x: 460, // Cambia esto a la posición X deseada
    y: 230, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });
  
  page.drawText(text22, {
    x: 70, // Cambia esto a la posición X deseada
    y: 115, // Cambia esto a la posición Y deseada
    size: 12, // Tamaño de la fuente
    color: PDFLib.rgb(0, 0, 0), // Color del texto
  });

  page.drawText(text23, {
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
  const blob = new Blob([pdfBytes], { type: 'application/pdf' });
  pdfBlobUrl = URL.createObjectURL(blob);
  
  // Previsualizar
  document.getElementById('pdf-preview').setAttribute('src', pdfBlobUrl);
});

function loadPDF4(event) {
  const file = event.target.files[0];
  const fileURL = URL.createObjectURL(file);
  const pdfPreview = document.getElementById('pdf-preview4');
  const previewContainer = document.getElementById('preview-container4');
  const fechaRecord = document.getElementById('fechaRecord').value;

  if (!fechaRecord) {
      alert("Por favor, seleccione una fecha antes de subir el archivo.");
      event.target.value = '';
      previewContainer.style.display = 'none'; // Ocultar el contenedor si no hay archivo cargado
  } else if (file) {
      pdfPreview.src = fileURL;
      previewContainer.style.display = 'block'; // Mostrar el contenedor al cargar el PDF
  }
}

document.getElementById('visualizar').addEventListener('click', async function() {
  const form = document.getElementById('empresaForm');
  const formData = new FormData(form);

  const apellidos = document.getElementById('apellidos').value;
  const nombre = document.getElementById('nombre').value;
  const escuela = document.getElementById('escuela_profesional').value;
  const codigo = document.getElementById('codigo_ins').value;
  const semestre = document.getElementById('semestre').value;
  const celular = document.getElementById('celular').value;
  const correo = document.getElementById('correo').value;
  const nom_empresa = document.getElementById('nombreEmpresa').value;
  const ruc_empresa = document.getElementById('rucEmpresa').value;
  const direccion_empre = document.getElementById('direccionEmpresa').value;
  const jefeInmediato = document.getElementById('jefeInmediato').value;
  const areaTrabajo = document.getElementById('areaTrabajo').value;
  const telefonoCelular = document.getElementById('telefonoCelular').value;
  const fechaInicio = document.getElementById('fechaInicio').value;
  const fechaCulminacion = document.getElementById('fechaCulminacion').value;

  const url = '/assets/pdf/fut_empre.pdf'; // Ruta del PDF

  if(!jefeInmediato || !areaTrabajo || !telefonoCelular || !fechaInicio || !fechaCulminacion){
    alert('Debes llenar todos los campos');
    return;
  }

  try {
      const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());

      const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes);
      const page = pdfDoc.getPage(0); // Obtener la primera página

      page.drawText(apellidos, { x: 135, y: 615, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(nombre, { x: 135, y: 585, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(codigo, { x: 135, y: 520, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(escuela, { x: 135, y: 555, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(semestre, { x: 420, y: 520, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(celular, { x: 350, y: 490, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(correo, { x: 135, y: 461, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(nom_empresa, { x: 135, y: 385, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(ruc_empresa, { x: 135, y: 355, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(direccion_empre, { x: 135, y: 327, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(areaTrabajo, { x: 170, y: 297, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(jefeInmediato, { x: 170, y: 267, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(fechaInicio, { x: 170, y: 236, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(fechaCulminacion, { x: 420, y: 236, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(telefonoCelular, { x: 170, y: 205, size: 12, color: PDFLib.rgb(0, 0, 0) });

      const pdfBytes2 = await pdfDoc.save();
      tempPdfDoc2 = await PDFLib.PDFDocument.load(pdfBytes2);
      blob2 = new Blob([pdfBytes2], { type: 'application/pdf' });
      pdfBlobUrl2 = URL.createObjectURL(blob2);

      document.getElementById('pdf-preview2').setAttribute('src', pdfBlobUrl2);
  } catch (error) {
    console.error('Error al generar el PDF:', error);
  }
});

function loadPDF5(event) {  
  const file = event.target.files[0];  
  const fileURL = URL.createObjectURL(file);  
  const pdfPreview = document.getElementById('pdf-preview5');  
  const previewContainer = document.getElementById('preview-container5');  

  if (file) {  
      pdfPreview.src = fileURL;  
      previewContainer.style.display = 'block'; // Mostrar el contenedor al cargar el PDF  
  }  
}

function loadPDF6(event) {
  const file = event.target.files[0];
  const fileURL = URL.createObjectURL(file);
  const pdfPreview = document.getElementById('pdf-preview6');
  const previewContainer = document.getElementById('preview-container6');
  const fechaInicio = document.getElementById('fechaInicio').value;
  const fechaCulminacion = document.getElementById('fechaCulminacion').value;

  if (!fechaInicio || !fechaCulminacion) {
      alert("Por favor, seleccione ambas fechas (Inicio y Culminación) antes de subir el archivo.");
      event.target.value = '';
      previewContainer.style.display = 'none'; 
  } else if (file) {
      pdfPreview.src = fileURL;
      previewContainer.style.display = 'block'; // Mostrar el contenedor al cargar el PDF
  }
}

$(document).ready(function() {  
  $('#descargar').click(async function() {  
      // Obtener los valores de los inputs  
      var fechaRegistroS = $('#fechaRegistroS').val();  
      var fechaRecord = $('#fechaRecord').val();  
      var fechaInicio = $('#fechaInicio').val();   
      var fechaCulminacion = $('#fechaCulminacion').val();
      var jefeInmediato = $('#jefeInmediato').val();
      var areaTrabajo = $('#areaTrabajo').val();
      var telefonoCelular = $('#telefonoCelular').val();
      
      // Obtener los blobs  
      var blob1 = await fetch(pdfBlobUrl).then(r => r.blob());   
      var blob2 = await fetch(pdfBlobUrl2).then(r => r.blob());  

      // Crear FormData y agregar los blobs  
      var formData = new FormData();  
      formData.append('fechaRegistroS', fechaRegistroS);  
      formData.append('fechaRecord', fechaRecord);  
      formData.append('fechaInicio', fechaInicio); 
      formData.append('fechaCulminacion', fechaCulminacion);  
      formData.append('jefeInmediato', jefeInmediato);  
      formData.append('areaTrabajo', areaTrabajo); 
      formData.append('telefonoCelular', telefonoCelular);  
      formData.append('blob1', blob1); 
      formData.append('blob2', blob2); 

      const inputs = [document.getElementById('RecordAca'), document.getElementById('CartaRec'), document.getElementById('CartaAceptacion')];  

      for (const input of inputs) {  
        if (input.files.length > 0) {  
          formData.append(input.name, input.files[0]); // Asegúrate de que los inputs tengan el atributo name  
        }  
      } 

      // Enviar los datos a un script PHP usando AJAX  
      $.ajax({  
          url: 'assets/controladores/registro_cp2.php',  
          type: 'POST',  
          data: formData,  
          contentType: false, // Importante: desactivamos el contenido  
          processData: false, // Importante: desactivamos el procesamiento de datos  
          success: function(response) {  
              alert(response);  
              window.location = "./../../carta_presentacion.php";   
          },  
          error: function() {  
              alert('Error al guardar los datos');  
          }  
      });  
  });  
}); 

$(document).ready(function() {  
  $('#g').click(async function() {  
      // Obtener los valores de los inputs  
      var jefeInmediato = $('#jefeInmediato').val();  
      var areaTrabajo = $('#areaTrabajo').val();  
      var telefonoCelular = $('#telefonoCelular').val();    
      var nombreEmpresa = $('#nombreEmpresa').val();  
      var rucEmpresa = $('#rucEmpresa').val();  
      var direccionEmpresa = $('#direccionEmpresa').val();    
      var fechaInicio = $('#fechaInicio').val();  
      var fechaCulminacion = $('#fechaCulminacion').val(); 

      // Crear FormData y agregar los blobs  
      var formData = new FormData();  
      formData.append('jefeInmediato', jefeInmediato);  
      formData.append('areaTrabajo', areaTrabajo);  
      formData.append('telefonoCelular', telefonoCelular);
      formData.append('nombreEmpresa', nombreEmpresa);  
      formData.append('rucEmpresa', rucEmpresa);  
      formData.append('direccionEmpresa', direccionEmpresa);
      formData.append('fechaInicio', fechaInicio);
      formData.append('fechaCulminacion', fechaCulminacion);

      // Enviar los datos a un script PHP usando AJAX  
      $.ajax({  
          url: 'assets/controladores/registro_empresa2.php',  
          type: 'POST',  
          data: formData,  
          contentType: false, // Importante: desactivamos el contenido  
          processData: false, // Importante: desactivamos el procesamiento de datos  
          success: function(response) {  
              alert(response);   
          },  
          error: function() {  
              alert('Error al guardar los datos');  
          }  
      });  
  });  
}); 
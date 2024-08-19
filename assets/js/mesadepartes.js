//ESTA FUNCIÓN OCULTA Y MUESTRA EL SIDEBAR
function toggleMenu() {
  const sidebar = document.getElementById('sidebar');
  sidebar.style.display = sidebar.style.display === 'none' ? 'block' : 'none';
}

function loadSolicitudForm() {
  //esta funcion carga el apartado de la carta de presentación (1er tramite)
  //resetForm();
  const profileContainer = document.getElementById('profileContainer');
  const solicitudContainer = document.getElementById('solicitudContainer');
  profileContainer.style.display = 'none';
  solicitudContainer.style.display = 'block';
}

function loadSegundoForm(){
  //esta funcion carga el apartado del 2form (subida de futs)
  //de la carta de presentacion
  //closeRegistroSolicitud();
  const segundoFormContainer = document.getElementById('segundo');
  segundoFormContainer.style.display = 'block';
}

function backtoMenuAdmin(){
  window.location.href = "./../../menuadmin.php";
}

function loadUpdateProfile(){
  //esta funcion carga el apartado de actualizar datos del perfil
  document.getElementById('update-fields-profile').style.display = 'block';
  document.getElementById('profileContainer').style.display = 'none';
}

function eliminarFoto() {  
  if (confirm("¿Estás seguro de que quieres eliminar la foto?")) {  
      // Crea un formulario para enviar la petición de eliminación  
      var form = new FormData();  
      form.append('accion', 'eliminar');  

      // Enviar la solicitud AJAX  
      fetch('../assets/controladores/imagen_perfil.php', {  
          method: 'POST',  
          body: form  
      })  
      .then(response => response.text())  
      .then(data => {  
          alert(data);  // Muestra la respuesta del servidor  
          window.location.reload();  // Recarga la página para ver los cambios  
      })  
      .catch(error => console.error('Error:', error));  
  }  
}

function closeProfileForm() {
  //esta funcion cierra el apartado de la muestra de datos del perfil
  window.location.href = "./../../../mesadepartes.php";
}

function closeSolicitudForm() {
  //esta funcion cierra el apartado de bienvenida de la carta
  //de presentación
  window.location.href = "./../../../mesadepartes.php";
}

function closeRegistroSolicitud(){
  //este apartado cierra el 1form de la carta de presentación
  console.log("abriendo la ventana 'segundo...'")
  document.getElementById('Next-step').style.display = 'none';
  document.getElementById('segundo').style.display = 'block';
}

function closeSegundoForm(){
  //este apartado cierra el 2form de la carta de presentación
  const segundoFormContainer = document.getElementById('nuevoContainer');
  segundoFormContainer.style.display = 'none';
}

function openModal() {
  document.getElementById('imageModal').style.display = 'block';
}

function closeModal() {
  document.getElementById('imageModal').style.display = 'none';
}

//VALIDACIONES PARA CARTA_PRESENTACION.PHP
//para el ruc de la empresa
document.getElementById("rucEmpresa").addEventListener("input",function(a){
  let valor = a.target.value;
  if(valor.length > 11){
      a.target.value = valor.slice(0, 11);
  }
})
//para el DNI del representante de la empresa
document.getElementById("dniRepresentante").addEventListener("input",function(a){
  let valor = a.target.value;
  if(valor.length > 8){
      a.target.value = valor.slice(0, 8);
  }
})
//para el celular del representante de la empresa
document.getElementById("celularRepresentante").addEventListener("input",function(a){
  let valor = a.target.value;
  if(valor.length > 9){
      a.target.value = valor.slice(0, 9);
  }
})
//para el número de liquidación del comprobante de pago
document.getElementById("numLiquidacion").addEventListener("input",function(a){
  let valor = a.target.value;
  if(valor.length > 10){
      a.target.value = valor.slice(0, 10);
  }
})



//Botones de tramite
function iniciar_cp() {
  window.location.href = 'carta_presentacion.php';
}


function apertura_carpeta(){
  window.location.href = 'apertura_carpeta.php';

}

function abrir_informes(){
  window.location.href = 'informes.php';

}


function abrir_evaluacion(){
  window.location.href = 'evaluacion.php';

}


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

// Para previsualizar el FUT 

let pdfBlobUrl = null;
let pdfBlobUrl2 = null;
let tempPdfDoc = null;
let tempPdfDoc2 = null;
let blob1 = null;
let blob2 = null;

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
const text19 = document.getElementById('doc5').value;
const text20 = document.getElementById('firma').value;
const text21 = document.getElementById('folios').value;
const text22 = document.getElementById('fechaRegistro').value;
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

page.drawText(text19, {
  x: 70, // Cambia esto a la posición X deseada
  y: 172, // Cambia esto a la posición Y deseada
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

// Previsualizacion Ficha de Empresa

document.getElementById('Previsualizacion').addEventListener('click', async function() {

  const nombres = document.getElementById('nombres').value;
  const apellidos = document.getElementById('apellidos').value;
  const codigo = document.getElementById('codigo_ins').value;
  const nombre_empresa = document.getElementById('nombreEmpresa').value;
  const ruc_empresa = document.getElementById('rucEmpresa').value;
  const celular_repre = document.getElementById('celularRepresentante').value;
  const email_repre = document.getElementById('emailRepresentante').value;
  const provincia_empre = document.getElementById('provinciaEmpresa').value;
  const distrito_empre = document.getElementById('DistritoEmpresa').value;
  const representante = document.getElementById('nombreRepresentante').value;
  const cargoRepresentante = document.getElementById('cargoRepresentante').value;
  const dni_repre = document.getElementById('dniRepresentante').value;
  const direccion_empre = document.getElementById('direccionRepresentante').value;
  const departamento_empre = document.getElementById('departamentoRepresentante').value;
  const direccion = provincia_empre + ' / ' + departamento_empre + ' / ' + distrito_empre;
  const cargoRepresentante_space = 'CARGO DEL REPRESENTANTE:';

  const url = '/assets/pdf/formato_1_ficha_datos_empresa.pdf'; // Ruta del PDF

  try {
      const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());

      const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes);
      const page = pdfDoc.getPage(0); // Obtener la primera página

      page.drawText(nombres, { x: 275, y: 647, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(apellidos, { x: 275, y: 625, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(codigo, { x: 275, y: 593, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(nombre_empresa, { x: 275, y: 533, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(ruc_empresa, { x: 275, y: 565, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(celular_repre, { x: 350, y: 410, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(email_repre, { x: 350, y: 380, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(direccion, { x: 275, y: 308, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(representante, { x: 275, y: 506, size: 11, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(cargoRepresentante_space, { x: 56, y: 483, size: 11  , color: PDFLib.rgb(0, 0, 0) })
      page.drawText(cargoRepresentante, { x: 275, y: 485, size: 12  , color: PDFLib.rgb(0, 0, 0) })
      page.drawText(dni_repre, { x: 315, y: 440, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(direccion_empre, { x: 275, y: 350, size: 12, color: PDFLib.rgb(0, 0, 0) });

      const pdfBytes2 = await pdfDoc.save();
      tempPdfDoc2 = await PDFLib.PDFDocument.load(pdfBytes2);
      blob2 = new Blob([pdfBytes2], { type: 'application/pdf' });
      pdfBlobUrl2 = URL.createObjectURL(blob2);

      document.getElementById('pdf-preview2').setAttribute('src', pdfBlobUrl2);
  } catch (error) {
    console.error('Error al generar el PDF:', error);
  }
});

document.getElementById('DocFinal').addEventListener('click', async () => {  

  const pdfFiles = [];  
  const inputs = [document.getElementById('archivo2'), document.getElementById('archivo3'), document.getElementById('archivo4')];  

  if (tempPdfDoc) {  
    pdfFiles.push(tempPdfDoc);  
  }   

  if (tempPdfDoc2) {  
    pdfFiles.push(tempPdfDoc2);  
  }   

  for (const input of inputs) {  
      if (input.files.length > 0) {  
          pdfFiles.push(input.files[0]);  
      }  
  }  

  if (pdfFiles.length < 5) {  
      alert('Falta subir un archivo.');  
      return;  
  }  

  const pdfDoc = await PDFLib.PDFDocument.create();  

  for (const pdfFile of pdfFiles) {  
      const pdfBytes = pdfFile instanceof File ? await pdfFile.arrayBuffer() : await pdfFile.save();
      const tempDoc = await PDFLib.PDFDocument.load(pdfBytes);  
      const copiedPages = await pdfDoc.copyPages(tempDoc, tempDoc.getPageIndices());  
      copiedPages.forEach((page) => pdfDoc.addPage(page));  
  }  

  const mergedPdfBytes = await pdfDoc.save();  
  const blob = new Blob([mergedPdfBytes], { type: 'application/pdf' });  
  const url = URL.createObjectURL(blob);  
  const a = document.createElement('a');  
  a.href = url;  
  a.download = 'SolicitudCartaPresentación.pdf';  
  document.body.appendChild(a);  
  a.click();  
  document.body.removeChild(a);  
  URL.revokeObjectURL(url);  

});  

$(document).ready(function() {  
  $('#DocFinal').click(async function() {  
      // Obtener los valores de los inputs  
      var fechaRegistro = $('#fechaRegistro').val();  
      var fechaRecord = $('#fechaRecord').val();  
      var numLiquidacion = $('#numLiquidacion').val();   
      
      // Obtener los blobs  
      var blob1 = await fetch(pdfBlobUrl).then(r => r.blob());   
      var blob2 = await fetch(pdfBlobUrl2).then(r => r.blob());  

      // Crear FormData y agregar los blobs  
      var formData = new FormData();  
      formData.append('fechaRegistro', fechaRegistro);  
      formData.append('fechaRecord', fechaRecord);  
      formData.append('numLiquidacion', numLiquidacion);  
      formData.append('blob1', blob1); 
      formData.append('blob2', blob2); 

      const inputs = [document.getElementById('archivo2'), document.getElementById('archivo3'), document.getElementById('archivo4')];  

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
  $('#guardar').click(async function() {  
      // Obtener los valores de los inputs  
      var nombreEmpresa = $('#nombreEmpresa').val();  
      var rucEmpresa = $('#rucEmpresa').val();  
      var celularRepresentante = $('#celularRepresentante').val();    
      var emailRepresentante = $('#emailRepresentante').val();  
      var provinciaEmpresa = $('#provinciaEmpresa').val();  
      var departamentoRepresentante = $('#departamentoRepresentante').val();    
      var DistritoEmpresa = $('#DistritoEmpresa').val();  
      var nombreRepresentante = $('#nombreRepresentante').val(); 
      var cargoRepresentante = $('#cargoRepresentante').val(); 
      var dniRepresentante = $('#dniRepresentante').val(); 
      var direccionRepresentante = $('#direccionRepresentante').val(); 
  
      var formData = new FormData();  
      formData.append('nombreEmpresa', nombreEmpresa);  
      formData.append('rucEmpresa', rucEmpresa);  
      formData.append('celularRepresentante', celularRepresentante);
      formData.append('emailRepresentante', emailRepresentante);  
      formData.append('provinciaEmpresa', provinciaEmpresa);  
      formData.append('departamentoRepresentante', departamentoRepresentante);
      formData.append('DistritoEmpresa', DistritoEmpresa);
      formData.append('nombreRepresentante', nombreRepresentante);
      formData.append('cargoRepresentante', cargoRepresentante);
      formData.append('dniRepresentante', dniRepresentante);
      formData.append('direccionRepresentante', direccionRepresentante);

      // Enviar los datos a un script PHP usando AJAX  
      $.ajax({  
          url: 'assets/controladores/registro_empresa.php',  
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

$(document).ready(function() {  
  $('#ModificarDoc').click(async function() {  
      // Obtener los valores de los inputs  
      var nombreEmpresa = $('#nombreEmpresa').val();  
      var rucEmpresa = $('#rucEmpresa').val();  
      var celularRepresentante = $('#celularRepresentante').val();    
      var emailRepresentante = $('#emailRepresentante').val();  
      var provinciaEmpresa = $('#provinciaEmpresa').val();  
      var departamentoRepresentante = $('#departamentoRepresentante').val();    
      var DistritoEmpresa = $('#DistritoEmpresa').val();  
      var nombreRepresentante = $('#nombreRepresentante').val(); 
      var cargoRepresentante = $('#cargoRepresentante').val(); 
      var dniRepresentante = $('#dniRepresentante').val(); 
      var direccionRepresentante = $('#direccionRepresentante').val(); 
  
      var formData = new FormData();  
      formData.append('nombreEmpresa', nombreEmpresa);  
      formData.append('rucEmpresa', rucEmpresa);  
      formData.append('celularRepresentante', celularRepresentante);
      formData.append('emailRepresentante', emailRepresentante);  
      formData.append('provinciaEmpresa', provinciaEmpresa);  
      formData.append('departamentoRepresentante', departamentoRepresentante);
      formData.append('DistritoEmpresa', DistritoEmpresa);
      formData.append('nombreRepresentante', nombreRepresentante);
      formData.append('cargoRepresentante', cargoRepresentante);
      formData.append('dniRepresentante', dniRepresentante);
      formData.append('direccionRepresentante', direccionRepresentante);

      // Enviar los datos a un script PHP usando AJAX  
      $.ajax({  
          url: 'assets/controladores/act_empresa.php',  
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

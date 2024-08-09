//resetform(); esta cometado porque daba errores en su implementacion.
//Comente tanto la función como sus llamadas

//ESTA FUNCIÓN OCULTA Y MUESTRA EL SIDEBAR
function toggleMenu() {
  const sidebar = document.getElementById('sidebar');
  sidebar.style.display = sidebar.style.display === 'none' ? 'block' : 'none';
}

//PARA CARGAR LOS APARTADOS DE LA PÁGINA
/*
function loadProfileForm() {
  //esta función hace que se cargue el apartado de los datos del perfil
  //resetForm();
  const profileContainer = document.getElementById('profileContainer');
  const solicitudContainer = document.getElementById('solicitudContainer');
  profileContainer.style.display = 'block';
  solicitudContainer.style.display = 'none';
}*/

function loadSolicitudForm() {
  //esta funcion carga el apartado de la carta de presentación (1er tramite)
  //resetForm();
  const profileContainer = document.getElementById('profileContainer');
  const solicitudContainer = document.getElementById('solicitudContainer');
  profileContainer.style.display = 'none';
  solicitudContainer.style.display = 'block';
}
/*
function loadRegistroSolicitud(){
  //esta funcion carga el apartado del 1form(registro)
  //de la carta de presentacion
  const registroContainer = document.getElementById('Next-step');
  registroContainer.style.display = 'block';
}*/

function loadSegundoForm(){
  //esta funcion carga el apartado del 2form (subida de futs)
  //de la carta de presentacion
  //closeRegistroSolicitud();
  const segundoFormContainer = document.getElementById('segundo');
  segundoFormContainer.style.display = 'block';
}
/*
function loadBienvenidaContainer(){
  //esta funcion carga el apartado de bienvenida a la pagina web
  const bienvenidaContainer = document.getElementById('bienvenidaContainer');
  bienvenidaContainer.style.display = 'block';
}*/

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
/*
function closeBienvenidaContainer(){
  //esta funcion cierra el apartado de bienvenida de la pag web
  const bienvenidaContainer = document.getElementById('bienvenidaContainer');
  bienvenidaContainer.style.display = 'none';
}*/

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
/*
function uploadImage() {
  alert('Cargar imagen');
}

function removeImage() {
  alert('Quitar imagen');
}

function saveImage() {
  alert('Imagen guardada');
  closeModal();
}*/


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


function abrir_constancia(){
  window.location.href = 'constancia.php';

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
  size: 12, // Tamaño de la fuente
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

// Guardar el PDF moqdificado
const pdfBytes = await pdfDoc.save();
tempPdfDoc = await PDFLib.PDFDocument.load(pdfBytes);
const blob = new Blob([pdfBytes], { type: 'application/pdf' });
pdfBlobUrl = URL.createObjectURL(blob);

// Previsualizar
document.getElementById('pdf-preview').setAttribute('src', pdfBlobUrl);
});

// MENSAJE DE CONFIRMACION DE ENVIO DE DATOS DE LA EMPRESA
document.getElementById('empresaForm').addEventListener('submit', function(event) {
  event.preventDefault(); 

  var formData = new FormData(this); 

  fetch('assets/controladores/registro_empresa.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.text())
  .then(data => {
      alert("Datos guardados exitosamente.");
      console.log(data); 
  })
  .catch(error => {
      alert("Error al guardar los datos. Inténtelo nuevamente.");
      console.error('Error:', error);
  });
});

// Previsualizacion Ficha de Empresa

document.getElementById('Previsualizacion').addEventListener('click', async function() {
  const form = document.getElementById('empresaForm');
  const formData = new FormData(form);

  const nombrecompleto = document.getElementById('nombre_fut').value;
  const codigo = document.getElementById('codigo_ins').value;
  const nombre_empresa = document.getElementById('nombreEmpresa').value;
  const ruc_empresa = formData.get('ruc_empresa');
  const celular_repre = formData.get('celular_repre');
  const email_repre = formData.get('email_repre');
  const provincia_empre = formData.get('provincia_empre');
  const distrito_empre = formData.get('distrito_empre');
  const representante = formData.get('representante');
  const dni_repre = formData.get('dni_repre');
  const direccion_empre = formData.get('direccion_empre');
  const departamento_empre = formData.get('departamento_empre');
  const direccion = provincia_empre + ' / ' + departamento_empre + ' / ' + distrito_empre;

  const url = '/assets/pdf/formato_1_ficha_datos_empresa.pdf'; // Ruta del PDF

  try {
      const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());

      const pdfDoc = await PDFLib.PDFDocument.load(existingPdfBytes);
      const page = pdfDoc.getPage(0); // Obtener la primera página

      page.drawText(nombrecompleto, { x: 275, y: 647, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(codigo, { x: 275, y: 593, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(nombre_empresa, { x: 275, y: 533, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(ruc_empresa, { x: 275, y: 565, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(celular_repre, { x: 350, y: 410, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(email_repre, { x: 350, y: 380, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(direccion, { x: 275, y: 308, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(representante, { x: 275, y: 506, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(dni_repre, { x: 315, y: 440, size: 12, color: PDFLib.rgb(0, 0, 0) });
      page.drawText(direccion_empre, { x: 275, y: 350, size: 12, color: PDFLib.rgb(0, 0, 0) });

      const pdfBytes2 = await pdfDoc.save();
      tempPdfDoc2 = await PDFLib.PDFDocument.load(pdfBytes2);
      const blob = new Blob([pdfBytes2], { type: 'application/pdf' });
      pdfBlobUrl2 = URL.createObjectURL(blob);

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

  if (pdfFiles.length < 4) {  
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
  a.download = 'CartaPresentación.pdf';  
  document.body.appendChild(a);  
  a.click();  
  document.body.removeChild(a);  
  URL.revokeObjectURL(url);  
});  




/*
  function Aformulario() {  
    document.getElementById('solicitudContainer').style.display = 'none';
    document.getElementById('nuevoContainer').style.display = 'block';
  }*/

/*
No usamos el updateProfilfe de js

function updateProfile() {
  const isNameValid = validateName();
  const isCodigoValid = validateCodigo();
  const isEmailValid = validateEmail();
  const isPhoneValid = validatePhone();

  const nameInput = document.getElementById('name');
  if (nameInput.value.trim() === '') {
      alert('Complete el campo "Apellidos y nombres".');
      return;
  }

  if (!isNameValid || !isCodigoValid || !isEmailValid || !isPhoneValid) {
      alert('Por favor, corrige los errores en el formulario.');
      return;
  }

  alert('Perfil actualizado correctamente.');
}*/

/*
//VALIDACIONES
function validateName() {
  const nameInput = document.getElementById('name');
  const nameError = document.getElementById('name-error');
  const regex = /^[a-zA-Z\s]*$/;
  if (!regex.test(nameInput.value)) {
      nameError.textContent = 'El campo "Apellidos y nombres" solo puede contener letras y espacios.';
      return false;
  } else {
      nameError.textContent = '';
      return true;
  }
}

function validateCodigo() {
  const codigoInput = document.getElementById('codigo');
  const codigoError = document.getElementById('codigo-error');
  const regex = /^\d{10}$/;
  const codigoValue = codigoInput.value;

  if (!regex.test(codigoValue)) {
      codigoError.textContent = 'El código debe ser un número de 10 cifras.';
      return false;
  }

  const codigoNumber = parseInt(codigoValue, 10);
  if (codigoNumber < 2018000000 || codigoNumber > 2024000000) {
      codigoError.textContent = 'El código debe estar entre 2018000000 y 2024000000.';
      return false;
  }

  codigoError.textContent = '';
  return true;
}

function validateEmail() {
  const emailInput = document.getElementById('email');
  const emailError = document.getElementById('email-error');
  const regex = /^[a-zA-Z0-9._%+-]+@(unfv\.edu\.pe|hotmail\.com|gmail\.com)$/;
  if (!regex.test(emailInput.value)) {
      emailError.textContent = 'Ingrese un correo electrónico válido';
      return false;
  } else {
      emailError.textContent = '';
      return true;
  }
}
  
function validatePhone() {
  const phoneInput = document.getElementById('phone');
  const phoneError = document.getElementById('phone-error');
  const regex = /^\d{9}$/;
  if (!regex.test(phoneInput.value)) {
      phoneError.textContent = 'El número de celular debe ser un número de 9 cifras.';
      return false;
  } else {
      phoneError.textContent = '';
      return true;
  }
}

//////////////////////////////////////////////

  No estamos usando esta seccion

  function resetForm() {
    const nameInput = document.getElementById('name');
    const codigoInput = document.getElementById('codigo');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const nameError = document.getElementById('name-error');
    const codigoError = document.getElementById('codigo-error');
    const emailError = document.getElementById('email-error');
    const phoneError = document.getElementById('phone-error');
  
    nameInput.value = '';
    codigoInput.value = '';
    emailInput.value = '';
    phoneInput.value = '';
  
    nameError.textContent = '';
    codigoError.textContent = '';
    emailError.textContent = '';
    phoneError.textContent = '';
  }
  
let currentImage = null; 

function openFileInput() {
    document.getElementById('fileInput').click();
}
function handleFileSelect(event) {
  const file = event.target.files[0];
  const imageButton = document.getElementById('image-button');
  const selectImageText = 'Seleccionar Imagen';

  if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
          // Actualiza el texto del botón a un texto vacío
          imageButton.textContent = ''; 
          // Continúa con la lógica para previsualizar la imagen
          const previewImage = document.getElementById('previewImage');
          previewImage.src = event.target.result;
          document.getElementById('imagePreview').style.display = 'block';
      };
      reader.readAsDataURL(file);
      currentImage = file;
  } else {
      // Si no se selecciona ninguna imagen, restaura el texto original
      imageButton.textContent = selectImageText;
      const previewImage = document.getElementById('previewImage');
      previewImage.src = '';
      document.getElementById('imagePreview').style.display = 'none';
      currentImage = null;
  }
}

document.getElementById('fileInput').addEventListener('change', handleFileSelect);
function uploadImage() {
    document.getElementById('fileInput').click();
}
function removeImage() {
    const previewImage = document.getElementById('previewImage');
    previewImage.src = '';
    document.getElementById('imagePreview').style.display = 'none';
    currentImage = null;
}
function saveImage() {
    if (currentImage) {
        alert('Imagen guardada');
        closeModal();
        updateMainImageButton();
    } else {
        alert('Cargue una imagen primero.');
    }
}
function updateMainImageButton() {
    if (currentImage) {
        const mainImageButton = document.getElementById('image-button');
        const reader = new FileReader();
        reader.onload = function(event) {
            mainImageButton.style.backgroundImage = `url(${event.target.result})`;
        };
        reader.readAsDataURL(currentImage);
    }
}*/

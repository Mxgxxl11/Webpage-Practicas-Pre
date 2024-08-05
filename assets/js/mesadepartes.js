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


function iniciar_cp() {
  window.location.href = 'carta_presentacion.php';
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

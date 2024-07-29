function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    sidebar.style.display = sidebar.style.display === 'none' ? 'block' : 'none';
  }
  
  function loadProfileForm() {
    /*
    resetForm(); este funcion era la que hacia que desapareciera todo*/
    const profileContainer = document.getElementById('profileContainer');
    const solicitudContainer = document.getElementById('solicitudContainer');
  
    profileContainer.style.display = 'block';
    solicitudContainer.style.display = 'none';
  }
  
  function loadSolicitudForm() {
    /*resetForm();*/
    const profileContainer = document.getElementById('profileContainer');
    const solicitudContainer = document.getElementById('solicitudContainer');
  
    profileContainer.style.display = 'none';
    solicitudContainer.style.display = 'block';
  }

  function loadRegistroSolicitud(){
    closeSolicitudForm();
    const registroContainer = document.getElementById('Next-step');
    registroContainer.style.display = 'block';

  }

  function closeProfileForm() {
    const profileContainer = document.getElementById('profileContainer');
    profileContainer.style.display = 'none';
  }
  
  function closeSolicitudForm() {
    const solicitudContainer = document.getElementById('solicitudContainer');
    solicitudContainer.style.display = 'none';
  }

  function closeRegistroSolicitud(){
    const registroSolicitud = document.getElementById('Next-step');
    registroSolicitud.style.display = 'none';

  }
  
  function openModal() {
    document.getElementById('imageModal').style.display = 'block';
  }
  
  function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
  }
  
  function uploadImage() {
    alert('Cargar imagen');
  }
  
  function removeImage() {
    alert('Quitar imagen');
  }
  
  function saveImage() {
    alert('Imagen guardada');
    closeModal();
  }
  
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
  }
  /*
  No la estamos usando
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
  }*/
  
  
  let currentImage = null; 
/*
No la estamos usando
function openFileInput() {
    document.getElementById('fileInput').click();
}
*/

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
/*
function uploadImage() {
    document.getElementById('fileInput').click();
}*/
/*
function removeImage() {
    const previewImage = document.getElementById('previewImage');
    previewImage.src = '';
    document.getElementById('imagePreview').style.display = 'none';
    currentImage = null;
}*/
/*
function saveImage() {
    if (currentImage) {
        alert('Imagen guardada');
        closeModal();
        updateMainImageButton();
    } else {
        alert('Cargue una imagen primero.');
    }
}*/
/*
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

function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
}

function openModal() {
    document.getElementById('imageModal').style.display = 'block';
}


function Aformulario() {  
  document.getElementById('solicitudContainer').style.display = 'none';
  
  document.getElementById('nuevoContainer').style.display = 'block';
}


/* ocultar contraseña*/
let verClave = document.getElementById("verclave");
let clave = document.getElementById("password");
let icono = document.getElementById("icono");
let condicion = true;

verClave.addEventListener("click", function() {
    if (condicion) {
        clave.type = "text";
        icono.classList.remove("fa-eye");
        icono.classList.add("fa-eye-slash");
        condicion = false;
    } else {
        clave.type = "password";
        icono.classList.remove("fa-eye-slash");
        icono.classList.add("fa-eye");
        condicion = true;
    }
});

/* VENTANA EMERGENTE DE LOGIN*/ 
function openv_emergente() {
    document.getElementById("myv_emergente").style.display = "block";
  }
  
  function redirectToInstitutional() {
    // Redirigir a la página de registro mediante correo institucional
    window.location.href = "registroinst.html";
  }
  
  function redirectToOther() {
    // Redirigir a la página de registro con otro correo
    window.location.href = "registroppp.html";
  }

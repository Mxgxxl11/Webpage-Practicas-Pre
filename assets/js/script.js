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
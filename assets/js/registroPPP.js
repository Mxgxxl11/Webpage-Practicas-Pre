function mostrarNumeroDocumento() {
    var tipoDocumento = document.getElementById("tipo_documento").value;
    var numeroDocumentoDiv = document.getElementById("numero_documento_div");
    var numeroDocumento = document.getElementById("numero_documento");

    if (tipoDocumento) {
      numeroDocumentoDiv.classList.remove("hidden");
      numeroDocumento.required = true;
      numeroDocumento.disabled = false;

      if (tipoDocumento == 1) {
        numeroDocumento.type = "number";
        numeroDocumento.placeholder = "Número de DNI";
        numeroDocumento.maxLength = 8;
        //numeroDocumento.pattern = "\\d{8}";
      } else {
        numeroDocumento.type = "text";
        numeroDocumento.placeholder = "Número de Documento";
        numeroDocumento.maxLength = 12;
        numeroDocumento.pattern = "[a-zA-Z0-9]{1,12}";
      }
    } else {
      numeroDocumentoDiv.classList.add("hidden");
      numeroDocumento.required = false;
      numeroDocumento.disabled = true;
    }
  }

  document.getElementById("numero_documento").addEventListener("input", function (e) {
      let tipoDocumento = document.getElementById("tipo_documento").value;
      let valor = e.target.value;

      if (tipoDocumento == 1) {
        if (valor.length > 8) {
          e.target.value = valor.slice(0, 8);
        }
      } else {
        if (valor.length > 12) {
          e.target.value = valor.slice(0, 12);
        }
      }
    });

document.getElementById("codigo").addEventListener("input",function(a){
    let valor = a.target.value;
    if(valor.length > 10){
        a.target.value = valor.slice(0, 10);
    }
})

document.getElementById("celular").addEventListener("input",function(a){
    let valor = a.target.value;
    if(valor.length >9){
        a.target.value = valor.slice(0, 9);
    }
})


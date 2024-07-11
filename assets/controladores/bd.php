<?php
    //este apartado es para conectarme a la base de datos de login_register_db --> usuarios
    $conexion = mysqli_connect("localhost:33065","root","", "proyecto_integrador");//si no funciona cambiar el localhost.
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
   
    if($conexion){
        echo 'Conectado exitosamente a la base de datos'; //el echo es como un alert en JavaScript, ademas imprime el texto en la pagina
    }
    else{
        echo 'No se ha podido conectar a la base de datos';
    }
?>
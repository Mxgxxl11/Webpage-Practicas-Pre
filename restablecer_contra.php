<!--    -->
<?php 
  session_start();
  if(!isset($_SESSION['codigo'])){
    echo'
            <script>
            alert("No has ingresado ningun codigo!");
            window.location = "./olvide_contra.html";
            </script>
        ';
        session_destroy();
  }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reestablecer contraseña</title>
    <link rel="stylesheet" href="assets/css/olvide_cont.css" />
  </head>
  <body>
    <div class="background"></div>
    <div class="container">
      <p>CODIGO DE USUARIO</p>
      <p><?php echo $_SESSION['codigo']; ?></p>
      <p>NUEVA CONTRASEÑA</p>
      <form action="assets/controladores/validar_password.php" method="post">
        <input
          type="password"
          id="new-password"
          name="nueva_contrasena"
          placeholder="Nueva contraseña"
          required
        /><br /><br />
        <span class="ver_clave" id="verclave"
          ><i id="icono" class="fa-solid fa-eye fa-2x"></i
        ></span>

        <input
          type="password"
          id="confirm-password"
          name="confirmar_contrasena"
          placeholder="Confirmar nueva contraseña"
          required
        /><br /><br />
        <span class="ver_clave" id="verclave"
          ><i id="icono" class="fa-solid fa-eye fa-2x"></i
        ></span>
        <button type="submit">Enviar</button>
      </form>
    </div>
  </body>
</html>

<!--     <span class="ver_clave" id="verclave"
              ><i id="icono" class="fa-solid fa-eye fa-2x"></i
                ></span>
                </label>
                  -->

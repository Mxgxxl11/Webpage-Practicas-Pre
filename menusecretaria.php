<!-- NO SE SI ELIMINAREMOS ESTE MENU O NO. LO HABLAMOS EN EL SPRINT 6 -->
<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENU SECRETARIA</title>
</head>
<body>
    <h1>HOLA SECRETARIA</h1>
</body>
</html>
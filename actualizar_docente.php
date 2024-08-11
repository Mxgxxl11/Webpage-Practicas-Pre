<?php

//este archivo pertenece al portal ADMIN
//permite actualizar el docente asignado a un alumno ya que el valor configurado en la tabla alumno
//para el id_docente es null
session_start();
include './assets/controladores/bd.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administradores</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <style>
        .styled-button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            /* Verde */
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .styled-button:hover {
            background-color: #45a049;
            /* Verde más oscuro */
        }

        .styled-link {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            background-color: #f44336;
            /* Rojo */
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .styled-link:hover {
            background-color: #d32f2f;
            /* Rojo más oscuro */
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-admin.php'; ?>
        <main class="main-content">
            <?php
            if (isset($_POST['enviar'])) {
                // Para actualizar el docente del alumno seleccionado
                $id_docente_nuevo = $_POST['docente']; // Obtiene el ID del nuevo docente desde el formulario
                $codigo_alumno = $_POST['codigo_alumno']; // Asegúrate de enviar este valor desde el formulario

                // Actualiza el docente en la base de datos
                $actualizar_docente = "UPDATE alumno SET id_docente='$id_docente_nuevo' WHERE id_usuario='$codigo_alumno'";
                $resultado = mysqli_query($conexion, $actualizar_docente);

                if ($resultado) {
                    echo '
                        <script>
                        alert("Docente actualizado correctamente");
                        window.location.href = "./asignar_docente.php"; 
                        </script>
                    ';
                } else {
                    echo '
                        <script>
                        alert("No se pudo actualizar el docente");
                        window.location.href = "./asignar_docente.php"; 
                        </script>
                    ';
                }
                mysqli_close($conexion);
            } else {
                // Para recuperar los datos y mostrarlos
                $id_docente = $_GET['id_docente'] ?? null; // Si no existe, se le asigna null
                $codigo_alm = $_GET['CODIGO_ALUMNO'];

                if (is_null($id_docente)) {
                    // Si el docente es nulo, continúa normalmente
                    // El formulario debería manejar la asignación de un nuevo docente
                    $consulta = "SELECT u.codigo AS 'CODIGO_ALUMNO',
    CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
    e.escuela, a.seccion, a.id_docente, 
    '' AS 'NOMBRE_DOCENTE' 
    FROM usuario u 
    JOIN escuelas e ON e.id_escuela = u.id_escuela 
    JOIN alumno a ON a.id_usuario = u.codigo 
    JOIN acceso ac ON ac.id_usuario = u.codigo 
    WHERE u.codigo = '$codigo_alm';";
                } else {
                    $consulta = "SELECT u.codigo AS 'CODIGO_ALUMNO',
    CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
    e.escuela, a.seccion, a.id_docente, 
    (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')
     FROM usuario us 
     JOIN docente dn ON dn.id_usuario = us.codigo 
     WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE' 
     FROM usuario u 
     JOIN escuelas e ON e.id_escuela = u.id_escuela 
     JOIN alumno a ON a.id_usuario = u.codigo 
     JOIN acceso ac ON ac.id_usuario = u.codigo 
     WHERE a.id_docente = '$id_docente' and u.codigo ='$codigo_alm';";
                }

                $ejecutar = mysqli_query($conexion, $consulta);
                if (!$ejecutar) {
                    die('Error en la consulta de alumno: ' . mysqli_error($conexion));
                }

                $fila = mysqli_fetch_assoc($ejecutar);
                $codigo_alumno = $fila['CODIGO_ALUMNO'];
                $nombre_alumno = $fila['NOMBRE_ALUMNO'];
                $id_docente_actual = $fila['id_docente'] ?? null;
                $nombre_docente_actual = $fila['NOMBRE_DOCENTE'] ?? null;

                // Consulta para obtener los docentes
                $sql = "SELECT CONCAT(u.nombre1,' ', u.apellido1) AS 'NOMBRE_DOCENTE', d.id_docente
                FROM usuario u
                JOIN docente d ON d.id_usuario = u.codigo;";

                $exec = mysqli_query($conexion, $sql);
                if (!$exec) {
                    die('Error en la consulta de docentes: ' . mysqli_error($conexion));
                }

                mysqli_close($conexion);
            ?>
                <div class="profile-form">
                    <h1 style="text-align:center;">ACTUALIZAR DOCENTE PARA</h1>
                    <h2 style="text-align:center;"><?php echo $nombre_alumno ?> (<?php echo $codigo_alumno ?>)</h2>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input type="hidden" name="codigo_alumno" value="<?php echo $codigo_alumno; ?>">
                        <div class="profile-fields">
                            <div class="entrada">
                                <label for="docente"> Selecciona al nuevo docente:</label>
                                <select name="docente" id="docente">
                                    <?php
                                    if (mysqli_num_rows($exec) > 0) {
                                        while ($rows = mysqli_fetch_assoc($exec)) {
                                            $selected = ($rows['id_docente'] == $id_docente_actual) ? 'selected' : '';
                                            echo "<option value='{$rows['id_docente']}' $selected>{$rows['id_docente']} {$rows['NOMBRE_DOCENTE']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>NO PROFESORES DISPONIBLES</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <input type="submit" name="enviar" value="ACTUALIZAR" class="styled-button">
                        <a href="asignar_docente.php" class="styled-link">REGRESAR</a>
                    </form>
                </div>
            <?php } ?>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
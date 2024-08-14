<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
$direccion_carpeta = "./assets/carpetas_virtuales/";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administradores</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <link rel="stylesheet" href="assets/css/detalles.css">
    <style>
        .my-form__button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: darkorange;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .my-form__button:hover {
            background-color: chocolate;
        }

        .download-button {
            padding: 10px 15px;
            background-color: orange;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .download-button:hover {
            background-color: burlywood;
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-admin.php' ?>
        <article class="table-widget">
            <div class="caption">
                <h2>
                    CARPETA ALUMNOS MECATRÓNICA
                </h2>
            </div>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="codigo">Codigo</label>
                            <input type="number" id="codigo" name="codigo" autocomplete="off">
                        </td>
                        <td>
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" autocomplete="off">
                        </td>
                        <td>
                            <input class="my-form__button" type="submit" name="enviar" value="Buscar">
                        </td>
                        <td>
                            <div class="tags">
                                <div class="tag tag--marketing">
                                    <a href="carpetas_mecatronica.php" style="text-decoration:none; color:black;">
                                        Mostrar todos los usuarios
                                    </a>
                                </div>

                        </td>
                    </tr>
                </table>
            </form>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Escuela</th>
                        <th>Semestre</th>
                        <th>Sección</th>
                        <th>Proceso Culminado</th>
                        <th>Descargar</th>
                        <th colspan="2">Generar</th>
                    </tr>
                </thead>
                <tbody id="team-member-rows">
                    <?php
                    if (isset($_POST['enviar'])) {
                        //aca es para la busqueda
                        $codigo = $_POST['codigo'];
                        $nombre = $_POST['nombre'];
                        if (empty($codigo) and empty($nombre)) { // si no funciona codigo cambiar a $_POST['codigo']
                            echo '<script>
                            alert("Ingresa algún dato para buscar");
                            window.location = "./carpetas_mecatronica.php"; 
                            </script>';
                        } else {
                            if (empty($nombre)) {
                                $busqueda = "SELECT u.codigo, u.nombre1, u.apellido1, u.correo, e.escuela, al.semestre, al.seccion, car.nombre_carpeta, p.paso 
                                FROM usuario u 
                                JOIN acceso a ON u.codigo = a.id_usuario 
                                JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                JOIN alumno al ON al.id_usuario = u.codigo 
                                JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno 
                                JOIN paso_cp p ON p.id_usuario = u.codigo
                                WHERE e.id_escuela = 3 and u.codigo like '%" . $codigo . "%'";
                            }
                            if (empty($codigo)) {
                                $busqueda = "SELECT u.codigo, u.nombre1, u.apellido1, u.correo, e.escuela, al.semestre, al.seccion, car.nombre_carpeta, p.paso 
                                FROM usuario u 
                                JOIN acceso a ON u.codigo = a.id_usuario 
                                JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                JOIN alumno al ON al.id_usuario = u.codigo 
                                JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno 
                                JOIN paso_cp p ON p.id_usuario = u.codigo
                                WHERE e.id_escuela = 3 AND u.nombre1 LIKE '%" . $nombre . "%'
                                 OR u.nombre2 LIKE '%" . $nombre . "%'
                                 OR u.apellido1 LIKE '%" . $nombre . "%'
                                 OR u.apellido2 LIKE '%" . $nombre . "%'";
                            }
                            if (!empty($nombre) and !empty($codigo)) {
                                $busqueda = "SELECT u.codigo, u.nombre1, u.apellido1, u.correo, e.escuela, al.semestre, al.seccion, car.nombre_carpeta, p.paso 
                                FROM usuario u 
                                JOIN acceso a ON u.codigo = a.id_usuario 
                                JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                JOIN alumno al ON al.id_usuario = u.codigo 
                                JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno 
                                JOIN paso_cp p ON p.id_usuario = u.codigo
                                WHERE e.id_escuela = 3 and u.codigo like '%" . $codigo . "%' 
                                and (
                                 u.nombre1 LIKE '%" . $nombre . "%'
                                 OR u.nombre2 LIKE '%" . $nombre . "%'
                                 OR u.apellido1 LIKE '%" . $nombre . "%'
                                 OR u.apellido2 LIKE '%" . $nombre . "%'
                                 )";
                            }
                        }
                        $ejec = mysqli_query($conexion, $busqueda);
                        if ($ejec) {
                            while ($filas = mysqli_fetch_assoc($ejec)) {
                                $ruta_carpeta = $direccion_carpeta . $filas['nombre_carpeta'];
                    ?>
                                <tr>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['codigo'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['escuela'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $filas['semestre']; ?>
                                    </td>
                                    <td>
                                        <?php echo $filas['seccion']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $estado = $filas['paso'];
                                        switch ($estado) {
                                            case 1:
                                                echo "Inicio del proceso";
                                                break;
                                            case 2:
                                                echo "Formulario datos del Alumno";
                                                break;
                                            case 3:
                                                echo "Carta de Presentación";
                                                break;
                                            case 4:
                                                echo "Subida de NT";
                                                break;
                                            case 5:
                                                echo "Apertura de Carpeta";
                                                break;
                                            case 6:
                                                echo "1er Informe";
                                                break;
                                            case 7:
                                                echo "2do Informe";
                                                break;
                                            case 8:
                                                echo "3er Informe";
                                                break;
                                            case 9:
                                                echo "Constancia de culminación";
                                                break;
                                            case 10:
                                                echo "Informe Final";
                                                break;
                                            case 11:
                                                echo "Examen Final";
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="tags">
                                            <div class="tag tag--QA">
                                                <a href="descargar_carpeta.php?carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>" style="text-decoration:none; color:#fff">
                                                    Carpeta Presentación
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tags">
                                            <div class="tag tag--dev">
                                                <a href="generar_carta.php?codigo=<?php echo urlencode($filas['codigo']); ?>&carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>" style="text-decoration:none; color:black">
                                                    Carta de Presentación
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tags">
                                            <div class="tag tag--dev">
                                                <a href="generar_constancia.php?codigo=<?php echo urlencode($filas['codigo']); ?>&carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>" style="text-decoration:none; color:black">
                                                    Constancia Culminación
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        }
                    } else {
                        //aca para mostrar todos los registros de los alumnos de mecatrónica

                        $consulta = "SELECT u.codigo, u.nombre1, u.apellido1, u.correo, e.escuela, al.semestre, al.seccion, car.nombre_carpeta, p.paso 
                        FROM usuario u 
                        JOIN acceso a ON u.codigo = a.id_usuario 
                        JOIN escuelas e ON e.id_escuela = u.id_escuela 
                        JOIN alumno al ON al.id_usuario = u.codigo 
                        JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno 
                        JOIN paso_cp p ON p.id_usuario = u.codigo
                                    where a.id_rol=3 and e.id_escuela=3";
                        $ejecucion = mysqli_query($conexion, $consulta);
                        while ($filas = mysqli_fetch_assoc($ejecucion)) {
                            $ruta_carpeta = $direccion_carpeta . $filas['nombre_carpeta'];
                            ?>

                            <tr>
                                <td>
                                    <div class="profile-info">
                                        <?php echo $filas['codigo'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="profile-info">
                                        <?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="profile-info">
                                        <?php echo $filas['escuela']; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $filas['semestre']; ?>
                                </td>
                                <td>
                                    <?php echo $filas['seccion']; ?>
                                </td>
                                <td>
                                    <?php
                                    $estado = $filas['paso'];
                                    switch ($estado) {
                                        case 1:
                                            echo "Inicio del proceso";
                                            break;
                                        case 2:
                                            echo "Formulario datos del Alumno";
                                            break;
                                        case 3:
                                            echo "Carta de Presentación";
                                            break;
                                        case 4:
                                            echo "Subida de NT";
                                            break;
                                        case 5:
                                            echo "Apertura de Carpeta";
                                            break;
                                        case 6:
                                            echo "1er Informe";
                                            break;
                                        case 7:
                                            echo "2do Informe";
                                            break;
                                        case 8:
                                            echo "3er Informe";
                                            break;
                                        case 9:
                                            echo "Constancia de culminación";
                                            break;
                                        case 10:
                                            echo "Informe Final";
                                            break;
                                        case 11:
                                            echo "Examen Final";
                                            break;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="tags">
                                        <div class="tag tag--QA">
                                            <a href="descargar_carpeta.php?carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>" style="text-decoration:none; color:#fff">
                                                Carpeta Presentación
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="tags">
                                        <div class="tag tag--dev">
                                            <a href="generar_carta.php?codigo=<?php echo urlencode($filas['codigo']); ?>&carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>" style="text-decoration:none; color:black">
                                                Carta de Presentación
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="tags">
                                        <div class="tag tag--dev">
                                            <a href="generar_constancia.php?codigo=<?php echo urlencode($filas['codigo']); ?>&carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>" style="text-decoration:none; color:black">
                                                Constancia Culminación
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
            <?php mysqli_close($conexion) ?>
        </article>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
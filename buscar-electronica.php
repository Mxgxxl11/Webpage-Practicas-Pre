<?php
session_start();
include './assets/controladores/bd.php';

if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
    exit();
}

// Definicion el id_escuela de "Electronica"
$id_escuela_telecomunicaciones = 4; // Cambia este valor según el id 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Alumnos de Telecomunicaciones</title>
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
    </style>
</head>
<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-docente.php' ?>
        <article class="table-widget">
            <div class="caption">
                <h2>
                    TODOS LOS ALUMNOS REGISTRADOS DE ELECTRONICA
                </h2>
            </div>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="codigo">Código o Nombre</label>
                            <input type="text" id="codigo" name="codigo" placeholder="Código o Nombre">
                        </td>
                        <td>
                            <input class="my-form__button" type="submit" name="enviar" value="Buscar">
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
                        <th>Base</th>
                        <th>Semestre</th>
                        <th>Sección</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="team-member-rows">
                    <?php
                    if (isset($_POST['enviar'])) {
                        $codigo = $_POST['codigo'];
                        if (empty($codigo)) {
                            echo '<script>
                                alert("Ingresa algún dato para buscar");
                                </script>';
                        } else {
                            $busqueda = "SELECT u.codigo, CONCAT(u.nombre1, ' ', u.apellido1) AS nombre_completo, a.base, a.semestre, a.seccion 
                                        FROM alumno a
                                        JOIN usuario u ON a.id_usuario = u.codigo
                                        JOIN escuelas es ON u.id_escuela = es.id_escuela
                                        WHERE es.id_escuela = '$id_escuela_telecomunicaciones' AND 
                                              (u.codigo LIKE '%$codigo%' OR u.nombre1 LIKE '%$codigo%' OR u.apellido1 LIKE '%$codigo%')";
                            $ejec = mysqli_query($conexion, $busqueda);
                            if ($ejec) {
                                while ($filas = mysqli_fetch_assoc($ejec)) { ?>
                                    <tr>
                                        <td><?php echo $filas['codigo'] ?></td>
                                        <td><?php echo $filas['nombre_completo'] ?></td>
                                        <td><?php echo $filas['base'] ?></td>
                                        <td><?php echo $filas['semestre'] ?></td>
                                        <td><?php echo $filas['seccion'] ?></td>
                                        <td>
                                            <button class="action-btn">Evaluar</button>
                                            <button class="action-btn">Enviar Informes</button>
                                        </td>
                                    </tr>
                                <?php }
                            }
                        }
                    } else {
                        $consulta = "SELECT u.codigo, CONCAT(u.nombre1, ' ', u.apellido1) AS nombre_completo, a.base, a.semestre, a.seccion 
                                    FROM alumno a
                                    JOIN usuario u ON a.id_usuario = u.codigo
                                    JOIN escuelas es ON u.id_escuela = es.id_escuela
                                    WHERE es.id_escuela = '$id_escuela_telecomunicaciones'";
                        $ejecucion = mysqli_query($conexion, $consulta);
                        while ($filas = mysqli_fetch_assoc($ejecucion)) { ?>
                            <tr>
                                <td><?php echo $filas['codigo'] ?></td>
                                <td><?php echo $filas['nombre_completo'] ?></td>
                                <td><?php echo $filas['base'] ?></td>
                                <td><?php echo $filas['semestre'] ?></td>
                                <td><?php echo $filas['seccion'] ?></td>
                                <td>
                                    <button class="action-btn">Evaluar</button>
                                    <button class="action-btn">Enviar Informes</button>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
            <?php mysqli_close($conexion); ?>
        </article>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>
</html>

<?php  
session_start();  
include './assets/controladores/bd.php';  
if (empty($_SESSION['codigo_institucional'])) {  
    echo '<script>  
    alert("Para continuar debe iniciar sesión");  
    window.location = "login.html";   
    </script>';  
}  
$codigo_admin = $_SESSION['codigo_institucional'];
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
    </style>  
</head>  

<body>  
<header>  
    <?php include './includes/header.php'; ?>  
</header>  
<div class="container">  
    <?php include './includes/sidebar-admin.php'; ?>  
    <article class="table-widget">  
        <div class="caption">  
            <h2>TODAS LAS NOTIFICACIONES</h2>  
        </div>  
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">  
            <table>  
                <tr>  
                    <td>  
                        <label for="codigo">Codigo</label>  
                        <input type="number" id="codigo" name="codigo" autocomplete="off">  
                    </td>  
                    <td>  
                        <label for="rol">Rol</label>  
                        <input type="text" id="rol" name="rol" autocomplete="off">  
                    </td>  
                    <td>  
                        <input class="my-form__button" type="submit" name="enviar" value="Buscar">  
                    </td>  
                    <td>  
                        <div class="tags">  
                            <div class="tag tag--marketing">  
                                <a href="ver_usuarios.php" style="text-decoration:none; color:black;">  
                                    Mostrar todas las notificaciones  
                                </a>  
                            </div>  
                        </div>  
                    </td>  
                </tr>  
            </table>  
        </form>  
        <br>  
        <table>  
            <thead>  
                <tr>  
                    <th>Nombre Alumno</th>  
                    <th>Apellido Alumno</th>  
                    <th>Mensaje</th>  
                    <th>Fecha-Hora</th>
                    <th>Leido</th>    
                </tr>  
            </thead>  
            <tbody id="team-member-rows">  
                <?php  
                if (isset($_POST['enviar'])) {  
                    // Busqueda en notificaciones  
                    $codigo = $_POST['codigo'];  
                    $rol = $_POST['rol'];  
                    if (empty($codigo) && empty($rol)) {  
                        echo '<script>  
                        alert("Ingresa algún dato para buscar");  
                        window.location = "./ver_usuarios.php";   
                        </script>';  
                    } else {  
                        $busqueda = "  
                        SELECT u.nombre1, u.apellido1, n.mensaje, n.fecha_notificacion, n.leido  
                        FROM notificaciones n   
                        JOIN usuario u ON u.codigo = n.id_usuario  
                        WHERE n.id_usuario <> '$codigo_admin'";  

                        // Añadir lógica de búsqueda adicional si es necesario aquí...  
                    }  
                    $ejec = mysqli_query($conexion, $busqueda);  
                    if ($ejec && mysqli_num_rows($ejec) > 0) {  
                        while ($filas = mysqli_fetch_assoc($ejec)) { ?>  
                            <tr>  
                                <td><?php echo $filas['nombre1']; ?></td>  
                                <td><?php echo $filas['apellido1']; ?></td>  
                                <td><?php echo $filas['mensaje']; ?></td>  
                                <td><?php echo $filas['fecha_notificacion']; ?></td> 
                                <td><?php echo $filas['leido']; ?></td> 
                            </tr>  
                        <?php }  
                    } else {  
                        echo '<tr><td colspan="4">No se encontraron notificaciones.</td></tr>';  
                    }  
                } else {  
                    // Mostrar todas las notificaciones  
                    $consulta = "  
                    SELECT u.nombre1, u.apellido1, n.mensaje, n.fecha_notificacion, n.leido   
                    FROM notificaciones n   
                    JOIN usuario u ON u.codigo = n.id_usuario  
                    WHERE n.id_usuario <> '$codigo_admin'";  

                    $ejecucion = mysqli_query($conexion, $consulta);  
                    while ($filas = mysqli_fetch_assoc($ejecucion)) { ?>  
                        <tr>  
                            <td><?php echo $filas['nombre1']; ?></td>  
                            <td><?php echo $filas['apellido1']; ?></td>  
                            <td><?php echo $filas['mensaje']; ?></td>  
                            <td><?php echo $filas['fecha_notificacion']; ?></td>  
                            <td><?php echo $filas['leido']; ?></td>  
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

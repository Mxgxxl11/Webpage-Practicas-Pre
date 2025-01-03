<!-- NOTIFICACIONES DOCENTE-->
<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>  
    alert("Para continuar debe iniciar sesión");  
    window.location = "login.html";   
    </script>';
}
$codigo = $_SESSION['codigo_institucional'];
$id_docente = 0;
try {
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT id_docente FROM docente WHERE id_usuario = ?");
    $stmt->bind_param("i", $codigo);
    $stmt->execute();
    $stmt->bind_result($id_docente);
    $stmt->fetch();
    $stmt->close();
} catch (Exception $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <link rel="stylesheet" href="assets/css/detalles.css">
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-docente.php'; ?>
        <article class="table-widget" style="margin: 10px 10px 10px 10px; width: 70%">
            <div class="caption">
                <h2>
                    Notificaciones
                </h2>
            </div>
            <table>
                <thead style="width: 100%;">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Mensaje</th>
                        <th>Fecha-Hora</th>
                    </tr>
                </thead>
                <tbody id="team-member-rows">
                    <?php
                    // Corregido y puesto en el contexto correcto  
                    $consulta = "  
                    SELECT u.nombre1, u.apellido1, n.mensaje, n.fecha_notificacion, n.leido   
                    FROM notificaciones n   
                    JOIN usuario u ON u.codigo = n.id_usuario  
                    WHERE (n.id_profesor = '$id_docente' AND (tipo_notificacion = 'Examen Final Resuelto' OR tipo_notificacion = 'Informe Final'))";

                    $ejecucion = mysqli_query($conexion, $consulta);

                    while ($filas = mysqli_fetch_assoc($ejecucion)) {
                    ?>
                        <tr>
                            <td><?php echo $filas['nombre1']; ?></td>
                            <td><?php echo $filas['apellido1']; ?></td>
                            <td><?php echo $filas['mensaje']; ?></td>
                            <td><?php echo $filas['fecha_notificacion']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php mysqli_close($conexion) ?>
        </article>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
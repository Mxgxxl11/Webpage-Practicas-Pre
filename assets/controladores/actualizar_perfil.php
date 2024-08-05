<?php
session_start();
include 'bd.php';
$rol = $_SESSION['idRol'];
if (isset($_POST['enviar'])) {
    $codigo = $_SESSION['codigo_institucional'];

    // Obtener los valores enviados por el formulario
    $upd_correo = $_POST['correo'];
    $upd_distrito = $_POST['distrito'];
    $upd_direccion = $_POST['direccion'];
    $upd_celular = $_POST['celular'];

    // Construir la consulta de actualización dinámicamente
    $actualizar_datos = "UPDATE usuarios SET ";
    $campos_a_actualizar = [];

    if (!empty($upd_correo)) {
        $campos_a_actualizar[] = "correo = '$upd_correo'";
    }
    if (!empty($upd_distrito)) {
        $campos_a_actualizar[] = "distrito = '$upd_distrito'";
    }
    if (!empty($upd_direccion)) {
        $campos_a_actualizar[] = "direccion = '$upd_direccion'";
    }
    if (!empty($upd_celular)) {
        $campos_a_actualizar[] = "celular = '$upd_celular'";
    }

    if (count($campos_a_actualizar) > 0) {
        $actualizar_datos .= implode(", ", $campos_a_actualizar);
        $actualizar_datos .= " WHERE codigo = '$codigo'";

        $ejec_act = mysqli_query($conexion, $actualizar_datos);

        if ($ejec_act) {
            // Actualizar la sesión solo con los valores proporcionados
            if (!empty($upd_correo)) {
                $_SESSION['Correo_Institucional'] = $upd_correo;
            }
            if (!empty($upd_distrito)) {
                $_SESSION['distrito'] = $upd_distrito;
            }
            if (!empty($upd_direccion)) {
                $_SESSION['direccion'] = $upd_direccion;
            }
            if (!empty($upd_celular)) {
                $_SESSION['celular'] = $upd_celular;
            }
            if ($rol == 3) {
                echo '
                <script>
                alert("Datos actualizados correctamente");
                window.location.href = "./../../ver_perfil.php"; 
                </script>
            ';
            } else if ($rol == 2) {
                echo '
                <script>
                alert("Datos actualizados correctamente");
                window.location.href = "./../../../menusecretaria.php"; 
                </script>
            ';
            } else if ($rol == 1) {
                echo '
                <script>
                alert("Datos actualizados correctamente");
                window.location.href = "./../../perfil_admin.php"; 
                </script>
            ';
            }
            
        } else {
            if ($rol == 3) {
                echo '
                <script>
                alert("Error al actualizar los datos");
                window.location.href = "./../../../mesadepartes.php"; 
                </script>
            ';
            } else if ($rol == 2) {
                echo '
                <script>
                alert("Error al actualizar los datos");
                window.location.href = "./../../../menusecretaria.php"; 
                </script>
            ';
            } else if ($rol == 1) {
                echo '
                <script>
                alert("Error al actualizar los datos");
                window.location.href = "./../../../menuadmin.php"; 
                </script>
            ';
            }
        }
    } else {
        if ($rol == 3) {
            echo '
            <script>
            alert("No se proporcionaron datos para actualizar");
            window.location.href = "./../../../mesadepartes.php"; 
            </script>
        ';
        } else if ($rol == 2) {
            echo '
            <script>
            alert("No se proporcionaron datos para actualizar");
            window.location.href = "./../../../menusecretaria.php"; 
            </script>
        ';
        } else if ($rol == 1) {
            echo '
            <script>
            alert("No se proporcionaron datos para actualizar");
            window.location.href = "./../../../menuadmin.php"; 
            </script>
        ';
        }
    }
} else {
    if ($rol == 3) {
        header("location: ./../../../mesadepartes.php");
    } else if ($rol == 2) {
        header("location: ./../../../menusecretaria.php");
    } else if ($rol == 1) {
        header("location: ./../../../menuadmin.php");
    }
}

<?php
session_start();
include 'bd.php';
$rol = $_SESSION['idRol'];
// Ruta predeterminada de la foto de perfil en una constante
define('FOTO_PREDETERMINADA', 'assets/fotos_perfil/perfil_pred.png');

// Verifica si el archivo se ha cargado correctamente
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $foto = $_FILES['foto']['tmp_name']; // Nombre temporal del archivo
    $nombre_foto = $_FILES['foto']['name']; // Nombre original del archivo
    $tipo_imagen = strtolower(pathinfo($nombre_foto, PATHINFO_EXTENSION)); // Extensión de la imagen
    $size_imagen = $_FILES['foto']['size']; // Tamaño de la imagen en bytes
    $codigo = $_SESSION['codigo_institucional'];
    $directorio_foto_perfil = __DIR__ . '/../../assets/fotos_perfil/'; // Ruta absoluta
    $ruta_actual = __DIR__ . '/../../' . $_SESSION['foto']; // Ruta absoluta de la foto actual

    // Verifica si la imagen tiene una extensión válida
    if (in_array($tipo_imagen, ['jpg', 'jpeg', 'png'])) {
        // Construye la ruta final de la imagen
        $ruta_foto = $directorio_foto_perfil . $codigo . "." . $tipo_imagen;

        // Verifica que el directorio tiene permisos de escritura
        if (!is_writable($directorio_foto_perfil)) {
            die('El directorio no tiene permisos de escritura...');
        }

        // Verifica si la ruta actual no es la foto predeterminada
        if ($ruta_actual != __DIR__ . '/../../' . FOTO_PREDETERMINADA) {
            unlink($ruta_actual);
        }

        // Mueve el archivo cargado al directorio de destino
        if (move_uploaded_file($foto, $ruta_foto)) {
            // Actualiza la ruta de la imagen en la base de datos
            $ruta_foto_db = mysqli_real_escape_string($conexion, 'assets/fotos_perfil/' . $codigo . '.' . $tipo_imagen);
            $query2 = "UPDATE usuarios SET foto='$ruta_foto_db' WHERE codigo ='$codigo'";
            $actualizar_foto = mysqli_query($conexion, $query2);

            if ($actualizar_foto) {
                // Actualiza la variable de sesión con la nueva ruta de la foto
                $_SESSION['foto'] = $ruta_foto_db;
                if ($rol == 3) {
                    echo '
                    <script>
                    alert("Imagen guardada exitosamente");
                    window.location.href = "./../../ver_perfil.php"; 
                    </script>
                ';
                } else if ($rol == 2) {
                    echo '
                    <script>
                    alert("Imagen guardada exitosamente");
                    window.location.href = "./../../../menusecretaria.php"; 
                    </script>
                ';
                } else if ($rol == 1) {
                    echo '
                    <script>
                    alert("Imagen guardada exitosamente");
                    window.location.href = "./../../perfil_admin.php"; 
                    </script>
                ';
                }
            } else {
                if ($rol == 3) {
                    echo '
                    <script>
                    alert("Problemas al actualizar la imagen en la base de datos");
                    window.location.href = "./../../../mesadepartes.php"; 
                    </script>
                ';
                    echo "Error: " . mysqli_error($conexion);
                } else if ($rol == 2) {
                    echo '
                    <script>
                    alert("Problemas al actualizar la imagen en la base de datos");
                    window.location.href = "./../../../menusecretaria.php"; 
                    </script>
                ';
                    echo "Error: " . mysqli_error($conexion);
                } else if ($rol == 1) {
                    echo '
                    <script>
                    alert("Problemas al actualizar la imagen en la base de datos");
                    window.location.href = "./../../../menuadmin.php"; 
                    </script>
                ';
                    echo "Error: " . mysqli_error($conexion);
                }
            }
        } else {
            echo '
                <script>
                alert("Problemas al cargar la imagen");
                window.location.href = "./../../../mesadepartes.php"; 
                </script>
            ';
            echo "Error: No se pudo mover el archivo.";
        }
    } else {
        if ($rol == 3) {
            echo '
            <script>
            alert("Formato de imagen no aceptado");
            window.location.href = "./../../ver_perfil.php"; 
            </script>
        ';
        } else if ($rol == 2) {
            echo '
            <script>
            alert("Formato de imagen no aceptado");
            window.location.href = "./../../../menusecretaria.php"; 
            </script>
        ';
        } else if ($rol == 1) {
            echo '
            <script>
            alert("Formato de imagen no aceptado");
            window.location.href = "./../../perfil_admin.php"; 
            </script>
        ';
        }
    }
} else {
    if ($rol == 3) {
        echo '
        <script>
        alert("No se ha cargado ningún archivo o hubo un error en la carga");
        window.location.href = "./../../ver_perfil.php"; 
        </script>
    ';
    } else if ($rol == 2) {
        echo '
        <script>
        alert("No se ha cargado ningún archivo o hubo un error en la carga");
        window.location.href = "./../../../menusecretaria.php"; 
        </script>
    ';
    } else if ($rol == 1) {
        echo '
        <script>
        alert("No se ha cargado ningún archivo o hubo un error en la carga");
        window.location.href = "./../../perfil_admin.php"; 
        </script>
    ';
    }
}

mysqli_close($conexion);

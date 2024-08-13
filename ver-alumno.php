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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buscar-alumno</title>
    <link rel="stylesheet" href="./assets/css/mesadepartes.css" />
    <link rel="stylesheet" href="./assets/css/menu_tramites.css">
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-docente.php'; ?>
        <main class="main-contents">
            <div class="responsive">
                <div class="gallery-docente">
                    <img src="./../assets/images/telecomunicaciones.png" alt="logo-telecomunicaciones">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>TELECOMUNICACIONES</strong></p>
                        </div>
                        <!-- Usa un enlace para redirigir -->
                        <a href="./buscar-telecomunicaones.php"><button>BUSCAR</button></a>
                    </div>
                </div>
            </div>



            <div class="responsive">

                <div class="gallery-docente">
                    <img src="./../assets/images/informatica.png" alt="logo-informatica">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>INFORMATICA</strong></p>
                        </div>

                        <a href="./buscar-informatica.php"><button>BUSCAR</button></a>
                    </div>
                </div>
            </div>

            <div class="responsive">

                <div class="gallery-docente">
                    <img src="./../assets/images/mecatronica.png" alt="logo-mecatronica">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>MECATRONICA</strong></p>
                        </div>

                        <a href="./buscar-mecatronica.php"><button>BUSCAR</button></a>
                    </div>
                </div>
            </div>

            <div class="responsive">

                <div class="gallery-docente">
                    <img src="./../assets/images/electronica.png" alt="logo-electronica">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>ELECTRONICA</strong></p>
                        </div>

                        <a href="./buscar-electronica.php"><button>BUSCAR</button></a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
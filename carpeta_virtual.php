<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
//este archivo pertenece al portal ADMIN, AUN NO ESTA LISTO
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrador</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <style>
        * {
            box-sizing: border-box;
        }

        div.ambos {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        div.desc {
            display: column;
            height: 100%;
        }

        div.gallery {
            border: 1px solid #ccc;
            border-radius: 15px;
            overflow: hidden;
            width: 100%;
            max-width: 300px;
            /* Ajusta este valor según sea necesario */
            height: 250px;
            /* Ajusta este valor según sea necesario */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;

        }

        .desc {
            padding: 15px;
            background-color: #fff;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
        }

        button {
            background-color: orange;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        #logosidebar {
            width: 30px;
            margin-right: 20px;
        }

        button:hover {
            background-color: orangered;
        }

        div.gallery:hover {
            border: 1px solid #777;
        }

        div.gallery img {
            width: 100px;
            height: 100x;
            display: block;
            margin: 0;
        }

        .responsive {
            padding: 0 6px;
            float: left;
            width: 50%;
            height: 50%;
            margin-top: 10px;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        .texto_derecho {
            margin: 5px 0;
            text-align: right;
        }

        .texto_izquierdo {
            margin: 5px 0;
            text-align: left;
        }

        #text1,
        #text3 {
            color: rgb(69, 68, 68);
        }

        #text2 {
            color: #C0392B;
        }

        #text1,
        #text2 {
            font-size: 15px;
        }

        #text3 {
            font-size: 30px;
        }

        #text4 {
            font-size: 13px;
            color: #777;
        }

        @media only screen and (max-width: 700px) {
            .responsive {
                width: 49.99999%;
                margin: 6px 0;
            }
        }

        @media only screen and (max-width: 500px) {
            .responsive {
                width: 100%;
            }
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
            <h2>VISUALIZACION DE CARPETAS VIRTUALES SEGUN ESCUELA</h2>
            <div class="responsive">
                <div class="gallery">
                    <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="carta_presentacion">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>INFORMÁTICA</strong></p>
                        </div>
                        <button onclick="location.href='./carpetas_informatica.php'">Iniciar</button>
                    </div>
                </div>
            </div>
            <div class="responsive">
                <div class="gallery">
                    <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="carta_presentacion">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>ELECTRÓNICA</strong></p>
                        </div>
                        <button onclick="">Iniciar</button>
                    </div>
                </div>
            </div>

            <div class="responsive">
                <div class="gallery">
                    <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="carta_presentacion">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>MECATRÓNICA</strong></p>
                        </div>
                        <button onclick="">Iniciar</button>
                    </div>
                </div>
            </div>
            <div class="responsive">
                <div class="gallery">
                    <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="carta_presentacion">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>TELECOM.</strong></p>
                        </div>
                        <button onclick="">Iniciar</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
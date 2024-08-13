<?php
session_start();
include './assets/controladores/bd.php';
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
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <style>
        /* Estilos CSS embebidos */
        .profile-form {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        .otro-con {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #FF5722;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #E64A19;
        }

        .btn-previsualizar {
            background-color: #FF5722;
            margin-top: 5px;
        }

        .btn-submit {
            background-color: #FF5722;
            margin-top: 20px;
        }

        .preview-box {
            width: 300px;
            height: 200px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            background-color: #f0f0f0;
        }

        .preview-box img {
            max-width: 100%;
            max-height: 100%;
        }

        .empty-container {
            width: 300px;
            height: 200px;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-docente.php'; ?>
        <main class="main-content">

            <!-- EVALUACIÓN DEL ALUMNO-- INFORME FINAL DEL ALUMNO--->
            <div class="container2"><br>
                <h2>EVALUACIÓN DEL ALUMNO</h2>
                <br>
            </div>
            <div class="container2">
                <h2>Informe Final Del alumno</h2>
                <div class="form-group">
                    <div class="buttons">
                        <button id="(DocFinal)descargar informe" type="button" class="btn-small">Descargar informe final</button>
                    </div>

                </div>

                <div class="form-group">
                    <label for="nombreEmpresa">Calificación:</label>
                    <input type="text" id="nombreEmpresa" name="nombre_empresa" placeholder="Nota de la evaluacion" required>
                </div>

                <div class=" btn">
                    <button type="submit" class="btn">Calificar</button>
                </div>
            </div>

            <!-- DOCENTE ENVIA PRACTICA AL ALUMNO--->
            <div class="container2">
                <h2>Examen de PRACTICA PRE-PROFESIONAL</h2>
                <div class="form-group">
                    <label for="fechaRegistro">Fecha de Registro:</label>
                    <input type="date" id="fechaRegistro" class="date-picker">
                </div>

                <div class="form-group">
                    <div class="buttons">
                        <button id="(DocFinal)descargar informe" type="button" class="btn-small">Adjuntar examen</button>
                    </div>
                </div>

                <div class=" btn">
                    <button type="submit" class="btn">Enviar examen</button>
                </div>
            </div>

            <!-- DOCENTE CALIFICA EXAMEN DLE ALUMNO-->
            <div class="container2">
                <h2>Calificar examen del alumno</h2>
                <div class="form-group">
                    <div class="buttons">
                        <button id="(DocFinal)descargar informe" type="button" class="btn-small">Descargar Examen</button>
                    </div>

                </div>

                <div class="form-group">
                    <label for="nombreEmpresa">Calificación del examen:</label>
                    <input type="text" id="nombreEmpresa" name="nombre_empresa" placeholder="Nota de la evaluacion" required>
                </div>

                <div class=" btn">
                    <button type="submit" class="btn">Calificar examen</button>
                </div>
            </div>

            <!-- NOTA DE APRESIACION DEL DOCENTE-->
            <div class="container2">

                <h2>Apreciación final del docente</h2>
                <div class="form-group">
                    <label for="nombreEmpresa">Apresiación final:</label>
                    <input type="text" id="nombreEmpresa" name="nombre_empresa" placeholder="Apresiación" required>
                </div>

                <div class=" btn">
                    <button type="submit" class="btn">Enviar apresiación </button>
                </div>

            </div>

            <!-- PROMEDIO FINAL DEL ALUMNO-->
            <div class="container2">

                <h2>PROMEDIO FINAL DEL ALUMNO</h2>
                <div class="form-group">
                    <label for="nombreEmpresa">Promedio final:</label>
                    <input type="text" id="nombreEmpresa" name="nombre_empresa" placeholder=" " required>
                </div>
                <div class="form-group">
                    <label for="nombreEmpresa">Comentario final sobre el alumno:</label>
                    <input type="text" id="nombreEmpresa" name="nombre_empresa" placeholder="comentario final required">
                </div>

                <div class=" btn">
                    <button type="submit" class="btn">Enviar apresiación </button>
                </div>
            </div>


            <div class="form-buttons">
                <button onclick="closeProfileForm()" class="close-btn"> Cerrar</button>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
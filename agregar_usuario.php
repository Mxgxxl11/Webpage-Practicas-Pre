<!-- PARA MENU ADMIN-->
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar usuario</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css">
    <style>
        .profile-form {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .profile-form .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .profile-form .entrada {
            display: flex;
            flex-direction: column;
        }

        .profile-form label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .profile-form input[type="text"],
        .profile-form input[type="number"],
        .profile-form input[type="password"],
        .profile-form input[type="email"],
        .profile-form select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .profile-form input[type="text"]:focus,
        .profile-form input[type="number"]:focus,
        .profile-form input[type="password"]:focus,
        .profile-form input[type="email"]:focus,
        .profile-form select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .profile-form .entrada.full-width {
            grid-column: span 2;
        }

        .profile-form .my-form__button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: coral;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .profile-form .my-form__button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-admin.php' ?>
        <main class="main-content">
            <div class="profile-form">
                <h1>REGISTRO ROLES</h1>
                <form action="assets/controladores/registro_admin.php" method="post">
                    <div class="entrada">
                        <label for="rol">Rol del usuario:</label>
                        <select id="rol" name="rol" required>
                            <option value="" selected disabled>
                                Seleccione un rol
                            </option>
                            <option value="1">Administrador</option>
                            <option value="2">Docente</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-grid">
                        <div class="entrada">
                            <label for="codigo">Codigo Usuario Villarreal:</label>
                            <input type="number" id="codigo" name="codigo" maxlength="10" autocomplete="off" title="Recuerda tu codigo son 10 dígitos" required />
                        </div>
                        <div class="entrada">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" autocomplete="off" required />
                        </div>
                        <div class="entrada">
                            <label for="tipo_documento">Tipo de Documento:</label>
                            <select id="tipo_documento" name="tipo_documento" required onchange="mostrarNumeroDocumento()">
                                <option value="" selected disabled>
                                    Seleccione un tipo de documento
                                </option>
                                <option value="1">DNI</option>
                                <option value="2">Pasaporte</option>
                                <option value="3">Otro</option>
                            </select>
                        </div>
                        <div class="hidden entrada" id="numero_documento_div">
                            <label for="numero_documento">Número de Documento:</label>
                            <input type="text" id="numero_documento" name="numero_documento" autocomplete="off" />
                        </div>
                        <div class="entrada">
                            <label for="primer_nombre">Primer Nombre:</label>
                            <input type="text" id="primer_nombre" name="nombre1" autocomplete="off" pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+" title="Solo se permiten letras y espacios" required />
                        </div>
                        <div class="entrada">
                            <label for="segundo_nombre">Segundo Nombre:</label>
                            <input type="text" id="segundo_nombre" name="nombre2" autocomplete="off" pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+" title="Solo se permiten letras y espacios" />
                        </div>
                        <div class="entrada">
                            <label for="primer_apellido">Primer Apellido:</label>
                            <input type="text" id="primer_apellido" name="apellido1" autocomplete="off" pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+" title="Solo se permiten letras y espacios" required />
                        </div>
                        <div class="entrada">
                            <label for="segundo_apellido">Segundo Apellido:</label>
                            <input type="text" id="segundo_apellido" name="apellido2" autocomplete="off" pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+" title="Solo se permiten letras y espacios" />
                        </div>
                        <div class="entrada">
                            <label for="distrito">Distrito:</label>
                            <select name="distrito" id="distrito" required>
                                <option value="" selected disabled>Seleccione un distrito</option>
                                <option value="ANCON">ANCON</option>
                                <option value="ATE">ATE</option>
                                <option value="BARRANCO">BARRANCO</option>
                                <option value="BREÑA">BREÑA</option>
                                <option value="CARABAYLLO">CARABAYLLO</option>
                                <option value="CHACLACAYO">CHACLACAYO</option>
                                <option value="CHORRILLOS">CHORRILLOS</option>
                                <option value="CIENEGUILLA">CIENEGUILLA</option>
                                <option value="COMAS">COMAS</option>
                                <option value="EL AGUSTINO">EL AGUSTINO</option>
                                <option value="INDEPENDENCIA">INDEPENDENCIA</option>
                                <option value="JESUS MARIA">JESUS MARIA</option>
                                <option value="LA MOLINA">LA MOLINA</option>
                                <option value="LA VICTORIA">LA VICTORIA</option>
                                <option value="LIMA">LIMA</option>
                                <option value="LINCE">LINCE</option>
                                <option value="LOS OLIVOS">LOS OLIVOS</option>
                                <option value="LURIGANCHO">LURIGANCHO</option>
                                <option value="LURIN">LURIN</option>
                                <option value="MAGDALENA DEL MAR">MAGDALENA DEL MAR</option>
                                <option value="MIRAFLORES">MIRAFLORES</option>
                                <option value="PACHACAMAC">PACHACAMAC</option>
                                <option value="PUCUSANA">PUCUSANA</option>
                                <option value="PUEBLO LIBRE">PUEBLO LIBRE</option>
                                <option value="PUENTE PIEDRA">PUENTE PIEDRA</option>
                                <option value="PUNTA HERMOSA">PUNTA HERMOSA</option>
                                <option value="PUNTA NEGRA">PUNTA NEGRA</option>
                                <option value="RIMAC">RIMAC</option>
                                <option value="SAN BARTOLO">SAN BARTOLO</option>
                                <option value="SAN BORJA">SAN BORJA</option>
                                <option value="SAN ISIDRO">SAN ISIDRO</option>
                                <option value="SAN JUAN DE LURIGANCHO">
                                    SAN JUAN DE LURIGANCHO
                                </option>
                                <option value="SAN JUAN DE MIRAFLORES">
                                    SAN JUAN DE MIRAFLORES
                                </option>
                                <option value="SAN LUIS">SAN LUIS</option>
                                <option value="SAN MARTIN DE PORRES">SAN MARTIN DE PORRES</option>
                                <option value="SAN MIGUEL">SAN MIGUEL</option>
                                <option value="SANTA ANITA">SANTA ANITA</option>
                                <option value="SANTA MARIA DEL MAR">SANTA MARIA DEL MAR</option>
                                <option value="SANTA ROSA">SANTA ROSA</option>
                                <option value="SANTIAGO DE SURCO">SANTIAGO DE SURCO</option>
                                <option value="SURQUILLO">SURQUILLO</option>
                                <option value="VENTANILLA">VENTANILLA</option>
                                <option value="VILLA EL SALVADOR">VILLA EL SALVADOR</option>
                                <option value="VILLA MARIA DEL TRIUNFO">
                                    VILLA MARIA DEL TRIUNFO
                                </option>
                            </select>
                        </div>
                        <div class="entrada">
                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" name="direccion" autocomplete="off" required />
                        </div>
                        <div class="entrada">
                            <label for="dpto">Nro Departamento:</label>
                            <input type="number" id="dpto" name="dpto" autocomplete="off" />
                        </div>
                        <div class="entrada">
                            <label for="correo">Correo Electronico:</label>
                            <input type="email" id="correo" name="correo" autocomplete="off" required />
                        </div>
                        <div class="entrada">
                            <label for="celular">Celular:</label>
                            <input type="text" id="celular" name="celular" autocomplete="off" title="El celular contiene 9 dígitos" required />
                        </div>
                        <div class="entrada">
                            <label for="escuela">Escuela:</label>
                            <select id="escuela" name="escuela" required>
                                <option value="1">Informática</option>
                                <option value="3">Mecatrónica</option>
                                <option value="4">Electrónica</option>
                                <option value="2">Telecomunicaciones</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="entrada full-width">
                        <button type="submit" class="my-form__button">Registrar</button>
                    </div>
                </form>
            </div>

        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
    <script src="assets/js/registroPPP.js"></script>
</body>

</html>
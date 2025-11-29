<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
$nombre_completo = $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'] . ' ' . $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Docente</title>
    <link rel="stylesheet" href="assets/css/modern-theme.css" />
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .container {
            display: block;
            padding: 0;
        }

        .main-content {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-badge {
            background: linear-gradient(135deg, #2C3E50 0%, #34495E 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-badge h1 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .back-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .profile-container {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f5f5f5;
        }

        .avatar-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .avatar-wrapper img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #FFCC00;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .edit-avatar-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #FFCC00;
            color: #2C3E50;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .edit-avatar-btn:hover {
            transform: scale(1.1);
            background: #FFD700;
        }

        .profile-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            color: #7f8c8d;
            font-size: 1rem;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .profile-field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .profile-field label {
            font-weight: 600;
            color: #2C3E50;
            font-size: 0.9rem;
        }

        .profile-field input,
        .profile-field select {
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .profile-field input:focus,
        .profile-field select:focus {
            outline: none;
            border-color: #FFCC00;
            background: #FFFEF8;
        }

        .profile-field input[readonly] {
            background: #f8f9fa;
            cursor: not-allowed;
        }

        .form-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: #FFCC00;
            color: #2C3E50;
        }

        .btn-primary:hover {
            background: #FFD700;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 204, 0, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #2C3E50;
            border: 2px solid #e0e0e0;
        }

        .btn-secondary:hover {
            background: #f8f9fa;
            border-color: #FFCC00;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 2.5rem;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            color: #2C3E50;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        #imagePreview {
            display: block;
            max-width: 200px;
            max-height: 200px;
            margin: 1rem auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        #fileInput {
            margin: 1rem 0;
            padding: 0.75rem;
            border: 2px dashed #e0e0e0;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .form-buttons {
                flex-direction: column;
            }

            .btn {
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
        <main class="main-content">
            <div class="page-badge">
                <h1>👤 Mi Perfil</h1>
                <a href="menusecretaria.php" class="back-button">← Volver al inicio</a>
            </div>

            <div id="profileContainer">
                <div class="profile-container">
                    <div class="profile-header">
                        <div class="avatar-wrapper">
                            <img src="<?php echo $_SESSION['foto']; ?>" alt="Foto de perfil">
                            <button class="edit-avatar-btn" type="button" onclick="openModal()">✏️</button>
                        </div>
                        <div class="profile-name"><?php echo $nombre_completo; ?></div>
                        <div class="profile-role">Docente</div>
                    </div>

                    <div class="profile-grid">
                        <div class="profile-field">
                            <label for="codigo">Código institucional:</label>
                            <input type="text" id="codigo" value="<?php echo $_SESSION['codigo_institucional']; ?>" readonly />
                        </div>
                        <div class="profile-field">
                            <label for="documento">Documento de identidad:</label>
                            <input type="text" id="documento" value="<?php echo $_SESSION['documento']; ?>" readonly />
                        </div>
                        <div class="profile-field">
                            <label for="email">Correo institucional:</label>
                            <input type="email" id="email" value="<?php echo $_SESSION['Correo_Institucional']; ?>" readonly />
                        </div>
                        <div class="profile-field">
                            <label for="phone">Celular:</label>
                            <input type="tel" id="phone" value="<?php echo $_SESSION['celular']; ?>" readonly />
                        </div>
                        <div class="profile-field">
                            <label for="distrito">Distrito:</label>
                            <input type="text" id="distrito" value="<?php echo $_SESSION['distrito']; ?>" readonly />
                        </div>
                        <div class="profile-field">
                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" value="<?php echo $_SESSION['direccion']; ?>" readonly />
                        </div>
                    </div>

                    <div class="form-buttons">
                        <button type="button" class="btn btn-primary" onclick="loadUpdateProfile()">
                            Actualizar perfil
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="backtoMenuDocente()">
                            Cerrar
                        </button>
                    </div>
                </div>

                <!-- Modal para la imagen del perfil -->
                <div id="imageModal" class="modal">
                    <div class="modal-content">
                        <h2>Actualizar foto de perfil</h2>
                        <form action="assets/controladores/imagen_perfil.php" enctype="multipart/form-data" method="POST">
                            <input type="file" name="foto" id="fileInput" accept="image/*" onchange="previewImage(event)">
                            <div id="imagePreviewContainer">
                                <img id="imagePreview" src="" alt="Vista previa" style="display: none;" />
                            </div>
                            <div class="form-buttons">
                                <button type="button" class="btn btn-secondary" onclick="eliminarFoto()">Eliminar foto</button>
                                <button type="submit" class="btn btn-primary">Guardar imagen</button>
                                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Formulario para actualizar el perfil -->
            <div class="profile-container" id="update-fields-profile" style="display: none;">
                <form action="assets/controladores/actualizar_perfil.php" method="POST">
                    <h2 style="text-align: center; color: #2C3E50; margin-bottom: 2rem;">Actualizar datos del perfil</h2>
                    <div class="profile-grid">
                        <div class="profile-field">
                            <label for="email-edit">Correo institucional:</label>
                            <input type="email" id="email-edit" name="correo" value="<?php echo $_SESSION['Correo_Institucional']; ?>" />
                        </div>
                        <div class="profile-field">
                            <label for="phone-edit">Celular:</label>
                            <input type="tel" id="phone-edit" name="celular" value="<?php echo $_SESSION['celular']; ?>" maxlength="9" />
                        </div>
                        <div class="profile-field">
                            <label for="distritos">Distrito:</label>
                            <select name="distrito" id="distritos">
                                <option value="" selected disabled><?php echo $_SESSION['distrito']; ?></option>
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
                                <option value="SAN JUAN DE LURIGANCHO">SAN JUAN DE LURIGANCHO</option>
                                <option value="SAN JUAN DE MIRAFLORES">SAN JUAN DE MIRAFLORES</option>
                                <option value="SAN LUIS">SAN LUIS</option>
                                <option value="SAN MARTIN DE PORRES">SAN MARTIN DE PORRES</option>
                                <option value="SAN MIGUEL">SAN MIGUEL</option>
                                <option value="SANTA ANITA">SANTA ANITA</option>
                                <option value="SANTA MARIA DEL MAR">SANTA MARIA DEL MAR</option>
                                <option value="SANTA ROSA">SANTA ROSA</option>
                                <option value="SANTIAGO DE SURCO">SANTIAGO DE SURCO</option>
                                <option value="SURQUILLO">SURQUILLO</option>
                                <option value="VILLA EL SALVADOR">VILLA EL SALVADOR</option>
                                <option value="VILLA MARIA DEL TRIUNFO">VILLA MARIA DEL TRIUNFO</option>
                                <option value="CALLAO">CALLAO</option>
                                <option value="LA PERLA">LA PERLA</option>
                                <option value="VENTANILLA">VENTANILLA</option>
                            </select>
                        </div>
                        <div class="profile-field">
                            <label for="direccion-edit">Dirección:</label>
                            <input type="text" id="direccion-edit" name="direccion" value="<?php echo $_SESSION['direccion']; ?>" />
                        </div>
                    </div>
                    <div class="form-buttons">
                        <input type="submit" name="enviar" value="Guardar cambios" class="btn btn-primary">
                        <button type="button" class="btn btn-secondary close-btn">Cancelar</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
    <script>
        function backtoMenuDocente() {
            window.location.href = 'menusecretaria.php';
        }
    </script>
</body>

</html>
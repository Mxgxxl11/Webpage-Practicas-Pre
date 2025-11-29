<!-- Este archivo sirve para mostrar el perfil y modificarlo en el portal ADMINISTRADOR-->
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
    <title>Mi Perfil - Administradores</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/modern-theme.css">
    <link rel="stylesheet" href="assets/css/mesadepartes.css">
    <style>
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .profile-avatar-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
        }
        
        #image-button {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid #FFCC00;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            padding: 0;
            position: relative;
        }
        
        #image-button img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        
        #image-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            border-color: #E6B800;
        }
        
        #image-button::after {
            content: '📷';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 204, 0, 0.9);
            padding: 0.5rem;
            font-size: 1.2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        #image-button:hover::after {
            opacity: 1;
        }
        
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
            margin-top: 1.5rem;
        }
        
        .profile-grid > div {
            display: flex;
            flex-direction: column;
        }
        
        .profile-grid label {
            font-weight: 600;
            color: #2C3E50;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .profile-grid input,
        .profile-grid select {
            padding: 0.875rem 1rem;
            border: 2px solid #ECF0F1;
            border-radius: 12px;
            font-size: 0.95rem;
            background: #f8f9fa;
            color: #2C3E50;
        }
        
        .profile-grid input:focus,
        .profile-grid select:focus {
            outline: none;
            border-color: #FFCC00;
            box-shadow: 0 0 0 3px rgba(255, 204, 0, 0.1);
            background: #FFFFFF;
        }
        
        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Estilos para el modal de imagen */
        #imageModal .modal-content {
            max-height: 90vh;
            overflow-y: auto;
            padding: 2rem;
        }
        
        #imagePreviewContainer {
            max-height: 200px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        #imagePreview {
            max-height: 200px;
            max-width: 100%;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container" style="display: block;">
        <main class="main-content" style="max-width: 1200px; margin: 0 auto;">
            <div id="profileContainer">
                <div class="card">
                    <div class="profile-header">
                        <div class="profile-avatar-container">
                            <button id="image-button" type="button" onclick="openModal()">
                                <img src="<?php echo $_SESSION['foto']; ?>" alt="Foto de perfil">
                            </button>
                        </div>
                    </div>
                    
                    <div class="profile-grid">
                        <div>
                            <label for="nombre">Apellidos y Nombres</label>
                            <input type="text" id="nombre" value="<?php echo $nombre_completo; ?>" readonly />
                        </div>
                        <div>
                            <label for="codigo">Código Institucional</label>
                            <input type="text" id="codigo" value="<?php echo $_SESSION['codigo_institucional']; ?>" readonly />
                        </div>
                        <div>
                            <label for="documento">Documento de Identidad</label>
                            <input type="text" id="documento" value="<?php echo $_SESSION['documento']; ?>" readonly />
                        </div>
                        <div>
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" value="<?php echo $_SESSION['Correo_Institucional']; ?>" readonly />
                        </div>
                        <div>
                            <label for="distrito">Distrito</label>
                            <input type="text" id="distrito" value="<?php echo $_SESSION['distrito']; ?>" readonly />
                        </div>
                        <div>
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" value="<?php echo $_SESSION['direccion']; ?>" readonly />
                        </div>
                        <div>
                            <label for="phone">Celular</label>
                            <input type="tel" id="phone" value="<?php echo $_SESSION['celular']; ?>" readonly />
                        </div>
                    </div>
                    
                    <div class="form-buttons" style="margin-top: 2rem;">
                        <button type="button" class="btn btn-primary" onclick="loadUpdateProfile()">
                            ✏️ Actualizar Datos
                        </button>
                        <button type="button" class="btn btn-outline" onclick="backtoMenuAdmin()">
                            ✖️ Cerrar
                        </button>
                    </div>
                </div>
                
                <!-- Modal para cambiar foto de perfil -->
                <div id="imageModal" class="modal">
                    <div class="modal-content">
                        <h2 style="margin-bottom: 1.5rem; color: #2C3E50;">📸 Cambiar Foto de Perfil</h2>
                        <form action="../assets/controladores/imagen_perfil.php" enctype="multipart/form-data" method="POST">
                            <div style="margin-bottom: 1.5rem;">
                                <label for="fileInput" class="btn btn-outline" style="cursor: pointer; display: inline-block; margin: 0;">
                                    📁 Seleccionar Imagen
                                </label>
                                <input type="file" name="foto" id="fileInput" accept="image/*" onchange="previewImage(event)" style="display: none;">
                            </div>
                            
                            <div id="imagePreviewContainer" style="margin: 1.5rem 0; text-align: center;">  
                                <img id="imagePreview" src="" alt="Vista previa" style="display: none;"/>  
                            </div>
                            
                            <div class="form-buttons" style="margin-top: 1.5rem;">
                                <button type="submit" class="btn btn-primary">💾 Guardar Imagen</button>
                                <button type="button" onclick="eliminarFoto()" class="btn btn-secondary">🗑️ Eliminar Foto</button>
                                <button type="button" onclick="closeModal()" class="btn btn-outline">✖️ Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Formulario para actualizar perfil -->
            <div class="card" id="update-fields-profile" style="display: none;">
                <h2 class="card-title">✏️ Actualizar Datos del Perfil</h2>
                <form action="/assets/controladores/actualizar_perfil.php" method="POST">
                    <div class="profile-grid">
                        <div>
                            <label for="email">Correo Electrónico *</label>
                            <input type="email" id="email" name="correo" value="<?php echo $_SESSION['Correo_Institucional']; ?>" required />
                        </div>
                        <div>
                            <label for="distritos">Distrito *</label>
                            <select name="distrito" id="distritos" required>
                                <option value="" selected disabled>Seleccione un distrito</option>  
                                <option value="ANCON">ANCON</option>  
                                <option value="ATE">ATE</option>  
                                <option value="BARRANCO">BARRANCO</option>  
                                <option value="BREÑA">BREÑA</option>  
                                <option value="CALLAO">CALLAO</option>  
                                <option value="CARABAYLLO">CARABAYLLO</option>  
                                <option value="CHACLACAYO">CHACLACAYO</option>  
                                <option value="CHORRILLOS">CHORRILLOS</option>  
                                <option value="CIENEGUILLA">CIENEGUILLA</option>  
                                <option value="COMAS">COMAS</option>  
                                <option value="EL AGUSTINO">EL AGUSTINO</option>  
                                <option value="INDEPENDENCIA">INDEPENDENCIA</option>  
                                <option value="JESUS MARIA">JESUS MARIA</option>  
                                <option value="LA MOLINA">LA MOLINA</option>  
                                <option value="LA PERLA">LA PERLA</option>  
                                <option value="LA PUNTA">LA PUNTA</option>  
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
                                <option value="VENTANILLA">VENTANILLA</option>  
                                <option value="VILLA EL SALVADOR">VILLA EL SALVADOR</option>  
                                <option value="VILLA MARIA DEL TRIUNFO">VILLA MARIA DEL TRIUNFO</option>
                            </select>
                        </div>
                        <div>
                            <label for="direccion">Dirección *</label>
                            <input type="text" id="direccion" name="direccion" value="<?php echo $_SESSION['direccion']; ?>" required />
                        </div>
                        <div>
                            <label for="phone">Celular *</label>
                            <input type="tel" id="phone" name="celular" value="<?php echo $_SESSION['celular']; ?>" maxlength="9" required />
                        </div>
                    </div>
                    
                    <div class="form-buttons" style="margin-top: 2rem;">
                        <button type="submit" name="enviar" class="btn btn-primary">
                            💾 Guardar Cambios
                        </button>
                        <button type="button" class="btn btn-outline" onclick="document.getElementById('update-fields-profile').style.display='none'; document.getElementById('profileContainer').style.display='block';">
                            ✖️ Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
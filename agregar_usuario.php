<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
    //Este archivo te sirve para agregar más administradores o docentes
    //al sistema. Pertenece al portal ADMINISTRADOR
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario - Administración</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/modern-theme.css">
    <link rel="stylesheet" href="assets/css/mesadepartes.css">
    <style>
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
            margin-top: 1.5rem;
        }

        .form-grid .entrada {
            display: flex;
            flex-direction: column;
        }

        .form-grid label {
            font-weight: 600;
            color: #2C3E50;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-grid input,
        .form-grid select {
            padding: 0.875rem 1rem;
            border: 2px solid #ECF0F1;
            border-radius: 12px;
            font-size: 0.95rem;
            background: #f8f9fa;
            color: #2C3E50;
            transition: all 0.3s ease;
        }

        .form-grid input:focus,
        .form-grid select:focus {
            outline: none;
            border-color: #FFCC00;
            box-shadow: 0 0 0 3px rgba(255, 204, 0, 0.1);
            background: #FFFFFF;
        }

        .entrada.full-width {
            grid-column: span 2;
        }

        .hidden {
            display: none !important;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .entrada.full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container" style="display: block;">
        <main class="main-content" style="max-width: 1200px; margin: 0 auto;">
            <div class="card">
                <h2 class="card-title">➕ Registrar Nuevo Usuario</h2>
                <p style="color: #7F8C8D; margin-bottom: 1.5rem;">Complete el formulario para agregar un nuevo administrador o docente al sistema.</p>
                
                <form action="assets/controladores/registro_admin.php" method="post">
                    <div class="entrada full-width">
                        <label for="rol">Rol del Usuario *</label>
                        <select id="rol" name="rol" required>
                            <option value="" selected disabled>Seleccione un rol</option>
                            <option value="1">👨‍💼 Administrador</option>
                            <option value="2">👨‍🏫 Docente</option>
                        </select>
                    </div>
                    
                    <div class="form-grid">
                        <div class="entrada">
                            <label for="codigo">Código Usuario Villarreal *</label>
                            <input type="number" id="codigo" name="codigo" maxlength="10" autocomplete="off" 
                                   title="Recuerda tu código son 10 dígitos" placeholder="Ej: 2019123456" required />
                        </div>
                        <div class="entrada">
                            <label for="password">Contraseña *</label>
                            <input type="password" id="password" name="password" autocomplete="off" 
                                   placeholder="Ingrese una contraseña segura" required />
                        </div>
                        
                        <div class="entrada">
                            <label for="tipo_documento">Tipo de Documento *</label>
                            <select id="tipo_documento" name="tipo_documento" required onchange="mostrarNumeroDocumento()">
                                <option value="" selected disabled>Seleccione un tipo de documento</option>
                                <option value="1">DNI</option>
                                <option value="2">Pasaporte</option>
                                <option value="3">Otro</option>
                            </select>
                        </div>
                        <div class="hidden entrada" id="numero_documento_div">
                            <label for="numero_documento">Número de Documento *</label>
                            <input type="text" id="numero_documento" name="numero_documento" autocomplete="off" 
                                   placeholder="Ej: 12345678" />
                        </div>
                        
                        <div class="entrada">
                            <label for="primer_nombre">Primer Nombre *</label>
                            <input type="text" id="primer_nombre" name="nombre1" autocomplete="off" 
                                   pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+" title="Solo se permiten letras y espacios" 
                                   placeholder="Ej: Juan" required />
                        </div>
                        <div class="entrada">
                            <label for="segundo_nombre">Segundo Nombre</label>
                            <input type="text" id="segundo_nombre" name="nombre2" autocomplete="off" 
                                   pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+" title="Solo se permiten letras y espacios" 
                                   placeholder="Ej: Carlos" />
                        </div>
                        
                        <div class="entrada">
                            <label for="primer_apellido">Primer Apellido *</label>
                            <input type="text" id="primer_apellido" name="apellido1" autocomplete="off" 
                                   pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+" title="Solo se permiten letras y espacios" 
                                   placeholder="Ej: Pérez" required />
                        </div>
                        <div class="entrada">
                            <label for="segundo_apellido">Segundo Apellido</label>
                            <input type="text" id="segundo_apellido" name="apellido2" autocomplete="off" 
                                   pattern="[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+" title="Solo se permiten letras y espacios" 
                                   placeholder="Ej: García" />
                        </div>
                        
                        <div class="entrada">
                            <label for="distrito">Distrito *</label>
                            <select name="distrito" id="distrito" required>
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
                        <div class="entrada">
                            <label for="direccion">Dirección *</label>
                            <input type="text" id="direccion" name="direccion" autocomplete="off" 
                                   placeholder="Ej: Av. Colonial 123" required />
                        </div>
                        
                        <div class="entrada">
                            <label for="dpto">Nro Departamento</label>
                            <input type="number" id="dpto" name="dpto" autocomplete="off" 
                                   placeholder="Ej: 201" />
                        </div>
                        <div class="entrada">
                            <label for="correo">Correo Electrónico *</label>
                            <input type="email" id="correo" name="correo" autocomplete="off" 
                                   placeholder="Ej: usuario@unfv.edu.pe" required />
                        </div>
                        
                        <div class="entrada">
                            <label for="celular">Celular *</label>
                            <input type="tel" id="celular" name="celular" autocomplete="off" maxlength="9"
                                   title="El celular contiene 9 dígitos" placeholder="Ej: 987654321" required />
                        </div>
                        <div class="entrada">
                            <label for="escuela">Escuela *</label>
                            <select id="escuela" name="escuela" required>
                                <option value="" selected disabled>Seleccione una escuela</option>
                                <option value="1">Informática</option>
                                <option value="3">Mecatrónica</option>
                                <option value="4">Electrónica</option>
                                <option value="2">Telecomunicaciones</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-buttons" style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary">💾 Registrar Usuario</button>
                        <button type="button" class="btn btn-outline" onclick="window.location.href='menuadmin.php'">✖️ Cancelar</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
    <script src="assets/js/registroPPP.js"></script>
</body>

</html>

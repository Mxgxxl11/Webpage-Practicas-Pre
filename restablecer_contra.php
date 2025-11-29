<!--    -->
<?php 
  session_start();
  if(!isset($_SESSION['codigo'])){
    echo'
            <script>
            alert("No has ingresado ningun codigo!");
            window.location = "./olvide_contra.html";
            </script>
        ';
        session_destroy();
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - UNFV</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2C3E50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .user-code {
            background: linear-gradient(135deg, #FFCC00 0%, #FFB800 100%);
            color: #2C3E50;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(255, 204, 0, 0.2);
        }

        .user-code-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .user-code-value {
            font-size: 24px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #2C3E50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 14px 45px 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }

        .form-group input:focus {
            outline: none;
            border-color: #FFCC00;
            box-shadow: 0 0 0 4px rgba(255, 204, 0, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
            font-size: 18px;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: #2C3E50;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #FFCC00 0%, #FFB800 100%);
            color: #2C3E50;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(255, 204, 0, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 204, 0, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .password-requirements {
            background: #f8f9fa;
            border-left: 4px solid #FFCC00;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .password-requirements h3 {
            color: #2C3E50;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .password-requirements ul {
            list-style: none;
            padding-left: 0;
        }

        .password-requirements li {
            color: #7f8c8d;
            font-size: 13px;
            padding: 4px 0;
            padding-left: 20px;
            position: relative;
        }

        .password-requirements li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #FFCC00;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .user-code-value {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Restablecer Contraseña</h1>
            <p>Ingrese su nueva contraseña</p>
        </div>

        <div class="user-code">
            <div class="user-code-label">Código de Usuario</div>
            <div class="user-code-value"><?php echo $_SESSION['codigo']; ?></div>
        </div>

        <div class="password-requirements">
            <h3>📋 Requisitos de la contraseña:</h3>
            <ul>
                <li>Mínimo 8 caracteres</li>
                <li>Al menos una letra mayúscula</li>
                <li>Al menos un número</li>
            </ul>
        </div>

        <form action="assets/controladores/validar_password.php" method="post" id="resetForm">
            <div class="form-group">
                <label for="new-password">Nueva Contraseña</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="new-password"
                        name="nueva_contrasena"
                        placeholder="Ingrese su nueva contraseña"
                        required
                    >
                    <span class="toggle-password" onclick="togglePassword('new-password', this)">👁️</span>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirmar Contraseña</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="confirm-password"
                        name="confirmar_contrasena"
                        placeholder="Confirme su nueva contraseña"
                        required
                    >
                    <span class="toggle-password" onclick="togglePassword('confirm-password', this)">👁️</span>
                </div>
            </div>

            <button type="submit" class="submit-btn">Restablecer Contraseña</button>
        </form>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = '👁️‍🗨️';
            } else {
                input.type = 'password';
                icon.textContent = '👁️';
            }
        }

        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('⚠️ Las contraseñas no coinciden. Por favor, verifique.');
                return false;
            }

            if (newPassword.length < 8) {
                e.preventDefault();
                alert('⚠️ La contraseña debe tener al menos 8 caracteres.');
                return false;
            }
        });
    </script>
</body>
</html>

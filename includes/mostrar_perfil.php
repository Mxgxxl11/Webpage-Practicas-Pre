<!-- Para mostrar datos del usuario-->
<div class="profile-form">

    <button id="image-button" type="button" onclick="openModal()">
        <img width="80" src="<?php echo $_SESSION['foto']; ?>" alt="foto_perfil_usuario">
    </button>
    <div class="profile-fields">

        <div>
            <label for="nombre">Apellidos y nombres:</label>
            <input type="text" id="nombre" value="<?php echo $nombre_completo; ?>" readonly />
        </div>
        <div>
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" value="<?php echo $_SESSION['codigo_institucional']; ?>" readonly />
        </div>
        <div>
            <label for="documento">Documento:</label>
            <input type="text" id="documento" value="<?php echo $_SESSION['documento']; ?>" readonly />
        </div>
        <div>
            <label for="email">Correo:</label>
            <input type="email" id="email" value="<?php echo $_SESSION['Correo_Institucional']; ?>" readonly />
        </div>
        <div>
            <label for="distrito">Distrito:</label>
            <input type="text" id="distrito" value="<?php echo $_SESSION['distrito']; ?>" />
        </div>
        <div>
            <label for="direccion">Direccion:</label>
            <input type="text" id="direccion" value="<?php echo $_SESSION['direccion']; ?>" />
        </div>
        <div>
            <label for="phone">Celular:</label>
            <input type="number" id="phone" name="phone" value="<?php echo $_SESSION['celular']; ?>" />
        </div>
    </div>
    <div class="form-buttons">
        <button type="button" onclick="updateProfile()">
            Actualizar
        </button>
        <button type="button" onclick="closeProfileForm()">Cerrar</button>
    </div>
</div>
<!-- Para la imagen del perfil-->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <form action="../assets/controladores/imagen_perfil.php" enctype="multipart/form-data" method="POST">
            <input type="file" name="foto">
            <div class="form-buttons">
                <button type="submit">Editar imagen perfil</button>
            </div>
        </form>
        <div class="form-buttons">
            <button onclick="closeModal()" class="close-btn">Cerrar</button>
        </div>
    </div>
</div>
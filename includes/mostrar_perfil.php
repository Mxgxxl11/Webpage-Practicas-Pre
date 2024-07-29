<!-- Para mostrar datos del usuario-->
<div class="profile-form">
    <button id="image-button" type="button" onclick="openModal()">Seleccionar Imagen</button>
    <div class="profile-fields">
        <?php
        $foto_perfil = $_SESSION['foto'];
        ?>
        <div>
            <img width="80" src="<?php echo $foto_perfil; ?>" alt="foto_perfil_usuario">
            <label for="name">Apellidos y nombres:</label>
            <input type="text" id="name" name="name" value="<?php echo $nombre_completo; ?>" readonly />
        </div>
        <div>
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" value="<?php echo $_SESSION['codigo_institucional']; ?>" readonly />
        </div>
        <div>
            <label for="email">Correo:</label>
            <input type="email" id="email" name="email" value="<?php echo $_SESSION['Correo_Institucional']; ?>" readonly />
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

        <input type="file" id="fileInput" style="display: none" />

        <div class="form-buttons">
            <button onclick="closeModal()" class="close-btn">Cerrar</button>
        </div>
    </div>
</div>
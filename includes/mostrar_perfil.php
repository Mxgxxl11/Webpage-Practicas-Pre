<!-- Para mostrar datos del usuario-->
<div class="profile-form">
    <button id="image-button" type="button" onclick="openModal()">Seleccionar Imagen</button>
    <div class="profile-fields">
        <div>
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
        <input type="file" id="fileInput" style="display: none" />
        <button onclick="openFileInput()" class="form-buttons">Cargar imagen</button>
        <button onclick="removeImage()">Quitar imagen</button>
        <div id="imagePreview" style="display: none">
            <img id="previewImage" src="#" alt="Vista previa de la imagen" />
        </div>
        <div class="form-buttons">
            <button onclick="closeModal()" class="close-btn">Cerrar</button>
            <button onclick="saveImage()">Guardar</button>
        </div>
    </div>
</div>
<nav id="sidebar" class="sidebar">
    <a href="#" onclick="loadProfileForm()">MI PERFIL</a>
    <a href="#" onclick="loadSolicitudForm()">TRÁMITES</a>
    <a href="#">DETALLES</a>
    <div class="sidebar__profile">
        <div class="avatar__wrapper">
            <img class="avatar" src="<?php echo $_SESSION['foto']; ?>" alt="Foto_usuario">
        </div>
        <section class="avatar__name hide">
            <div class="user-name"><?php echo $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido']; ?></div>
            <div class="email"><?php echo $_SESSION['Correo_Institucional'] ?></div>
        </section>
        <br>
        <div>
            <a href="assets/controladores/cerrar_sesion.php" class="logout-btn">
                <span class="logout">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                        <path d="M9 12h12l-3 -3"></path>
                        <path d="M18 15l3 -3"></path>
                    </svg>
                </span>
            </a>
        </div>
    </div>

</nav>
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
    <title>Team Table</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" type='text/css'>
    <link rel="stylesheet" href="assets/css/mesadepartes.css">
    <link rel="stylesheet" href="assets/css/detalles.css">
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar.php'; ?>
        <main class="main-content">
            <article class="table-widget">
                <div class="caption">
                    <h2>
                        Team Members
                    </h2>
                    <button class="export-btn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-export" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M11.5 21h-4.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v5m-5 6h7m-3 -3l3 3l-3 3" />
                        </svg>
                        Export
                    </button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>
                               Descripcion
                            </th>
                            <th>
                                Estado
                            </th>
                            <th>
                                Fecha de subida
                            </th>
                            <th>Tags</th>
                        </tr>
                    </thead>
                    <tbody id="team-member-rows">
                        <tr>
                            <td class="team-member-profile">
                                <img src="assets/drew.jpg" alt="${teamMember.name}">
                                <div class="profile-info">
                                    <div class="profile-info__name">
                                        Drew Cano
                                    </div>
                                    <div class=profile-info__alias>
                                        @drew
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="status">
                                    <div class="status__circle status--active"></div>
                                    active
                                </div>
                            </td>
                            <td>drew.crano@example.com</td>
                            <td>
                                <div class="tags">
                                    <div class="tag tag--marketing">
                                        Marketing
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="team-member-profile">
                                <img src="assets/natalia.jpg" alt="Natalia Alexandra">
                                <div class="profile-info">
                                    <div class="profile-info__name">
                                        Natalia Alexandra
                                    </div>
                                    <div class=profile-info__alias>
                                        @natalia
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="status ">
                                    <div class="status__circle status--inactive"></div>
                                    inactive
                                </div>
                            </td>
                            <td>natalia@example.com</td>
                            <td>
                                <div class="tags">
                                    <div class="tag tag--dev">
                                        Dev
                                    </div>
                                    <div class="tag tag--marketing">
                                        Marketing
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="team-member-profile">
                                <img src="assets/liliya.jpg" alt="Lilia Taylor">
                                <div class="profile-info">
                                    <div class="profile-info__name">
                                        Lilia Taylor
                                    </div>
                                    <div class=profile-info__alias>
                                        @lilia
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="status">
                                    <div class="status__circle status--active"></div>
                                    active
                                </div>
                            </td>
                            <td>lilia.taylor@example.com</td>
                            <td>
                                <div class="tags">
                                    <div class="tag tag--design">
                                        Design
                                    </div>
                                    <div class="tag tag--marketing">
                                        Marketing
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="team-member-profile">
                                <img src="assets/james.jpg" alt="James Alexander">
                                <div class="profile-info">
                                    <div class="profile-info__name">
                                        James Alexander
                                    </div>
                                    <span class=profile-info__alias>
                                        @james
                                </div>
    </div>
    </td>
    <td>
        <div class="status">
            <div class="status__circle status--offline"></div>
            offline
        </div>
    </td>
    <td>james@example.com</td>
    <td>
        <div class="tags">
            <div class="tag tag--dev">
                Dev
            </div>
            <div class="tag tag--QA">
                QA
            </div>
        </div>
    </td>
    </tr>
    </tbody>
    </table>
    </article>
    </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
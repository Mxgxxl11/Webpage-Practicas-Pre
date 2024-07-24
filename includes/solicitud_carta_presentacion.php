<div id="solicitudContainer" style="display: none">
    <div class="profile-form">
        <div class="welcome-message">
            <p>Bienvenido al modulo de atención de trámites
                de Prácticas Pre Profesionales</p>
            <p>Debe saber que va a necesitar:</p>
            <ul>
                <li>Formulario FUT</li>
                <li>Record académico</li>
                <li>Ficha de matricula 9 ciclo</li>
                <li>Comprobante de pago</li>
            </ul>
            <p>Si tiene todo completo los requisitos antes mencionados, continue con el proceso</p>
        </div>
        <div class="form-buttons" id="continuar">
            <button type="button" onclick="loadRegistroSolicitud()">
                Continuar
            </button>
        </div>
    </div>
</div>

<!-- INICIA FORM DE REGISTRO-->
<div class="profile-form" id="Next-step" style="display: none">
    <div class="welcome-message">
        <form action="#" method="POST">
            <div class="profile-fields">
                <div>
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" value="" />
                    <div class="error-message" id="codigo-error"></div>

                </div>
                <div>
                    <label for="name">Apellidos y nombres:</label>
                    <input type="text" id="name" name="name" value="" />
                    <div class="error-message" id="name-error"></div>
                </div>
                <div>
                    <label for="distritos">Distrito:</label>
                    <select name="opciones" id="distritos">
                        <option value="ANCON" default>ANCON</option>
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
                    </select>
                </div>
                <div>
                    <label for="p-curricular">Plan curricular:</label>
                    <input type="text" id="p-curricular" name="pcurricular" />
                </div>
                <div>
                    <label for="base">Base:</label>
                    <input type="text" id="base" name="base" />

                </div>
                <div>
                    <label for="semestre">Semestre:</label>
                    <input type="text" id="semestre" name="semestre" />
                </div>
                <div>
                    <label for="seccion">Sección:</label>
                    <input type="text" id="seccion" name="seccion" />
                </div>
                <label for="condicion">Condición:</label>
                <select id="condicion" name="condicion" required>
                    <option value="1">Estudiante</option>
                    <option value="2">Egresado</option>
                </select>
                <div>
                    <label for="">Fecha de hoy:</label>
                    <input type="date">
                </div>
                <div>
                    <label for="firma">Subir firma:</label>
                    <input id="firma" type="file" value="enviar firma">
                </div>

                <button type="submit">
                    enviar
                </button>

        </form>

    </div>
</div>
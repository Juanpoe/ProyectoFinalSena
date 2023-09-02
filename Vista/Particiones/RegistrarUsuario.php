<?php
include("../Paginador.php");
?>
<div class="body">
    <main class="form">
        <section class="form__header">
            <!-- NOMBRE DEL FORMULARIO -->
            <h1>Registrar Empleado</h1>
            <!-- BOTON REGRESAR -->
            <a href="#" onclick='Metodo("Particiones/ListarUsuarios.php"); ListarUsuario(1);' class="btn-registrar">Regresar</a>
        </section>
        <!-- CONTENEDOR DEL FORMULARIO -->
        <section class="form__body">
            <form action="" method="post">
                <label for="IdRol">Rol</label>
                <div class="fila1">
                    <select name="IdRol" id="IdRol"></select>
                </div>
                <!-- DIV FILA, ESTE AGRUPA DE A 2 INPUTS Y LOS PONE DE FORMA HORIZONTAL ----- HACIENDO QUE SE OCUPE EL ESPACIO DE FORMA MAS BONITA -->
                <div class="fila">
                    <div class="item">
                        <p>Nombres</p>
                        <input type="text" name="Nombre" id="Nombre" placeholder="Nombres" onkeyup="ValidarNombreUsuario(this)" required />
                        <br>
                        <span id="NombreError"></span>
                    </div>
                    <div class="item">
                        <p>Apellidos</p>
                        <input type="text" name="Apellido" id="Apellido" placeholder="Apellido" onkeyup="ValidarApellidoUsuario(this)" required /><br>
                        <span id="ApellidoError"></span>
                    </div>
                </div>
                <!-- FIN DIV FILA -->
                <!-- DIV FILA -->
                <div class="fila">
                    <div class="item">
                        <p>Tipo de documento</p>
                        <select name="TipoDocumento" id="TipoDocumento" placeholder="Tipo de documento">
                            <option value="Cédula">Cédula de Ciudadanía</option>
                            <option value="Tarjeta de identidad">Tarjeta de Identidad</option>
                            <option value="Cedula de extrangeria">Cédula de Extrangería</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="item">
                        <p>Documento</p>
                        <input type="number" name="Documento" id="Documento" placeholder="Documento" onkeyup="ValidarDocumentoUsuario(this)" required /><br>
                        <span id="DocumentoError"></span>
                    </div>
                </div>
                <!-- FIN DIV FILA -->
                <!--  DIV FILA -->
                <div class="fila">
                    <div class="item">
                        <p>Correo</p>
                        <input type="email" name="Correo" id="Correo" placeholder="Correo" onkeyup="ValidarCorreoUsuario(this)" required /><br>
                        <span id="CorreoError"></span>
                    </div>
                    <div class="item">
                        <p>Contraseña</p>
                        <input id="Contrasena" name="Contrasena" type="password" placeholder="Ingrese la Contraseña" onkeyup="ValidarContrasenaUsuario(this)" required /><br>
                        <span id="ContrasenaError"></span>
                    </div>
                </div>
                <!-- FIN DIV FILA -->
                <!--  DIV FILA -->
                <div class="fila">
                    <div class="item">
                        <p>Telefono</p>
                        <input type="number" name="Telefono" id="Telefono" placeholder="Telefono" onkeyup="ValidarTelefonoUsuario(this)" required /><br>
                        <span id="TelefonoError"></span>
                    </div>
                    <div class="item">
                        <p>Dirección</p>
                        <input type="text" name="Direccion" id="Direccion" placeholder="Direccion" onkeyup="ValidarDireccionUsuario(this)" required /><br>
                        <span id="DireccionError"></span>
                    </div>
                </div>
                <!-- FIN DIV FILA -->
                <div class="Boton">
                    <button type="submit" value="Guardar" id="submitButton" class="btn-azul" onclick="RegistrarUsuario()">Registrar</button>
                </div>
            </form>
        </section>
        <!-- CONTENEDOR DEL FORMULARIO -->
    </main>
</div>

<script>
    $(document).ready(function() {
        MostrarRolesEmpleados();
    });
    ValidarCamposUsuario();
</script>
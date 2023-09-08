<?php
session_start();
include("../Paginador.php");
?>
<div class="body">
    <main class="form">
        <!-- NOMBRE DEL FORMULARIO -->
        <section class="form__header">
            <h1>Registrar Novedad</h1>
            <!-- BOTON REGRESAR -->
            <a href="#" onclick='Metodo("Particiones/ListarNovedades.php"); ListarNovedad(1);' class="btn-registrar">Regresar</a>
        </section>
        <!-- CONTENEDOR DEL FORMULARIO -->
        <section class="form__body">
            <form action="" method="post">
                <!-- DIV FILA, ESTE AGRUPA DE A 2 INPUTS Y LOS PONE DE FORMA HORIZONTAL ----- HACIENDO QUE SE OCUPE EL ESPACIO DE FORMA MAS BONITA -->
                <div class="fila">
                
                <?php
                if ($_SESSION["Rol"] == 1) {
                ?>
                    <div class="item">
                    <P>Para cual empleado</p>
                    <select name="IdNovedad" id="IdNovedad" onchange="ValidateFechaInicioPhp(); ValidateFechaFinPhp(); ValidateFechaInicioYFinVista()">
                    </select>
                    </div>
                <?php
                } else {
                ?>
                    <input type="hidden" name="IdNovedad" id="IdNovedad" value="<?php echo $_SESSION["IdUsuario"] ?>" />
                    <div class="item">
                        <p>Descripción</p>
                        <textarea type="text" name="Descripcion" id="Descripcion" onkeyup="ValidaDescripcionNovedad(this)"></textarea>
                        <br>
                        <span id="DescripcionError"></span>
                        </div>
                <?php
                }
                ?>
                 
                <div class="item">
                
                        <p>Petición</p>
                        <input type="text" name="Peticion" id="Peticion" onkeyup="ValidaPeticionNovedad(this)">
                        <br>
                        <span id="PeticionError"></span>
                        </div>
                </div>
                <!-- FIN DIV FILA -->
             

                <!-- HORA -->
                <div class="fila">
                    <div class="Hora">
                        <p>Desde la hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <input type="time" id="HoraInicio" name="HoraInicio" onchange="ValidateHoraInicio()">
                        <br>
                        <span id="HoraInicioError"></span>
                        <p>Desde el día &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <input type="date" id="FechaInicio" name="FechaInicio" onchange="ValidateFechaInicioPhp(); ValidateFechaInicio(); ValidateFechaInicioYFinVista()">
                        <br>
                        <span id="FechaInicioError"></span>
                       
                    </div>
                    <!-- FECHA -->
                    <div class="Dia">
                        <p>Hasta la hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <input type="time" id="HoraFin" name="HoraFin" onchange="ValidateHoraFin()">
                        <br>
                        <span id="HoraFinError"></span>
                        <p>Hasta el día &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <input type="date" id="FechaFin" name="FechaFin" onchange="ValidateFechaFinPhp(); ValidateFechaFin(); ValidateFechaInicioYFinVista()">
                        <br>
                        <span id="FechaFinError"></span>
                    </div>
                </div>
                <?php
                if ($_SESSION["Rol"] == 1) {
                ?>
        <div class="fila1">
                    <div class="item" style="width: 98%">
                        <p>Descripción</p>
                        <textarea type="text" name="Descripcion" id="Descripcion" onkeyup="ValidaDescripcionNovedad(this)"></textarea>
                        <br>
                        <span id="DescripcionError"></span>
                        </div>
                        
                </div>
                <?php
                }
                ?>
                <!-- FIN DIV FILA -->
                <div class="Boton">
                    <button class="btn-azul" id="submitButton" onclick="GuardarNovedad()">Registrar</button>
                </div>
            </form>
        </section>
        <!-- FIN CONTENEDOR DEL FORMULARIO -->
    </main>
</div>

<!-- SCRIPTS -->
<script>
    $(document).ready(function() {
        MostrarEmpleadosNovedad();
    });
    ValidarCamposNovedad();
</script>
<!-- SCRIPTS -->
<?php
include("../Paginador.php");
?>
<div class="body">
    <main class="form">
        <section class="form__header">
            <!-- NOMBRE DEL FORMULARIO -->
            <h1>Crear Servicio</h1>
            <!-- BOTON REGRESAR -->
            <a href="#" onclick='Metodo("Particiones/ListarServicios.php")' class="btn-registrar">Regresar</a>
        </section>

        <section class="form__body">
            <form id="CrearServicio" action="#" method="post">
                <p>Nombre del Servicio</p>
            <input type="text" id="NombredelServicio" onkeyup="ValidarNombredelServicio(this)" placeholder="Ingrese nombre del servicio">
           <br>
            <span id="NombredelServicioError"></span>

            <div class="Boton">
                <button disabled class="btn-azul" id="CrearServicio2" onclick="GuardarServicio()">Guardar</button>
            </div>
            </form>
        </section>
        <!-- FIN CONTENEDOR DEL FORMULARIO -->
    </main>
</div>

   
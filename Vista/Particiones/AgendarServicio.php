<?php
include("../Paginador.php");
?>
<div class="body">
    <main class="form">
        <!-- NOMBRE DEL FORMULARIO -->
        <section class="form__header">
            <h1>Registrar Novedad</h1>
            <!-- BOTON REGRESAR -->
            <a href="#" class="btn-registrar" onclick='Metodo("Particiones/ListarAgendamientoAdmin.php")'>Listado de Agendamientos</a>
        </section>

        <section class="form__body">
            <form id="Formulario" action="" method="post">
                <div class="fila">
                    <div class="item">
                        <p>Nombre Cliente</p>
                        <input type="text" id="NombreCliente" onkeyup="ValidarTamañoNombreCliente(this);" placeholder="Ingrese nombre del cliente">
                        <br>
                        <span id="ValidarCliente"></span>
                    </div>
                    <div class="item">
                        <p>Nombre del Empleado</p>
                        <select name="nombre" id="Empleado" onclick="ValidarEmpleado();"></select>
                        <br>
                        <span id="MensajeEmpleado"></span>
                    </div>
                </div>
                <div class="fila">
                    <div class="item">
                        <p>Telefono del Cliente</p>
                        <input type="number"  id="Telefono" onkeyup="ValidarTamañoNumero(this)" placeholder="Ingrese telefono">
                        <br>
                        <span id="MensajeNumero"></span>
                    </div>
                    <div class="item">
                        <p>Fecha</p>
                        <input type="date" id="Fecha" placeholder="Ingrese fecha" oninput="ValidarFechaDelAgendamiento();">
                        <br>
                        <span id="MensajeFecha"></span>
                    </div>
                </div>
                <div class="fila">
                    <div class="item">
                        <p>Direccion de la solicitud</p>
                        <input type="text" id="Direccion" placeholder="Ingrese direccion" onkeyup="ValidarTamañoDireccion(this)">
                        <br>
                        <span id="MensajeDireccion"></span>
                    </div>
                    <div class="item">
                        <p>Tipo de Servicio</p>
                        <select class="ContenedorAñadirselect" onclick="ValidarServicio()" name="inputselect" name="nombre" id="Servicio">
                        </select>
                        <br>
                        <span id="MensajeServicio"></span>
                    </div>
                </div>
                <style>

                </style>
                <div class="fila-tabla">
                    <div class="item-fila-tabla">
                        <p>Escoger insumos</p>
                        <table id="AgendarInsumos">
                            <thead class="tbInsumo">
                            <tr>
                                <th>Insumo</th>
                                <th>Cantidad</th>
                                <th>Accion</th>
                            </tr>
                            </thead>
                            <tbody class="tbInsumo">
                            <tr>
                                <td class="TablaInsumos">
                                    <select name="Insumos" id="Insumos" class="SelectInsumo">
                                    </select>
                                </td>
                                <td class="TablaInsumos"><Input type="number" class="InputInsumo" value="0" id="Cantidad" step="1.0" min="0"></Input></td>
                                <td class="TablaInsumos"><button type="button"  title="Guardar Insumo" class="BotonVerde" id="AgregarInsumo" onclick="GuardarInsumosAgendamiento()"></button>
                                </td>
                            </tr>
                            </tbody>
                           
                         
                        </table>
                    </div>
                    <span id ="MensajeInsumo"></span>
                </div>
                <p>Descripcion</p>
                <textarea type="text" id="Descripcion" placeholder="Ingrese una descripcion" oninput="ValidarDescripcionAgendamiento(this);"></textarea>
                <br>
                <span id="MensajeDescripcion"></span>
                <div class="Boton">
                    <button type="submit" id="Agendar" title="Guardar Agendamiento" onclick="GuardarAgendamiento();" class="btn-azul" disabled>Agendar</button>
                </div>
</div>
</form>
<main class="FormularioAñadir">
    <section class="FormularioBody"></section>
</main>
</body>
<script>
    $(document).ready(function() {
        SelectServicio();
        SelectUsuario();
        SelectInsumo();
        ListarNombresEmpleado();
    });
</script>
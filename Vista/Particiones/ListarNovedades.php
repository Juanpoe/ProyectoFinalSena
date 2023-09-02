<?php
session_start();
?>
<div class="body">
    <main class="table">
        <!-- NOMBRE DE LA TABLA -->
        <section class="table__header">
            <h1>Mis Novedades</h1>
            <!-- BOTON REGISTRAR -->
            <a href="#" onclick='Metodo("Particiones/RegistrarNovedad.php"); ListarNovedad(1);' class="btn-registrar">Registrar Novedad</a>
        </section>
        <div class="form-group">
            <!-- BUSCADOR -->
            <div class="buscador">
                <?php
                if ($_SESSION['Rol'] == 1) {
                ?>
                    Buscar:
                    <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarNovedad(1); ListarPaginacion(1);">

                <?php
                } else {
                ?>
                    <input type="hidden" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarNovedad(1); ListarPaginacion(1);">

                <?php
                }
                ?>
            </div>
            <input type="hidden" id="OrdenInput" value=" ">
            <input type="hidden" id="ColumnaInput" value=" ">
            <!-- FIN BUSCADOR -->

            <!-- ENTRADAS -->
            <div class="entradas">
                <p>Mostrando
                    <?php
                    if ($_SESSION['Rol'] == 1) {
                    ?>
                        <!-- del select de abajo cambiar la primer funcion por la funcion que lista los datos -->
                        <select class="selectpeque" id="CantidadDatos" onclick='ListarNovedad(1); ListarPaginacion(1);'>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    <?php
                    } else {
                    ?>
                        <select class="selectpeque" id="CantidadDatos" onclick='ListarNovedad(1); ListarPaginacion(1);'>
                            <option value="5">1</option>
                        </select>
                    <?php
                    }
                    ?>
                    entradas
                </p>
            </div>
            <!-- FIN ENTRADAS -->
        </div>
        <hr>
        <!-- PAGINACION -->
        <div class="ContenidoAbajoTabla">
            <ul class="CantidadDatos">
            </ul>
            <ul class="paginacion">
            </ul>
        </div>
        <!-- FIN PAGINACION -->

        <!-- CONTENEDOR DE LA TABLA -->
        <section class="table__body">
            <table>
                <?php
                if ($_SESSION['Rol'] == 1) {
                ?>
                    <thead>
                        <tr>
                            <td onclick="Resaltar(this, 'IdNovedad')">Id</td>
                            <td onclick="Resaltar(this, 'Nombre')">Nombre Empleado</td>
                            <td onclick="Resaltar(this, 'FechaRegistro')">Fecha</td>
                            <td onclick="Resaltar(this, 'Peticion')">Petición</td>
                            <td onclick="Resaltar(this, 'Descripcion')">Descripción</td>
                            <td onclick="Resaltar(this, 'FechaInicio')">Desde el dia</td>
                            <td onclick="Resaltar(this, 'FechaFinal')">Hasta el dia</td>
                            <td onclick="Resaltar(this, 'HoraInicio')">Desde la hora</td>
                            <td onclick="Resaltar(this, 'HoraFinal')">Hasta la hora</td>
                            <td onclick="Resaltar(this, 'EstadoNovedad')">Estado</td>
                            <td class="NoFiltro">Operaciones</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                <?php
                } else {
                ?><thead>
                        <tr>
                            <td onclick="Resaltar(this, 'Nombre')">Nombre Empleado</td>
                            <td onclick="Resaltar(this, 'FechaRegistro')">Fecha</td>
                            <td onclick="Resaltar(this, 'Peticion')">Petición</td>
                            <td onclick="Resaltar(this, 'Descripcion')">Descripción</td>
                            <td onclick="Resaltar(this, 'FechaInicio')">Desde el dia</td>
                            <td onclick="Resaltar(this, 'FechaFinal')">Hasta el dia</td>
                            <td onclick="Resaltar(this, 'HoraInicio')">Desde la hora</td>
                            <td onclick="Resaltar(this, 'HoraFinal')">Hasta la hora</td>
                            <td onclick="Resaltar(this, 'EstadoNovedad')">Estado</td>
                            <td class="NoFiltro">Operaciones</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                <?php
                }
                ?>
            </table>
        </section>
        <!-- FIN CONTENEDOR DE LA TABLA -->
    </main>
</div>

<!-- MODAL MODIFICAR -->
<dialog id="modal" class="form_registrar_novedad">
    <div class="modal-body">
        ...
    </div>
  
</dialog>
<!-- FIN MODAL MODIFICAR -->

<!-- SCRIPTS -->
<script>
    $(document).ready(function() {
        ListarNovedad(1);
        ListarPaginacion(1);
    });
</script>
<!-- SCRIPTS -->

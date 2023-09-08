<?php
session_start();
?>
<div class="body">
    <main class="table">
        <!-- NOMBRE DE LA TABLA -->
        <section class="table__header">
            <h1>Roles</h1>
            <!-- BOTON REGISTRAR -->
            <?php
            if ($_SESSION["Rol"] == 1) {
                   echo"
                   <a href='#' onclick='Metodo(\"Particiones/RegistrarRol.php\"); ListarRoles(1);' class='btn-registrar'>Registrar Rol</a>";     
                    }
                    ?>
      
        </section>
        <div class="form-group">
            <!-- BUSCADOR -->
            <div class="buscador">
                <?php
                if ($_SESSION['Rol'] == 1) {
                ?>
                    Buscar:
                    <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarRoles(1); ListarPaginacion(1);">

                <?php
                } else {
                ?>
                    <input type="hidden" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarRoles(1); ListarPaginacion(1);">

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
                        <select class="selectpeque" id="CantidadDatos" onclick='ListarRoles(1); ListarPaginacion(1);'>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    <?php
                    } else {
                    ?>
                        <select class="selectpeque" id="CantidadDatos" onclick='ListarRoles(1); ListarPaginacion(1);'>
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
            <table id="Tabla">
                <?php
                if ($_SESSION['Rol'] == 1) {
                ?>
                    <thead>
                        <tr>
                            <th onclick="Resaltar(this, 'IdRol')">ID</th>
                            <th onclick="Resaltar(this, 'NombreRol')">Nombre Rol</th>
                            <th onclick="Resaltar(this, 'Rol')">Tipo Rol</th>
                            <th onclick="Resaltar(this, 'Permisos')">Permisos</th>
                            <th onclick="Resaltar(this, 'FechaRol')">Fecha de creación</th>
                            <th onclick="Resaltar(this, 'EstadoRol')">Estado</th>
                            <th class="NoFiltro">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                <?php
                } else {
                ?>
                    <thead>
                        <tr>
                            <th class="NoFiltro">Nombre Rol</th>
                            <th class="NoFiltro">Tipo Rol</th>
                            <th class="NoFiltro">Permisos</th>
                            <th class="NoFiltro">Fecha de creación</th>
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
<dialog id="modal">
    <div class="modal-body">
        ....
    </div>
</dialog>
<!-- FIN MODAL MODIFICAR -->

<!-- SCRIPTS -->
<script>
    $(document).ready(function() {
        ListarRoles(1);
        ListarPaginacion(1);
    });
</script>
<!-- SCRIPTS -->

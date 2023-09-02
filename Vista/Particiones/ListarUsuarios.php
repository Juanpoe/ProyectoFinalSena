<?php
session_start();
?>
<div class="body">
    <main class="table">
        <section class="table__header">
            <h1>Empleados</h1>
            <?php
            if ($_SESSION["Rol"] == 1) {
                   echo"
                   <a href='#' onclick='Metodo(\"Particiones/RegistrarUsuario.php\"); ListarUsuario(1);' class='btn-registrar'>Registrar Empleado</a>";     
                    }
                    ?>
        </section>















        
        <div class="form-group">
            <div class="buscador">
                <?php
                if ($_SESSION['Rol'] == 1) {
                ?>
                    Buscar:
                    <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarUsuario(1); ListarPaginacion(1);">
                <?php
                } else {
                ?>
                    <input type="hidden" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarUsuario(1); ListarPaginacion(1);">
                <?php
                }
                ?>
            </div>
            <input type="hidden" id="OrdenInput" value=" ">
            <input type="hidden" id="ColumnaInput" value=" ">
            <div class="entradas">
                <p>Mostrando
                    <?php
                    if ($_SESSION['Rol'] == 1) {
                    ?>
                        <!-- del select de abajo cambiar la primer funcion por la funcion que lista los datos -->
                        <select id="CantidadDatos" onclick='ListarUsuario(1); ListarPaginacion(1);'>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    <?php
                    } else {
                    ?>
                        <select id="CantidadDatos" onclick='ListarUsuario(1); ListarPaginacion(1);'>
                            <option value="5">1</option>
                        </select>
                    <?php
                    }
                    ?>
                    entradas
                </p>
            </div>
        </div>
        <hr>
        <div class="ContenidoAbajoTabla">
            <ul class="CantidadDatos">
            </ul>
            <ul class="paginacion">
            </ul>
        </div>
        <section class="table__body">
            <table>
                <?php
                if ($_SESSION['Rol'] == 1) {
                ?>
                    <thead>
                        <tr>
                            <th onclick="Resaltar(this, 'IdUsuario')">ID</th>
                            <th onclick="Resaltar(this, 'NombreRol')">Rol</th>
                            <th onclick="Resaltar(this, 'Nombre')">Nombre</th>
                            <th onclick="Resaltar(this, 'Apellido')">Apellido</th>
                            <th onclick="Resaltar(this, 'TipoDocumento')">Tipo de Documento</th>
                            <th onclick="Resaltar(this, 'Documento')">Documento</th>
                            <th onclick="Resaltar(this, 'Correo')">Correo</th>
                            <th onclick="Resaltar(this, 'Telefono')">Telefono</th>
                            <th onclick="Resaltar(this, 'Direccion')">Direccion</th>
                            <th onclick="Resaltar(this, 'Estado')">Estado</th>
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
                            <th class="NoFiltro">Rol</th>
                            <th class="NoFiltro">Nombre</th>
                            <th class="NoFiltro">Apellido</th>
                            <th class="NoFiltro">Tipo de Documento</th>
                            <th class="NoFiltro">Documento</th>
                            <th class="NoFiltro">Correo</th>
                            <th class="NoFiltro">Telefono</th>
                            <th class="NoFiltro">Direccion</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                <?php
                }
                ?>
            </table>
        </section>
    </main>
</div>

<dialog id="modal">
    <div class="modal-body">
        ....
    </div>    
</dialog>

<script>
    $(document).ready(function() {
        ListarUsuario(1);
        ListarPaginacion(1);
    });
</script>
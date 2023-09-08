<div class="body">
    <main class="table">
        <section class="table__header">
            <h1>Trabajo Pendiente</h1>
            <?php
            session_start();
                if ($_SESSION["Rol"] == 1) {
                    ?>
                    <a href='#' class='btn-registrar' onclick='Metodo("Particiones/AgendarServicio.php")'>Añadir Agendamiento</a>
                    <?php
                }

?>
                   
            
    </section>


    
    <div class="form-group">
    <div class="buscador">
 
            Buscar:
            <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarAgendamientoAdministrador(1); ListarPaginacion(1);">
   
    </div>
    <input type="hidden" id="OrdenInput" value=" ">
    <input type="hidden" id="ColumnaInput" value=" ">
    <div class="entradas">
        <p>Mostrando
         
                <!-- del select de abajo cambiar la primer funcion por la funcion que lista los datos -->
                <select id="CantidadDatos" onclick='ListarAgendamientoAdministrador(1); ListarPaginacion(1);'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
      
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
            <thead>
                <?php
                if ($_SESSION["Rol"] == 1) {
                ?>
                    <tr>
                        <th onclick="Resaltar(this, 'agendamiento.IdAgendamiento')">Id</th>
                        <th onclick="Resaltar(this, 'usuario.Nombre')">Nombre del <br> Empleado</th>
                        <th onclick="Resaltar(this, 'agendamiento.NombreCliente')">Nombre del <br> Cliente</th>
                        <th onclick="Resaltar(this, 'servicio.NombreServicio')">Tipo de Servicio</th>
                        <th onclick="Resaltar(this, 'agendamiento.DireccionCliente')">Lugar del Servicio</th>
                        <th onclick="Resaltar(this, 'agendamiento.Descripcion')">Descripcion</th>
                        <th onclick="Resaltar(this, 'agendamiento.TelefonoCliente')">Telefono</th>
                        <th onclick="Resaltar(this, 'agendamiento.FechaServicio')">Fecha</th>
                        <th onclick="Resaltar(this, 'herramientainsumo.Nombre')">Insumos</th>
                        <th class="NoFiltro">Cantidad</th>
                        <th onclick="Resaltar(this, 'agendamiento.Estado')">Estado</th>
                        <th class="NoFiltro">Operaciones</th>
                    </tr>
                <?php
                } else {
                ?>
                    <tr>
                    <th onclick="Resaltar(this, 'agendamiento.IdAgendamiento')">Id</th>
                        <th onclick="Resaltar(this, 'usuario.Nombre')">Nombre del <br> Empleado</th>
                        <th onclick="Resaltar(this, 'agendamiento.NombreCliente')">Nombre del <br> Cliente</th>
                        <th onclick="Resaltar(this, 'servicio.Nombre')">Tipo de Servicio</th>
                        <th onclick="Resaltar(this, 'agendamiento.DireccionCliente')">Lugar del Servicio</th>
                        <th onclick="Resaltar(this, 'agendamiento.Descripcion')">Descripcion</th>
                        <th onclick="Resaltar(this, 'agendamiento.TelefonoCliente')">Telefono</th>
                        <th onclick="Resaltar(this, 'agendamiento.FechaServicio')">Fecha</th>
                        <th onclick="Resaltar(this, 'herramientainsumo.Nombre')">Insumos</th>
                        <th class="NoFiltro">Cantidad</th>
                        <th onclick="Resaltar(this, 'agendamiento.Estado')">Estado</th>
                    </tr>
                <?php
                }
                ?>
            </thead>
            <tbody>

            </tbody>
        </table>
  
        </section>
    </main>
</div>
<dialog id="modal">
    <div class="modal-body">

    </div>
</dialog>


<script>
    $(document).ready(function() {
        ListarAgendamientoAdministrador(1);
        ListarPaginacion(1);
    });
</script>
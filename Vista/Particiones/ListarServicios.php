<div class="body">
    <main class="table">
        <section class="table__header">
            <h1>Servicios</h1>
            <?php
                    session_start();
                    if ($_SESSION["Rol"] == 1) {
                        echo "
                        <a href='#' class='btn-registrar' onclick='Metodo(\"Particiones/CrearServicios.php\")'>Crear Servicio</a>";
                    }
                    ?>
                  </section>
     
    
        <div class="form-group">
            <div class="buscador">
         
                    Buscar:
                    <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarServicios(1); ListarPaginacion(1);">
           
            </div>
            <input type="hidden" id="OrdenInput" value=" ">
            <input type="hidden" id="ColumnaInput" value=" ">
            <div class="entradas">
                <p>Mostrando
                 
                        <!-- del select de abajo cambiar la primer funcion por la funcion que lista los datos -->
                        <select id="CantidadDatos" onclick='ListarServicios(1); ListarPaginacion(1);'>
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
                    <tr class="fila_servicios">
                    <th onclick="Resaltar(this, 'servicio.IdServicio')">Id</th>
                            <th onclick="Resaltar(this, 'servicio.NombreServicio')">Nombre</th>
                           <th onclick="Resaltar(this, 'servicio.EstadoServicio')"> Estado</th>
                           <?php
                    if ($_SESSION["Rol"] == 1) {
                        echo '
              
                        <th class="NoFiltro">Operaciones</th>';
                    }
                    ?>
                        </tr>
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
        <!-- <div class="Boton">
            <button class="BotonVerde" onclick="ModificarListar()">Aceptar</button>
            <button class="BotonRojo" onclick="CerrarModal()">Cancelar</button>
        </div> -->
    </dialog>
	
<script>
	$(document).ready(function() {
		ListarServicios(1);
        ListarPaginacion(1);
	});
</script>

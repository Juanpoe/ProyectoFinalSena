<div class="body">
    <main class="table">
        <section class="table__header">
            <h1>Herramientas Dañadas</h1>
            <a href="#" class="btn-registrar"onclick='Metodo("Particiones/ListarPrestamos.php")'>Regresar</a>

        </section>


    
        <div class="form-group">
            <div class="buscador">
         
                    Buscar:
                    <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarPrestamoDañado(1); ListarPaginacion(1);">
           
            </div>
            <input type="hidden" id="OrdenInput" value=" ">
            <input type="hidden" id="ColumnaInput" value=" ">
            <div class="entradas">
                <p>Mostrando
                 
                        <!-- del select de abajo cambiar la primer funcion por la funcion que lista los datos -->
                        <select id="CantidadDatos" onclick='ListarPrestamoDañado(1); ListarPaginacion(1);'>
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
                    <tr>       
                        <th onclick="Resaltar(this, 'herramientadanada.IdHerramientaDanada')">Id</th>
                        <th onclick="Resaltar(this, 'usuario.Nombre')">Empleado <br> Responsable</th>
                        <th onclick="Resaltar(this, 'herramientainsumo.Nombre')">Herramienta</th>
                        <th onclick="Resaltar(this, 'herramientadanada.CantidadElemento')">Cantidad</th>
                        <th onclick="Resaltar(this, 'herramientadanada.Observacion')">Observacion</th>
                        <th onclick="Resaltar(this, 'herramientadanada.Estado')">Estado</th>
<?php
                        session_start();
                        if ($_SESSION["Rol"] == 1){
                        echo"
                        <th class='NoFiltro'>Operaciones</th>";}
                        ?>
                        </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
                </section>
    </main>
</div>

<dialog id="modal" class="">
    <form action="">
    <center>
        <br>
        <div class="modal-body">
            ...
        </div>
  </center>
</form>
</dialog>

<!-- SCRIPTS -->
<script>
    $(document).ready(function() {
        ListarPrestamoDañado(1);
        ListarPaginacion(1);
    });
</script>
<div class="body">
    <main class="table">
        <section class="table__header">
            <h1>Prestamos</h1>
  

            <div class="ListaPPrestamo">
  <img src="Assets/Img/Iconos/abajo.svg" alt="">
  <div class="ListaPPrestamo-content">
  <?php
                    session_start();
                    if ($_SESSION["Rol"] == 1) {
                        echo "
    <a onclick='Metodo(\"Particiones/RealizarPrestamo.php\"); Borrado(); ListarRealizarP(1);' href='#'>Realizar Prestamo</a>
    <a onclick='Metodo(\"Particiones/ListarDañadas.php\");' href='#'>Herramientas Dañadas</a>
    <a onclick='Metodo(\"Particiones/ListarSolicitudPrestamo.php\");' href='#'>Prestamos Solicitados</a>
    ";
                    }
                    else{   echo" 
                        <a onclick='Metodo(\"Particiones/ListarDañadas.php\");' href='#'>Herramientas Dañadas</a>
                        <a onclick='Metodo(\"Particiones/ListarSolicitudPrestamo.php\");' href='#'>Prestamos Solicitados</a>
                        <a onclick='Metodo(\"Particiones/SolicitarPrestamo.php\");' href='#'>Solicitar Prestamo</a>
                        ";     
                    }
                    ?> 
  </div>
</div>


        </section>



    
        <div class="form-group">
            <div class="buscador">
         
                    Buscar:
                    <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarPrestamos(1); ListarPaginacion(1);">
           
            </div>
            <input type="hidden" id="OrdenInput" value=" ">
            <input type="hidden" id="ColumnaInput" value=" ">
            <div class="entradas">
                <p>Mostrando
                 
                        <!-- del select de abajo cambiar la primer funcion por la funcion que lista los datos -->
                        <select id="CantidadDatos" onclick='ListarPrestamos(1); ListarPaginacion(1);'>
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
                <th onclick="Resaltar(this, 'prestamo.IdPrestamo')">Id</th>
                    <th onclick="Resaltar(this, 'usuario.Nombre')">Empleado</th>
                    <th onclick="Resaltar(this, 'herramientainsumo.Nombre')">Herramienta</th>
                    <th onclick="Resaltar(this, 'prestamo.FechaPrestamo')">Fecha Registro</th>
                    <th onclick="Resaltar(this, 'prestamo.CantidadElemento')">Cantidad</th>
                    <th onclick="Resaltar(this, 'prestamo.Estado')">Estado</th>
                    <?php
                    if ($_SESSION["Rol"] == 1) {
                        echo "
                        <th class='NoFiltro'>Operaciones</th>";
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
    <form action="" method="get">
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
        ListarPrestamos(1);
        ListarPaginacion(1);
    });
</script>
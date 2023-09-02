<div class="body">
    <main class="table">
        <section class="table__header">
            <h1>Solicitar Prestamo</h1>
            <a href="#" class="btn-registrar"onclick='Metodo("Particiones/ListarPrestamos.php")'>Volver</a>
        </section>

        <div class="form-group">
            <div class="buscador">
         
                    Buscar:
                    <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarHerramientasSP(1); ListarPaginacion(1);">
           
            </div>
            <input type="hidden" id="OrdenInput" value=" ">
            <input type="hidden" id="ColumnaInput" value=" ">
            <div class="entradas">
                <p>Mostrando
                 
                        <!-- del select de abajo cambiar la primer funcion por la funcion que lista los datos -->
                        <select id="CantidadDatos" onclick='ListarHerramientasSP(1); ListarPaginacion(1);'>
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
                    <!-- En cada columna poner la funcion, dejar el this y cambiar el segundo por el nombre de la columna en la base de datos-->
                    <th onclick="Resaltar(this, 'IdHerramientaInsumo')">ID</th>
                    <th onclick="Resaltar(this, 'Nombre')">Nombre herramienta</th>
                    <th onclick="Resaltar(this, 'Categoria')">Categoria</th>
                    <th onclick="Resaltar(this, 'Descripcion')">Descripcion</th>
                    <th onclick="Resaltar(this, 'Medida')">Medida</th>
                    <th onclick="Resaltar(this, 'Cantidad')">Cantidad</th>
                    <th class="NoFiltro">Solicitar</th>
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
<script>
    //EU
    $(document).ready(function() {
        ListarHerramientasSP(1);
        ListarPaginacion(1);
    });
</script>
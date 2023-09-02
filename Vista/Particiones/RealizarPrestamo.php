<div class="body">
    <main class="table">
        <section class="table__header">
            <h1>Realizar Prestamo A Empleado</h1>
            <a href="#" class="btn-registrar"onclick='Metodo("Particiones/ListarPrestamos.php")'>Volver</a>
        </section>
        <center>
        <h4 style="color: var(--dark);">Seleccione un empleado</h4>
        <br>
        <select style="width:30%; background: var(--grey);
    color: var(--dark);
    border-radius: 5px;
    border: none;
    outline: none;
    padding: 10px 36px 10px 16px;
    transition: all .3s ease;
    cursor: pointer;
    margin-bottom: 5px;" name="id_empleado" id="id_empleado" placeholder="Empleado">
        </select>
        <br><br>
        <h4 style="color: var(--dark);">Seleccione las herramientas que va a prestar</h4>
</center>
        <div class="form-group">
            <div class="buscador">
         
                    Buscar:
                    <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarRealizarP(1); ListarPaginacion(1);">
           
            </div>
            <input type="hidden" id="OrdenInput" value=" ">
            <input type="hidden" id="ColumnaInput" value=" ">
            <div class="entradas">
                <p>Mostrando
                 
                        <!-- del select de abajo cambiar la primer funcion por la funcion que lista los datos -->
                        <select id="CantidadDatos" onclick='ListarRealizarP(1); ListarPaginacion(1);'>
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
                    <th class="NoFiltro">Prestar</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
   
        </section>
    </main>
</div>






<section class="table__body">
<form action="">
<div class="herramientasAsignadas" style="display: none;">
<center>
    <br>
    <h3 style="color: var(--dark);">Asignadas</h3></center>
    <div id="todo">
        <table id="herramienta"></table>
    </div>
    <center>
    <button id="BotonRealizarPrestar" class="btn-azul" disabled onclick="Prestar()">Prestar</button></center>
    <br>
</div>
</form>
</section>
<script>
    //EU
    $(document).ready(function() {
        ListarRealizarP(1);
        ListarNombresEmpleado();
        ListarPaginacion(1);
    });
</script>
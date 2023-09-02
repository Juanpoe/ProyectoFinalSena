<div class="body">
    <main class="table">
        <section class="table__header">
            <h1>Herramientas e Insumos</h1>

            <?php
                    session_start();
                    if ($_SESSION["Rol"] == 1) {
                        echo "
                        <a href='#' class='btn-registrar' onclick='Metodo(\"Particiones/RegistrarHerramientas.php\")'>Registrar</a>";
                    }
                    ?>


    </section>


    
<div class="form-group">
    <div class="buscador">
 
            Buscar:
            <input type="text" id="Busqueda" class="form-control" placeholder="Filtrar" onkeyup="ListarHerramienta(1); ListarPaginacion(1);">
   
    </div>
    <input type="hidden" id="OrdenInput" value=" ">
    <input type="hidden" id="ColumnaInput" value=" ">
    <div class="entradas">
        <p>Mostrando
         
                <!-- del select de abajo cambiar la primer funcion por la funcion que lista los datos -->
                <select id="CantidadDatos" onclick='ListarHerramienta(1); ListarPaginacion(1);'>
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
                    <th onclick="Resaltar(this, 'IdHerramientaInsumo')">Id</th>
                    <th onclick="Resaltar(this, 'Nombre')">Nombre</th>
                    <th onclick="Resaltar(this, 'Tipo')">Tipo</th>
                    <th onclick="Resaltar(this, 'Categoria')">categoría</th>
                    <th onclick="Resaltar(this, 'Descripcion')">Descripción</th>
                    <th onclick="Resaltar(this, 'Medida')">Medida</th>
                    <th onclick="Resaltar(this, 'Cantidad')">Cantidad</th>
                    <?php
                    if ($_SESSION["Rol"] == 1) {
                        echo '
                    <th onclick="Resaltar(this, \'Estado\')">Estado</th>
              
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
   <form action="">
    <macaco class="modal-body">
        ...
    </macaco>
    </form> 
</dialog>

<script>
    $(document).ready(function() {
        ListarHerramienta(1);
        ListarPaginacion(1);
        MensajeStock();
    });
</script>
<?php
include("../Paginador.php");
?>
<div class="body">
    <main class="form">
        <section class="form__header">
        
            <h1>Registrar Herramienta e Insumo</h1>

			<a class="btn-registrar" onclick='Metodo("Particiones/MasterHerramientas.php")'>Regresar</a>
        </section>



  
        <section class="form__body">
            <form action="" method="post">

			<div class="fila">
                    <div class="item">
					<p class="letra">Nombre</p>
					<input name="Nombre" id="Nombre" type="text" onkeyup="ValidarNombre(this)" placeholder="Ingrese el nombre">
                        <br>
						<span id="NombreError"></span>
                    </div>
                    <div class="item">
					<p>Tipo</p>

<select onclick="Cambio()" name="Tipo" id="Tipo">
	<option value="Herramienta">Herramienta</option>
	<option value="Insumo">Insumo</option>
</select>
                    </div>
                </div>

	

	
				<div class="fila">
                    <div class="item">
             
		<p>Categoría</p>
		<select name="Categoria" id="Categoria">
			<option id="Manual" value="Manual">Manual</option>
			<option id="Electrica" value="Electrica">Electrica</option>
			<option id="Mecanica" value="Mecanica">Mecánica</option>
			
			<option id="Cable" style="display: none;" value="Cable">Cable</option>
			<option id="Router" style="display: none;" value="Router">Router</option>
			<option id="Switch" style="display: none;" value="Switch">Switch</option>
			<option id="Otros" style="display: none;" value="Otros">Otros</option>
			<option id="Otros1" value="Otros">Otros</option>
		</select>
                    </div>
                    <div class="item">
                        <p>Descripción</p>
						<textarea name="Descripcion" id="Descripcion" type="text" onkeyup="ValidarDescripcion(this)" class="input" placeholder="Ingrese la descripción"></textarea>
		<br><span id="DescripcionError"></span>
                    </div>
                </div>

				<div class="fila">
                    <div class="item">
                        <p>Tipo de Medida</p>
						<select disabled name="Medida" id="Medida">			
			<option value="U">Unidad</option>
			<option value="M">Metros</option>
			<option value="Cm">Centímetros</option>
			<option value="Km">Kilometros</option>
		</select>
                    </div>
                    <div class="item">
                        <p>Cantidad</p>
						<input onkeyup="ValidarCantidad(this)" name="Cantidad" id="Cantidad" type="number" placeholder="Ingrese la cantidad">
				<br>		<span id="CantidadError"></span>
                    </div>
                </div>

	


					
			<button id="registrar" disabled class="btn-azul" onclick="guardarHerramienta()">Registrar</button>
	
                </div>
            </form>
        </section>
        <!-- CONTENEDOR DEL FORMULARIO -->
    </main>
</div>


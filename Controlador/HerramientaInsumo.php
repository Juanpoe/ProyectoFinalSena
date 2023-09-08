<?php
require_once '../Modelo/Conexion.php';

switch ($_POST['Metodo']) {
    case 'GuardarHerramienta':
        GuardarHerramienta();
        break;
    case 'ListarHerramientas':
        ListarHerramientas();
        break;
        case 'ModalDesactivarHerramientaInsumo':
            ModalDesactivarHerramientaInsumo();
            break;
    case 'ModificarHerramientas':
        ModificarHerramientas();
        break;
        case 'DesactivarHerramientaInsumo':
          DesactivarHerramientaInsumo();
          break;
          case 'EliminarHerramienta':
            EliminarHerramienta();
            break;
              case 'ModalModificarHerramienta':
                ModalModificarHerramienta();
                break;
                case 'ModalEliminarHerramienta':
                    ModalEliminarHerramienta();
                    break;
                    case 'MensajeStock':
                        ModalMensajeStock();
                        break;

}


function ListarHerramientas()
{
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $Busca = $_POST['Busca'];

    $Columnas = ["IdHerramientaInsumo", "Nombre", "Tipo", "Categoria", "Descripcion", "Cantidad", "Medida", "Estado"];


    $Conexion = new PDODB();

    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM herramientainsumo WHERE IdHerramientaInsumo > 0";
 

    session_start();

    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    $_SESSION["Funcion"] = "ListarHerramienta";
    $NombreRol = $_SESSION["Rol"];
    if ($NombreRol == 0) {
        $InstruccionSql .= " AND Estado = 1 ";
    }
    $ConCol = count($Columnas);
    $InstruccionSql .= " AND (";
    for ($i = 0; $i < $ConCol; $i++) {
        $InstruccionSql .= $Columnas[$i] . " LIKE '%" . $Busca . "%' OR ";
    }
    $InstruccionSql = substr_replace($InstruccionSql, "", -3);
    $InstruccionSql .= ")";
    if ($Orden[0] != " ") {
        $InstruccionSql .= "ORDER BY $Orden[1] $Orden[0] ";
    }
    $InstruccionSql .= "LIMIT $Inicio,$Registros";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    $ResultadoContar = count($Resultado);
    if ($ResultadoContar > 0) {
    foreach ($Resultado as $key => $Value) {
        if ($Value['Estado'] == 1){
            $Estado = "<buttom class='Estado Activo'>Activo</buttom>";
          }
          else{
              $Estado = "<buttom class='Estado Inactivo'>Desactivado</buttom>";
          }
        echo '<tr>  
            <td class="space_master_herramienta" data-th="Id" contenteditable="false">' . $Value['IdHerramientaInsumo'] . ' </td>
                <td class="space_master_herramienta" data-th="Nombre" contenteditable="false">' . $Value['Nombre'] . ' </td>
                <td class="space_master_herramienta" data-th="Tipo" contenteditable="false">' . $Value['Tipo'] . ' </td>
                <td class="space_master_herramienta" data-th="Categoria" contenteditable="false">' . $Value['Categoria'] . ' </td>
                <td class="space_master_herramienta" data-th="Descripcion" contenteditable="false">' . $Value['Descripcion'] . ' </td>
                <td class="space_master_herramienta" data-th="Medida" contenteditable="false">' . $Value['Medida'] . ' </td>
                <td class="space_master_herramienta" data-th="Cantidad" contenteditable="false">' . $Value['Cantidad'] . ' </td>';
                if ($NombreRol == 1) {
                    echo '
                <td class="space_master_herramienta" data-th="Estado" contenteditable="false">' . $Estado . ' </td>
                <td class="space_master_herramienta" data-th="Operacion" contenteditable="false">';
                if ($Value['Estado'] == 1){
                    echo'<Img title="Editar" class="icon" onclick="window.modal.showModal(); ModalModificarHerramienta(' . $Value['IdHerramientaInsumo'] . ')" src="Assets/Img\Iconos\editar.svg" alt="">  
                ';}
                else{
             echo'<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';       
                }
                echo'
                <Img ';
                if ($Value['Estado'] == 1){
                    echo'
                title = "Desactivar"';}
                else{
                    echo'
                title = "Activar"';}
                echo'
                class="icon" onclick="ModalDesactivarHerramientaInsumo(' . $Value['IdHerramientaInsumo'] . ', ' . $Value['Estado'] . ')" src="Assets/Img\Iconos\desactivar.svg" alt="">';
                if ($Value['Estado'] == 1){
                    echo'<Img title="Eliminar"  class="icon" onclick="window.modal.showModal(); ModalEliminarHerramienta(' . $Value['IdHerramientaInsumo'] . ')" src="Assets/Img\Iconos\basura.svg" alt=""></td>
                    </tr>';} else{
                        echo'<Img src="Assets/Img/Iconos/InEditable.svg" alt="" title="Deshabilitado" class="icon"></td>                
                        </tr>';       
                           }}
            
    }
} else {
    echo '<td colspan="9">Sin resultados</td>';
}
}

function GuardarHerramienta()
{

      $Nombre = $_POST['Nombre'];
      $Tipo = $_POST["Tipo"];
      $Categoria = $_POST["Categoria"];
      $Descripcion = $_POST['Descripcion'];
      $Medida = $_POST['Medida'];
      if ($Tipo == "Herramienta"){
        $Medida = "U";
      }  
  
      $Cantidad = $_POST['Cantidad'];
  
      $Conexion = new PDODB();
  
      $Conexion->Conectar();

      $InstruccionSQL = "SELECT * FROM herramientainsumo;";
  
      $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);

      foreach ($Resultado as $key => $Value) {
        if (strtolower($Value['Nombre']) == strtolower($Nombre)){
            echo "Ya existe una herramienta con el mismo nombre";
            return;
        } 
      }
  
      $InstruccionSQL = "INSERT INTO herramientainsumo  
          VALUES
          (null,'" . $Nombre . "', '" . $Tipo . "','" . $Categoria . "','" . $Descripcion . "', '" . $Cantidad . "', '" . $Medida . "', 1)";
  
      $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);
  
      if ($Resultado == true) {
          echo "Registrado Correctamente";
      } else {
          echo "No fue posible guardar";
      }
  }

function ModalDesactivarHerramientaInsumo(){
    $Id = $_POST["Id"];
    $Estado = $_POST["Estado"];
    echo'<center><h3>¿Está seguro de cambiar el estado?</h3></center>
    <input id="Id" value="'.$Id.'" type="hidden">
    <input id="Estado" value="'.$Estado.'" type="hidden">
    <div class="Boton">
    <button class="btn-azul" id="registrar" onclick="DesactivarHerramientaInsumo()">Aceptar</button>
    <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
    ';
}
  function ModalEliminarHerramienta(){
    $Id = $_POST["Id"];
    echo'<center><h3>¿Está seguro de eliminarlo?</h3></center>
    <input id="Id" value="'.$Id.'" type="hidden">
    <div class="Boton">
    <button class="btn-azul" id="registrar" onclick="EliminarHerramienta()">Aceptar</button>
    <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
    ';
}function ModalMensajeStock() {
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSQL = "SELECT * FROM herramientainsumo ORDER BY Cantidad ASC";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);

    $minStock = null;
    $maxStock = null;

    foreach ($Resultado as $key => $Value) {
        if ($minStock === null || $Value['Cantidad'] < $minStock['Cantidad']) {
            $minStock = $Value;
        }

        if ($maxStock === null || $Value['Cantidad'] > $maxStock['Cantidad']) {
            $maxStock = $Value;
        }
    }

    $mensaje = '';

    foreach ($Resultado as $Value) {
        if ($Value['Cantidad'] == $minStock['Cantidad']) {
            $mensaje .= 'La Herramienta o Insumo: ' . $Value['Nombre'] . ' presenta la más baja cantidad con un stock de:  ' . $Value['Cantidad'] . "\n";
        }

        if ($Value['Cantidad'] == $maxStock['Cantidad']) {
            $mensaje .= 'La Herramienta o Insumo: ' . $Value['Nombre'] . '  presenta la más alta cantidad con un stock de:  ' . $Value['Cantidad'] . "\n";
        }
    }

    echo $mensaje;
}

// Llamada a la función
if (isset($_POST['Metodo']) && $_POST['Metodo'] === 'ModalMensajeStock') {
    ModalMensajeStock();
}


function ModalModificarHerramienta()
{
    $Id = $_POST["Id"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSQL = "SELECT * FROM herramientainsumo WHERE IdHerramientaInsumo = ".$Id;

    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);

    foreach ($Resultado as $key => $Value) {
        
        echo ' 	
        <!-- DIV FILA -->
        <input id="Id" value="'.$Value['IdHerramientaInsumo'].'" type="hidden">
        <input id="Caso" type="hidden" value="Modificar">

        <input value="'.$Value['Tipo'].'" type="hidden" name="Tipo" id="Tipo">


    <div class="fila">
    <div class="item">
				<p class="letra">Nombre</p>
                
				<input name="Nombre" id="Nombre" onkeyup="ValidarNombre(this)" type="text" value="'.$Value['Nombre'].'">
                <br>
                <span id="NombreError"></span> 
            </div>
            
				
      
            <div class="item">
				<p class="letra" for="">Categoria</p>
				<select value="'.$Value['Categoria'].'" name="Categoria" id="Categoria">
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
    </div>
    <!-- FIN DIV FILA -->

            <!-- DIV FILA -->
            <div class="fila">
                <div class="item">

				<p class="letra" for="">Tipo de Medida</p>
				
				<select 
                name="Medida" id="Medida" value="'.$Value['Medida'].'"
                ' . ($Value['Tipo'] == 'Herramienta' ? 'disabled' : '') . '>
                <option value="U" ' . ($Value['Medida'] == 'U' ? 'selected' : '') . '>Unidad</option>
                <option value="M" ' . ($Value['Medida'] == 'M' ? 'selected' : '') . '>Metros</option>
                <option value="Cm" ' . ($Value['Medida'] == 'Cm' ? 'selected' : '') . '>Centímetros</option>
                <option value="Km" ' . ($Value['Medida'] == 'Km' ? 'selected' : '') . '>Kilometros</option>
				</select>
                </div>
                <div class="item">
				<p class="label_registrar_herramienta" for="">Cantidad</p>
				<input onkeyup="ValidarCantidad(this)" name="Cantidad" id="Cantidad" type="number" value="'.$Value['Cantidad'].'">
				<br><span id="CantidadError"></span>
                </div>
            </div>
                <!-- FIN DIV FILA -->
                <!-- DIV FILA -->
                <div class="fila1">
                <div class="item2">
                        <p class="letra" for="">Descripcion</p>
                        
                        <textarea name="Descripcion" id="Descripcion" type="text" onkeyup="ValidarDescripcion(this)" class="input">'.$Value['Descripcion'].'</textarea>
                        <br><span id="DescripcionError"></span>
                        </div>
                    </div>
                    <!-- FIN DIV FILA -->

				</div>
			</div>
            <div class="Boton">
            <button class="btn-azul" id="registrar" onclick="ModificarHerramientas()">Aceptar</button>
            <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
        </div>
          ';
    }
}

function ModificarHerramientas()
{
    $Nombre = $_POST['Nombre'];
    $Tipo = $_POST["Tipo"];
    $Categoria = $_POST["Categoria"];
    $Descripcion = $_POST['Descripcion'];
    $Id = $_POST['Id'];
    $Medida = $_POST['Medida'];
    $Cantidad = $_POST['Cantidad'];

    $Conexion = new PDODB();

    $Conexion->Conectar();

 
    $InstruccionSQL = "SELECT * FROM herramientainsumo WHERE IdHerramientaInsumo != ".$Id;

    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);

    foreach ($Resultado as $key => $Value) {
            if (strtolower($Value['Nombre']) == strtolower($Nombre)) {
                echo "Ya existe una herramienta con el mismo nombre";
                return;
            }
        
    }

    $InstruccionSQL = "UPDATE herramientainsumo SET 
    Nombre = '" . $Nombre . "',
    Tipo = '" . $Tipo . "',
    Categoria = '" . $Categoria . "',
    Descripcion = '" . $Descripcion . "',
    Cantidad = " . $Cantidad . ",
    Medida = '" . $Medida . "'
    WHERE
    IdHerramientaInsumo = " . $Id ;

    $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);

    if ($Resultado == true) {
        echo "Modificado Correctamente";
    } else {
        echo "No fué posible modificar";
    }
}


function DesactivarHerramientaInsumo(){
  $IdHerramientaInsumo = $_POST['IdHerramientaInsumo'];
  $Estado = $_POST['Estado'];
  $Conexion = new PDODB();
  $Conexion->Conectar();
  if ($Estado == 1){
    $Estado = 0;
  }
  else if ($Estado == 0){
    $Estado = 1;
  }
  $InstruccionSQL = "UPDATE herramientainsumo SET 
  Estado = '" . $Estado . "'
  WHERE
  IdHerramientaInsumo = " . $IdHerramientaInsumo ;

  $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);
  if ($Resultado == true) {
    echo "Se ha cambiado el estado";
} else {
    echo "No fué posible Cambiar";
}
}

function EliminarHerramienta(){
  $IdHerramientaInsumo = $_POST['IdHerramientaInsumo'];
  $Conexion = new PDODB();
  $Conexion->Conectar();
  try {
    $consultaInfoUsuario = "SHOW CREATE TABLE herramientainsumo";
    $resultadoInfoUsuario = $Conexion->EjecutarInstruccion($consultaInfoUsuario);
    $definicionUsuario = $resultadoInfoUsuario->fetchColumn(1);
} catch (PDOException $e) {
    echo "Error al obtener información de la tabla Usuario: " . $e->getMessage();
    return;
}

try {
    $consultaTablasRelacionadas = "SHOW TABLES";
    $resultadoTablasRelacionadas = $Conexion->EjecutarInstruccion($consultaTablasRelacionadas);

    while ($filaTablaRelacionada = $resultadoTablasRelacionadas->fetch(PDO::FETCH_NUM)) {
        $tablaRelacionada = $filaTablaRelacionada[0];

        if ($tablaRelacionada != "herramientainsumo") {
            $consultaInfoTablaRelacionada = "SHOW CREATE TABLE $tablaRelacionada";
            $resultadoInfoTablaRelacionada = $Conexion->EjecutarInstruccion($consultaInfoTablaRelacionada);
            $definicionTablaRelacionada = $resultadoInfoTablaRelacionada->fetchColumn(1);

            if (strpos($definicionTablaRelacionada, 'FOREIGN KEY (`IdHerramientaInsumo`) REFERENCES `herramientainsumo` (`IdHerramientaInsumo`)') !== false) {

                // Verificar si hay datos relacionados
                $consultaDatosRelacionados = "SELECT * FROM $tablaRelacionada WHERE IdHerramientaInsumo IN (SELECT IdHerramientaInsumo FROM herramientainsumo WHERE IdHerramientaInsumo = $IdHerramientaInsumo)";
                $resultadoDatosRelacionados = $Conexion->EjecutarInstruccion($consultaDatosRelacionados);

                if ($resultadoDatosRelacionados->rowCount() > 0) {
                    $ArrayTablasRelacionadas[] = " " . $tablaRelacionada;
                }
                //  else {
                //     echo "No hay datos relacionados en la tabla $tablaRelacionada.<br>";
                // }
            }
        }
    }
} catch (PDOException $e) {
    echo "Error al buscar tablas relacionadas: " . $e->getMessage();
    return;
}

if (empty($ArrayTablasRelacionadas)) {
    $Sqly = "DELETE FROM herramientainsumo
    WHERE IdHerramientaInsumo = " . $IdHerramientaInsumo;

    $Eliminado = $Conexion->EjecutarInstruccion($Sqly);

    if ($Eliminado == true) {
        echo "Eliminado correctamente";
    } else {
        echo "No fue posible eliminar";
    }
} else {
    echo "La herramienta o insumo tiene datos relacionados en los siguientes modulos: ";
    for ($i = 0; $i < count($ArrayTablasRelacionadas); $i++) {
        echo $ArrayTablasRelacionadas[$i] . " ";
    }
}
}

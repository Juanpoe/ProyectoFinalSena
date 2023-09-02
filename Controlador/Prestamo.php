<?php
require_once '../Modelo/Conexion.php';
switch ($_POST['Metodo']) {
        // Inicio Realizar Prestamo 
    case 'ListarRealizarP':
        ListarRealizarP();
        break;
    case 'Prestar':
        Prestar();
        break;
    case 'ListarNombresEmpleado':
        ListarNombresEmpleado();
        break;
    case 'ListarPrestamos':
        ListarPrestamos();
        break;
    case 'ListarPrestamoDañado':
        ListarPrestamoDañado();
        break;
    case 'DevolverHerramienta':
        DevolverHerramienta();
        break;
    case 'ModalModificarPrestamo':
        ModalModificarPrestamo();
        break;
    case 'ModificarPrestamo':
        ModificarPrestamo();
        break;
    case 'ModalDevolverHerramienta':
        ModalDevolverHerramienta();
        break;
    case 'DevolverHerramienta':
        DevolverHerramienta();
        break;
    case 'DevolverDañada':
        DevolverDañada();
        break;
 
    case 'ModalArreglarH':
        ModalArreglarH();
        break;
    case 'ModificarDanada':
        ModificarDanada();
        break;
    case 'ModalEditarDanada':
        ModalEditarDanada();
        break;
        // Fin Realizar Prestamo
}
// Inicio Realizar Prestamo 
function ListarRealizarP()
{
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $Busca = $_POST['Busca'];

    //Cambiar esto por el nombre de las columnas que se pueden buscar en el filtro
    $Columnas = ["IdHerramientaInsumo", "Nombre", "Categoria", "Descripcion", "Cantidad", "Medida"];


    $Conexion = new PDODB();
    $Conexion->Conectar();

    //Cambiar esto por la instruccion del sql
    $InstruccionSql = "SELECT * FROM herramientainsumo WHERE Cantidad > 0 AND Estado = 1 AND Tipo = 'Herramienta'";
    session_start();

    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    //Cambiar esto por el nombre de la funcion de listar
    $_SESSION["Funcion"] = "ListarRealizarP";

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
            //Ya esto cada quien
            echo '<tr>
        <td class="pt-3-half" data-th="Id" contenteditable="false">' . $Value['IdHerramientaInsumo'] . '</td>
        <td class="pt-3-half" data-th="Nombre" contenteditable="false"><input id="Nombre' . $Value['IdHerramientaInsumo'] . '" type="hidden" value="' . $Value['Nombre'] . '">' . $Value['Nombre'] . '</td>
                
        
        <td class="pt-3-half" data-th="Categoria" contenteditable="false"><input type="hidden" value="' . $Value['Categoria'] . '">' . $Value['Categoria'] . '</td>
        <td class="pt-3-half" data-th="Descripcion" contenteditable="false"><input type="hidden" value="' . $Value['Descripcion'] . '">' . $Value['Descripcion'] . '</td>
        <td class="pt-3-half" data-th="Medida" contenteditable="false"><input type="hidden" value="' . $Value['Medida'] . '">' . $Value['Medida'] . '</td>
        <td class="pt-3-half" data-th="Cantidad" contenteditable="false"><input type="hidden" id="cantidadd' . $Value['IdHerramientaInsumo'] . '" value="' . $Value['Cantidad'] . '">' . $Value['Cantidad'] . '</td>
        <td data-th="Prestar"><img src="Assets/Img\Iconos\agregar.svg" title="Asignar" id="boton' . $Value['IdHerramientaInsumo'] . '"  class="icon" onclick="Asignar(' . $Value['IdHerramientaInsumo'] . '); ValidarCamposRealizarPrestamo()"></td>
    </tr>';
            echo '<script>          
        CambiarImagen(' . $Value['IdHerramientaInsumo'] . ');
        </script>';
        }
    } else {
        echo '<td colspan="9">Sin resultados</td>';
    }
}





































function ObtenerIdPrestamo($IdEmpleado, $Conexion)
{
    $sql = "SELECT * FROM prestamo
    WHERE IdUsuario = " . $IdEmpleado;
    $resul = $Conexion->ObtenerDatos($sql);
    foreach ($resul as $key => $Value) {
        return $Value['IdPrestamo'];
    }
}

function Prestar()
{
    $Ides = $_POST['Ides'];
    $Cantidad = $_POST['Cantidades'];
    $IdEmpleado = $_POST['IdEmpleado'];
    date_default_timezone_set('America/Mexico_City');

  

    $Conexion = new PDODB();

    $Conexion->Conectar();


    $Cosa2 = 0;
    $Cosa = 0;
    //validar si ya se ha prestado
    for ($i = 0; $i < count($Ides); $i++) {
        $Valida = 0;


        $sql = "SELECT * FROM prestamo 
        INNER JOIN herramientainsumo USING(IdHerramientaInsumo)
        WHERE IdHerramientaInsumo = " . $Ides[$i] . " AND prestamo.Estado = 1 AND IdUsuario = " . $IdEmpleado;

        $resul = $Conexion->ObtenerDatos($sql);

        foreach ($resul as $key => $Value) {
            $Valida = 1;
            $NombreHerramienta = $Value['Nombre'];
        }
        if ($Valida > 0) {
            if ($Cosa == 0) {
                echo "Ya le has prestado al empleado: ";
                $Cosa++;

                echo $NombreHerramienta;
            } else {
                echo ", " . $NombreHerramienta;
            }
        }
        //si no se ha prestado tons se hara
        else {
            $FechaActual = date("d-m-Y");
            $Cosa2++;
            $InstruccionSQL = "INSERT INTO prestamo
            VALUES
            (null,'" . $IdEmpleado . "', '" . $Ides[$i] . "','".$FechaActual."' ,'" . $Cantidad[$i] . "', 1)";

            $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);
            ActHerramienta($Ides[$i], $Cantidad[$i], "-");
        }
    }
    if($Cosa2 > 0 && $Cosa > 0){
        echo "\n ,Se ha realizado el prestamo";
    }
    else if ($Cosa2 > 0) {
        echo "\n Se ha realizado el prestamo";
    }
     else {
        echo "\n ,No fué posible prestar";
    }
}





























function ActHerramienta($Id, $Cantidad, $Operacion)
{

    $Conexion = new PDODB();

    $Conexion->Conectar();

    $InstruccionSQL = "SELECT * FROM herramientainsumo WHERE IdHerramientaInsumo= '" . $Id . "'";

    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);

    foreach ($Resultado as $key => $Value) {
        $CantidadHerramienta = $Value['Cantidad'];
    }
    if ($Operacion == "-") {
        $Resultado = $CantidadHerramienta - $Cantidad;
    } else {
        $Resultado = $CantidadHerramienta + $Cantidad;
    }
    $InstruccionSQL = "UPDATE herramientainsumo  
SET
Cantidad = " . $Resultado . "
WHERE IdHerramientaInsumo = '" . $Id . "'";

    $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);
}





function ListarNombresEmpleado()
{
    $Conexion = new PDODB();

    $Conexion->Conectar();
    $InstruccionSQL = "SELECT * FROM usuario WHERE Estado = 1";

    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);


    foreach ($Resultado as $key => $Value) {
        echo '<option value="' . $Value["IdUsuario"] . '">' . $Value["Nombre"] . '</option>';
    }
}

// Fin Realizar Prestamo

//Funcionalidad de prestamo y dañadas

function ListarPrestamos()
{

    session_start();
    $NombreRol = $_SESSION["Rol"];



    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $Busca = $_POST['Busca'];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $Columnas = ["prestamo.FechaPrestamo", "prestamo.CantidadElemento", "usuario.Nombre", "herramientainsumo.Nombre", "prestamo.Estado", "prestamo.IdPrestamo"];

    $InstruccionSql = "SELECT prestamo.IdPrestamo,usuario.Apellido, prestamo.FechaPrestamo, prestamo.CantidadElemento AS
     CantidadPrestamo, usuario.Nombre AS NombreEmpleado, herramientainsumo.Nombre AS 
     NombreHerramienta, prestamo.Estado AS EstadoPrestamo FROM prestamo INNER JOIN herramientainsumo USING(IdHerramientaInsumo)
      INNER JOIN usuario USING(IdUsuario) WHERE prestamo.IdPrestamo > 0 ";

    if ($NombreRol != 1) {
        $InstruccionSql .= "AND usuario.IdUsuario = " . $_SESSION["IdUsuario"];
    }

    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    $_SESSION["Funcion"] = "ListarPrestamos";

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
            echo '<tr>
            <td data-th="Id" class="pt-3-half" contenteditable="false">' . $Value['IdPrestamo'] . '</td>
        <td data-th="Empleado" class="pt-3-half" contenteditable="false">' . $Value['NombreEmpleado'] . ' ' . $Value['Apellido'] . '</td>
        <td data-th="Herramienta" class="pt-3-half" contenteditable="false">' . $Value['NombreHerramienta'] . '</td>
        <td data-th="Fecha" class="pt-3-half" contenteditable="false">' . $Value['FechaPrestamo'] . '</td>
        <td data-th="Cantidad" class="pt-3-half" contenteditable="false">' . $Value['CantidadPrestamo'] . '</td>
        <td data-th="Estado" class="pt-3-half" contenteditable="false">';
        if ($Value['EstadoPrestamo'] == 1){
            echo"<buttom class='Estado Activo'>Activo</buttom>";
        }
        else{
            echo"<buttom class='Estado Inactivo'>Desactivado</buttom>";
        }
        echo'
        </td>';
            if ($NombreRol == 1 && $Value['EstadoPrestamo'] == 1) {
                echo '<td data-th="Operaciones"> <img src="Assets/Img\Iconos\devolver.svg" title="ERA <br> practicamente \n Mejor dicho" title="Devolver Herramienta" class="icon" onclick="ModalDevolverHerramienta(' . $Value['IdPrestamo'] . ')" >

            <img src="Assets/Img/Iconos/editar.svg" title="Editar" class="icon" onclick="ModalModificarPrestamo(' . $Value['IdPrestamo'] . ')" >
            </td>';
            }
            else if($NombreRol == 1){
                echo '<td data-th="Operaciones"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"></td>';
            }
            echo '
        </tr>';
        }
    } else {
        echo '<td colspan="9">Sin resultados</td>';
    }
}



function ListarPrestamoDañado()
{
    session_start();
    $NombreRol = $_SESSION["Rol"];
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $Busca = $_POST['Busca'];

    $Columnas = ["herramientadanada.IdHerramientaDanada","herramientadanada.Estado", "herramientadanada.CantidadElemento", "herramientadanada.Observacion", "herramientainsumo.Nombre", "usuario.Nombre"];

    $Conexion = new PDODB();
    $Conexion->Conectar();
    $InstruccionSql = "SELECT herramientadanada.Estado AS EstadoDañado,  herramientadanada.IdHerramientaDanada, usuario.Apellido, herramientadanada.CantidadElemento, herramientadanada.Observacion, herramientainsumo.Nombre AS NombreHerramienta, usuario.Nombre AS NombreEmpleado  
    FROM herramientadanada
    INNER JOIN prestamo USING(IdPrestamo)
    INNER JOIN usuario USING(IdUsuario)
    INNER JOIN herramientainsumo USING(IdHerramientaInsumo)
    WHERE herramientadanada.IdHerramientaDanada > 0 ";
    if ($NombreRol != 1) {
        $InstruccionSql .= "AND usuario.IdUsuario = " . $_SESSION["IdUsuario"];
    }
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);
    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    $_SESSION["Funcion"] = "ListarPrestamoDañado";

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
            echo '<tr>
    <td data-th="Id" class="pt-3-half" contenteditable="false">' . $Value['IdHerramientaDanada'] . '</td>
    <td data-th="Empleado" class="pt-3-half" contenteditable="false">' . $Value['NombreEmpleado'] . ' ' . $Value['Apellido'] . '</td>
        <td data-th="Herramienta" class="pt-3-half" contenteditable="false">' . $Value['NombreHerramienta'] . '</td>
        <td data-th="Cantidad" class="pt-3-half" contenteditable="false">' . $Value['CantidadElemento'] . '</td>
        <td data-th="Observacion" class="pt-3-half" contenteditable="false">' . $Value['Observacion'] . '</td>
        <td data-th="Estado" class="pt-3-half" contenteditable="false">';
        if ($Value['EstadoDañado'] == 1){
            echo"<buttom class='Estado Activo'>Activo</buttom>";
        }
        else{
            echo"<buttom class='Estado Inactivo'>Desactivado</buttom>";
        }
        echo'
        </td>'
        ;
            if ($NombreRol == 1 && $Value['EstadoDañado'] == 1) {
                echo '
        <td data-th="Operaciones">
        <img src="Assets/Img/Iconos/reparar.svg" title="Reparar Herramienta" class="icon" onclick="ModalArreglarH(' . $Value['IdHerramientaDanada'] . ', ' . $Value['CantidadElemento'] . ')">
        <img src="Assets/Img/Iconos/editar.svg" title="Editar" class="icon" onclick="ModalEditarDanada(' . $Value['IdHerramientaDanada'] . ', `' . $Value['Observacion'] . '`)">
        </td>';
            } 
            else if($NombreRol == 1){
                echo '<td data-th="Operaciones"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"></td>';
            }
            echo '
        </tr>';
        }
    } else {
        echo '<td colspan="9">Sin resultados</td>';
    }
}
function DevolverHerramienta()
{
    $IdPrestamo = $_POST['IdPrestamo'];
    $Select = $_POST['Select'];
    $CantidadDañado = $_POST['CantidadDañado'];
    $Observacion = $_POST['Observacion'];
    $CantidadDevolver = $_POST['CantidadDevolver'];
    $Conexion = new PDODB();

    $Conexion->Conectar();

    if ($Select == "no") {
        $InstruccionSQL = "SELECT * FROM prestamo WHERE IdPrestamo = " . $IdPrestamo;
        $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);
        foreach ($Resultado as $key => $Value) {
            ActHerramienta($Value['IdHerramientaInsumo'], $CantidadDevolver, "+");
            $IdPrestamo = $Value['IdPrestamo'];
            $CantidadElemento = $Value['CantidadElemento'];
        }

        if ($CantidadDevolver == $CantidadElemento) {
            $InstruccionSQL = "UPDATE prestamo SET CantidadElemento = 0, Estado = 0
            WHERE IdPrestamo = " . $IdPrestamo;
        } else {
            $CantidadDevolver = $CantidadElemento - $CantidadDevolver;
            $InstruccionSQL = "UPDATE prestamo SET CantidadElemento = '" . $CantidadDevolver . "'
            WHERE IdPrestamo = " . $IdPrestamo;
        }
        $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);
    } else {
        // Selecciona la tabla detalle prestamo y prestamo para tomar todos los datos
        $InstruccionSQL = "SELECT * FROM prestamo WHERE IdPrestamo = " . $IdPrestamo;
        $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);
        foreach ($Resultado as $key => $Value) {
            // $Devolver = $Value['CantidadElemento'] - $CantidadDañado;
            ActHerramienta($Value['IdHerramientaInsumo'], ($CantidadDevolver - $CantidadDañado), "+");
            if ($CantidadDevolver == $Value["CantidadElemento"]) {
                $InstruccionSQL = "UPDATE prestamo SET CantidadElemento = " . ($Value["CantidadElemento"] - $CantidadDevolver) . " , Estado = 0
                WHERE IdPrestamo = " . $IdPrestamo;
            } else {
                $InstruccionSQL = "UPDATE prestamo SET CantidadElemento = " . ($Value["CantidadElemento"] - $CantidadDevolver) . "
                WHERE IdPrestamo = " . $IdPrestamo;
            }
            $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);


            $InstruccionSQL = "INSERT INTO herramientadanada  
            VALUES
            (null,'" . $Value['IdPrestamo'] . "', '" . $CantidadDañado . "', '" . $Observacion . "', 1)";
            $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);
            $IdPrestamo = $Value['IdPrestamo'];
        }
    }
    if ($Resultado == true) {
        echo "Se han devuelto las herramientas";
    } else {
        echo "No fué posible";
    }
}



function ModalModificarPrestamo()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdPrestamo  = $_POST['IdPrestamo'];
    $InstruccionSQL = "SELECT prestamo.IdPrestamo, prestamo.CantidadElemento 
    AS CantidadPrestamo, herramientainsumo.Cantidad AS CantidadHerramienta FROM prestamo  
    INNER JOIN herramientainsumo 
    ON prestamo.IdHerramientaInsumo=herramientainsumo.IdHerramientaInsumo 
    WHERE IdPrestamo = " . $IdPrestamo;

    $Lista = $Conexion->ObtenerDatos($InstruccionSQL);

    foreach ($Lista as $key => $Value) {
        $CantidadTotal = $Value['CantidadHerramienta'] + $Value['CantidadPrestamo'];
        echo '
        <input type="hidden" id="Metodo2" value="Modificar">
        <h3>Modificar cantidad del prestamo</h3>
<input type="hidden" id="IdPrestamo" value="' . $Value['IdPrestamo'] . '"><br>

<input id="CantidadPrestamoActual" type="hidden" value="' . $Value['CantidadPrestamo'] . '">
<input onkeyup="Validacion2()" id="CantidadPrestamo" type="number" value="' . $Value['CantidadPrestamo'] . '">
<br>
<span id="CantidadError"></span>
<br>
<label>Cantidad disponible: ' . ($CantidadTotal - $Value['CantidadPrestamo']) . '</label>
<br>
<input type="hidden" id="CantidadHerramienta" value="' . ($CantidadTotal - $Value['CantidadPrestamo']) . '">
<br>
<div class="Boton">
<button class="btn-azul" id="BotonPrestamo" onclick="ModificarPrestamo()">Aceptar</button>
<button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>';
    };
};


function ModificarPrestamo()
{
    $IdPrestamo = $_POST["IdPrestamo"];
    $CantidadPrestamo = $_POST["CantidadPrestamo"];
    $Conexion = new PDODB();

    $Conexion->Conectar();

    $InstruccionSQL = "SELECT * FROM prestamo WHERE IdPrestamo = " . $IdPrestamo;

    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);

    foreach ($Resultado as $key => $Value) {
        ActHerramienta($Value['IdHerramientaInsumo'], $Value['CantidadElemento'], "+");
    }

    $InstruccionSQL = "UPDATE prestamo SET CantidadElemento = '" . $CantidadPrestamo . "'
         WHERE IdPrestamo = " . $IdPrestamo;

    $Modificado = $Conexion->EjecutarInstruccion($InstruccionSQL);

    foreach ($Resultado as $key => $Value) {
        ActHerramienta($Value['IdHerramientaInsumo'], $CantidadPrestamo, "-");
    }


    if ($Modificado == true) {
        echo "Modificado correctamente";
    } else {
        echo "No fue posible modificar";
    }
};

function ModalDevolverHerramienta()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdPrestamo  = $_POST['IdPrestamo'];
    $InstruccionSQL = "SELECT prestamo.IdPrestamo, herramientainsumo.Tipo, prestamo.CantidadElemento 
    AS CantidadPrestamo, herramientainsumo.Cantidad AS CantidadHerramienta FROM prestamo  
    INNER JOIN herramientainsumo USING(IdHerramientaInsumo)
    WHERE IdPrestamo = " . $IdPrestamo;

    $Lista = $Conexion->ObtenerDatos($InstruccionSQL);

    foreach ($Lista as $key => $Value) {

            echo '
        <input type="hidden" id="Metodo2" value="Devolver">
        <h3>¿Cuantas Herramientas va a devolver?</h3>
        <br>
        <input onkeyup="Validacion4(); Validacion3()" id="NoDevolver" type="number" placeholder="MAX: ' . $Value['CantidadPrestamo'] . '"> 
        <br>
<span id="CantidadError"></span> 
        <br>
        <h3>¿Se ha dañado alguna herramienta?</h3>
        <br>
        <select onclick="Siono(); ValidarCamposPrestamo();" id="Select" name="Select">
        <option value="no">No</option>
  <option value="si">Si</option>
 </select>
 <br>
<input type="hidden" id="IdPrestamo2" value="' . $Value['IdPrestamo'] . '">
<input id="CantidadBase" disabled type="hidden" value="' . $Value['CantidadPrestamo'] . '">
<br>
<label id="Label1" style="display: none;">Ingrese la cantidad de herramientas dañadas</label>

<input onkeyup="Validacion3()" id="CantidadDañado" style="display: none;" type="number" placeholder="Ingrese la cantidad de herramientas dañadas">
<span id="CantidadDevolverError" style="display: none;"></span>

<br><label id="Label2" style="display: none;">Ingrese el motivo</label>
<textarea type="text" id="Observacion" onkeyup="Validacion5()" class="input" maxlength="200" style="display: none;">
</textarea>
<span id="ObservacionError" style="display: none;"></span>
<br>
<div class="Boton">
<button class="btn-azul" id="BotonPrestamo" onclick="DevolverHerramienta()" disabled>Aceptar</button>
<button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
';
        };
};

function DevolverDañada()
{
    $Id = $_POST['Id'];
    $Cantidad = $_POST['Cantidad'];
    $CantidadArreglada = $_POST['CantidadArreglada'];

    $Conexion = new PDODB();

    $Conexion->Conectar();


    $InstruccionSQL = "SELECT * FROM herramientadanada INNER JOIN prestamo USING(Idprestamo) INNER JOIN herramientainsumo USING(IdHerramientaInsumo) WHERE IdHerramientaDanada = " . $Id;
    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);
    foreach ($Resultado as $key => $Value) {
        ActHerramienta($Value['IdHerramientaInsumo'], $CantidadArreglada, "+");
    }

    if ($Cantidad == $CantidadArreglada) {
        $InstruccionSQL = "UPDATE herramientadanada  
        SET
        CantidadElemento = 0, Estado = 0
        WHERE IdHerramientaDanada = '" . $Id . "'";
    } else {
        $InstruccionSQL = "UPDATE herramientadanada  
    SET
    CantidadElemento = " . ($Cantidad - $CantidadArreglada) . "
    WHERE IdHerramientaDanada = '" . $Id . "'";
    }

    $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);

    if ($Resultado == true) {
        echo "Se han devuelto las herramientas";
    } else {
        echo "No fué posible";
    }
}


function ModalArreglarH()
{
    $Id = $_POST['Id'];
    $Cantidad = $_POST['Cantidad'];
    echo '
            <h3>¿Cuantas herramientas se han arreglado?</h3>
            <br>
            <input id="CantidadHerramienta" type="hidden" value="' . $Cantidad . '">
            <input onkeyup="Validacion6()" type="number" id="CantidadPrestamo" placeholder="MAX: ' . $Cantidad . '">
            <br>
            <span id="ArreglarError"></span>
            <br>   <div class="Boton">
            <button class="btn-azul" disabled id="BotonArreglar" onclick="DevolverDañada(' . $Id . ')">Aceptar</button>
            <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>  
            </div> ';
};
function ModalEditarDanada()
{
    $Id = $_POST['Id'];
    $Observacion = $_POST['Observacion'];
    echo '
            <h3>Motivo</h3>
            <br>
            <textarea onkeyup="Validacion7()" type="text" id="Observacion" maxlength="200" class="input">' . $Observacion . '</textarea>
            <br>
            <span id="ObservacionError"></span>
            <br>   <div class="Boton">
            <button class="btn-azul" id="BotonObservacion" onclick="ModificarDanada(' . $Id . ')">Aceptar</button>
            <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>  
       </div> ';
}

function ModificarDanada()
{

    $Id = $_POST["Id"];
    $Observacion = $_POST["Observacion"];
    $Conexion = new PDODB();

    $Conexion->Conectar();

    $InstruccionSQL = "UPDATE herramientadanada SET Observacion = '" . $Observacion . "'
         WHERE Idherramientadanada = " . $Id;

    $Modificado = $Conexion->EjecutarInstruccion($InstruccionSQL);

    if ($Modificado == true) {
        echo "Modificado correctamente";
    } else {
        echo "No fue posible modificar";
    }
}

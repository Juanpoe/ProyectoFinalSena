<?php
require_once '../Modelo/Conexion.php';
switch ($_POST['Metodo']) {
    case 'ListarHerramientas':
        ListarHerramientas();
        break;
    case 'ModalSolicitar':
        ModalSolicitar();
        break;
    case 'GuardarSolicitud':
        GuardarSolicitud();
        break;
        case 'ListarPrestamosSolicitados':
            ListarPrestamosSolicitados();
            break;
            case 'ModalEditarSolicitudPrestamo':
                ModalEditarSolicitudPrestamo();
                break;
                case 'EditarSolicitud': 
                    EditarSolicitud();
                    break;
                    case 'ModalAceptarSolicitudPrestamo':
                        ModalAceptarSolicitudPrestamo();
                        break;
                        case 'ModalRechazarSolicitudPrestamo':
                            ModalRechazarSolicitudPrestamo();
                            break;
                            case 'RechazarSolicitudPrestamo':
                                RechazarSolicitudPrestamo();
                                break;
                                case 'AceptarSolicitudPrestamo':
                                    AceptarSolicitudPrestamo();
                                    break;
    }


    
function ListarHerramientas()
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
    session_start();
    //Cambiar esto por la instruccion del sql
    $InstruccionSql = "SELECT herramientainsumo.*
    FROM herramientainsumo
    LEFT JOIN prestamo ON herramientainsumo.IdHerramientaInsumo = prestamo.IdHerramientaInsumo AND prestamo.IdUsuario = ".$_SESSION['IdUsuario']."
    LEFT JOIN (
        SELECT DISTINCT IdHerramientaInsumo
        FROM solicitudprestamo
        WHERE Estado = 2
    ) solicitud_activa ON herramientainsumo.IdHerramientaInsumo = solicitud_activa.IdHerramientaInsumo
    WHERE (prestamo.IdHerramientaInsumo IS NULL OR prestamo.Estado = 0)
      AND solicitud_activa.IdHerramientaInsumo IS NULL
      AND herramientainsumo.Cantidad > 0
      AND herramientainsumo.Estado = 1
      AND herramientainsumo.Tipo = 'Herramienta';";


    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    //Cambiar esto por el nombre de la funcion de listar
    $_SESSION["Funcion"] = "ListarHerramientasSP";

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
        <td class="pt-3-half" data-th="Id" contenteditable="false"> ' . $Value['IdHerramientaInsumo'] . '</td>
        <td class="pt-3-half" data-th="Nombre" contenteditable="false">' . $Value['Nombre'] . '</td>
        <td class="pt-3-half" data-th="Categoria" contenteditable="false">' . $Value['Categoria'] . '</td>
        <td class="pt-3-half" data-th="Descripcion" contenteditable="false">' . $Value['Descripcion'] . '</td>
        <td class="pt-3-half" data-th="Medida" contenteditable="false">' . $Value['Medida'] . '</td>
        <td class="pt-3-half" data-th="Cantidad" contenteditable="false">' . $Value['Cantidad'] . '</td>
        <td data-th="Solicitar"><img src="Assets/Img\Iconos\solicitar.svg" title="Solicitar"  class="icon" onclick="ModalSolicitar(' . $Value['IdHerramientaInsumo'] . ', ' . $Value['Cantidad'] . ');"></td>
    </tr>';
        }
    } else {
        echo '<td colspan="9">No hay herramientas disponibles</td>';
    }
}

function ModalSolicitar()
{
    $IdHerramienta  = $_POST['IdHerramienta'];
    $CantidadTotal  = $_POST['Cantidad'];
      echo '
        <h3>Cantidad a solicitar</h3>
<input onkeyup="ValidacionSolicitar()" placeholder="Ingrese una cantidad:" id="CantidadSolicitud" type="number" >
<br>
<span id="CantidadError"></span>
<br>
<label>Cantidad disponible: ' . ($CantidadTotal) . '</label>
<br>
<input type="hidden" id="CantidadHerramienta" value="' . ($CantidadTotal) . '">
<br>
<label id="Label2">Motivo</label>
<textarea placeholder="Ingrese el motivo:" type="text" id="Observacion" onkeyup="ValidacionObservacionSolicitarPrestamo()" class="input" maxlength="200">
</textarea>
<br>
<br>
<span id="ObservacionError"></span>
<div class="Boton">
<button class="btn-azul" id="BotonSolicitar" disabled onclick="GuardarSolicitud('.$IdHerramienta.')">Aceptar</button>
<button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>';
};


function GuardarSolicitud(){
    $IdHerramienta = $_POST['IdHerramienta'];
    $Cantidad = $_POST['CantidadSolicitud'];
    $Observacion = $_POST['Observacion'];
    date_default_timezone_set('America/Mexico_City');
    session_start();
    $IdUsuario = $_SESSION['IdUsuario'];

    $Conexion = new PDODB();

    $Conexion->Conectar();
    
            $FechaActual = date("d-m-Y");
            $InstruccionSQL = "INSERT INTO solicitudprestamo
            VALUES
            (null,'" . $IdHerramienta . "', '" . $IdUsuario . "','".$Cantidad."' ,'" . $Observacion . "','" . $FechaActual . "', 2)";

            $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);
            echo "Se ha realizado la solicitud";
        }


function ListarPrestamosSolicitados(){
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $Busca = $_POST['Busca'];
    $Columnas = ["solicitudprestamo.IdSolicitudPrestamo", "herramientainsumo.Nombre", "solicitudprestamo.CantidadSolicitud", "solicitudprestamo.Observacion", "solicitudprestamo.FechaSolicitud", ".solicitudprestamo.Estado"];

    //Cambiar esto por el nombre de las columnas que se pueden buscar en el filtro

    $Conexion = new PDODB();
    $Conexion->Conectar();
    session_start();
    //Cambiar esto por la instruccion del sql
    $InstruccionSql = "SELECT 
    solicitudprestamo.IdSolicitudPrestamo,
    solicitudprestamo.IdHerramientaInsumo,
    solicitudprestamo.IdUsuario,
    herramientainsumo.Nombre AS NombreHerramientaInsumo,
    usuario.Nombre AS NombreUsuario,
    solicitudprestamo.CantidadSolicitud,
    solicitudprestamo.Observacion,
    solicitudprestamo.FechaSolicitud,
    solicitudprestamo.Estado AS EstadoSolicitud
FROM solicitudprestamo 
INNER JOIN herramientainsumo USING(IdHerramientaInsumo)
INNER JOIN usuario USING(IdUsuario)
WHERE solicitudprestamo.IdSolicitudPrestamo > 0 ";
$NombreRol = $_SESSION["Rol"];
if ($NombreRol != 1) {
    $InstruccionSql .= "AND IdUsuario = " . $_SESSION["IdUsuario"] ;
    $Columnas = ["solicitudprestamo.IdSolicitudPrestamo", "herramientainsumo.Nombre", "usuario.Nombre", "solicitudprestamo.CantidadSolicitud", "solicitudprestamo.Observacion", "solicitudprestamo.FechaSolicitud", ".solicitudprestamo.Estado"];
}


    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    //Cambiar esto por el nombre de la funcion de listar
    $_SESSION["Funcion"] = "ListarPrestamosSolicitados";

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
            $InstruccionSql = "SELECT * 
            FROM herramientainsumo
            WHERE IdHerramientaInsumo = ".$Value['IdHerramientaInsumo'];  
            $Resultado = $Conexion->ObtenerDatos($InstruccionSql);  
            foreach ($Resultado as $key => $Values) {
                $CantidadH = $Values['Cantidad'];
                $EstadoH = $Values['Estado'];
            }
            $InstruccionSql = "SELECT * 
            FROM prestamo
            WHERE Idusuario = ".$Value['IdUsuario']." AND Estado = 1 AND IdHerramientaInsumo = ".$Value['IdHerramientaInsumo'];  
            $Resultado = $Conexion->ObtenerDatos($InstruccionSql);  
            $UsuarioH = 0;
            $ValidacionH = 0;
            foreach ($Resultado as $key => $Values) {
                $UsuarioH = 1;
            }



            echo '<tr>
        <td class="pt-3-half" data-th="Id" contenteditable="false"> ' . $Value['IdSolicitudPrestamo'] . '</td>
';
        if ($NombreRol == 1) {
            echo'
        <td class="pt-3-half" data-th="Empleado" contenteditable="false">' . $Value['NombreUsuario'] . '</td>
        ';}
        echo'
        <td class="pt-3-half" data-th="Herramienta" contenteditable="false">' . $Value['NombreHerramientaInsumo'] . '</td>
        <td class="pt-3-half" data-th="Observacion" contenteditable="false">' . $Value['Observacion'] . '</td>
        <td class="pt-3-half" data-th="Cantidad" contenteditable="false">' . $Value['CantidadSolicitud'] . '</td>
        <td class="pt-3-half" data-th="Fecha" contenteditable="false">' . $Value['FechaSolicitud'] . '</td>
        <td class="pt-3-half" data-th="Estado" contenteditable="false">';
        if ($Value['EstadoSolicitud'] == 2){
        echo'En espera.'; 
            if($CantidadH < $Value['CantidadSolicitud']){
                echo'<br> No hay suficientes herramientas disponibles, <br> no se podrá aceptar la solicitud.';
                $ValidacionH = 1;
            }
            else if($EstadoH == 0){
                echo'<br> La herramienta está desactivada, <br> no se podrá aceptar la solicitud.';
                $ValidacionH = 1;
            }
            else if ($UsuarioH == 1) {
                echo'<br> Empleado con préstamo previo de esta herramienta, <br> no se podrá aceptar la solicitud.';                
                $ValidacionH = 1;
            }
        }
        else if ($Value['EstadoSolicitud'] == 0){
            echo'Rechazado.'; 
            }
            else{
                echo'Aceptado.'; 
                }
         echo'</td>
        <td data-th="Operaciones">';
        // Empleado
        if ($NombreRol == 0) {
            if ($Value['EstadoSolicitud'] == 2){
            echo'
        <img src="Assets/Img\Iconos\editar.svg" title="Editar" class="icon" onclick="ModalEditarSolicitudPrestamo('.$Value["IdSolicitudPrestamo"].', '.$CantidadH.', '.$Value['CantidadSolicitud'].', \'' . $Value['Observacion'] . '\');">
        ';}
        else{
            echo'<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';
        }
    }
    // Administrador
        else{
            if ($Value['EstadoSolicitud'] == 2 && $ValidacionH == 0){
                echo'
            <img src="Assets/Img\Iconos\check.svg" title="Aceptar" class="icon" onclick="ModalAceptarSolicitudPrestamo('.$Value['IdSolicitudPrestamo'].', '.$Value['CantidadSolicitud'].', '.$Value['IdHerramientaInsumo'].', '.$Value['IdUsuario'].');">
            <img src="Assets/Img\Iconos\x.svg" title="Rechazar" class="icon" onclick="ModalRechazarSolicitudPrestamo('.$Value['IdSolicitudPrestamo'].');">
            ';}
            else if($Value['EstadoSolicitud'] == 2){
                echo'
                <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                <img src="Assets/Img\Iconos\x.svg" title="Rechazar" class="icon" onclick="ModalRechazarSolicitudPrestamo('.$Value['IdSolicitudPrestamo'].');">';
            }
            else{
                echo'<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';
            }
        }
        echo'</td>
    </tr>';
        }
    } else {
        echo '<td colspan="9">Sin resultados</td>';
    }
}


function ModalEditarSolicitudPrestamo(){
    $IdSolicitud = $_POST['IdSolicitud'];
    $CantidadHerramienta = $_POST['CantidadHerramienta'];
    $CantidadSolicitud = $_POST['CantidadSolicitud'];
    $Observacion = $_POST['Observacion'];
      echo '
      <script>          
      ValidacionSolicitar();
      ValidacionObservacionSolicitarPrestamo();
        </script>
        <h3>Modificar cantidad a solicitar</h3>
<input onkeyup="ValidacionSolicitar()" placeholder="Ingrese una cantidad:" id="CantidadSolicitud" type="number" value="'.$CantidadSolicitud.'">
<br>
<span id="CantidadError"></span>
<br>
<label>Herramientas actuales: ' . $CantidadHerramienta . '</label>
<br>
<input type="hidden" id="CantidadHerramienta" value="' . $CantidadHerramienta . '">
<br>
<label id="Label2">Motivo</label>
<textarea placeholder="Ingrese el motivo" type="text" id="Observacion" onkeyup="ValidacionObservacionSolicitarPrestamo()" class="input" maxlength="200">
'.$Observacion.'</textarea>
<br>
<br>
<span id="ObservacionError"></span>
<div class="Boton">
<button class="btn-azul" id="BotonSolicitar" onclick="EditarSolicitud('.$IdSolicitud.')">Aceptar</button>
<button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>';   
}

function EditarSolicitud(){
    $IdSolicitud = $_POST["IdSolicitud"];
    $CantidadSolicitud = $_POST["CantidadSolicitud"];
    $Observacion = $_POST['Observacion'];
    $Conexion = new PDODB();

    $Conexion->Conectar();

    $InstruccionSQL = "UPDATE solicitudprestamo SET CantidadSolicitud = " . $CantidadSolicitud . ",
    Observacion = '".$Observacion."'
         WHERE IdSolicitudPrestamo = " . $IdSolicitud;

    $Modificado = $Conexion->EjecutarInstruccion($InstruccionSQL);

    if ($Modificado == true) {
        echo "Modificado correctamente";
    } else {
        echo "No fue posible modificar";
    }
}

function ModalRechazarSolicitudPrestamo(){
    $IdSolicitud = $_POST['IdSolicitud'];

    echo '
    <h3>¿Estas seguro de rechazar esta solicitud?</h3>

    <div class="Boton">
    <button class="btn-azul" id="SubmitButtonModal" onclick="RechazarSolicitudPrestamo('.$IdSolicitud.');">Aceptar</button> 
    <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
    ';  
}

function RechazarSolicitudPrestamo(){
    $IdSolicitud = $_POST["IdSolicitud"];
    $Conexion = new PDODB();

    $Conexion->Conectar();

    $InstruccionSQL = "UPDATE solicitudprestamo SET Estado = 0
         WHERE IdSolicitudPrestamo = " . $IdSolicitud;

    $Modificado = $Conexion->EjecutarInstruccion($InstruccionSQL);

    if ($Modificado == true) {
        echo "Se ha cambiado el estado correctamente";
    } else {
        echo "No fue posible cambiar el estado";
    }
}
function ModalAceptarSolicitudPrestamo(){
    echo '
    <h3>¿Estas seguro de aceptar esta solicitud?</h3>
    <div class="Boton">
    <button class="btn-azul" id="SubmitButtonModal" onclick="AceptarSolicitudPrestamo('.$_POST['IdSolicitud'].', '.$_POST['CantidadSolicitud'].', '.$_POST['IdHerramienta'].', '.$_POST['IdUsuario'].');">Aceptar</button> 
    <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
    ';
}
function AceptarSolicitudPrestamo(){
    $IdSolicitud = $_POST["IdSolicitud"];
    $CantidadSolicitud = $_POST["CantidadSolicitud"];
    $IdHerramienta = $_POST["IdHerramienta"];
    $IdUsuario = $_POST["IdUsuario"];
    date_default_timezone_set('America/Mexico_City');
    $Conexion = new PDODB();

    $Conexion->Conectar();

    $InstruccionSQL = "UPDATE solicitudprestamo SET Estado = 1
         WHERE IdSolicitudPrestamo = " . $IdSolicitud;

    $Modificado = $Conexion->EjecutarInstruccion($InstruccionSQL);


    $FechaActual = date("d-m-Y");
    $InstruccionSQL = "INSERT INTO prestamo
    VALUES
    (null,'" . $IdUsuario . "', '" . $IdHerramienta . "','".$FechaActual."' ,'" . $CantidadSolicitud . "', 1)";

    $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);
    ActHerramienta($IdHerramienta, $CantidadSolicitud, "-");

    if ($Modificado == true && $Resultado == true) {
        echo "Se ha cambiado el estado y creado el prestamo";
    } else {
        echo "No fue posible cambiar el estado";
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
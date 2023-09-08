<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/SolicitarPrestamo.php';
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
    $SolicitarPrestamoModel = new SolicitarPrestamo($Conexion);
    $SolicitarPrestamoModel->ListarHerramientas($Columnas, $Pagina, $Registros, $Inicio, $Orden, $Busca);

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
       
            $SolicitarPrestamoModel = new SolicitarPrestamo($Conexion);
            $SolicitarPrestamoModel->GuardarSolicitud($IdHerramienta,$Cantidad,$Observacion,$IdUsuario,$FechaActual);
        }


function ListarPrestamosSolicitados(){
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $Busca = $_POST['Busca'];
    $Columnas = ["solicitudprestamo.IdSolicitudPrestamo", "herramientainsumo.Nombre", "solicitudprestamo.CantidadSolicitud", "solicitudprestamo.Observacion", "solicitudprestamo.FechaSolicitud", ".solicitudprestamo.Estado"];


    $Conexion = new PDODB();
    $Conexion->Conectar();
    session_start();
    $NombreRol = $_SESSION["Rol"];

    $SolicitarPrestamoModel = new SolicitarPrestamo($Conexion);
    $SolicitarPrestamoModel->ListarPrestamosSolicitados($Pagina, $Registros, $Inicio, $Orden, $Busca, $Columnas, $NombreRol);
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
    $SolicitarPrestamoModel = new SolicitarPrestamo($Conexion);
    $Modificado = $SolicitarPrestamoModel->EditarSolicitud($IdSolicitud, $CantidadSolicitud, $Observacion);

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

    $SolicitarPrestamoModel = new SolicitarPrestamo($Conexion);
    $Modificado = $SolicitarPrestamoModel->RechazarSolicitudPrestamo($IdSolicitud);

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

    $SolicitarPrestamoModel = new SolicitarPrestamo($Conexion);
    echo $SolicitarPrestamoModel->AceptarSolicitudPrestamo($IdSolicitud, $CantidadSolicitud, $IdHerramienta, $IdUsuario);

  
}



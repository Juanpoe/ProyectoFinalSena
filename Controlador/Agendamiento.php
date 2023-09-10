<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Agendamiento.php';
switch ($_POST['Metodo']) {
    case 'GuardarAgendamiento':
        GuardarAgendamiento();
        break;
    case 'SelectInsumo':
        SelectInsumo();
        break;
    case 'SelectServicio':
        SelectServicio();
        break;
    case 'SelectUsuario':
        SelectUsuario();
        break;
    case 'ModificarAgendamiento':
        ModificarAgendamiento();
        break;
    case 'ModalAgendamiento':
        ModalAgendamiento();
        break;
    case 'CambiarEstado':
        CambiarEstado();
        break;
    case 'ListarAgendamientoAdministrador':
        ListarAgendamientoAdministrador();
        break;

    case 'ModalEliminarAgendamiento';
    ModalEliminarAgendamiento();
        break;
    
    case 'ModalNovedadAgendamiento';
    ModalNovedadAgendamiento();
        break;
    case 'ModalPrestamoAgendamiento';
    ModalPrestamoAgendamiento();
        break;

    case 'ValidacionDeServiciosEmpleados';
    ValidacionDeServiciosEmpleados();
    break;

    
    case 'ValidacionDeServiciosEmpleadosModal';
    ValidacionDeServiciosEmpleadosModal();
    break;
    
    
        
}

function ValidacionDeServiciosEmpleados(){
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdEmpleado = $_POST["IdEmpleado"];
    $FechaServicio = $_POST["FechaServicio"];
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->ValidacionDeServiciosEmpleados($IdEmpleado, $FechaServicio);
  
    }


    function ValidacionDeServiciosEmpleadosModal(){
        $Conexion = new PDODB();
        $Conexion->Conectar();
        $IdEmpleado = $_POST["IdEmpleado"];
        $FechaServicio = $_POST["FechaServicio"];
        $AgendamientoModel = new Agendamiento($Conexion);
        $AgendamientoModel->ValidacionDeServiciosEmpleadosModal($IdEmpleado, $FechaServicio);
      
        }
  
    





function ModalNovedadAgendamiento(){
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdUsuario = $_POST["IdUsuario"];
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->ModalNovedadAgendamiento($IdUsuario);
   
}



function ModalPrestamoAgendamiento(){
    $IdUsuario = $_POST["IdUsuario"];
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->ModalPrestamoAgendamiento($IdUsuario);
}
   






function ModalEliminarAgendamiento(){
    $Id = $_POST["Id"];
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->ModalEliminarAgendamiento($Id);

}








function GuardarAgendamiento()
{
    $Cantidad = $_POST["CantidadRegistrados"];
    $IdAcumuladas = $_POST["IdRegistrados"];
    $IdUsuario = $_POST["IdUsuario"];
    $IdServicio = $_POST["IdServicio"];
    $NombreCliente = $_POST["NombreCliente"];
    $Descripcion = $_POST["Descripcion"];
    $FechaServicio = $_POST["FechaServicio"];
    $DireccionCliente = $_POST["DireccionCliente"];
    $TelefonoCliente = $_POST["TelefonoCliente"];
    $Estado = "2";
    $ListaIdHerramientaInsumo = "";
    foreach ($IdAcumuladas as $key => $IdAcumulada) {
        $ListaIdHerramientaInsumo = "$ListaIdHerramientaInsumo$IdAcumulada, ";
    }
    $ListaCantidadHerramientaInsumo = "";
    foreach ($Cantidad as $key => $Cantidades) {

        $ListaCantidadHerramientaInsumo = "$ListaCantidadHerramientaInsumo$Cantidades, ";
    }
    $ListaCantidadHerramientaInsumo = str_replace(' ','',$ListaCantidadHerramientaInsumo);
    $ListaCantidadHerramientaInsumo = substr($ListaCantidadHerramientaInsumo, 0, strlen($ListaCantidadHerramientaInsumo) - 1);
    

    $ListaIdHerramientaInsumo = str_replace(' ','',$ListaIdHerramientaInsumo);
    $ListaIdHerramientaInsumo = substr($ListaIdHerramientaInsumo, 0, strlen($ListaIdHerramientaInsumo) - 1);

    $Conexion = new PDODB();
    $Conexion->Conectar();
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->GuardarAgendamiento($Cantidad,$IdAcumuladas,$IdUsuario,$IdServicio,$NombreCliente,$Descripcion,$FechaServicio,$DireccionCliente,$TelefonoCliente,$Estado,$ListaCantidadHerramientaInsumo,$ListaIdHerramientaInsumo);

}





function SelectServicio()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->SelectServicio();

}






function SelectInsumo()
{
    $IdRegistrados = $_POST["IdRegistrados"];
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->SelectInsumo($IdRegistrados);


}





function SelectUsuario()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->SelectUsuario();
}

function ListarAgendamientoAdministrador()
{
    session_start();
    $NombreRol = $_SESSION["Rol"];
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $Busca = $_POST['Busca'];

    // Cambiar esto por el nombre de las columnas que se pueden buscar en el filtro
    $Columnas = [
        "agendamiento.IdAgendamiento", "usuario.Nombre", "agendamiento.NombreCliente",
        "servicio.NombreServicio", "herramientainsumo.Nombre", "agendamiento.DireccionCliente", "agendamiento.Estado",
        "agendamiento.TelefonoCliente", "agendamiento.FechaServicio","agendamiento.Descripcion"
    ];

    $Conexion = new PDODB();
    $Conexion->Conectar();
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->ListarAgendamientoAdministrador($NombreRol,$Registros,$Inicio,$Orden,$Busca,$Columnas);


}
function CambiarEstado()
{

    $IdAgendamiento = $_POST["IdAgendamiento"];
    $estado1 = "1";

    $Conexion = new PDODB();
    $Conexion->Conectar();
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->CambiarEstado($IdAgendamiento,$estado1);

}
function ModalAgendamiento()
{
    $IdAgendamiento = $_POST['IdAgendamiento'];
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->ModalAgendamiento($IdAgendamiento);
   
}


function ModificarAgendamiento()
{
    $IdAcumuladas = $_POST["IdRegistrados"];
    $IdAgendamiento = $_POST["IdAgendamiento"];
    $CopiadeArrays = $_POST["Copia"];
    $IdUsuario = $_POST["IdUsuario"];
    $IdServicio = $_POST["IdServicio"];
    $NombreCliente = $_POST["NombreCliente"];
    $Descripcion = $_POST["Descripcion"];
    $FechaServicio = $_POST["FechaServicio"];
    $DireccionCliente = $_POST["DireccionCliente"];
    $TelefonoCliente = $_POST["TelefonoCliente"];
    $Cantidad = $_POST["CantidadRegistrados"];
    $Descripcion = $_POST["Descripcion"];
    $Estado = "2";
    $ListaIdHerramientaInsumo = "";
   
    // Decodificar el objeto Copia
$copiaDecodificada = json_decode($CopiadeArrays);

// Acceder a los arrays en la copia
$copiaIdRegistrados = $copiaDecodificada->copiaIdRegistrados;
$copiaCantidadRegistrados = $copiaDecodificada->copiaCantidadRegistrados;
$iguales = array();
    
// Obtener valores iguales
$iguales = array_intersect($copiaIdRegistrados, $IdAcumuladas);

// Obtener valores únicos en cada array
$diferentesCopia = array_diff($copiaIdRegistrados, $IdAcumuladas);
$diferentesIdacumuladas = array_diff($IdAcumuladas, $copiaIdRegistrados);


$igualesCantidades = array_intersect($copiaCantidadRegistrados,$Cantidad);
// Obtener valores únicos en cada array
$diferentesCantidades = array_diff($Cantidad,$copiaCantidadRegistrados);
$diferentesCopiaCantidades = array_diff($copiaCantidadRegistrados,$Cantidad);

foreach ($IdAcumuladas as $key => $value) {
        $ListaIdHerramientaInsumo = "$ListaIdHerramientaInsumo$value, ";
    }
    $ListaCantidadHerramientaInsumo = "";
    foreach ($Cantidad as $key => $value) {
        $ListaCantidadHerramientaInsumo = "$ListaCantidadHerramientaInsumo$value, ";
    }
    $ListaCantidadHerramientaInsumo = str_replace(' ','',$ListaCantidadHerramientaInsumo);
    $ListaCantidadHerramientaInsumo = substr($ListaCantidadHerramientaInsumo, 0, strlen($ListaCantidadHerramientaInsumo) - 1);
    $ListaIdHerramientaInsumo = str_replace(' ','',$ListaIdHerramientaInsumo);
    $ListaIdHerramientaInsumo = substr($ListaIdHerramientaInsumo, 0, strlen($ListaIdHerramientaInsumo) - 1);
    $Conexion = new PDODB();

    $Conexion->Conectar();
    $AgendamientoModel = new Agendamiento($Conexion);
    $AgendamientoModel->ModificarAgendamiento($IdAcumuladas,$IdAgendamiento,$IdUsuario,$IdServicio,$NombreCliente,
    $Descripcion,$FechaServicio,$DireccionCliente,$TelefonoCliente,$Cantidad,
    $Estado,$ListaIdHerramientaInsumo,$copiaIdRegistrados,$copiaCantidadRegistrados,$ListaCantidadHerramientaInsumo,$diferentesCopia,
    $diferentesIdacumuladas,$iguales);


}




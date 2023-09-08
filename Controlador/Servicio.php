<?php
include("../Modelo/Conexion.php");
include("../Modelo/Servicio.php");
switch ($_POST['Metodo']) {
    case 'ListarServicios':
        ListarServicios();
        break;
    case 'GuardarServicio':
        GuardarServicio();
        break;
    case 'DesactivarServicio':
        DesactivarServicio();
        break;
    case 'ModalListarServicio':
        ModalListarServicio();
        break;
    case 'ModificarListar':
        ModificarListar();
        break;
        case 'ModalDesactivarServicio':
            ModalDesactivarServicio();
            break;
}

function GuardarServicio()
{
    $Nombre = $_POST["Nombre"];
    $Estado = "1";

    $conexion = new PDODB();

    $conexion->Conectar();

    $ServicioModel = new Servicio($conexion);

    $resultado = $ServicioModel->GuardarServicio($Nombre, $Estado);

    if ($resultado == true) {
        echo "Registrado Correctamente";
    } else {
        echo "Ya existe un servicio con el mismo nombre";
    }
}

function ListarServicios()
{
    session_start();
    $NombreRol = $_SESSION["NombreRol"];
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $Busca = $_POST['Busca'];

    $Columnas = ["NombreServicio", "IdServicio", "EstadoServicio"];


    $conexion = new PDODB();

    $conexion->Conectar();

    $ServicioModel = new Servicio($conexion);

    $ServicioModel->ListarServicio($NombreRol, $Registros, $Inicio, $Orden, $Busca, $Columnas);

}

function DesactivarServicio()
{
    $IdServicio = $_POST['IdServicio'];
    $Estado = $_POST['Estado'];  
    if ($Estado == 1) {
        $Estado = 0;
    } else {
        $Estado = 1;
    }
    $conexion = new PDODB();
    $conexion->Conectar();

    $ServicioModel = new Servicio($conexion);

    $Modificado = $ServicioModel->DesactivarServicio($Estado, $IdServicio);

        if ($Modificado == true && $Estado == 0) {
            echo "Desactivado correctamente";
        } else if ($Modificado == true && $Estado == 1) {
            echo "Activado correctamente";
        } else {
            echo "No fue posible modificar";
        }   
}


function ModalListarServicio()
{

    $IdServicio = $_POST['IdServicio'];


    $conexion = new PDODB();
    $conexion->Conectar();
    
    $ServicioModel = new Servicio($conexion);

    $ServicioModel->ModalListarServicio($IdServicio);

}


function ModificarListar()
{

    $IdServicio = $_POST["IdServicio"];
    $Nombre = $_POST["Nombre"];
    $Estado = 1;


    $conexion = new PDODB();

    $conexion->Conectar();

$ServicioModel = new Servicio($conexion);

$modificado = $ServicioModel->ModificarListar($IdServicio, $Nombre, $Estado);

    if ($modificado == true) {
        echo "Modificado correctamente";
    } 
    else {
        echo "Ya existe un servicio con el mismo nombre";
    }
}






function ModalDesactivarServicio(){
    $Id = $_POST["Id"];
    $Estado = $_POST["Estado"];
    echo'
    <form action="" Id="ModalServicio"><center><h3>¿Está seguro de cambiar el estado?</h3></center>
    <input id="Id" value="'.$Id.'" type="hidden">
    <input id="Estado" value="'.$Estado.'" type="hidden">
    <div class="Boton">
    <button class="btn-azul" id="registrar" onclick="DesactivarServicio()">Aceptar</button>
    <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
</form>
    ';
}
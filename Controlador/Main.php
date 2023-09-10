<?php

require_once '../Modelo/Conexion.php';
require_once '../Modelo/Main.php';
switch ($_POST['Metodo']) {
    case 'ListarPaginacion':
        ListarPaginacion();
        break;
    case 'CantidadDatosT':
        CantidadDatosT();
        break;
    case 'ObtenerFuncionJs':
        ObtenerFuncionJs();
        break;
    case 'ModalGeneralEliminar':
        ModalGeneralEliminar();
        break;
        case 'EliminarGeneral':
            EliminarGeneral();
            break;
}

//Metodo para la paginacion de la tabla
function ListarPaginacion()
{
    $Pagina = $_POST['Pagina'];
    $Busca = $_POST['Busca'];
    $Registros = $_POST['CantidadDatos'];
    $Conexion = new PDODB();
    $Conexion->Conectar();
    session_start();

    $MainModel = new Main($Conexion);

    $MainModel->ListarPaginacion($Pagina, $Busca, $Registros);

}



//Metodo para cambiar la cantidad de datos que se muestran  
function CantidadDatosT()
{
    $CantidadDatos = $_POST['CantidadDatos'];
    $Busca = $_POST['Busca'];
    $Conexion = new PDODB();
    $Conexion->Conectar();
    session_start();
    $NombreColumnas = $_SESSION["Columnas"];
    $InstruccionSql = $_SESSION["Instruccion"];
    $ConCol = count($NombreColumnas);
    $MainModel = new Main($Conexion);

    echo $MainModel->CantidadDatosT($ConCol,$NombreColumnas, $Busca, $InstruccionSql, $CantidadDatos
);
    
}

function ObtenerFuncionJs()
{
    session_start();
    echo $_SESSION["Funcion"];
}



//Insanisima parte hecha por yo ps para ahorrar tiempo
function ModalGeneralEliminar(){
    $Id = $_POST["Id"];
    $NombreTabla = $_POST["NombreTabla"];
    $NombreId = $_POST["NombreId"];
    $FuncionListar = $_POST["FuncionListar"];
    echo'<center><h3>¿Está seguro de eliminarlo?</h3></center>
    <input id="NombreTabla" value="'.$NombreTabla.'" type="hidden">
    <input id="NombreId" value="'.$NombreId.'" type="hidden">
    <input id="Id" value="'.$Id.'" type="hidden">
    <input id="FuncionListar" value="'.$FuncionListar.'" type="hidden">
    <div class="Boton">
    <button class="btn-azul" id="registrar" onclick="EliminarGeneral()">Aceptar</button>
    <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
    </div>
    ';
}

// Despeguelo hp 
// <img title="Eliminar" class="icon" onclick="window.modal.showModal(); ModalGeneralEliminar(\'NombreListar\', \'NombreTabla\', \'NombreId\', ' . $fila['IdEnCuestion'] . ')" src="Assets/Img/Iconos/basura.svg" alt="">
function EliminarGeneral(){
    $Id = $_POST['Id'];
    $NombreTabla = $_POST['NombreTabla'];
    $NombreId = $_POST['NombreId'];
  $Conexion = new PDODB();
  $Conexion->Conectar();
  $MainModel = new Main($Conexion);

  echo $MainModel->EliminarGeneral($Id, $NombreTabla, $NombreId);

}


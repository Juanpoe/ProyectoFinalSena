<?php
require_once '../Modelo/Conexion.php';

require_once '../Modelo/Usuario.php';

switch ($_POST['Metodo']) {
    case 'RegistrarUsuario':
        RegistrarUsuario();
        break;
    case 'ListarUsuario':
        ListarUsuario();
        break;
    case 'ConsultarUsuario':
        ConsultarUsuario();
        break;
    case 'ModificarUsuario':
        ModificarUsuario();
        break;
    case 'DesactivarActivarUsuario':
        DesactivarActivarUsuario();
        break;
    case 'MostrarRolesEmpleados':
        MostrarRolesEmpleados();
        break;
        case 'ModalDesactivarUsuario':
            ModalDesactivarUsuario();
            break;
}

function RegistrarUsuario()
{
    $IdRol = $_POST['IdRol'];
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST["Apellido"];
    $TipoDocumento = $_POST['TipoDocumento'];
    $Documento = $_POST['Documento'];
    $Correo = $_POST['Correo'];
    $Telefono = $_POST['Telefono'];
    $Direccion = $_POST['Direccion'];
    $Contrasena = $_POST['Contrasena'];
    $Salt = 'MaxiSoft';
    $ContraseñaEncryptada =  hash('sha512', $Salt . $Contrasena);
    $Estado = true;

    $Conexion = new PDODB();

    $Conexion->Conectar();

    $UsuarioModel = new Usuario($Conexion);

    $Resultado = $UsuarioModel->RegistrarUsuario($IdRol,$Nombre,$Apellido,$TipoDocumento,$Documento,$Correo,$ContraseñaEncryptada,$Telefono,$Direccion,$Estado);
    
    echo $Resultado;
}










function MostrarRolesEmpleados()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();

    
    $UsuarioModel = new Usuario($Conexion);
    $UsuarioModel->MostrarRolesEmpleados();
}






function ListarUsuario()
{
    session_start();
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $BusquedaUsuario = $_POST['BusquedaUsuario'];
    $Columnas = ["NombreRol", "Nombre", "Apellido", "TipoDocumento", "Documento", "Correo", "Telefono", "Direccion", "Estado"];

    $Conexion = new PDODB();

    $Conexion->Conectar();

    $UsuarioModel = new Usuario($Conexion);

    $UsuarioModel->ListarUsuario($Columnas, $Orden, $Inicio, $Registros,$BusquedaUsuario);
}

function ConsultarUsuario()
{
    session_start();
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdUsuario = $_POST['IdUsuario'];
    $UsuarioModel = new Usuario($Conexion);
    $UsuarioModel->ConsultarUsuario($IdUsuario);

}

function ModificarUsuario()
{
    session_start();
    $Conexion = new PDODB();

    $Conexion->Conectar();

    $IdUsuario = $_POST['IdUsuario'];
    $IdRol = $_POST['IdRol'];
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST["Apellido"];
    $TipoDocumento = $_POST['TipoDocumento'];
    $Documento = $_POST['Documento'];
    $Correo = $_POST['Correo'];
    $Telefono = $_POST['Telefono'];
    $Direccion = $_POST['Direccion'];

  

    $UsuarioModel->Conectar();  
    $UsuarioModel = new Usuario($Conexion);

    $Resultado = $Conexion->ModificarUsuario($IdUsuario,$IdRol ,$Nombre,$Apellido,$TipoDocumento ,$Documento ,$Correo,$Telefono,$Direccion);
    echo $Resultado;
}

function DesactivarActivarUsuario()
{

    $Conexion = new PDODB();

    $Conexion->Conectar();

    $tablaUsuario = "usuario";

    $IdUsuario = $_POST['IdUsuario'];
    $Estado = $_POST['Estado'];
    $ArrayTablasRelacionadas = array();

    if ($Estado == 1) {
        $Estado = 0;
    } else {
        $Estado = 1;
    }

    $UsuarioModel = new Usuario($Conexion);

    $Resultado = $UsuarioModel->DesactivarActivarUsuario($tablaUsuario,$IdUsuario,$Estado,$ArrayTablasRelacionadas);
    echo $Resultado;
}


function ModalDesactivarUsuario(){
    $Id = $_POST["Id"];
    $Estado = $_POST["Estado"];
    echo'
    <form action=""><center><h3>¿Está seguro de cambiar el estado?</h3></center>
    <input id="Id" value="'.$Id.'" type="hidden">
    <input id="Estado" value="'.$Estado.'" type="hidden">
    <div class="Boton">
    <button class="btn-azul" id="registrar" onclick="DesactivarActivarUsuario()">Aceptar</button>
    <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
</form>
    ';
}
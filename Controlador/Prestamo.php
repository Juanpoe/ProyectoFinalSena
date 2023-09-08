<?php
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Prestamo.php';
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
    $PrestamoModel = new Prestamo($Conexion);
    $PrestamoModel->ListarRealizarP($Inicio, $Orden, $Busca, $Registros, $Columnas);
}

function Prestar()
{
    $Ides = $_POST['Ides'];
    $Cantidad = $_POST['Cantidades'];
    $IdEmpleado = $_POST['IdEmpleado'];
    date_default_timezone_set('America/Mexico_City');

    $Conexion = new PDODB();

    $Conexion->Conectar();

    //validar si ya se ha prestado
    $PrestamoModel = new Prestamo($Conexion);

    $Resultado = $PrestamoModel->Prestar($Ides, $Cantidad, $IdEmpleado);
    echo $Resultado;
}

function ListarNombresEmpleado()
{
    $Conexion = new PDODB();

    $Conexion->Conectar();
    $PrestamoModel = new Prestamo($Conexion);

    $Resultado = $PrestamoModel->ListarNombresEmpleado();
    
    echo $Resultado;
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


    $PrestamoModel = new Prestamo($Conexion);

    $Resultado = $PrestamoModel->ListarPrestamos($Inicio, $Orden, $Busca, $Registros, $Columnas, $NombreRol);

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
  
    $PrestamoModel = new Prestamo($Conexion);

    $Resultado = $PrestamoModel->ListarPrestamoDañado($Inicio, $Orden, $Busca, $Registros, $Columnas, $NombreRol);
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

    $PrestamoModel = new Prestamo($Conexion);

    $Resultado = $PrestamoModel->DevolverHerramienta($IdPrestamo, $Select, $CantidadDañado, $Observacion, $CantidadDevolver);
 
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
    $PrestamoModel = new Prestamo($Conexion);
    $PrestamoModel->ModalModificarPrestamo($IdPrestamo);
};


function ModificarPrestamo()
{
    $IdPrestamo = $_POST["IdPrestamo"];
    $CantidadPrestamo = $_POST["CantidadPrestamo"];
    $Conexion = new PDODB();

    $Conexion->Conectar();
    $PrestamoModel = new Prestamo($Conexion);

    $Modificado = $PrestamoModel->ModificarPrestamo($IdPrestamo, $CantidadPrestamo);
    
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
    $PrestamoModel = new Prestamo($Conexion);

    $PrestamoModel->ModalDevolverHerramienta($IdPrestamo);
    
};





























function DevolverDañada()
{
    $Id = $_POST['Id'];
    $Cantidad = $_POST['Cantidad'];
    $CantidadArreglada = $_POST['CantidadArreglada'];

    $Conexion = new PDODB();

    $Conexion->Conectar();


     $PrestamoModel = new Prestamo($Conexion);

     $Resultado = $PrestamoModel->DevolverDañada($Id, $Cantidad, $CantidadArreglada);

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
            <h3>¿Cuántas herramientas se han arreglado o repuesto?</h3>
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
    $PrestamoModel = new Prestamo($Conexion);

    $Modificado = $PrestamoModel->ModificarDanada($Id, $Observacion);

    if ($Modificado == true) {
        echo "Modificado correctamente";
    } else {
        echo "No fue posible modificar";
    }
}

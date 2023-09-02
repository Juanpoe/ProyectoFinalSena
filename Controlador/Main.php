<?php

require_once '../Modelo/Conexion.php';
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
    $Funcion = $_SESSION['Funcion'];
    $Columnas = $_SESSION["Columnas"];
    $InstruccionSql =  $_SESSION["Instruccion"];
    $ConCol = count($Columnas);
    $InstruccionSql .= " AND (";
    for ($i = 0; $i < $ConCol; $i++) {
        $InstruccionSql .= $Columnas[$i] . " LIKE '%" . $Busca . "%' OR ";
    }
    $InstruccionSql = substr_replace($InstruccionSql, "", -3);
    $InstruccionSql .= ")";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);
    $CantPaginas = 0;
    foreach ($Resultado as $key => $Value) {
        $CantPaginas = $CantPaginas + 1;
    }
    $Paginas = ceil($CantPaginas / $Registros);
    $Actual = 0;
    if ($Pagina > 1 && $Paginas > 5) {

        echo '<li class="li_pagina" onclick="' . $Funcion . '(' . ($Pagina - 1) . '); ListarPaginacion(' . ($Pagina - 1) . ', \'' . $Funcion . '\');">Anterior</li>';
    } else if ($Pagina == 1 && $Paginas > 2) {
        echo '<li class="li_pagina inactivopagina">Anterior</li>';
    }
    for ($i = 0; $i < $Paginas; $i++) {
        $Actual = $Actual + 1;
        if ($Paginas != 1 && $Actual < ($Pagina + 3) && $Actual > ($Pagina - 3)) {
            if ($Actual == $Pagina) {
                $Estilo = "activo_pagina";
            } else {
                $Estilo = "";
            }

            echo '<li class="li_pagina ' . $Estilo . '" onclick="' . $Funcion . '(' . $Actual . '); ListarPaginacion(' . $Actual . ', \'' . $Funcion . '\');">' . $Actual . '</li>';
        }
    }
    if ($Pagina < $Paginas && $Paginas > 5) {

        echo '<li class="li_pagina" onclick="' . $Funcion . '(' . ($Pagina + 1) . '); ListarPaginacion(' . ($Pagina + 1) . ', \'' . $Funcion . '\');">Siguiente</li>';
    } else if ($Pagina == $Paginas && $Paginas > 2) {
        echo '<li class="li_pagina inactivopagina">Siguiente</li>';
    }
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
    $InstruccionSql .= " AND (";
    for ($i = 0; $i < $ConCol; $i++) {
        $InstruccionSql .= $NombreColumnas[$i] . " LIKE '%" . $Busca . "%' OR ";
    }
    $InstruccionSql = substr_replace($InstruccionSql, "", -3);
    $InstruccionSql .= ")";


    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);
    $CantPaginas = 0;
    foreach ($Resultado as $key => $Value) {
        $CantPaginas = $CantPaginas + 1;
    }
    if ($CantidadDatos > $CantPaginas) {
        $CantidadDatos = $CantPaginas;
    }
    echo 'Mostrando 1 a ' . $CantidadDatos . ' de ' . $CantPaginas . ' entradas';
}

function ObtenerFuncionJs()
{
    session_start();
    echo $_SESSION["Funcion"];
}

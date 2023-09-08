<?php
class Main {
    private $Conexion;

    public function __construct($Conexion) {
        $this->Conexion = $Conexion;
    }


    public function ListarPaginacion($Pagina, $Busca, $Registros)
{
    try {
        //code...
    $Funcion = $_SESSION['Funcion'];
    $Columnas = $_SESSION["Columnas"];
    $InstruccionSql = $_SESSION["Instruccion"];
    $ConCol = count($Columnas);
    $InstruccionSql .= " AND (";
    for ($i = 0; $i < $ConCol; $i++) {
        $InstruccionSql .= $Columnas[$i] . " LIKE '%" . $Busca . "%' OR ";
    }
    $InstruccionSql = substr_replace($InstruccionSql, "", -3);
    $InstruccionSql .= ")";
    if ($_SESSION['Funcion'] == "ListarAgendamientoAdministrador"){
        $InstruccionSql .= "GROUP BY agendamiento.IdAgendamiento ";
    }
    $Resultado = $this->Conexion->ObtenerDatos($InstruccionSql);
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
} catch (\Throwable $th) {
}
}

public function CantidadDatosT($ConCol,$NombreColumnas, $Busca, $InstruccionSql, $CantidadDatos)
{
    $InstruccionSql .= " AND (";
    for ($i = 0; $i < $ConCol; $i++) {
        $InstruccionSql .= $NombreColumnas[$i] . " LIKE '%" . $Busca . "%' OR ";
    }
    $InstruccionSql = substr_replace($InstruccionSql, "", -3);
    $InstruccionSql .= ")";
    if ($_SESSION['Funcion'] == "ListarAgendamientoAdministrador"){
        $InstruccionSql .= "GROUP BY agendamiento.IdAgendamiento ";
    }

    $Resultado = $this->Conexion->ObtenerDatos($InstruccionSql);
    $CantPaginas = 0;
    foreach ($Resultado as $key => $Value) {
        $CantPaginas = $CantPaginas + 1;
    }
    if ($CantidadDatos > $CantPaginas) {
        $CantidadDatos = $CantPaginas;
    }
    return 'Mostrando 1 a ' . $CantidadDatos . ' de ' . $CantPaginas . ' entradas';
}
public function EliminarGeneral($Id, $NombreTabla, $NombreId){
  try {
    $consultaInfoUsuario = "SHOW CREATE TABLE ".$NombreTabla;
    $resultadoInfoUsuario = $this->Conexion->EjecutarInstruccion($consultaInfoUsuario);
    $definicionUsuario = $resultadoInfoUsuario->fetchColumn(1);
} catch (PDOException $e) {
    return "Error al obtener información de la tabla Usuario: " . $e->getMessage();
}
try {
    $consultaTablasRelacionadas = "SHOW TABLES";
    $resultadoTablasRelacionadas = $this->Conexion->EjecutarInstruccion($consultaTablasRelacionadas);

    while ($filaTablaRelacionada = $resultadoTablasRelacionadas->fetch(PDO::FETCH_NUM)) {
        $tablaRelacionada = $filaTablaRelacionada[0];

        if ($tablaRelacionada != $NombreTabla) {
            $consultaInfoTablaRelacionada = "SHOW CREATE TABLE $tablaRelacionada";
            $resultadoInfoTablaRelacionada = $this->Conexion->EjecutarInstruccion($consultaInfoTablaRelacionada);
            $definicionTablaRelacionada = $resultadoInfoTablaRelacionada->fetchColumn(1);

            if (strpos($definicionTablaRelacionada, 'FOREIGN KEY (`'.$NombreId.'`) REFERENCES `'.$NombreTabla.'` (`'.$NombreId.'`)') !== false) {

                // Verificar si hay datos relacionados
                $consultaDatosRelacionados = "SELECT * FROM $tablaRelacionada WHERE ".$NombreId." IN (SELECT ".$NombreId." FROM ".$NombreTabla." WHERE ".$NombreId." = $Id)";
                $resultadoDatosRelacionados = $this->Conexion->EjecutarInstruccion($consultaDatosRelacionados);

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
    return "Error al buscar tablas relacionadas: " . $e->getMessage();

}

if (empty($ArrayTablasRelacionadas)) {
    $Sqly = "DELETE FROM ".$NombreTabla."
    WHERE ".$NombreId." = " . $Id;

    $Eliminado = $this->Conexion->EjecutarInstruccion($Sqly);

    if ($Eliminado == true) {
        return "Eliminado correctamente";
    } else {
        return "No fue posible eliminar";
    }
} else {
    $Text = "";
    $Text .= "El registro tiene datos relacionados en los siguientes modulos: ";
    for ($i = 0; $i < count($ArrayTablasRelacionadas); $i++) {
        $Text .= $ArrayTablasRelacionadas[$i] . " ";
    }
    return $Text;
}
}


}
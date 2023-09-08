<?php
class SolicitarPrestamo {
    private $Conexion;

    public function __construct($Conexion) {
        $this->Conexion = $Conexion;
    }

    public function ListarHerramientas($Columnas,$Pagina, $Registros, $Inicio, $Orden, $Busca)
{
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
    $Resultado = $this->Conexion->ObtenerDatos($InstruccionSql);

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

public function GuardarSolicitud($IdHerramienta,$Cantidad,$Observacion,$IdUsuario,$FechaActual){
  
            $InstruccionSQL = "INSERT INTO solicitudprestamo
            VALUES
            (null,'" . $IdHerramienta . "', '" . $IdUsuario . "','".$Cantidad."' ,'" . $Observacion . "','" . $FechaActual . "', 2)";

            $Resultado = $this->Conexion->EjecutarInstruccion($InstruccionSQL);
            echo "Se ha realizado la solicitud";
        }

public function ListarPrestamosSolicitados($Pagina, $Registros, $Inicio, $Orden, $Busca, $Columnas, $NombreRol){
        
            //Cambiar esto por la instruccion del sql
            $InstruccionSql = "SELECT 
            solicitudprestamo.IdSolicitudPrestamo,
            solicitudprestamo.IdHerramientaInsumo,
            solicitudprestamo.IdUsuario,
            usuario.Apellido,
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
            $Resultado = $this->Conexion->ObtenerDatos($InstruccionSql);
        
            $ResultadoContar = count($Resultado);
            if ($ResultadoContar > 0) {
        
                foreach ($Resultado as $key => $Value) {
                    //Ya esto cada quien
                    $InstruccionSql = "SELECT * 
                    FROM herramientainsumo
                    WHERE IdHerramientaInsumo = ".$Value['IdHerramientaInsumo'];  
                    $Resultado = $this->Conexion->ObtenerDatos($InstruccionSql);  
                    foreach ($Resultado as $key => $Values) {
                        $CantidadH = $Values['Cantidad'];
                        $EstadoH = $Values['Estado'];
                    }
                    $InstruccionSql = "SELECT * 
                    FROM prestamo
                    WHERE Idusuario = ".$Value['IdUsuario']." AND Estado = 1 AND IdHerramientaInsumo = ".$Value['IdHerramientaInsumo'];  
                    $Resultado = $this->Conexion->ObtenerDatos($InstruccionSql);  
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
                <td class="pt-3-half" data-th="Empleado" contenteditable="false">' . $Value['NombreUsuario'] . ' ' . $Value['Apellido'] . '</td>
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
                <img title="Eliminar" class="icon" onclick="window.modal.showModal(); ModalGeneralEliminar(\'ListarPrestamosSolicitados\', \'solicitudprestamo\', \'IdSolicitudPrestamo\', ' . $Value['IdSolicitudPrestamo'] . ')" src="Assets/Img/Iconos/basura.svg" alt="">
                ';}
                else{
                    echo'<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';
                }
            }
            // Administrador
                else{
                    if ($Value['EstadoSolicitud'] == 2 && $ValidacionH == 0){
                        echo'
                    <img src="Assets/Img\Iconos\check.svg" title="Aceptar" class="icon" onclick="ModalAceptarSolicitudPrestamo('.$Value['IdSolicitudPrestamo'].', '.$Value['CantidadSolicitud'].', '.$Value['IdHerramientaInsumo'].', '.$Value['IdUsuario'].');">
                    <img src="Assets/Img\Iconos\x.svg" title="Rechazar" class="icon" onclick="ModalRechazarSolicitudPrestamo('.$Value['IdSolicitudPrestamo'].');">
                    <img title="Eliminar" class="icon" onclick="window.modal.showModal(); ModalGeneralEliminar(\'ListarPrestamosSolicitados\', \'solicitudprestamo\', \'IdSolicitudPrestamo\', ' . $Value['IdSolicitudPrestamo'] . ')" src="Assets/Img/Iconos/basura.svg" alt="">
                    ';}
                    else if($Value['EstadoSolicitud'] == 2){
                        echo'
                        <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                        <img src="Assets/Img\Iconos\x.svg" title="Rechazar" class="icon" onclick="ModalRechazarSolicitudPrestamo('.$Value['IdSolicitudPrestamo'].');">
                        <img title="Eliminar" class="icon" onclick="window.modal.showModal(); ModalGeneralEliminar(\'ListarPrestamosSolicitados\', \'solicitudprestamo\', \'IdSolicitudPrestamo\', ' . $Value['IdSolicitudPrestamo'] . ')" src="Assets/Img/Iconos/basura.svg" alt="">';
                    }
                    else{
                        echo'<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                        <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                        <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                        ';
                    }
                }
                echo'</td>
            </tr>';
                }
            } else {
                echo '<td colspan="9">Sin resultados</td>';
            }
        }

        function EditarSolicitud($IdSolicitud, $CantidadSolicitud, $Observacion){
            $InstruccionSQL = "UPDATE solicitudprestamo SET CantidadSolicitud = " . $CantidadSolicitud . ",
            Observacion = '".$Observacion."'
                 WHERE IdSolicitudPrestamo = " . $IdSolicitud;
        
            return $Modificado = $this->Conexion->EjecutarInstruccion($InstruccionSQL);
        }
        function RechazarSolicitudPrestamo($IdSolicitud){
         
        
            $InstruccionSQL = "UPDATE solicitudprestamo SET Estado = 0
                 WHERE IdSolicitudPrestamo = " . $IdSolicitud;
        
            return $this->Conexion->EjecutarInstruccion($InstruccionSQL);
        

        }

        public function ActHerramienta($Id, $Cantidad, $Operacion)
{
    $InstruccionSQL = "SELECT * FROM herramientainsumo WHERE IdHerramientaInsumo= '" . $Id . "'";

    $Resultado = $this->Conexion->ObtenerDatos($InstruccionSQL);

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

    $Resultado = $this->Conexion->EjecutarInstruccion($InstruccionSQL);
}
public function AceptarSolicitudPrestamo($IdSolicitud, $CantidadSolicitud, $IdHerramienta, $IdUsuario){


    $InstruccionSQL = "UPDATE solicitudprestamo SET Estado = 1
         WHERE IdSolicitudPrestamo = " . $IdSolicitud;

    $Modificado = $this->Conexion->EjecutarInstruccion($InstruccionSQL);


    $FechaActual = date("d-m-Y");
    $InstruccionSQL = "INSERT INTO prestamo
    VALUES
    (null,'" . $IdUsuario . "', '" . $IdHerramienta . "','".$FechaActual."' ,'" . $CantidadSolicitud . "', 1)";

    $Resultado = $this->Conexion->EjecutarInstruccion($InstruccionSQL);
    $this->ActHerramienta($IdHerramienta, $CantidadSolicitud, "-");

    if ($Modificado == true && $Resultado == true) {
        return "Se ha cambiado el estado y creado el prestamo";
    } else {
        return "No fue posible cambiar el estado";
    }
}
}
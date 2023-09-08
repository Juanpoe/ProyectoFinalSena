<?php
class Servicio {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function GuardarServicio($Nombre, $Estado) {
        $InstruccionSQL = "SELECT * FROM servicio;";
  
        $Resultado = $this->conexion->ObtenerDatos($InstruccionSQL);
    
        foreach ($Resultado as $key => $Value) {
          if (strtolower($Value['NombreServicio']) == strtolower($Nombre)){   
              return false;
          } 
        }
    
        $InstruccionSQL = "INSERT INTO servicio 
            VALUES
            (null,'" .  $Nombre . "','" .  $Estado . "')";
    
        $resultado = $this->conexion->EjecutarInstruccion($InstruccionSQL);
        return $resultado;
    }
    
    public function ListarServicio($NombreRol, $Registros, $Inicio, $Orden, $Busca, $Columnas) {
        $InstruccionSql = "SELECT IdServicio,NombreServicio,EstadoServicio FROM servicio WHERE IdServicio > 0";

        $_SESSION["Columnas"] = $Columnas;
        $_SESSION["Instruccion"] = $InstruccionSql;
        //Cambiar esto por el nombre de la funcion de listar
        $_SESSION["Funcion"] = "ListarServicios";
        $ConCol = count($Columnas);
        if (!empty($Busca)) {
            $InstruccionSql .= " AND (";
            for ($i = 0; $i < $ConCol; $i++) {
                $InstruccionSql .= $Columnas[$i] . " LIKE '%" . $Busca . "%' OR ";
            }
            $InstruccionSql = substr_replace($InstruccionSql, "", -3);
            $InstruccionSql .= ")";
        }
    
        $InstruccionSql .= " GROUP BY Servicio.IdServicio ";
        if ($Orden[0] != " ") {
            $InstruccionSql .= "ORDER BY $Orden[1] $Orden[0] ";
        }
        $InstruccionSql .= "LIMIT $Inicio, $Registros";
    
        $resultado = $this->conexion->ObtenerDatos($InstruccionSql);
    
        $NombreRol = $_SESSION["Rol"];
        
        $ResultadoContar = count($resultado);
        if ($ResultadoContar > 0) {
        foreach ($resultado as $fila) {
            $StringEstado = "";
            if ($fila['EstadoServicio'] == "1") {
                $StringEstado = "Activo";
            } else {
                $StringEstado = "Desactivado";
            }
            echo '
            <tr>
            <td data-th="Id">', $fila['IdServicio'], '</td>
            <td data-th="Nombre">', $fila['NombreServicio'], '</td>
            <td data-th="Estado"><buttom class="Estado Activo">', $StringEstado, ' </buttom> ', '</td>';
            if ($NombreRol == 1) {
                echo '
          <td data-th="Operaciones">
          ';
            if ($fila['EstadoServicio'] == 1) {
                echo '<Img onclick="ModalListarServicio(' . $fila['IdServicio'] . ')" src="Assets/Img/Iconos/editar.svg" title="Editar" alt="" class="icon">
                <img title="Eliminar" class="icon" onclick="window.modal.showModal(); ModalGeneralEliminar(\'ListarServicios\', \'servicio\', \'IdServicio\', ' . $fila['IdServicio'] . ')" src="Assets/Img/Iconos/basura.svg" alt="">
                ';
            } else {
                echo '<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"> <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';
            }
            echo '  
            <Img class="icon" title="
            ';
            if ($fila['EstadoServicio'] == 1) {
                echo 'Desactivar';
            } else {
                echo 'Activar';
            }
            echo
            '" onclick="ModalDesactivarServicio(', $fila['IdServicio'], ',', $fila['EstadoServicio'], ');" src="Assets/Img\Iconos\desactivar.svg" alt="">
        </td>
            </tr>
           
            ';
        }}
    } else {
        echo '<td colspan="9">Sin resultados</td>';
    }
      
    }


    public function ModalListarServicio($IdServicio){
        $sql = "SELECT * FROM servicio WHERE IdServicio  = " . $IdServicio;
        $lista = $this->conexion->ObtenerDatos($sql);
    
        foreach ($lista as $key => $value) {
            echo '
            <form action="" Id="ModalServicio">
            <input id="Servicio" type="hidden" value = "' . $value['IdServicio'] . '">
            <p>Nombre Del Servicio</p>
            <input type="text" id="NombredelServicio" onkeyup="ValidarNombredelServicio(this)" value="' . $value['NombreServicio'] . '" placeholder="Ingrese nombre del Servicio">
            <br>
            <span id="NombredelServicioError"></span>
            <div class="Boton">
            <button class="btn-azul" id="CrearServicio2" onclick="ModificarListar()" type="submit">Modificar</button>
            <button class="btn-rojo" id="CancelarServicio" onclick=CerrarModal();>Cancelar</button>
            </div>
        </div>
        </form>
        ';
        }
    }

    public function DesactivarServicio($Estado, $IdServicio){

        $Sql = "UPDATE servicio SET EstadoServicio = '" . $Estado . "'
    WHERE IdServicio = " . $IdServicio;

        $Modificado = $this->conexion->EjecutarInstruccion($Sql);

        return $Modificado;
    }

    public function ModificarListar($IdServicio, $Nombre, $Estado){
        $InstruccionSQL = "SELECT * FROM servicio WHERE IdServicio != ".$IdServicio;

        $Resultado = $this->conexion->ObtenerDatos($InstruccionSQL);
    
        foreach ($Resultado as $key => $Value) {
                if (strtolower($Value['NombreServicio']) == strtolower($Nombre)) {
                    return false;
                }    
        }
    
        $sql = " SELECT NombreServicio FROM servicio WHERE EstadoServicio = 1";
    
        $sql = "UPDATE Servicio SET 
            NombreServicio = '" . $Nombre . "',
            EstadoServicio = '" . $Estado . "'
            WHERE IdServicio = " . $IdServicio;
    
        $modificado = $this->conexion->EjecutarInstruccion($sql);

        return $modificado;
    }
}
?>
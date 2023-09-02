<?php
include("../Modelo/Conexion.php");
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

    $InstruccionSQL = "SELECT * FROM servicio;";
  
    $Resultado = $conexion->ObtenerDatos($InstruccionSQL);

    foreach ($Resultado as $key => $Value) {
      if ($Value['NombreServicio'] == $Nombre){
          echo "Ya existe un servicio con el mismo nombre";
          return;
      } 
    }

    $InstruccionSQL = "INSERT INTO servicio 
        VALUES
        (null,'" .  $Nombre . "','" .  $Estado . "')";

    $resultado = $conexion->EjecutarInstruccion($InstruccionSQL);

    if ($resultado == true) {
        echo "Registrado Correctamente";
    } else {
        echo "No fue posible guardar";
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


   
    $resultado = $conexion->ObtenerDatos($InstruccionSql);

    $NombreRol = $_SESSION["Rol"];
    foreach ($resultado as $fila) {
        $StringEstado = "";
        if ($fila['EstadoServicio'] == "1") {
            $StringEstado = "Activo";
        } else {
            $StringEstado = "Desactivado";
        }


        $estadoValue = $fila['EstadoServicio'];

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
            echo '<Img onclick="ModalListarServicio(' . $fila['IdServicio'] . ')" src="Assets/Img/Iconos/editar.svg" title="Editar" alt="" class="icon">';
        } else {
            echo '<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';
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
}

function DesactivarServicio()
{

    $conexion = new PDODB();

    $conexion->Conectar();

    $tablaServicio = "servicio";

    $IdServicio = $_POST['IdServicio'];
    $Estado = $_POST['Estado'];
    $ArrayTablasRelacionadas = array();

    if ($Estado == 1) {
        $Estado = 0;
    } else {
        $Estado = 1;
    }

    try {
        $consultaInfoServicio = "SHOW CREATE TABLE $tablaServicio";
        $resultadoInfoServicio = $conexion->EjecutarInstruccion($consultaInfoServicio);
        $definicionServicio = $resultadoInfoServicio->fetchColumn(1);
    } catch (PDOException $e) {
        echo "Error al obtener información de la tabla servicios: " . $e->getMessage();
        return;
    }

    try {
        $consultaTablasRelacionadas = "SHOW TABLES";
        $resultadoTablasRelacionadas = $conexion->EjecutarInstruccion($consultaTablasRelacionadas);

        while ($filaTablaRelacionada = $resultadoTablasRelacionadas->fetch(PDO::FETCH_NUM)) {
            $tablaRelacionada = $filaTablaRelacionada[0];

            if ($tablaRelacionada != $tablaServicio) {
                $consultaInfoTablaRelacionada = "SHOW CREATE TABLE $tablaRelacionada";
                $resultadoInfoTablaRelacionada = $conexion->EjecutarInstruccion($consultaInfoTablaRelacionada);
                $definicionTablaRelacionada = $resultadoInfoTablaRelacionada->fetchColumn(1);

                if (strpos($definicionTablaRelacionada, 'FOREIGN KEY (`IdServicio`) REFERENCES `servicio` (`IdServicio`)') !== false) {

                    // Verificar si hay datos relacionados
                    $consultaDatosRelacionados = "SELECT * FROM $tablaRelacionada WHERE IdServicio IN (SELECT IdServicio FROM servicio WHERE IdServicio = $IdServicio)";
                    $resultadoDatosRelacionados = $conexion->EjecutarInstruccion($consultaDatosRelacionados);

                    if ($resultadoDatosRelacionados->rowCount() > 0) {
                        $ArrayTablasRelacionadas[] = " " . $tablaRelacionada;
                    }
                }
            }
        }
    } catch (PDOException $e) {
        echo "Error al buscar tablas relacionadas: " . $e->getMessage();
        return;
    }

    if (empty($ArrayTablasRelacionadas)) {

        $Sql = "UPDATE servicio SET EstadoServicio = '" . $Estado . "'
    WHERE IdServicio = " . $IdServicio;

        $Modificado = $conexion->EjecutarInstruccion($Sql);

        if ($Modificado == true && $Estado == 0) {
            echo "Desactivado correctamente";
        } else if ($Modificado == true && $Estado == 1) {
            echo "Activado correctamente";
        } else {
            echo "No fue posible modificar";
        }
    } else {
        echo "El servicio tiene datos relacionados en los siguientes modulos: ";
        for ($i = 0; $i < count($ArrayTablasRelacionadas); $i++) {
            echo $ArrayTablasRelacionadas[$i] . " ";
        }
    }
}


function ModalListarServicio()
{
    $conexion = new PDODB();
    $conexion->Conectar();
    $IdServicio = $_POST['IdServicio'];
    $sql = "SELECT * FROM servicio WHERE IdServicio  = " . $IdServicio;
    $lista = $conexion->ObtenerDatos($sql);

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


function ModificarListar()
{

    $IdServicio = $_POST["IdServicio"];
    $Nombre = $_POST["Nombre"];
    $Estado = 1;


    $conexion = new PDODB();

    $conexion->Conectar();

    $InstruccionSQL = "SELECT * FROM servicio WHERE IdServicio != ".$IdServicio;

    $Resultado = $conexion->ObtenerDatos($InstruccionSQL);

    foreach ($Resultado as $key => $Value) {
            if ($Value['NombreServicio'] == $Nombre) {
                echo "Ya existe un servicio con el mismo nombre";
                return;
            }
        
    }

    $sql = " SELECT NombreServicio FROM servicio WHERE EstadoServicio = 1";

    $sql = "UPDATE Servicio SET 
        NombreServicio = '" . $Nombre . "',
        EstadoServicio = '" . $Estado . "'
        WHERE IdServicio = " . $IdServicio;

    $modificado = $conexion->EjecutarInstruccion($sql);

    if ($modificado == true) {
        echo "Modificado correctamente";
    } else {
        echo "No fue posible modificar";
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
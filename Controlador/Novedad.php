<?php
include("../Modelo/Conexion.php");
switch ($_POST['metodo']) {
    case 'GuardarNovedad':
        GuardarNovedad();
        break;
    case 'ListarNovedad':
        ListarNovedad();
        break;
    case 'ModalNovedad':
        ModalNovedad();
        break;
    case 'ModificarNovedad':
        ModificarNovedad();
        break;
    case 'ModalAceptarNovedad':
        ModalAceptarNovedad();
        break;
    case 'ModalRechazarNovedad':
        ModalRechazarNovedad();
        break;
    case 'AceptarRechazarNovedad':
        AceptarRechazarNovedad();
        break;
    case 'MostrarEmpleadosNovedad':
        MostrarEmpleadosNovedad();
        break;
    case 'ValidarFechaInicioPhp':
        ValidarFechaInicioPhp();
        break;
    case 'ValidarFechaFinPhp':
        ValidarFechaFinPhp();
        break;
    case 'ValidateFechaInicioVista':
        ValidateFechaInicioVista();
        break;
    case 'ValidateFechaFinVista':
        ValidateFechaFinVista();
        break;
    case 'ValidateFechaInicioYFinVista':
        ValidateFechaInicioYFinVista();
        break;
    case 'ValidateFechaInicioModificar':
        ValidateFechaInicioModificar();
        break;
    case 'ValidateFechaFinModificar':
        ValidateFechaFinModificar();
        break;
    case 'ValidateFechaInicioYFinModificar':
        ValidateFechaInicioYFinModificar();
        break;
}

function ValidarFechaInicioPhp()
{
    $IdNovedad = $_POST["IdNovedad"];
    $FechaInicio = $_POST["FechaInicio"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM novedad WHERE IdUsuario = $IdNovedad AND EstadoNovedad != 0";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        if ($FechaInicio == $Datos["FechaInicio"] || $FechaInicio == $Datos["FechaFinal"] || ($FechaInicio >= $Datos["FechaInicio"] && $FechaInicio <= $Datos["FechaFinal"])) {
            echo "No se puede " . $FechaInicio . " " . $Datos["FechaInicio"];
        }
    }
}

function ValidateFechaInicioModificar()
{
    $IdNovedad = $_POST["IdNovedad"];
    $IdUsuario = $_POST["IdUsuario"];
    $FechaInicio = $_POST["FechaInicio"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM novedad WHERE IdNovedad != $IdNovedad AND IdUsuario = $IdUsuario AND EstadoNovedad != 0";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        if ($FechaInicio == $Datos["FechaInicio"] || $FechaInicio == $Datos["FechaFinal"] || ($FechaInicio >= $Datos["FechaInicio"] && $FechaInicio <= $Datos["FechaFinal"])) {
            echo "No se puede " . $FechaInicio . " " . $Datos["FechaInicio"];
        }
    }
}
function ValidateFechaInicioVista()
{
    $IdUsuario = $_POST["IdNovedad"];
    $FechaInicio = $_POST["FechaInicio"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM novedad WHERE IdUsuario = $IdUsuario AND EstadoNovedad != 0";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        if ($FechaInicio == $Datos["FechaInicio"] || $FechaInicio == $Datos["FechaFinal"] || ($FechaInicio >= $Datos["FechaInicio"] && $FechaInicio <= $Datos["FechaFinal"])) {
            echo "No se puede " . $FechaInicio . " " . $Datos["FechaInicio"];
        }
    }
}

function ValidateFechaInicioYFinModificar()
{
    $IdNovedad = $_POST["IdNovedad"];
    $IdUsuario = $_POST["IdUsuario"];
    $FechaInicio = $_POST["FechaInicio"];
    $FechaFin = $_POST["FechaFin"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM novedad WHERE IdNovedad != $IdNovedad AND IdUsuario = $IdUsuario AND EstadoNovedad != 0";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        if (($FechaInicio <= $Datos["FechaInicio"] && $FechaFin >= $Datos["FechaFinal"])) {
            echo "No se puede " . $FechaInicio . " " . $Datos["FechaInicio"];
        }
    }
}

function ValidateFechaInicioYFinVista()
{
    $IdUsuario = $_POST["IdNovedad"];
    $FechaInicio = $_POST["FechaInicio"];
    $FechaFin = $_POST["FechaFin"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM novedad WHERE IdUsuario = $IdUsuario AND EstadoNovedad != 0";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        if (($FechaInicio <= $Datos["FechaInicio"] && $FechaFin >= $Datos["FechaFinal"])) {
            echo "No se puede " . $FechaInicio . " " . $Datos["FechaInicio"];
        }
    }
}

function ValidateFechaFinModificar()
{
    $IdNovedad = $_POST["IdNovedad"];
    $IdUsuario = $_POST["IdUsuario"];
    $FechaFin = $_POST["FechaFin"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM novedad WHERE IdNovedad != $IdNovedad AND IdUsuario = $IdUsuario AND EstadoNovedad != 0";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        if ($FechaFin == $Datos["FechaInicio"] || $FechaFin == $Datos["FechaFinal"] || ($FechaFin >= $Datos["FechaInicio"] && $FechaFin <= $Datos["FechaFinal"])) {
            echo "No se puede " . $FechaFin . " " . $Datos["FechaInicio"];
        }
    }
}
function ValidateFechaFinVista()
{
    $IdUsuario = $_POST["IdNovedad"];
    $FechaFin = $_POST["FechaFin"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM novedad WHERE IdUsuario = $IdUsuario AND EstadoNovedad != 0";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        if ($FechaFin == $Datos["FechaInicio"] || $FechaFin == $Datos["FechaFinal"] || ($FechaFin >= $Datos["FechaInicio"] && $FechaFin <= $Datos["FechaFinal"])) {
            echo "No se puede " . $FechaFin . " " . $Datos["FechaInicio"];
        }
    }
}

function ValidarFechaFinPhp()
{
    $IdNovedad = $_POST["IdNovedad"];
    $FechaFinal = $_POST["FechaFinal"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM novedad WHERE IdUsuario = $IdNovedad AND EstadoNovedad != 0";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        if ($FechaFinal == $Datos["FechaInicio"] || $FechaFinal == $Datos["FechaFinal"] || ($FechaFinal >= $Datos["FechaInicio"] && $FechaFinal <= $Datos["FechaFinal"])) {
            echo "No se puede " . $FechaFinal . " " . $Datos["FechaInicio"];
        }
    }
}

function MostrarEmpleadosNovedad()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM usuario WHERE Estado = 1";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        echo '<option value="' . $Datos["IdUsuario"] . '">' . $Datos["Nombre"] . ' ' . $Datos["Apellido"] . '</option>';
    }
}

function GuardarNovedad()
{
    session_start();
    date_default_timezone_set('America/Bogota');
    $IdUsuario = $_POST["IdNovedad"];
    $Peticion = $_POST["Peticion"];
    $Descripcion = $_POST["Descripcion"];
    $HoraInicio = $_POST["HoraInicio"];
    $HoraFinal = $_POST["HoraFinal"];
    $FechaInicio = $_POST["FechaInicio"];
    $FechaFinal = $_POST["FechaFinal"];
    $EstadoNovedad = 2;
    $FechaRegistro = date('d/m/Y H:i:s');

    $Conexion = new PDODB();

    $Conexion->Conectar();

    try {
        $InstruccionSQL = "INSERT INTO novedad VALUES (null,'" . $IdUsuario . "', '" . $Peticion . "','" . $Descripcion . "','" . $FechaRegistro . "','" . $FechaInicio . "','" . $FechaFinal . "','" . $HoraInicio . "', '" . $HoraFinal . "', '" . $EstadoNovedad . "')";
        $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);
        echo "Novedad guardada correctamente";
    } catch (PDOException $e) {
        echo "Error al insertar los datos: " . $e->getMessage();
    }
}

function listarNovedad()
{
    session_start();
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $BusquedaNovedad = $_POST['BusquedaNovedad'];
    $Columnas = ["Nombre", "Peticion", "Descripcion", "FechaRegistro", "FechaInicio", "FechaFinal", "HoraInicio", "HoraFinal"];

    $Conexion = new PDODB();

    $Conexion->Conectar();
    if ($_SESSION["Rol"] == 1) {
        $InstruccionSql = "SELECT * FROM novedad INNER JOIN usuario ON novedad.IdUsuario=usuario.IdUsuario WHERE IdNovedad > 0";
    } else {
        $InstruccionSql = "SELECT * FROM novedad INNER JOIN usuario ON novedad.IdUsuario = " . $_SESSION["IdUsuario"] . " AND usuario.IdUsuario = " . $_SESSION["IdUsuario"];
    }
    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    //Cambiar esto por el nombre de la funcion de listar
    $_SESSION["Funcion"] = "ListarNovedad";
    $ConCol = count($Columnas);
    $InstruccionSql .= " AND (";
    for ($i = 0; $i < $ConCol; $i++) {
        $InstruccionSql .= $Columnas[$i] . " LIKE '%" . $BusquedaNovedad . "%' OR ";
    }
    $InstruccionSql = substr_replace($InstruccionSql, "", -3);
    $InstruccionSql .= ")";
    if ($Orden[0] != " ") {
        $InstruccionSql .= "ORDER BY $Orden[1] $Orden[0] ";
    }
    $InstruccionSql .= "LIMIT $Inicio,$Registros";
    echo $InstruccionSql;
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);
    $ResultadoContar = count($Resultado);
    if ($ResultadoContar > 0) {
        foreach ($Resultado as $key => $fila) {
            echo '
            <tr class="tr_lista_listar_novedad">';
            if ($_SESSION["Rol"] == 1) {
                echo '<td data-th="Id">', $fila['IdNovedad'], '</td>';
            }
            echo '<td data-th="Nombre">', $fila['Nombre'], ' ', $fila['Apellido'], '</td>
                <td data-th="Fecha Registro">', $fila['FechaRegistro'], '</td>
                <td data-th="Peticion">', $fila['Peticion'], '</td>
                <td data-th="Descripcion">', $fila['Descripcion'], '</td>
                <td data-th="Fecha Inicio">', $fila['FechaInicio'], '</td>
                <td data-th="Fecha Final">', $fila['FechaFinal'], '</td>
                <td data-th="Hora Inicio">', $fila['HoraInicio'], '</td>
                <td data-th="Hora Final">', $fila['HoraFinal'], '</td>
                <td data-th="Estado"> <buttom class="';
            if ($fila["EstadoNovedad"] == 0) {
                echo "Estado Rechazado";
            } else if ($fila["EstadoNovedad"] == 1) {
                echo "Estado Aceptado";
            } else if ($fila["EstadoNovedad"] == 2) {
                echo "Estado Espera";
            };
            echo '"</buttom>';
            if ($fila["EstadoNovedad"] == 0) {
                echo "Rechazado";
            } else if ($fila["EstadoNovedad"] == 1) {
                echo "Aceptado";
            } else if ($fila["EstadoNovedad"] == 2) {
                echo "En Espera";
            }
            echo '</td>';
            if ($_SESSION["Rol"] == 1) {
                echo '<td data-th="Operaciones">
                <center>';
                if ($fila['EstadoNovedad'] == 1) {
                    echo '<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';
                } else if ($fila['EstadoNovedad'] == 2) {
                    echo '<a onclick="ModalNovedad(' . $fila['IdNovedad'] . ');">
                    <Img src="../Vista/Assets/Img/Iconos/editar.svg" class="icon" title="Editar" alt=""></a>
                    <a onclick="ModalAceptarNovedad(' . $fila['IdNovedad'] . ');">
                    <Img src="../Vista/Assets/Img/Iconos/check.svg" class="icon" title="Aceptar" alt=""></a>
                    <a onclick="ModalRechazarNovedad(' . $fila['IdNovedad'] . ');">
                    <Img src="../Vista/Assets/Img/Iconos/x.svg" class="icon" title="Rechazar" alt=""></a>
                    <img title="Eliminar" class="icon" onclick="window.modal.showModal(); ModalGeneralEliminar(\'ListarNovedad\', \'Novedad\', \'IdNovedad\', ' . $fila['IdNovedad'] . ')" src="Assets/Img/Iconos/basura.svg" alt="">
                    </center>';
                } else {
                    echo '<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';
                }
                echo '</center>
            </td>';
            } else {
                echo '<td data-th="Operaciones"><center>';
                if ($fila['EstadoNovedad'] == 1) {
                    echo '<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';
                } else if ($fila['EstadoNovedad'] == 2) {
                    echo '
                    <Img src="../Vista/Assets/Img/Iconos/editar.svg" onclick="ModalNovedad(' . $fila['IdNovedad'] . ');" class="icon" title="Editar" alt="">
                    <img title="Eliminar" class="icon" onclick="window.modal.showModal(); ModalGeneralEliminar(\'ListarNovedad\', \'Novedad\', \'IdNovedad\', ' . $fila['IdNovedad'] . ')" src="Assets/Img/Iconos/basura.svg" alt="">';
                } else {
                    echo '<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">';
                }
                echo '
                </center>
            </td>';
            }
            echo '</tr>
            ';
        }
    } else {
        echo '<tr>
            <td colspan="11">Sin resultados</td>
        </tr>';
    }
}

function AceptarRechazarNovedad()
{
    $IdNovedad = $_POST["IdNovedad"];
    $Cambio = $_POST["opcion"];

    $Conexion = new PDODB();

    $Conexion->Conectar();


    $InstruccionSQL = "UPDATE novedad SET EstadoNovedad = '" . $Cambio . "' WHERE IdNovedad = " . $IdNovedad;

    $Resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);

    if ($Cambio == 1 && $Resultado == true) {
        echo "Novedad aceptada con exito";
    } else if ($Cambio == 0 && $Resultado == true) {
        echo "Novedad rechazada con exito";
    } else {
        echo "Ups, hubo un error";
    }
}

function ModalNovedad()
{
    session_start();
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdNovedad = $_POST['IdNovedad'];
    $sql = "SELECT * FROM novedad INNER JOIN usuario ON novedad.IdUsuario = usuario.IdUsuario WHERE IdNovedad  = " . $IdNovedad;
    $lista = $Conexion->ObtenerDatos($sql);

    foreach ($lista as $key => $value) {
        echo '
       
        <input type="hidden" id="IdNovedadModal" name="IdNovedadModal" value="' . $value['IdNovedad'] . '">
        <div class="caja_registrar_novedad">';
        if ($_SESSION['Rol'] == 1) {
            echo '
            <!-- DIV FILA, ESTE AGRUPA DE A 2 INPUTS Y LOS PONE DE FORMA HORIZONTAL ----- HACIENDO QUE SE OCUPE EL ESPACIO DE FORMA MAS BONITA -->
            <div class="fila">
                <div class="item">
            <p>Nombre de usuario</p>
            <select name="IdUsuarioModal" id="IdUsuarioModal" onchange="ValidateFechaInicioModificar(); ValidateFechaFinModificar(); ValidateFechaInicioYFinModificar();">
                <option value="' . $value['IdUsuario'] . '">' . $value['Nombre'] . '</option>';
            MostrarEmpleadosNovedad();
            echo '</select>';
        } else {
            echo '<input type="hidden" id="IdUsuarioModal" name="IdUsuarioModal" value="' . $value['IdUsuario'] . '">
            <div class="fila">
                <div class="item">
            <p>Descripción</p>
            <textarea style="width: 20vw;" type="text" name="DescripcionModal" id="DescripcionModal" onkeyup="ValidaDescripcionNovedadModal(this)">' . $value['Descripcion'] . '</textarea>
            <span id="DescripcionModalError"></span>
            ';
        }
        echo '
        </div>
        <div class="item">
        
        <p>Petición</p>
        <input class="input_largo_registrar_novedad" type="text" name="PeticionModal" id="PeticionModal" value="' . $value['Peticion'] . '" onkeyup="ValidaPeticionNovedadModal(this)">
        <br>
        <span id="PeticionModalError"></span>
        </div>
        </div>
        <!-- FIN DIV FILA -->

        <!-- DIV FILA -->
        <div class="fila">
        <div class="item">
        <p>Desde la hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        <input type="time" class="input_pequeño_registrar_novedad" id="HoraInicioModal" name="HoraInicioModal" value="' . $value['HoraInicio'] . '" onchange="ValidateHoraInicioModal()">
        <br>
        <span id="HoraInicioModalError"></span>
        </div>
        <div class="item">
        <p>Hasta la hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        <input type="time" class="input_pequeño_registrar_novedad" id="HoraFinModal" name="HoraFinModal" value="' . $value['HoraFinal'] . '" onchange="ValidateHoraFinModal()">
        <br>
        <span id="HoraFinModalError"></span>
        </div>
        </div>
        <!-- FIN DIV FILA -->
        <!-- DIV FILA -->
        <div class="fila">
        <div class="item">
        <p>Desde el día &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        <input type="date" class="input_pequeño_registrar_novedad" id="FechaInicioModal" name="FechaInicioModal" value="' . $value['FechaInicio'] . '" onchange="ValidateFechaInicioModificar(); ValidateFechaInicioModal(); ValidateFechaInicioYFinModificar();">
        <br>
        <span id="FechaInicioModalError"></span>
        </div>
        <div class="item">
        <p>Hasta el día &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        <input type="date" class="input_pequeño_registrar_novedad" id="FechaFinModal" name="FechaFinModal" value="' . $value['FechaFinal'] . '" onchange="ValidateFechaFinModal(); ValidateFechaFinModificar(); ValidateFechaInicioYFinModificar();">
        <br>
        <span id="FechaFinModalError"></span>
        </div>
        </div>
        <!-- FIN DIV FILA -->
        <!-- DIV FILA -->';
        if ($_SESSION['Rol'] == 1) {
            echo '
        <div class="fila1">
        <div class="item2">
        <p>Descripción</p>
        <br>
        <textarea class="input_largo_registrar_novedad" type="text" name="DescripcionModal" id="DescripcionModal" onkeyup="ValidaDescripcionNovedadModal(this)">' . $value['Descripcion'] . '</textarea>
        <span id="DescripcionModalError"></span>
        </div>
                </div>
        ';}
        echo'
                <!-- FIN DIV FILA -->
        <div class="Boton">
        <button class="btn-azul" id="SubmitButtonModal" onclick="ModificarNovedad();">Aceptar</button> 
        <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
    </div>
        <script>
            ValidarCamposNovedadModal();
        </script>';
    }
}

function ModalAceptarNovedad()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdNovedad = $_POST['IdNovedad'];
    $sql = "SELECT * FROM novedad WHERE IdNovedad = " . $IdNovedad;
    $lista = $Conexion->ObtenerDatos($sql);

    foreach ($lista as $key => $value) {
        echo '
        <h3>¿Estas seguro de aceptar esta novedad?</h3>
        <input type="hidden" id="IdNovedad" name="IdNovedad" value="' . $value['IdNovedad'] . '">
        <input type="hidden" id="opcion" name="opcion" value="1">
        <div class="Boton">
        <button class="btn-azul" id="SubmitButtonModal" onclick="AceptarRechazarNovedad();">Aceptar</button> 
        <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
    </div>
        ';
    };
};

function ModalRechazarNovedad()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdNovedad = $_POST['IdNovedad'];
    $sql = "SELECT * FROM novedad WHERE IdNovedad  = " . $IdNovedad;
    $lista = $Conexion->ObtenerDatos($sql);

    foreach ($lista as $key => $value) {
        echo '
        <h3>¿Estas seguro de rechazar esta novedad?</h3>
        <input type="hidden" id="IdNovedad" name="IdNovedad" value="' . $value['IdNovedad'] . '">
        <input type="hidden" id="opcion" name="opcion" value="0">
        <div class="Boton">
        <button class="btn-azul" id="SubmitButtonModal" onclick="AceptarRechazarNovedad();">Aceptar</button> 
        <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
    </div> ';
    };
};


function ModificarNovedad()
{
    session_start();
    $IdNovedad = $_POST["IdNovedad"];
    $IdUsuario = $_POST["IdUsuario"];
    $Peticion = $_POST["Peticion"];
    $Descripcion = $_POST["Descripcion"];
    $HoraInicio = $_POST["HoraInicio"];
    $HoraFinal = $_POST["HoraFinal"];
    $FechaInicio = $_POST["FechaInicio"];
    $FechaFinal = $_POST["FechaFinal"];

    if ($_SESSION["Rol"] != 1) {
        $IdUsuario = $_SESSION["IdUsuario"];
    }

    $Conexion = new PDODB();

    $Conexion->Conectar();

    $sql = "UPDATE novedad SET IdUsuario = " . $IdUsuario . ",
         Peticion = '" . $Peticion . "', 
         Descripcion = '" . $Descripcion . "', 
         HoraInicio = '" . $HoraInicio . "', 
         HoraFinal = '" . $HoraFinal . "', 
         FechaInicio = '" . $FechaInicio . "', 
         FechaFinal = '" . $FechaFinal . "'
         WHERE IdNovedad = " . $IdNovedad;
    $modificado = $Conexion->EjecutarInstruccion($sql);

    if ($modificado == true) {
        echo "Modificado correctamente";
    } else {
        echo "No fue posible modificar";
    }
};

// LISTAR NOVEDADES DE LOS usuarioS

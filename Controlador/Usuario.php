<?php
require_once '../Modelo/Conexion.php';

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

    $BuscarSql = "SELECT * FROM usuario";

    $Buscar = $Conexion->ObtenerDatos($BuscarSql);

    foreach ($Buscar as $key => $Datos) {
        if ($Datos['Documento'] == $Documento) {
            echo 'El numero de documento ya existe en la base de datos';
            return;
        } else if ($Datos['Telefono'] == $Telefono) {
            echo 'El numero de Telefono ya existe en la base de datos';
            return;
        } else if ($Datos['Correo'] == $Correo) {
            echo 'El correo ya existe en la base de datos';
            return;
        }
    }

    $InstruccionSql = "INSERT INTO usuario VALUES (null,'" . $IdRol . "', '" . $Nombre . "', '" . $Apellido . "','" . $TipoDocumento . "','" . $Documento . "','" . $Correo . "','" . $ContraseñaEncryptada . "','" . $Telefono . "', '" . $Direccion . "','" . $Estado . "')";

    $Resultado = $Conexion->EjecutarInstruccion($InstruccionSql);

    if ($Resultado == true) {
        echo "Registrado correctamente";
    } else {
        echo "No fué posible realizar el registro";
    }
}

function MostrarRolesEmpleados()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT * FROM rol Where EstadoRol = 1";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);

    foreach ($Resultado as $key => $Datos) {
        echo '<option value="' . $Datos["IdRol"] . '">' . $Datos["NombreRol"] . '</option>';
    }
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

    if ($_SESSION['Rol'] == 1) {
        $InstruccionSql = "SELECT * FROM usuario INNER JOIN rol ON usuario.IdRol = rol.IdRol WHERE IdUsuario > 0";
    } else {
        $InstruccionSql = "SELECT * FROM usuario INNER JOIN rol ON usuario.IdRol = rol.IdRol WHERE IdUsuario = " . $_SESSION['IdUsuario'];
    }
    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    $_SESSION["Funcion"] = "ListarUsuario";

    $ConCol = count($Columnas);
    $InstruccionSql .= " AND (";
    for ($i = 0; $i < $ConCol; $i++) {
        $InstruccionSql .= $Columnas[$i] . " LIKE '%" . $BusquedaUsuario . "%' OR ";
    }
    $InstruccionSql = substr_replace($InstruccionSql, "", -3);
    $InstruccionSql .= ")";

    if ($Orden[0] != " ") {
        $InstruccionSql .= "ORDER BY $Orden[1] $Orden[0] ";
    }
    $InstruccionSql .= "LIMIT $Inicio,$Registros";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);
    $ResultadoContar = count($Resultado);

    if ($ResultadoContar > 0) {
        foreach ($Resultado as $key => $Datos) {
            echo '<tr>';
            if ($_SESSION['Rol'] == 1) {
                echo '
                    <td class="pt-3-half" data-th="Id" contenteditable="false">' . $Datos['IdUsuario'] . '</td>';
            }
            echo '  <td class="pt-3-half" data-th="Rol" contenteditable="false">' . $Datos['NombreRol'] . '</td>
                    <td class="pt-3-half" data-th="Nombre" contenteditable="false">' . $Datos['Nombre'] . '</td>
                    <td class="pt-3-half" data-th="Apellido" contenteditable="false">' . $Datos['Apellido'] . '</td>
                    <td class="pt-3-half" data-th="Tipo Doc" contenteditable="false">' . $Datos['TipoDocumento'] . '</td>
                    <td class="pt-3-half" data-th="Documento" contenteditable="false">' . $Datos['Documento'] . '</td>
                    <td class="pt-3-half" data-th="Correo" contenteditable="false">' . $Datos['Correo'] . '</td>
                    <td class="pt-3-half" data-th="Telefono" contenteditable="false">' . $Datos['Telefono'] . '</td>
                    <td class="pt-3-half" data-th="Direccion" contenteditable="false">' . $Datos['Direccion'] . '</td>';
            if ($_SESSION['Rol'] == 1) {
                echo '<td data-th="Estado"> <buttom class="';
                if ($Datos["Estado"] == 1) {
                    echo "Estado Activo";
                } else {
                    echo "Estado Inactivo";
                };
                echo '"</buttom>';
                if ($Datos["Estado"] == 1) {
                    echo "Activo";
                } else {
                    echo "Desactivado";
                };
                echo '</td>';
                if ($Datos["Estado"] == 1) {
                    echo '<td data-th="Operaciones"><Img src="Assets/Img/Iconos/editar.svg" title="Editar" alt="" class="icon" onclick="ConsultarUsuario(' . $Datos['IdUsuario'] . ')">';
                    if ($_SESSION['IdUsuario'] == $Datos['IdUsuario']) {
                        echo '<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"></td>';
                    } else {
                        echo '<Img src="Assets/Img/Iconos/desactivar.svg" alt="" title="Desactivar" class="icon" onclick="ModalDesactivarUsuario(' . $Datos['IdUsuario'] . ', ' . $Datos['Estado'] . ')"></td>';
                    }
                } else {
                    echo '<td data-th="Operaciones"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                    <Img src="Assets/Img/Iconos/desactivar.svg" title="Activar" alt="" class="icon" onclick="ModalDesactivarUsuario(' . $Datos['IdUsuario'] . ', ' . $Datos['Estado'] . ')"></td>';
                }
            }
            echo '</tr>';
        }
    } else {
        echo '<tr>
            <td colspan="11">Sin resultados</td>
        </tr>';
    }
}

function ConsultarUsuario()
{
    session_start();
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdUsuario = $_POST['IdUsuario'];

    $Sql = "SELECT * FROM usuario INNER JOIN Rol ON usuario.IdRol = rol.IdRol WHERE IdUsuario = " . $IdUsuario;
    $InstruccionSql = "SELECT * FROM rol WHERE EstadoRol = 1";

    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);
    $Lista = $Conexion->ObtenerDatos($Sql);

    foreach ($Lista as $key => $Datos) {
        echo '<form>

        <input id="Contrasena" value="1234567890" name="Contrasena" type="hidden" placeholder="Ingrese la Contraseña" onkeyup="ValidarContrasenaUsuario(this)" required />

    
        <input type="hidden" value="' . $_SESSION["IdUsuario"] . '" id="IdUsuarioActual">
      
        <p>Modificar a ' . $Datos["Nombre"] . '</p>
        <input type="hidden" id="IdUsuario" name="IdUsuario" value="' . $Datos['IdUsuario'] . '">
        <!-- DIV FILA -->
        <div class="fila">
            <div class="item">
        <p>Rol</p>    
        <select name="IdRol" id="IdRol" placeholder="Roles">
       
        <option value="' . $Datos["IdRol"] . '">' . $Datos["NombreRol"] . '</option>';
        foreach ($Resultado as $key => $DatosRol) {
            if ($Datos["IdRol"] != $DatosRol["IdRol"]) {
                echo '<option value="' . $DatosRol["IdRol"] . '">' . $DatosRol["NombreRol"] . '</option>';
            }
        };
        echo '
            </select>
            </div>
            
				
      
            <div class="item">
            <p>Nombre</p>
            <input type="text" name="Nombre" id="Nombre" class="form-control" placeholder="Nombres" onkeyup="ValidarNombreUsuario(this)" value="' . $Datos["Nombre"] . '" required />
            <br> 
            <span id="NombreError"></span>
            </div>
    </div>
    <!-- FIN DIV FILA -->
    <!-- DIV FILA -->
    <div class="fila">
        <div class="item">
            <p>Apellido</p>
            <input type="text" name="Apellido" id="Apellido" class="form-control" placeholder="Apellido" onkeyup="ValidarApellidoUsuario(this)" value="' . $Datos["Apellido"] . '" required />
            <br> 
            <span id="ApellidoError"></span>
            </div>
            
				
      
            <div class="item">
            <p>Tipo de Documento</p>
            <select name="TipoDocumento" id="TipoDocumento" class="form-control" placeholder="Tipo de documento">
                    <option value="' . $Datos["TipoDocumento"] . '">' . $Datos["TipoDocumento"] . '</option>
                    <option value="Cédula">Cédula de Ciudadanía</option>
                    <option value="Tarjeta de identidad">Tarjeta de Identidad</option>
                    <option value="Cedula de extrangeria">Cédula de Extrangería</option>
                    <option value="Pasaporte">Pasaporte</option>
                </select>
                </div>
    </div>
    <!-- FIN DIV FILA -->
    <!-- DIV FILA -->
    <div class="fila">
        <div class="item">
                <p>Documento</p>
                <input type="number" name="Documento " id="Documento" onkeyup="ValidarDocumentoUsuario(this)" class="form-control " placeholder="Documento" value="' . $Datos["Documento"] . '" required />
                <br>
                <span id="DocumentoError"></span>
                </div>
            
				
      
                <div class="item">
                <p>Correo</p>
                <input type="email" name="Correo " id="Correo" onkeyup="ValidarCorreoUsuario(this)" class="form-control " placeholder="Correo" value="' . $Datos["Correo"] . '" required />
                <br> 
                <span id="CorreoError"></span>
                </div>
    </div>
    <!-- FIN DIV FILA -->
    <!-- DIV FILA -->
    <div class="fila">
        <div class="item">
                <p>Telefono</p>
                <input type="number" name="Telefono " id="Telefono" onkeyup="ValidarTelefonoUsuario(this)" class="form-control" placeholder="Telefono" value="' . $Datos["Telefono"] . '" required />
                <br> 
                <span id="TelefonoError"></span>
                </div>
            
				
      
                <div class="item">
                <p>Direccion</p>
                <input type="text" name="Direccion " id="Direccion" onkeyup="ValidarDireccionUsuario(this)" class="form-control" placeholder="Direccion" value="' . $Datos["Direccion"] . '" required />
                <br> 
                <span id="DireccionError"></span>
                </div>
    </div>
    <div class="Boton">
    <button class="btn-azul" id="submitButton" onclick="ModificarUsuario()">Modificar</button>
    <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
    <!-- FIN DIV FILA -->
        </form>
        <script>
            ValidarCamposUsuario();
        </script>';
    }
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

    $BuscarSql = "SELECT * FROM usuario WHERE IdUsuario != $IdUsuario";

    $Buscar = $Conexion->ObtenerDatos($BuscarSql);

    foreach ($Buscar as $key => $Datos) {
        if ($Datos['Documento'] == $Documento) {
            // $DocumentoRegistrado++;
            echo 'El numero de documento ya existe en la base de datos';
            return;
        } else if ($Datos['Telefono'] == $Telefono) {
            // $TelefonoRegistrado++;
            echo 'El numero de telefono ya existe en la base de datos';
            return;
        } else if ($Datos['Correo'] == $Correo) {
            // $CorreoRegistrado++;
            echo 'El correo ya existe en la base de datos';
            return;
        }
    }

    $Sqly = "UPDATE usuario SET IdRol = '" . $IdRol . "',
    Nombre = '" . $Nombre . "', 
    Apellido = '" . $Apellido . "', 
    TipoDocumento = '" . $TipoDocumento . "',
    Documento = '" . $Documento . "', 
    Correo = '" . $Correo . "',
    Telefono = '" . $Telefono . "', 
    Direccion = '" . $Direccion . "'
    WHERE IdUsuario = " . $IdUsuario;

    $Modificado = $Conexion->EjecutarInstruccion($Sqly);

    if ($Modificado == true) {
        echo "Modificado correctamente";
    } else {
        echo "No fue posible modificar";
    }
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

    try {
        $consultaInfoUsuario = "SHOW CREATE TABLE $tablaUsuario";
        $resultadoInfoUsuario = $Conexion->EjecutarInstruccion($consultaInfoUsuario);
        $definicionUsuario = $resultadoInfoUsuario->fetchColumn(1);
    } catch (PDOException $e) {
        echo "Error al obtener información de la tabla Usuario: " . $e->getMessage() . "";
        return;
    }

    try {
        $consultaTablasRelacionadas = "SHOW TABLES";
        $resultadoTablasRelacionadas = $Conexion->EjecutarInstruccion($consultaTablasRelacionadas);

        while ($filaTablaRelacionada = $resultadoTablasRelacionadas->fetch(PDO::FETCH_NUM)) {
            $tablaRelacionada = $filaTablaRelacionada[0];

            if ($tablaRelacionada != $tablaUsuario) {
                $consultaInfoTablaRelacionada = "SHOW CREATE TABLE $tablaRelacionada";
                $resultadoInfoTablaRelacionada = $Conexion->EjecutarInstruccion($consultaInfoTablaRelacionada);
                $definicionTablaRelacionada = $resultadoInfoTablaRelacionada->fetchColumn(1);

                if (strpos($definicionTablaRelacionada, 'FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`)') !== false) {

                    // Verificar si hay datos relacionados
                    $consultaDatosRelacionados = "SELECT * FROM $tablaRelacionada WHERE IdUsuario IN (SELECT IdUsuario FROM usuario WHERE IdUsuario = $IdUsuario)";
                    $resultadoDatosRelacionados = $Conexion->EjecutarInstruccion($consultaDatosRelacionados);

                    if ($resultadoDatosRelacionados->rowCount() > 0) {
                        $ArrayTablasRelacionadas[] = " " . $tablaRelacionada;
                    }
                }
            }
        }
    } catch (PDOException $e) {
        echo "Error al buscar tablas relacionadas: " . $e->getMessage() . "";
        return;
    }

    if (empty($ArrayTablasRelacionadas)) {
        $Sqly = "UPDATE usuario SET Estado = '" . $Estado . "'
        WHERE IdUsuario = " . $IdUsuario;

        $Modificado = $Conexion->EjecutarInstruccion($Sqly);

        if ($Modificado == true && $Estado == 0) {
            echo "Desactivado correctamente";
        } else if ($Modificado == true && $Estado == 1) {
            echo "Activado correctamente";
        } else {
            echo "No fue posible modificar";
        }
    } else {
        echo "El usuario tiene datos relacionados en los siguientes modulos: ";
        for ($i = 0; $i < count($ArrayTablasRelacionadas); $i++) {
            echo $ArrayTablasRelacionadas[$i] . " ";
        }
        echo "";
    }
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
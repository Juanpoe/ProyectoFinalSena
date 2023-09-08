<?php
require_once '../Modelo/Conexion.php';

switch ($_POST['Metodo']) {
    case 'RegistrarRol':
        RegistrarRol();
        break;
    case 'ListarRoles':
        ListarRoles();
        break;
    case 'ConsultarRol':
        ConsultarRol();
        break;
    case 'ModificarRol':
        ModificarRol();
        break;
    case 'DesactivarActivarRol':
        DesactivarActivarRol();
        break;
    case 'ModalDesactivarRol':
        ModalDesactivarRol();
        break;
}

function RegistrarRol()
{
    date_default_timezone_set('America/Bogota');
    $NombreRol = $_POST["NombreRol"];
    $Rol = $_POST["Rol"];
    $Permiso = $_POST["Permisos"];
    $FechaRol = date("d-m-Y h:i:s");
    $EstadoRol = 1;
    $NombreRolEnUsuo = array();

    $Conexion = new PDODB();
    $Conexion->Conectar();

    $Averiguar = "SELECT * FROM rol";

    $Resultado = $Conexion->ObtenerDatos($Averiguar);

    foreach ($Resultado as $key => $Datos) {

        if (strtolower($Datos["NombreRol"]) == strtolower($NombreRol)) {
            $NombreRolEnUsuo[] = $Datos["NombreRol"];
        }
    }

    if ($NombreRolEnUsuo) {
        echo "Ya existe un rol con el mismo nombre";
    } else {
        $InstruccionSql = "INSERT INTO rol VALUES (NULL,'" . $NombreRol . "', '" . $Rol . "', '" . $Permiso . "',  '" . $FechaRol . "', '" . $EstadoRol . "')";

        if ($Conexion->EjecutarInstruccion($InstruccionSql)) {
            echo "Registrado correctamente";
        } else {
            echo "No fue posible realizar el registro";
        }
    }
}

function ListarRoles()
{
    session_start();

    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $BusquedaRol = $_POST['BusquedaRol'];

    $Conexion = new PDODB();
    $Conexion->Conectar();

    $Columnas = ["NombreRol", "Permisos", "FechaRol"];
    if ($_SESSION['Rol'] == 1) {
        $InstruccionSql = "SELECT * FROM rol WHERE IdRol > 0";
    } else {
        $InstruccionSql = "SELECT * FROM rol WHERE IdRol > 0 AND NombreRol = '" . $_SESSION['NombreRol'] . "'";
    }
    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    //Cambiar esto por el nombre de la funcion de listar
    $_SESSION["Funcion"] = "ListarRoles";
    $ConCol = count($Columnas);
    $InstruccionSql .= " AND (";
    for ($i = 0; $i < $ConCol; $i++) {
        $InstruccionSql .= $Columnas[$i] . " LIKE '%" . $BusquedaRol . "%' OR ";
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
    $cont = 0;

    if ($ResultadoContar > 0) {
        foreach ($Resultado as $key => $Datos) {
            $cont++;
            $ListaPermisos = explode(",", $Datos['Permisos']);
            echo '<tr>';
            if ($_SESSION['Rol'] == 1) {
                echo '
                    <td data-th="Id">' . $Datos['IdRol'] . '</td>';
            }
            echo '<td data-th="Nombre">' . $Datos['NombreRol'] . '</td>
            <td data-th="Tipo">';
            if ($Datos['Rol'] == 0) {
                echo "Empleado";
            } else {
                echo "Administrador";
            }
            echo '</td>
            <td data-th="Permisos">';
            if ($ListaPermisos[0] == 1) {
                echo 'Modulo de roles<br>';
            }
            if ($ListaPermisos[1] == 1) {
                echo 'Modulo de usuarios<br>';
            }
            if ($ListaPermisos[2] == 1) {
                echo 'Modulo de novedades<br>';
            }
            if ($ListaPermisos[3] == 1) {
                echo 'Modulo de herramientas e insumos<br>';
            }
            if ($ListaPermisos[4] == 1) {
                echo 'Modulo de prestamos<br>';
            }
            if ($ListaPermisos[5] == 1) {
                echo 'Modulo de servicios<br>';
            }
            if ($ListaPermisos[6] == 1) {
                echo 'Modulo de agendamiento';
            };
            echo '</td>
            <td data-th="Fecha">' . $Datos["FechaRol"] . '</td>';
            if ($_SESSION['Rol'] == 1) {
                echo '
                    <td data-th="Estado"> <buttom class="';
                if ($Datos["EstadoRol"] == 1) {
                    echo "Estado Activo";
                } else {
                    echo "Estado Inactivo";
                };
                echo '"</buttom>';
                if ($Datos["EstadoRol"] == 1) {
                    echo "Activo";
                } else {
                    echo "Desactivado";
                };
                echo '</td>';
                if ($Datos["NombreRol"] == 'Administrador') {
                    echo '<td data-th="Operaciones"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                    <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"> <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"></td>';
                } else {
                    if ($Datos["EstadoRol"] == 1) {
                        echo '<td data-th="Operaciones"><Img src="Assets/Img/Iconos/editar.svg" title="Editar" alt="" class="icon" onclick="ConsultarRol(' . $Datos['IdRol'] . ')">
                        <img title="Eliminar" class="icon" onclick="window.modal.showModal(); ModalGeneralEliminar(\'ListarRoles\', \'rol\', \'IdRol\', ' . $Datos['IdRol'] . ')" src="Assets/Img/Iconos/basura.svg" alt="">
                        ';

                        if ($_SESSION['IdRol'] == $Datos['IdRol']) {
                            echo '<Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon"></td>';
                        } else {
                            echo '<Img src="Assets/Img/Iconos/desactivar.svg" title="Desactivar" alt="" class="icon" onclick="ModalDesactivarRol(' . $Datos['IdRol'] . ', ' . $Datos['EstadoRol'] . ')"></td>';
                        }
                    } else {
                        echo '<td data-th="Operaciones"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                        <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                        <Img src="Assets/Img/Iconos/desactivar.svg" alt="" title="Activar" class="icon" onclick="ModalDesactivarRol(' . $Datos['IdRol'] . ', ' . $Datos['EstadoRol'] . ')"></td>';
                    }
                }
            }
            echo '</tr>';
        }
    } else {
        echo '<tr>
            <td colspan="8">Sin resultados</td>
        </tr>';
    }
}

function ConsultarRol()
{
    session_start();
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdRol = $_POST['IdRol'];
    $Sql = "SELECT * FROM rol WHERE IdRol = " . $IdRol;
    $Lista = $Conexion->ObtenerDatos($Sql);
    $FormHtml = "";

    foreach ($Lista as $key => $Datos) {
        $FormHtml .= '    
        <form method="post">
        <input type="hidden" id="IdRolActual" value="' . $_SESSION["IdRol"] . '">';
        if ($Datos["Rol"] == 1) {
            echo '
            <div class="fila"><div class="item">
            <p>Tipo rol</p>
            <br>
            <select name="Rol" id="Rol">
                <option value="1">Administrador</option>
                <option value="0">Empleado</option>
            </select></div>
            ';
        } else {
            echo '
            <div class="fila"><div class="item">
            <p>Tipo rol</p>
            <br>
            <select name="Rol" id="Rol">
                <option value="0">Empleado</option>
                <option value="1">Administrador</option>
            </select></div>
           ';
        }
        echo '
       
            <input type="hidden" id="IdRol" name="IdRol" value="' . $Datos['IdRol'] . '">
            <input type="hidden" id="IdRolNombre" name="IdRolNombre" value="' . $Datos['NombreRol'] . '">
            <div class="item">
            <p id="LabelNombreRol">Nombre rol</p>
            <br>
            <input type="text" id="NombreRol" name="NombreRol" placeholder="Nombre del rol" onkeyup="ValidarNombreRol(this)"  value="' . $Datos['NombreRol'] . '">
            <br>
            <span id="NombreRolError"></span>
            </div></div>
         <div class="contenedor-permisos">
            <h1>Permisos</h1>
            <br>
            <div class="contenedor-fila-permisos">
                <div class="fila-permisos">
                    <label for="">
                        Modulo de roles
                        <label class="toggle">
                            <input class="toggle-checkbox" type="checkbox" id="Roles" onclick="FuncionRoles(0)">
                            <div class="toggle-switch"></div>
                        </label>
                    </label>
                    <label for="">
                        Modulo de usuarios
                        <label class="toggle">
                            <input class="toggle-checkbox" type="checkbox" id="Usuarios" onclick="FuncionRoles(1)">
                            <div class="toggle-switch"></div>
                        </label>
                    </label>
                    <label for="">
                        Modulo de novedades
                        <label class="toggle">
                            <input class="toggle-checkbox" type="checkbox" id="Novedades" onclick="FuncionRoles(2)">
                            <div class="toggle-switch"></div>
                        </label>
                    </label>
                    <label for="">
                        Modulo de herramientas e insumos
                        <label class="toggle">
                            <input class="toggle-checkbox" type="checkbox" id="HerramientasInsumos" onclick="FuncionRoles(3)">
                            <div class="toggle-switch"></div>
                        </label>
                    </label>
                </div>
                <div class="fila-permisos">
                    <label for="">
                        Modulo de prestamos
                        <label class="toggle">
                            <input class="toggle-checkbox" type="checkbox" id="Prestamos" onclick="FuncionRoles(4)">
                            <div class="toggle-switch"></div>
                        </label>
                    </label>
                    <label for="">
                        Modulo de servicios
                        <label class="toggle">
                            <input class="toggle-checkbox" type="checkbox" id="Servicios" onclick="FuncionRoles(5)">
                            <div class="toggle-switch"></div>
                        </label>
                    </label>
                    <label for="">
                        Modulo de agendamiento
                        <label class="toggle">
                            <input class="toggle-checkbox" type="checkbox" id="Agendamiento" onclick="FuncionRoles(6)">
                            <div class="toggle-switch"></div>
                        </label>
                    </label>
                </div>
            </div>
        </div>
            <input type="hidden" id="Permisos" name="Permisos" value="0,0,0,0,0,0,0">
            <br>
            <span id="PermisosError"></span>
            <div class="Boton">
<button type="submit" value="Guardar" id="submitButton" class="btn-azul" onclick="ModificarRol()">Modificar</button>
<button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
        </form>
        <script>
            var Permisos = [0, 0, 0, 0, 0, 0, 0]
            var Permisostxt = ""

            function Cargas() {
                var PermiososBobada = document.getElementById("Permisos").value;
                let Permisos = "' . $Datos['Permisos'] . '".split(",");

                console.log("entro a cargas" + Permisos.length);
                for (let index = 0; index < Permisos.length; index++) {
                    console.log("Permiso " + index + "  " + Permisos[index])
                    switch (index) {
                        case 0:
                            if (Permisos[index] == 1) {
                                var checkBox = document.getElementById("Roles");
                                checkBox.click();
                            }
                            break;
                        case 1:
                            if (Permisos[index] == 1) {
                                var checkBox = document.getElementById("Usuarios");
                                checkBox.click();
                            }
                            break;
                        case 2:
                            if (Permisos[index] == 1) {
                                var checkBox = document.getElementById("Novedades");
                                checkBox.click();
                            }
                            break;
                        case 3:
                            if (Permisos[index] == 1) {
                                var checkBox = document.getElementById("HerramientasInsumos");
                                checkBox.click();
                            }
                            break;
                        case 4:
                            if (Permisos[index] == 1) {
                                var checkBox = document.getElementById("Prestamos");
                                checkBox.click();
                            }
                            break;
                        case 5:
                            if (Permisos[index] == 1) {
                                var checkBox = document.getElementById("Servicios");
                                checkBox.click();
                            }
                            break;
                        case 6:
                            if (Permisos[index] == 1) {
                                var checkBox = document.getElementById("Agendamiento");
                                checkBox.click();
                            }
                            break;
                    }
                }
            }

            Cargas();

            function FuncionRoles(num) {
                switch (num) {
                    case 0:
                        var checkBox = document.getElementById("Roles");
                        break;
                    case 1:
                        var checkBox = document.getElementById("Usuarios");
                        break;
                    case 2:
                        var checkBox = document.getElementById("Novedades");
                        break;
                    case 3:
                        var checkBox = document.getElementById("HerramientasInsumos");
                        break;
                    case 4:
                        var checkBox = document.getElementById("Prestamos");
                        break;
                    case 5:
                        var checkBox = document.getElementById("Servicios");
                        break;
                    case 6:
                        var checkBox = document.getElementById("Agendamiento");
                        break;
                }
                if (checkBox.checked == true) {
                    // Aquí puedes enviar los datos si el switch está activado 
                    console.log("Switch activado");
                    Permisos[num] = 1
                    console.log(Permisos.toString())
                } else {
                    // Aquí puedes enviar los datos si el switch está desactivado 
                    console.log("Switch desactivado");
                    Permisos[num] = 0
                    console.log(Permisos.toString())
                }
                Permisostxt = Permisos.toString()
                var permisohidden = document.getElementById("Permisos");
                permisohidden.value = Permisostxt
                ValidarPermisosRol(document.getElementById("Permisos"))
            }
        </script>
    ';
    }
    echo $FormHtml;
}

function ModificarRol()
{
    $Conexion = new PDODB();

    $Conexion->Conectar();

    $IdRol = $_POST["IdRol"];
    $Rol = $_POST["Rol"];
    $IdRolNombre = $_POST["IdRolNombre"];
    $NombreRol = $_POST["NombreRol"];
    $Permisos = $_POST["Permisos"];
    $NombreRolEnUsuo = array();

    $Averiguar = "SELECT * FROM rol";

    $Resultado = $Conexion->ObtenerDatos($Averiguar);

    foreach ($Resultado as $key => $Datos) {

        if (strtolower($Datos["NombreRol"]) == strtolower($NombreRol) && strtolower($Datos["NombreRol"]) != strtolower($IdRolNombre)) {
            $NombreRolEnUsuo[] = $Datos["NombreRol"];
        }
    }

    if ($NombreRolEnUsuo) {
        echo "Ya existe un rol con el mismo nombre";
    } else {

        $Sql = "UPDATE rol SET NombreRol = '" . $NombreRol . "', 
    Rol = '" . $Rol . "', 
    Permisos = '" . $Permisos . "'
    WHERE IdRol = " . $IdRol;

        $Modificado = $Conexion->EjecutarInstruccion($Sql);

        if ($Modificado == true) {
            echo "Modificado correctamente";
        } else {
            echo "No fue posible modificar";
        }
    }
}

function DesactivarActivarRol()
{
    $Conexion = new PDODB();

    $Conexion->Conectar();

    $TablaRol = "rol";

    $IdRol = $_POST['IdRol'];
    $EstadoRol = $_POST['EstadoRol'];
    $ArrayEmpleadosRoles = array();

    if ($EstadoRol == 1) {
        $EstadoRol = 0;
    } else {
        $EstadoRol = 1;
    }

    try {
        $consultaInfoRol = "SHOW CREATE TABLE $TablaRol";
        $resultadoInfoRol = $Conexion->EjecutarInstruccion($consultaInfoRol);
        $definicionRol = $resultadoInfoRol->fetchColumn(1);
    } catch (PDOException $e) {
        echo "Error al obtener información de la tabla rol: " . $e->getMessage() . "";
        return;
    }

    try {
        $consultaTablasRelacionadas = "SHOW TABLES";
        $resultadoTablasRelacionadas = $Conexion->EjecutarInstruccion($consultaTablasRelacionadas);

        while ($filaTablaRelacionada = $resultadoTablasRelacionadas->fetch(PDO::FETCH_NUM)) {
            $tablaRelacionada = $filaTablaRelacionada[0];

            if ($tablaRelacionada != $TablaRol) {
                $consultaInfoTablaRelacionada = "SHOW CREATE TABLE $tablaRelacionada";
                $resultadoInfoTablaRelacionada = $Conexion->EjecutarInstruccion($consultaInfoTablaRelacionada);
                $definicionTablaRelacionada = $resultadoInfoTablaRelacionada->fetchColumn(1);

                if (strpos($definicionTablaRelacionada, 'FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`)') !== false) {

                    $consultaDatosRelacionados = "SELECT * FROM $tablaRelacionada WHERE IdRol IN (SELECT IdRol FROM rol WHERE IdRol = $IdRol)";
                    $resultadoDatosRelacionados = $Conexion->EjecutarInstruccion($consultaDatosRelacionados);

                    if ($resultadoDatosRelacionados->rowCount() > 0) {
                        foreach ($resultadoDatosRelacionados as $fila) {
                            // Aquí puedes acceder a los datos de cada fila con $fila['nombre_columna']
                            // y almacenarlos en el array o hacer cualquier otra operación necesaria
                            $ArrayEmpleadosRoles[] = $fila["Nombre"];
                        }
                    }
                }
            }
        }
    } catch (PDOException $e) {
        echo "Error al buscar tablas relacionadas: " . $e->getMessage() . "";
        return;
    }

    if (empty($ArrayEmpleadosRoles)) {

        $Sql = "UPDATE rol SET EstadoRol = '" . $EstadoRol . "'
        WHERE IdRol = " . $IdRol;

        $Modificado = $Conexion->EjecutarInstruccion($Sql);

        if ($Modificado == true && $EstadoRol == 0) {
            echo 'Desactivado correctamente';
        } else if ($Modificado == true && $EstadoRol == 1) {
            echo 'Activado correctamente';
        } else {
            echo 'No fue posible realizar esta operación';
        }
    } else {
        echo "El rol esta en uso por los siguientes empleados: ";
        for ($i = 0; $i < count($ArrayEmpleadosRoles); $i++) {
            echo $ArrayEmpleadosRoles[$i] . " ";
        }
    }
}

function ModalDesactivarRol(){
    $Id = $_POST["Id"];
    $Estado = $_POST["Estado"];
    echo'
    <form action="" Id="ModalServicio"><center><h3>¿Está seguro de cambiar el estado?</h3></center>
    <input id="Id" value="'.$Id.'" type="hidden">
    <input id="Estado" value="'.$Estado.'" type="hidden">
    <div class="Boton">
    <button class="btn-azul" id="registrar" onclick="DesactivarActivarRol()">Aceptar</button>
    <button class="btn-rojo" onclick="CerrarModal()">Cancelar</button>
</div>
</form>
    ';
}
<?php
require_once '../Modelo/Conexion.php';
switch ($_POST['Metodo']) {
    case 'GuardarAgendamiento':
        GuardarAgendamiento();
        break;
    case 'SelectInsumo':
        SelectInsumo();
        break;
    case 'SelectServicio':
        SelectServicio();
        break;
    case 'SelectUsuario':
        SelectUsuario();
        break;
    case 'ModificarAgendamiento':
        ModificarAgendamiento();
        break;
    case 'ModalAgendamiento':
        ModalAgendamiento();
        break;
    case 'CambiarEstado':
        CambiarEstado();
        break;
    case 'ListarAgendamientoAdministrador':
        ListarAgendamientoAdministrador();
        break;

    case 'ModalEliminarAgendamiento';
    ModalEliminarAgendamiento();
        break;
    
    case 'ModalNovedadAgendamiento';
    ModalNovedadAgendamiento();
        break;
    
    case 'ModalPrestamoAgendamiento';
    ModalPrestamoAgendamiento();
        break;

    case 'ValidacionDeServiciosEmpleados';
    ValidacionDeServiciosEmpleados();
    break;
    
    
        
}

function ValidacionDeServiciosEmpleados(){
    $IdEmpleado = $_POST["IdEmpleado"];
    $FechaServicio = $_POST["FechaServicio"];

    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSQL ="SELECT IdUsuario, FechaServicio, COUNT(FechaServicio) as contador FROM agendamiento WHERE Estado = 2  AND
    IdUsuario = ".$IdEmpleado." AND FechaServicio = ".$FechaServicio." GROUP BY IdUsuario, FechaServicio HAVING COUNT(FechaServicio) <= 10 ;";
    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);
    echo $IdEmpleado;
    echo $FechaServicio;

    if($Resultado){
        echo"la consulta se hizo";
    }else{
        echo"la consulta no se hizo";
        
    }
    if ($Resultado && $Resultado['contador'] <= 10) {

        echo "Hay espacio para programar el servicio para este empleado en esta fecha.";
    } else {
        echo "Este usuario ya tiene la agenda llena para esta fecha.";
    }

  
    }
  
    





function ModalNovedadAgendamiento(){
    $IdUsuario = $_POST["IdUsuario"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSQL = "SELECT *
FROM novedad
WHERE IdUsuario = ".$IdUsuario." AND EstadoNovedad < 2
ORDER BY IdNovedad DESC
LIMIT 5";

    // $InstruccionSQL = "SELECT * FROM novedad WHERE IdUsuario= ".$IdUsuario;
    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);
    foreach ($Resultado as $key => $Value){

    echo'
    <div class="modalnotificacion" >
    <h4>Petición :</h4>'.$Value['Peticion'].'<br/>
    <h4>Descripción:</h4>'.$Value['Descripcion'].'<br/>
    <h4>Resultado :</h4>';
    if($Value['EstadoNovedad']=='1'){
        echo 'Aceptada <br/>';

    }elseif ($Value['EstadoNovedad']=='0') {
        echo'Rechazada <br/>' ;
 }

echo'</div> <br/>';

}
   
}



function ModalPrestamoAgendamiento(){
    $IdUsuario = $_POST["IdUsuario"];
    $Conexion = new PDODB();
    $Conexion->Conectar();


    $InstruccionSQL = "SELECT *
FROM novedad
WHERE IdUsuario = ".$IdUsuario." AND EstadoNovedad < 2
ORDER BY IdNovedad DESC
LIMIT 5";

    $InstruccionSQL = "SELECT * FROM solicitudprestamo WHERE IdUsuario= ".$IdUsuario;
    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);
    foreach ($Resultado as $key => $Value) {
    echo'
    <div class="modalnotificacion" >
    <h3>Herramienta :</h3>'; 
    $InstruccionSQL2 = "SELECT Nombre FROM herramientainsumo WHERE IdHerramientaInsumo = ".$Value['IdHerramientaInsumo'];
    $Resultado2 = $Conexion->ObtenerDatos($InstruccionSQL2);
    foreach ($Resultado2 as $key => $nombre) {
        echo $nombre["Nombre"];
    }
    echo '
    <h3>Cantidad:</h3>'.$Value['CantidadSolicitud'].'<br/>
    <h3>Resultado :</h3>';
    if($Value['Estado']=='1'){
        echo 'Aceptada <br/>';

    }elseif ($Value['Estado']=='0') {
        echo'Rechazada<br/>' ;
 }
}
echo'</div>';

}
   






function ModalEliminarAgendamiento(){
    $Id = $_POST["Id"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSQL = "SELECT * FROM agendamiento WHERE IdAgendamiento = ".$Id;
    $Resultado = $Conexion->ObtenerDatos($InstruccionSQL);
    foreach ($Resultado as $key => $Value) {
      
    echo'<center><h3>¿Está seguro de cambiar de estado el agendamiento?</h3></center>
    <div class="Boton">
    <button class="btn-azul" onclick="CambiarEstado('.$Value['IdAgendamiento'].' )">Aceptar</button>
    <button class="btn-rojo" Id="CancelarEnvioModal" onclick=CerrarModalAgendamiento();>Cancelar</button>
    </div>

    ';
}

}








function GuardarAgendamiento()
{
    $Cantidad = $_POST["CantidadRegistrados"];
    $IdAcumuladas = $_POST["IdRegistrados"];
    $IdUsuario = $_POST["IdUsuario"];
    $IdServicio = $_POST["IdServicio"];
    $NombreCliente = $_POST["NombreCliente"];
    $Descripcion = $_POST["Descripcion"];
    $FechaServicio = $_POST["FechaServicio"];
    $DireccionCliente = $_POST["DireccionCliente"];
    $TelefonoCliente = $_POST["TelefonoCliente"];
    $Estado = "2";
    $ListaIdHerramientaInsumo = "";
    foreach ($IdAcumuladas as $key => $IdAcumulada) {
        $ListaIdHerramientaInsumo = "$ListaIdHerramientaInsumo$IdAcumulada, ";
    }
    $ListaCantidadHerramientaInsumo = "";
    foreach ($Cantidad as $key => $Cantidades) {

        $ListaCantidadHerramientaInsumo = "$ListaCantidadHerramientaInsumo$Cantidades, ";
    }
    $ListaCantidadHerramientaInsumo = str_replace(' ','',$ListaCantidadHerramientaInsumo);
    $ListaCantidadHerramientaInsumo = substr($ListaCantidadHerramientaInsumo, 0, strlen($ListaCantidadHerramientaInsumo) - 1);
    

    $ListaIdHerramientaInsumo = str_replace(' ','',$ListaIdHerramientaInsumo);
    $ListaIdHerramientaInsumo = substr($ListaIdHerramientaInsumo, 0, strlen($ListaIdHerramientaInsumo) - 1);

    $Conexion = new PDODB();

    $Conexion->Conectar();
    $InstruccionSQL1 = "INSERT INTO agendamiento 
VALUES
(null,'" . $IdUsuario . "','" . $IdServicio . "','" . $ListaIdHerramientaInsumo . "','" . $NombreCliente . "','" . $Descripcion . "','" . $FechaServicio . "','" . $DireccionCliente . "','" . $TelefonoCliente . "','" . $Estado . "')";
    $resultado1 = $Conexion->EjecutarInstruccion($InstruccionSQL1);
    $InstruccionSQL2 = "SELECT MAX(IdAgendamiento) as IdAgendamiento FROM agendamiento;";
    $resultado2 = $Conexion->EjecutarInstruccion($InstruccionSQL2);
    foreach ($resultado2 as $key => $value) {
        $IdAgendamiento = "$value[0]";
    }
    $InstruccionSQL3 = "INSERT INTO insumoagenda
VALUES
('" . $IdAgendamiento . "','" . $ListaIdHerramientaInsumo . "','" . $IdAgendamiento . "','" . $ListaCantidadHerramientaInsumo . "')";
    $resultado3 = $Conexion->EjecutarInstruccion($InstruccionSQL3);

    if ($ListaIdHerramientaInsumo != 'Ninguno') {
        for ($i = 0; $i < count($IdAcumuladas); $i++) {
            $InstruccionSQL4 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $IdAcumuladas[$i];
            $resultado4 = $Conexion->EjecutarInstruccion($InstruccionSQL4);
            foreach ($resultado4 as $key => $CantidadInventario) {
            }
            $NuevaCantidad = $CantidadInventario['Cantidad'] - $Cantidad[$i];


            $InstruccionSQL5 = "UPDATE herramientainsumo SET Cantidad =" . $NuevaCantidad . " WHERE IdHerramientaInsumo = " . $IdAcumuladas[$i];
            $resultado5 = $Conexion->EjecutarInstruccion($InstruccionSQL5);
        }
        if ($resultado1 == true and $resultado2 == true and $resultado3 == true and  $resultado4 == true and $resultado5 == true) {
            echo "Se ha guardado correctamente";
        }
    } else if ($resultado1 == true and $resultado2 == true and $resultado3 == true) {
        echo "Se ha guardado correctamente";
    } else {
        echo ("No se ha podido guardar");
    }
}





function SelectServicio()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $sql = "SELECT * FROM servicio";
    $lista = $Conexion->ObtenerDatos($sql);

    foreach ($lista as $key => $value) {
        if ($value['EstadoServicio'] == 1) {
            echo '
                <option value="" hidden>Selecciona una opción</option>
                <option value="' . $value['IdServicio'] . '">' . $value['NombreServicio'] . '</option>
            ';
        }
    }
}






function SelectInsumo()
{
    $IdRegistrados = $_POST["IdRegistrados"];
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $sql = "SELECT * FROM herramientainsumo WHERE Cantidad > 0";
    $lista = $Conexion->ObtenerDatos($sql);

    // Obtener los nombres de los elementos en el array $lista
    $nombresEnLista = array_column($lista, 'IdHerramientaInsumo');

    // Calcular los nombres de los elementos que no se repiten en ambos arrays
    $nombresNoRepetidos = array_diff($nombresEnLista, $IdRegistrados);

    foreach ($lista as $value) {
        // Verificar si el nombre no se repite en $NombreInsumos y si es un 'Insumo'
        if (in_array($value['IdHerramientaInsumo'], $nombresNoRepetidos) && $value['Tipo'] == 'Insumo' && $value['Estado']== 1) {
            echo '
                <input id="CantidadActual' . $value['Nombre'] . '" type="hidden" value="' . $value['Cantidad'] . '">
                <input id="IdInsumo' . $value['Nombre'] . '" type="hidden" value="' . $value['IdHerramientaInsumo'] . '">
                <option value="" hidden>Selecciona una opción</option>
                <option value="' . $value['Nombre'] . '">' . $value['Nombre'] . '</option>

            ';
        }
    }
}





function SelectUsuario()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();

    $sql = "SELECT * FROM usuario";
    $lista = $Conexion->ObtenerDatos($sql);
    $formHtml = "";

    foreach ($lista as $key => $value) {
        echo '
                <option value="" hidden>Selecciona una opción</option>
                <option  value="' . $value['IdUsuario'] . '">' . $value['Nombre'] . ' ' . $value['Apellido'] . '</option>
            ';
    }
}

function ListarAgendamientoAdministrador()
{
    session_start();
    $NombreRol = $_SESSION["NombreRol"];
    $Pagina = $_POST['Pagina'];
    $Registros = $_POST['CantidadDatos'];
    $Inicio = (($Pagina - 1) * $Registros);
    $Orden = $_POST['Orden'];
    $Busca = $_POST['Busca'];

    // Cambiar esto por el nombre de las columnas que se pueden buscar en el filtro
    $Columnas = [
        "agendamiento.IdAgendamiento", "usuario.Nombre", "agendamiento.NombreCliente",
        "servicio.NombreServicio", "herramientainsumo.Nombre", "agendamiento.DireccionCliente", "agendamiento.Estado",
        "agendamiento.TelefonoCliente", "agendamiento.FechaServicio","agendamiento.Descripcion"
    ];

    $Conexion = new PDODB();
    $Conexion->Conectar();

    $InstruccionSql = "SELECT agendamiento.IdAgendamiento, 
        usuario.Nombre AS NombreUsuario,
        agendamiento.NombreCliente,
        servicio.NombreServicio AS NombreServicio,
        agendamiento.DireccionCliente,
        agendamiento.TelefonoCliente,
        agendamiento.FechaServicio,
        agendamiento.Descripcion,
        usuario.Apellido,
        GROUP_CONCAT(herramientainsumo.Nombre) AS NombreHerramientaInsumo,
        insumoagenda.IdHerramientaInsumo AS Herramientas,
        insumoagenda.Cantidad AS Cantidades,
        CASE WHEN agendamiento.Estado = '2' THEN 'Pendiente' ELSE 'Realizado' END AS Estado
    FROM agendamiento
    INNER JOIN usuario ON agendamiento.IdUsuario = usuario.IdUsuario
    INNER JOIN servicio ON agendamiento.IdServicio = servicio.IdServicio
    LEFT JOIN insumoagenda ON agendamiento.IdAgendamiento = insumoagenda.IdAgendamiento
    LEFT JOIN herramientainsumo ON FIND_IN_SET(herramientainsumo.IdHerramientaInsumo, agendamiento.IdHerramientaInsumo) > 0
    WHERE agendamiento.IdAgendamiento > 0 ";

    $_SESSION["Columnas"] = $Columnas;
    $_SESSION["Instruccion"] = $InstruccionSql;
    //Cambiar esto por el nombre de la funcion de listar
    $_SESSION["Funcion"] = "ListarAgendamientoAdministrador";
    $ConCol = count($Columnas);
    if (!empty($Busca)) {
        $InstruccionSql .= " AND (";
        for ($i = 0; $i < $ConCol; $i++) {
            $InstruccionSql .= $Columnas[$i] . " LIKE '%" . $Busca . "%' OR ";
        }
        $InstruccionSql = substr_replace($InstruccionSql, "", -3);
        $InstruccionSql .= ")";
    }

    $InstruccionSql .= " GROUP BY agendamiento.IdAgendamiento ";
    if ($Orden[0] != " ") {
        $InstruccionSql .= "ORDER BY $Orden[1] $Orden[0] ";
    }
    $InstruccionSql .= "LIMIT $Inicio, $Registros";

    $resultado = $Conexion->ObtenerDatos($InstruccionSql);
    foreach ($resultado as $fila) {
        $IdHerramientaInsumo = $fila['Herramientas'];
        $StringHerrameintas = [];
        $separador = ",";
        $separadorq = "";
        $separadas = explode($separador, $IdHerramientaInsumo);
        foreach ($separadas as $key => $value) {
            if ($value != "Ninguno") {
                $InstruccionSQL3 = "SELECT Nombre FROM  herramientainsumo where IdHerramientaInsumo=" . $value;
                $resultado3 = $Conexion->ObtenerDatos($InstruccionSQL3);

                foreach ($resultado3 as $key => $fila3) {
                    array_push($StringHerrameintas, "$fila3[Nombre]");
                }
            } else {
                array_push($StringHerrameintas, $IdHerramientaInsumo);
            }
        }
        $StringHerrameintas = implode($separador, $StringHerrameintas);
        echo '
        <tr>
        <td data-th="Id">', $fila['IdAgendamiento'], '</td>
            <td data-th="Nombre">', $fila['NombreUsuario'], ' ', $fila['Apellido'], '</td>
            <td data-th="Cliente">', $fila['NombreCliente'], '</td>
            <td data-th="Servicio">', $fila['NombreServicio'], '</td>
            <td data-th="Direccion">', $fila['DireccionCliente'], '</td>';
            if ($_SESSION["Rol"] !== 1){
                echo'<td>', $fila['Descripcion'], '</td>';
    
            };
            echo'
            <td data-th="Telefono">', $fila['TelefonoCliente'], '</td>
            <td data-th="Fecha">', $fila['FechaServicio'], '</td>
            <td data-th="Insumo">', $StringHerrameintas, '</td>
            <td data-th="Cantidad">', $fila['Cantidades'], '</td>
            <td data-th="Estado"><buttom id="Estado2"   value ="', $fila['Estado'], '" class="', $fila['Estado'] == 'Pendiente' ? 'Estado Inactivo' : 'Estado Activo', '">', $fila['Estado'], '</buttom></td>
           
        ';

        $estadoValue = $fila['Estado'];
        $estadoClass = $estadoValue == 'Pendiente' ? 'Estado Inactivo' : 'Estado Activo';
        $checkBoxPosition = $estadoValue == 'Pendiente' ? 'after' : 'before';
        if ($_SESSION["Rol"] == 1) {
            if($fila['Estado'] !== "Realizado"){
                      echo '
                      
            <td data-th="Operaciones"><Img title="Modificar Agendamiento" onclick="ModalAgendamiento(', $fila['IdAgendamiento'], ')" src="Assets/Img/Iconos/editar.svg"  alt="" class="IconoTabla">
            <img title="Cambiar Estado del Agendamiento" src="Assets/Img\Iconos\desactivar.svg"   onclick="ModalEliminarAgendamiento(', $fila['IdAgendamiento'], ');" class="icon">
           
        </td>
        </tr>';

            }else{
                echo '
                <td data-th="Operaciones"><Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
                <Img src="Assets/Img/Iconos/InEditable.svg" title="Deshabilitado" alt="" class="icon">
               
            </td>
            </tr>
                ';

            }









    
        }
    }
}
function CambiarEstado()
{

    $IdAgendamiento = $_POST["IdAgendamiento"];
    $estado1 = "1";

    $Conexion = new PDODB();

    $Conexion->Conectar();

    $estadoss = "SELECT * FROM agendamiento WHERE IdAgendamiento=" . $IdAgendamiento;

    $resultado = $Conexion->ObtenerDatos($estadoss);

    foreach ($resultado as $key => $fila) {
        $estado = $fila['Estado'];
    }

    if ($estado == "1") {
        $estado1 = "2";
    }
    if ($estado == "1" || $estado == "2") {

        $InstruccionSQL = "UPDATE agendamiento SET Estado = '" . $estado1 . "'
         WHERE IdAgendamiento = " . $IdAgendamiento;

        $resultado = $Conexion->EjecutarInstruccion($InstruccionSQL);

        if ($resultado == true) {
            echo "Se ha cambiado el estado";
        } else {
            echo "Cambio No Realiazado";
        }
    }
}
function ModalAgendamiento()
{
    $Conexion = new PDODB();
    $Conexion->Conectar();
    $IdAgendamiento = $_POST['IdAgendamiento'];
    $sql = "SELECT * FROM agendamiento INNER JOIN usuario ON agendamiento.IdUsuario = usuario.IdUsuario  INNER JOIN servicio ON agendamiento.Idservicio = servicio.IdServicio  WHERE IdAgendamiento = " . $IdAgendamiento;
    $InstruccionSql = "SELECT * FROM usuario WHERE Estado = 1";
    $lista = $Conexion->ObtenerDatos($sql);
    $Resultado = $Conexion->ObtenerDatos($InstruccionSql);
    $InstruccionSql2 = "SELECT * FROM servicio WHERE EstadoServicio = 1";
    $Resultado2 = $Conexion->ObtenerDatos($InstruccionSql2);
    $InstruccionSql3 = "SELECT * FROM insumoagenda WHERE IdInsumoAgenda = ".  $IdAgendamiento;
    $Resultado3 = $Conexion->ObtenerDatos($InstruccionSql3);
    foreach ($lista as $key => $value) {
        echo ' <form action="" Id="ModalAgendamiento">
        <input type="hidden" id="Agendamiento" value="' . $value['IdAgendamiento'] . '">
        <div class="fila">
        <div class="item">
        <p>Nombre Cliente</p>
        <input type="text" id="NombreCliente" onkeyup="ValidarTamañoNombreCliente(this);" placeholder="Ingrese nombre del cliente" value="' . $value['NombreCliente'] . '">
        <br><span id="ValidarCliente"></span>   
        
        </div>
        <div class="item">
        <p>Nombre del Empleado</p>
        <select name="nombre" id="Usuario">
            <option value="' . $value["IdUsuario"] . '">' . $value["Nombre"] . '</option>';
        foreach ($Resultado as $key => $DatosUser) {
            if ($value["IdUsuario"] != $DatosUser["IdUsuario"]) {
                echo '<option value="' . $DatosUser["IdUsuario"] . '">' . $DatosUser["Nombre"] . ' ' . $DatosUser["Apellido"] . '</option>';
            }
        };
        echo '
        <select/>
        <br><span id="MensajeUsuario"></span>
        </div>
        </div>
        <div class="fila">
        <div class="item">
        <p>Telefono del Cliente</p>
        <input type="number" id="Telefono"  onkeyup="ValidarTamañoNumero(this)" value="' . $value['TelefonoCliente'] . '" placeholder="Ingrese telefono">
        <br><span id="MensajeNumero"></span>
        </div>
        <div class="item">
        <p>Fecha</p>
        <input type="date" id="Fecha"  oninput="ValidarFechaDelAgendamiento();"  value="' . $value['FechaServicio'] . '" placeholder="Ingrese fecha">
        <br><span id="MensajeFecha"></span>
        </div>
        </div>
        <div class="fila">
        <div class="item">
        <p>Direccion de la solicitud</p>
        <input type="text" id="Direccion" value="' . $value['DireccionCliente'] . '" placeholder="Ingrese direccion" onkeyup="ValidarTamañoDireccion(this)">
        <br><span id="MensajeDireccion"></span>
        </div>
        <div class="item">
        <p>Tipo de Servicio</p>
        <select class="ContenedorAñadirselect" name="inputselect" name="nombre" id="ServicioModal">
        <option value="' . $value["IdServicio"] . '">' . $value["NombreServicio"] . '</option>';
        foreach ($Resultado2 as $key => $DatosUser2) {
            if ($value["IdServicio"] != $DatosUser2["IdServicio"]) {
                echo '<option value="' . $DatosUser2["IdServicio"] . '">' . $DatosUser2["NombreServicio"] . '</option>';
            }
        };
        echo '
        </select>
        <br><span id="MensajeServicio"></span>
        </div>
        </div>
   
        <p>Escoger insumos</p>
            
                <table id="AgendarInsumos">
                <thead class="tbInsumo">
                <tr>
                <th>Insumo</th>
                <th>Cantidad</th>
                <th>Accion</th>
            </tr>
                </th>
                <tb
              
                <tr>
                        <td>
                        <select name="Insumos" id="Insumos" style = "width:143px">
                        </select></td>
                        <td><Input type="number" value="0" id="Cantidad" step="1.0" min="0"  style = "width:100px"></Input></td>
                        <td><input type="button" class="BotonVerde" onclick="GuardarInsumosAgendamiento()" style = "width:84px" value="Agregar">
    
                    </td>
                </tr> ';
               
                foreach ($Resultado3 as $key => $InsumoAgenda) {  
                    $CadenaSeparadaId = explode(",",$InsumoAgenda['IdHerramientaInsumo']);
                    $CadenaSeparadaCantidades = explode(",",$InsumoAgenda['Cantidad']); 
                }
                foreach($CadenaSeparadaId as $key=> $NombresHerramientas ){
                    if (isset($CadenaSeparadaCantidades[$key])) {
                        $Cantodades = $CadenaSeparadaCantidades[$key];
                        if($NombresHerramientas!=='Ninguno'){
                            $InstruccionSql4 = "SELECT Nombre FROM herramientaInsumo WHERE IdHerramientaInsumo =". $NombresHerramientas;
                            $Resultado4 = $Conexion->ObtenerDatos($InstruccionSql4);
                            foreach ($Resultado4 as $key => $Nombre) {
                            }
                            $NombresHerramientas=trim($NombresHerramientas);

                        echo '
                        <tr >
                        <td>',$Nombre['Nombre'] ,'</td>
                        <td>',$Cantodades ,'  <input type="hidden"  id="CantidadHerramienta'.$Cantodades.'"  value="'.$Cantodades.'"></td>
                        <td><button class="btn-azul-eliminar"  id="IdHerramienta'.$NombresHerramientas.'"  value ="'.$NombresHerramientas.'" onclick="EliminarInsumosAgendamiento('.$NombresHerramientas.')"></button></td>
                        </tr>
                        ';

                        }
            }
        }
                echo'

                <tr>

                </tr>
                </table>
                <span id ="MensajeInsumo"></span></>
        <p>Descripcion</p>
        <textarea  type="text" id="Descripcion"  oninput="ValidarDescripcionAgendamiento(this);" placeholder="Ingrese una descripcion">' . $value['Descripcion'] . '</textarea>
        <br>
        <span id="MensajeDescripcion"></span>
        <br>
        <div class="Boton">
        <button id="Agendar" class="btn-azul" onclick="ModificarAgendamiento()">Modificar</button>
        <button class="btn-rojo" Id="CancelarEnvioModal" onclick=CerrarModalAgendamiento();>Cancelar</button>
   </div>

</div>
</form>

<script>
$(document).ready(function() {
    agregarValores();
    SelectServicio();
    SelectUsuario();
    SelectInsumo();
    ListarNombresEmpleado();
});';
    }
}


function ModificarAgendamiento()
{
    $IdAcumuladas = $_POST["IdRegistrados"];
    $IdAgendamiento = $_POST["IdAgendamiento"];
    $CopiadeArrays = $_POST["Copia"];
    $IdUsuario = $_POST["IdUsuario"];
    $IdServicio = $_POST["IdServicio"];
    $NombreCliente = $_POST["NombreCliente"];
    $Descripcion = $_POST["Descripcion"];
    $FechaServicio = $_POST["FechaServicio"];
    $DireccionCliente = $_POST["DireccionCliente"];
    $TelefonoCliente = $_POST["TelefonoCliente"];
    $Cantidad = $_POST["CantidadRegistrados"];
    $Descripcion = $_POST["Descripcion"];
    $Estado = "2";
    $ListaIdHerramientaInsumo = "";
   
    // Decodificar el objeto Copia
$copiaDecodificada = json_decode($CopiadeArrays);

// Acceder a los arrays en la copia
$copiaIdRegistrados = $copiaDecodificada->copiaIdRegistrados;
$copiaCantidadRegistrados = $copiaDecodificada->copiaCantidadRegistrados;
$iguales = array();
    
// Obtener valores iguales
$iguales = array_intersect($copiaIdRegistrados, $IdAcumuladas);

// Obtener valores únicos en cada array
$diferentesCopia = array_diff($copiaIdRegistrados, $IdAcumuladas);
$diferentesIdacumuladas = array_diff($IdAcumuladas, $copiaIdRegistrados);


$igualesCantidades = array_intersect($copiaCantidadRegistrados,$Cantidad);
// Obtener valores únicos en cada array
$diferentesCantidades = array_diff($Cantidad,$copiaCantidadRegistrados);
$diferentesCopiaCantidades = array_diff($copiaCantidadRegistrados,$Cantidad);
echo"CopiaDecodificada \n";
print_r($copiaDecodificada)."\n";
echo"copiaIdRegistrados \n";
print_r($copiaCantidadRegistrados);
echo"iguales";
print_r($iguales);
echo"diferentesCopia";
print_r($diferentesCopia);
echo"diferentesIdacumuladas";
print_r($diferentesIdacumuladas);
echo"igualesCantidades";
print_r($igualesCantidades);
echo"diferentesCantidades";
print_r($diferentesCantidades);
echo"diferentesCopiaCantidades";
print_r($diferentesCopiaCantidades);
foreach ($IdAcumuladas as $key => $value) {
        $ListaIdHerramientaInsumo = "$ListaIdHerramientaInsumo$value, ";
    }
    $ListaCantidadHerramientaInsumo = "";
    foreach ($Cantidad as $key => $value) {
        $ListaCantidadHerramientaInsumo = "$ListaCantidadHerramientaInsumo$value, ";
    }
    $ListaCantidadHerramientaInsumo = str_replace(' ','',$ListaCantidadHerramientaInsumo);
    $ListaCantidadHerramientaInsumo = substr($ListaCantidadHerramientaInsumo, 0, strlen($ListaCantidadHerramientaInsumo) - 1);
    $ListaIdHerramientaInsumo = str_replace(' ','',$ListaIdHerramientaInsumo);
    $ListaIdHerramientaInsumo = substr($ListaIdHerramientaInsumo, 0, strlen($ListaIdHerramientaInsumo) - 1);
    $Conexion = new PDODB();

    $Conexion->Conectar();


    if($IdAcumuladas[0]=='Ninguno'){
        $NuevaCantidad=0;
        $CompararId=current($copiaIdRegistrados);
        if($CompararId!='Ninguno'){
        foreach ($copiaIdRegistrados as $indice => $IddeHerramientas) {
            $sql10 = "SELECT Cantidad FROM herramientainsumo WHERE IdHerramientaInsumo = " . $IddeHerramientas;
            $resultado = $Conexion->EjecutarInstruccion($sql10);
            foreach ($resultado as $key => $fila10) {}
                $Cantidades = $copiaCantidadRegistrados[$indice];
                $NuevaCantidad=$fila10['Cantidad']+$Cantidades;



            $sql11 = "UPDATE herramientainsumo SET 
            Cantidad = '" . $NuevaCantidad . "'
            WHERE IdHerramientaInsumo = " . $IddeHerramientas;
            $Resultado11=$Conexion->EjecutarInstruccion($sql11);
        }
    }else{
        echo"Cambio de Ninguno a Ninguno Realizado";

    }

    $sql2 = "UPDATE insumoagenda SET 
    IdHerramientaInsumo = '" . $ListaIdHerramientaInsumo . "',
    Cantidad = '" . $ListaCantidadHerramientaInsumo . "'
    WHERE Idinsumoagenda = " . $IdAgendamiento;



$sql = "UPDATE agendamiento SET 
    NombreCliente = '" . $NombreCliente . "',
    FechaServicio = '" . $FechaServicio . "',
    DireccionCliente = '" . $DireccionCliente . "',
    TelefonoCliente = '" . $TelefonoCliente . "',
    IdUsuario = '" . $IdUsuario . "',
    IdServicio = '" . $IdServicio . "',
    Estado = '" . $Estado . "',
    Descripcion = '" . $Descripcion . "',
    IdHerramientaInsumo = '" . $ListaIdHerramientaInsumo . "'
    WHERE IdAgendamiento = " . $IdAgendamiento;

$modificado2 = $Conexion->EjecutarInstruccion($sql2);
$modificado = $Conexion->EjecutarInstruccion($sql);

if ($modificado and $modificado2 ) {
    echo "Se ha modificado correctamente. Primer ciclo";
    $IdAcumuladas=array();
    $Cantidad=array();
} else {
    echo "No fue posible modificar";
}
    }elseif(count($IdAcumuladas)==1 and $IdAcumuladas[0]!=='Ninguno'){
        foreach ($diferentesCopia as $key => $UnicoIdDiferente) {
            if($UnicoIdDiferente=='Ninguno'){
                foreach ($diferentesIdacumuladas as $key => $UnicoIdDiferente2) {
                    $UnicoIdDiferente=$UnicoIdDiferente2;

                    $InstruccionSQL4 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $UnicoIdDiferente;
                    $resultado4 = $Conexion->EjecutarInstruccion($InstruccionSQL4);
                    foreach ($resultado4 as $key => $CantidadInventario) {
                    }
                    $NuevaCantidad = $CantidadInventario['Cantidad'] - $Cantidad[0];
                    $InstruccionSQL20 = "UPDATE herramientainsumo SET Cantidad = $NuevaCantidad WHERE  IdHerramientaInsumo=" .$UnicoIdDiferente;
                    $resultado20 = $Conexion->EjecutarInstruccion($InstruccionSQL20);
                    if($resultado20){
                        echo"Se actuliazo el valor en la base de datos11";
                    }else{
                        echo"Error11";
                    }
                    
                }
            }else{
                foreach ($diferentesIdacumuladas as $key => $UnicoIdDiferente2) {

                    $UnicoIdDiferente2;
                    $InstruccionSQL4 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $UnicoIdDiferente2;
                    $resultado4 = $Conexion->EjecutarInstruccion($InstruccionSQL4);
                    foreach ($resultado4 as $key => $CantidadInventario) {
                    }
                    $NuevaCantidad = $CantidadInventario['Cantidad'] - $Cantidad[0];
                    $InstruccionSQL20 = "UPDATE herramientainsumo SET Cantidad = $NuevaCantidad WHERE  IdHerramientaInsumo=" .$UnicoIdDiferente2;
                    $resultado20 = $Conexion->EjecutarInstruccion($InstruccionSQL20);
                    if($resultado20){
                        echo"Se actuliazo el valor en la base de datos114";
                    }else{
                        echo"Error114";
                    }
                    
    
                }   
            }
                $InstruccionSQL4 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $UnicoIdDiferente;
                $resultado4 = $Conexion->EjecutarInstruccion($InstruccionSQL4);
                foreach ($resultado4 as $key => $CantidadInventario) {
                }
                $key = array_search($UnicoIdDiferente, $copiaIdRegistrados);
                $NuevaCantidad = $CantidadInventario['Cantidad'] + $copiaCantidadRegistrados[$key];
                $InstruccionSQL20 = "UPDATE herramientainsumo SET Cantidad = $NuevaCantidad WHERE  IdHerramientaInsumo=" .$UnicoIdDiferente;
                $resultado20 = $Conexion->EjecutarInstruccion($InstruccionSQL20);
                if($resultado20){
                    echo"Se actuliazo el valor en la base de datos11";
                }else{
                    echo"Error11";
                }

            
            }
       




            foreach ($iguales as $key => $IdIguales){
                $ValorAcomparar = array_search($IdIguales,$copiaIdRegistrados);
                $InstruccionSQL42 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $IdIguales;
                $resultado42 = $Conexion->EjecutarInstruccion($InstruccionSQL42);
                foreach ($resultado42 as $key => $CantidadInventario2) {
                }
                if($copiaCantidadRegistrados[$ValorAcomparar]>$Cantidad[$ValorAcomparar]){

                    $NuevaCantidad2 = $copiaCantidadRegistrados[$ValorAcomparar]-$Cantidad[$ValorAcomparar];
                    $CantidadActulizar = $CantidadInventario2['Cantidad']+$NuevaCantidad2;

                    $InstruccionSQL25 = "UPDATE herramientainsumo SET Cantidad =" . $CantidadActulizar . " WHERE IdHerramientaInsumo = " . $IdIguales;
                    $resultado5 = $Conexion->EjecutarInstruccion($InstruccionSQL25);
                    
                    echo"Se actuliazo el valor en la base de datos111";

                }elseif($copiaCantidadRegistrados[$ValorAcomparar]<$Cantidad[$ValorAcomparar]){


                    $NuevaCantidad2 = $Cantidad[$ValorAcomparar]-$copiaCantidadRegistrados[$ValorAcomparar];
                    $CantidadActulizar = $CantidadInventario2['Cantidad']-$NuevaCantidad2;

                    $InstruccionSQL25 = "UPDATE herramientainsumo SET Cantidad =" . $CantidadActulizar . " WHERE IdHerramientaInsumo = " . $IdIguales;
                    $resultado5 = $Conexion->EjecutarInstruccion($InstruccionSQL25);

                    echo"Se actuliazo el valor en la base de datos222";
                    

                }elseif($copiaCantidadRegistrados[$ValorAcomparar]==$Cantidad[$ValorAcomparar]){

                echo"Valores iguales por lo tanto no se actualiza333";
                

            }

            }
                
        $sql2 = "UPDATE insumoagenda SET 
        IdHerramientaInsumo = '" . $ListaIdHerramientaInsumo . "',
        Cantidad = " . $ListaCantidadHerramientaInsumo . "
        WHERE Idinsumoagenda = " . $IdAgendamiento;
    
        
    
        $sql = "UPDATE agendamiento SET 
            NombreCliente = '" . $NombreCliente . "',
            FechaServicio = '" . $FechaServicio . "',
            DireccionCliente = '" . $DireccionCliente . "',
            TelefonoCliente = '" . $TelefonoCliente . "',
            IdUsuario = '" . $IdUsuario . "',
            IdServicio = '" . $IdServicio . "',
            Estado = '" . $Estado . "',
            Descripcion = '" . $Descripcion . "',
            IdHerramientaInsumo = '" . $ListaIdHerramientaInsumo . "'
            WHERE IdAgendamiento = " . $IdAgendamiento;
    
        $modificado2 = $Conexion->EjecutarInstruccion($sql2);
        $modificado = $Conexion->EjecutarInstruccion($sql);
        if ($modificado== true and $modificado2 == true) {
            echo "Se ha modificado correctamente.Segundo ciclo";
             $IdAcumuladas=array();
            $Cantidad=array();

        }else{
            echo "No se ha modificado";
        } 
        }else{
            foreach ($diferentesIdacumuladas as $key => $IdParaActualizar) {
                $ValorAcomparar = array_search($IdParaActualizar,$IdAcumuladas);

                $InstruccionSQL4 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $IdParaActualizar;
                $resultado4 = $Conexion->EjecutarInstruccion($InstruccionSQL4);
                foreach ($resultado4 as $key => $CantidadInventario) {
                }
                $NuevaCantidad = $CantidadInventario['Cantidad'] - $Cantidad[$ValorAcomparar];

    
        
                $InstruccionSQL5 = "UPDATE herramientainsumo SET Cantidad =" . $NuevaCantidad . " WHERE IdHerramientaInsumo = " . $IdParaActualizar;
                $resultado5 = $Conexion->EjecutarInstruccion($InstruccionSQL5);
                
            
            }
            foreach ($iguales as $key => $IdIguales){
                $ValorAcomparar = array_search($IdIguales,$IdAcumuladas);
                $InstruccionSQL42 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $IdIguales;
                $resultado42 = $Conexion->EjecutarInstruccion($InstruccionSQL42);
                foreach ($resultado42 as $key => $CantidadInventario2) {
                }
                if($copiaCantidadRegistrados[$ValorAcomparar]>$Cantidad[$ValorAcomparar]){

                    $NuevaCantidad2 = $copiaCantidadRegistrados[$ValorAcomparar]-$Cantidad[$ValorAcomparar];
                    $CantidadActulizar = $CantidadInventario2['Cantidad']+$NuevaCantidad2;

                    $InstruccionSQL25 = "UPDATE herramientainsumo SET Cantidad =" . $CantidadActulizar . " WHERE IdHerramientaInsumo = " . $IdIguales;
                    $resultado5 = $Conexion->EjecutarInstruccion($InstruccionSQL25);
                    
                    echo"Se actuliazo el valor en la base de datos1111";

                }elseif($copiaCantidadRegistrados[$ValorAcomparar]<$Cantidad[$ValorAcomparar]){


                    $NuevaCantidad2 = $Cantidad[$ValorAcomparar]-$copiaCantidadRegistrados[$ValorAcomparar];
                    $CantidadActulizar = $CantidadInventario2['Cantidad']-$NuevaCantidad2;

                    $InstruccionSQL25 = "UPDATE herramientainsumo SET Cantidad =" . $CantidadActulizar . " WHERE IdHerramientaInsumo = " . $IdIguales;
                    $resultado5 = $Conexion->EjecutarInstruccion($InstruccionSQL25);

                    echo"Se actuliazo el valor en la base de datos2222";
                    

                }elseif($copiaCantidadRegistrados[$ValorAcomparar]==$Cantidad[$ValorAcomparar]){

                echo"Valores iguales por lo tanto no se actualiza3333";
                

            }

            }


        $sql2 = "UPDATE insumoagenda SET 
        IdHerramientaInsumo = '" . $ListaIdHerramientaInsumo . "',
        Cantidad = '" . $ListaCantidadHerramientaInsumo . "'
        WHERE Idinsumoagenda = " . $IdAgendamiento;
    
        
    
        $sql = "UPDATE agendamiento SET 
            NombreCliente = '" . $NombreCliente . "',
            FechaServicio = '" . $FechaServicio . "',
            DireccionCliente = '" . $DireccionCliente . "',
            TelefonoCliente = '" . $TelefonoCliente . "',
            IdUsuario = '" . $IdUsuario . "',
            IdServicio = '" . $IdServicio . "',
            Estado = '" . $Estado . "',
            Descripcion = '" . $Descripcion . "',
            IdHerramientaInsumo = '" . $ListaIdHerramientaInsumo . "'
            WHERE IdAgendamiento = " . $IdAgendamiento;
    
        $modificado2 = $Conexion->EjecutarInstruccion($sql2);
        $modificado = $Conexion->EjecutarInstruccion($sql);
        if ($modificado== true and $modificado2 == true) {
            echo "Se ha modificado correctamente. tercer ciclo";
            $IdAcumuladas=array();
            $Cantidad=array();
        }else{
            echo "No se ha modificado";
        } 



        }
}




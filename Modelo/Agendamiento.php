<?php
class Agendamiento {
    private $Conexion;

    public function __construct($Conexion) {
        $this->Conexion = $Conexion;
    }

    public function ValidacionDeServiciosEmpleados($IdEmpleado, $FechaServicio){
        $InstruccionSQL ="SELECT FechaServicio FROM agendamiento  WHERE IdUsuario =".$IdEmpleado." AND FechaServicio ='".$FechaServicio."'";
        $Resultado = $this->Conexion->ObtenerDatos($InstruccionSQL);
       
       
        if ($Resultado !== false) {
            // Contar los resultados
            $Cantidad = count($Resultado);
            if ($Cantidad < 10) {
                echo "Hay espacio para programar el servicio para este empleado en esta fecha.";
            } else {
                echo "Este usuario ya tiene la agenda llena para esta fecha.";
            }
        } else {
            echo "La consulta no se hizo correctamente.";
        }    
    }


    public function ModalNovedadAgendamiento($IdUsuario){
 
    $InstruccionSQL = "SELECT *
    FROM novedad
    WHERE IdUsuario = ".$IdUsuario." AND EstadoNovedad < 2
    ORDER BY IdNovedad DESC
    LIMIT 5";
    
        // $InstruccionSQL = "SELECT * FROM novedad WHERE IdUsuario= ".$IdUsuario;
        $Resultado = $this->Conexion->ObtenerDatos($InstruccionSQL);
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


    public function ModalPrestamoAgendamiento($IdUsuario){
    $InstruccionSQL = "SELECT *
    FROM novedad
    WHERE IdUsuario = ".$IdUsuario." AND EstadoNovedad < 2
    ORDER BY IdNovedad DESC
    LIMIT 5";
    
        $InstruccionSQL = "SELECT * FROM solicitudprestamo WHERE IdUsuario= ".$IdUsuario;
        $Resultado = $this->Conexion->ObtenerDatos($InstruccionSQL);
        
        foreach ($Resultado as $key => $Value) {
        echo'
        <div class="modalnotificacion" >
        <h3>Herramienta :</h3>'; 
        $InstruccionSQL2 = "SELECT Nombre FROM herramientainsumo WHERE IdHerramientaInsumo = ".$Value['IdHerramientaInsumo'];
        $Resultado2 =  $this->Conexion->ObtenerDatos($InstruccionSQL2);
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
     echo'</div>';
    }


    }


    public function ModalEliminarAgendamiento($Id){
        $InstruccionSQL = "SELECT * FROM agendamiento WHERE IdAgendamiento = ".$Id;
        $Resultado =  $this->Conexion->ObtenerDatos($InstruccionSQL);
        foreach ($Resultado as $key => $Value) {
          
        echo'<center><h3>¿Está seguro de cambiar de estado el agendamiento?</h3></center>
        <div class="Boton">
        <button class="btn-azul" onclick="CambiarEstado('.$Value['IdAgendamiento'].' )">Aceptar</button>
        <button class="btn-rojo" Id="CancelarEnvioModal" onclick=CerrarModalAgendamiento();>Cancelar</button>
        </div>
    
        ';
        
    }
}

    
    public function GuardarAgendamiento($Cantidad,$IdAcumuladas,$IdUsuario,$IdServicio,$NombreCliente,$Descripcion,$FechaServicio,$DireccionCliente,$TelefonoCliente,$Estado,$ListaCantidadHerramientaInsumo,$ListaIdHerramientaInsumo)
    {

        $InstruccionSQL1 = "INSERT INTO agendamiento 
        VALUES
        (null,'" . $IdUsuario . "','" . $IdServicio . "','" . $ListaIdHerramientaInsumo . "','" . $NombreCliente . "','" . $Descripcion . "','" . $FechaServicio . "','" . $DireccionCliente . "','" . $TelefonoCliente . "','" . $Estado . "')";
            $resultado1 = $this->Conexion->EjecutarInstruccion($InstruccionSQL1);
            $InstruccionSQL2 = "SELECT MAX(IdAgendamiento) as IdAgendamiento FROM agendamiento;";
            $resultado2 = $this->Conexion->EjecutarInstruccion($InstruccionSQL2);
            foreach ($resultado2 as $key => $value) {
                $IdAgendamiento = "$value[0]";
            }
            $InstruccionSQL3 = "INSERT INTO insumoagenda
        VALUES
        ('" . $IdAgendamiento . "','" . $ListaIdHerramientaInsumo . "','" . $IdAgendamiento . "','" . $ListaCantidadHerramientaInsumo . "')";
            $resultado3 = $this->Conexion->EjecutarInstruccion($InstruccionSQL3);
        
            if ($ListaIdHerramientaInsumo != 'Ninguno') {
                for ($i = 0; $i < count($IdAcumuladas); $i++) {
                    $InstruccionSQL4 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $IdAcumuladas[$i];
                    $resultado4 =$this->Conexion->EjecutarInstruccion($InstruccionSQL4);
                    foreach ($resultado4 as $key => $CantidadInventario) {
                    }
                    $NuevaCantidad = $CantidadInventario['Cantidad'] - $Cantidad[$i];
        
        
                    $InstruccionSQL5 = "UPDATE herramientainsumo SET Cantidad =" . $NuevaCantidad . " WHERE IdHerramientaInsumo = " . $IdAcumuladas[$i];
                    $resultado5 = $this->Conexion->EjecutarInstruccion($InstruccionSQL5);
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



public function SelectServicio()
{
    
    $sql = "SELECT * FROM servicio";
    $lista = $this->Conexion->ObtenerDatos($sql);

    foreach ($lista as $key => $value) {
        if ($value['EstadoServicio'] == 1) {
            echo '
                <option value="" hidden>Selecciona una opción</option>
                <option value="' . $value['IdServicio'] . '">' . $value['NombreServicio'] . '</option>
            ';
        }
    }


}


public function SelectInsumo($IdRegistrados) {
    $sql = "SELECT * FROM herramientainsumo WHERE Cantidad > 0";
    $lista = $this->Conexion->ObtenerDatos($sql);

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





public function SelectUsuario(){
    $sql = "SELECT * FROM usuario";
    $lista = $this->Conexion->ObtenerDatos($sql);

    foreach ($lista as $key => $value) {
        echo '
                <option value="" hidden>Selecciona una opción</option>
                <option  value="' . $value['IdUsuario'] . '">' . $value['Nombre'] . ' ' . $value['Apellido'] . '</option>
            ';
    }

}


public function ListarAgendamientoAdministrador($NombreRol,$Pagina,$Registros,$Inicio,$Orden,$Busca,$Columnas) {
    
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

    if ($NombreRol != 1) {
        $InstruccionSql .= "AND agendamiento.IdUsuario = " . $_SESSION["IdUsuario"] . " ";
    }

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

    // $InstruccionSql .= " GROUP BY agendamiento.IdAgendamiento ";
    if ($Orden[0] != " ") {
        $InstruccionSql .= "ORDER BY $Orden[1] $Orden[0] ";
    }
    $InstruccionSql .= "LIMIT $Inicio, $Registros";

    $resultado = $this->Conexion->ObtenerDatos($InstruccionSql);
    $ResultadoContar = count($resultado);
    if ($ResultadoContar > 0) {
    foreach ($resultado as $fila) {
        $IdHerramientaInsumo = $fila['Herramientas'];
        $StringHerrameintas = [];
        $separador = ",";
        $separadorq = "";
        $separadas = explode($separador, $IdHerramientaInsumo);
        foreach ($separadas as $key => $value) {
            if ($value != "Ninguno") {
                $InstruccionSQL3 = "SELECT Nombre FROM  herramientainsumo where IdHerramientaInsumo=" . $value;
                $resultado3 = $this->Conexion->ObtenerDatos($InstruccionSQL3);

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
            <td data-th="Direccion">', $fila['DireccionCliente'], '</td>
            <td>', $fila['Descripcion'], '</td>
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
} else {
    echo '<td colspan="9">Sin resultados</td>';
}

}

public function CambiarEstado($IdAgendamiento,$estado1) {
    $estadoss = "SELECT * FROM agendamiento WHERE IdAgendamiento=" . $IdAgendamiento;

    $resultado = $this->Conexion->ObtenerDatos($estadoss);

    foreach ($resultado as $key => $fila) {
        $estado = $fila['Estado'];
    }

    if ($estado == "1") {
        $estado1 = "2";
    }
    if ($estado == "1" || $estado == "2") {

        $InstruccionSQL = "UPDATE agendamiento SET Estado = '" . $estado1 . "'
         WHERE IdAgendamiento = " . $IdAgendamiento;

        $resultado = $this->Conexion->EjecutarInstruccion($InstruccionSQL);

        if ($resultado == true) {
            echo "Se ha cambiado el estado";
        } else {
            echo "Cambio No Realiazado";
        }
    }
}


    public function ModalAgendamiento($IdAgendamiento){
         
    $sql = "SELECT * FROM agendamiento INNER JOIN usuario ON agendamiento.IdUsuario = usuario.IdUsuario  INNER JOIN servicio ON agendamiento.Idservicio = servicio.IdServicio  WHERE IdAgendamiento = " . $IdAgendamiento;
    $InstruccionSql = "SELECT * FROM usuario WHERE Estado = 1";
    $lista = $this->Conexion->ObtenerDatos($sql);
    $Resultado = $this->Conexion->ObtenerDatos($InstruccionSql);
    $InstruccionSql2 = "SELECT * FROM servicio WHERE EstadoServicio = 1";
    $Resultado2 = $this->Conexion->ObtenerDatos($InstruccionSql2);
    $InstruccionSql3 = "SELECT * FROM insumoagenda WHERE IdInsumoAgenda = ".  $IdAgendamiento;
    $Resultado3 = $this->Conexion->ObtenerDatos($InstruccionSql3);
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
                            $Resultado4 = $this->Conexion->ObtenerDatos($InstruccionSql4);
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


 public function ModificarAgendamiento($IdAcumuladas,$IdAgendamiento,$IdUsuario,$IdServicio,$NombreCliente,
 $Descripcion,$FechaServicio,$DireccionCliente,$TelefonoCliente,$Cantidad,
 $Estado,$ListaIdHerramientaInsumo,$copiaIdRegistrados,$copiaCantidadRegistrados,$ListaCantidadHerramientaInsumo,$diferentesCopia,
 $diferentesIdacumuladas,$iguales){
    if($IdAcumuladas[0]=='Ninguno'){
        $NuevaCantidad=0;
        $CompararId=current($copiaIdRegistrados);
        if($CompararId!='Ninguno'){
        foreach ($copiaIdRegistrados as $indice => $IddeHerramientas) {
            $sql10 = "SELECT Cantidad FROM herramientainsumo WHERE IdHerramientaInsumo = " . $IddeHerramientas;
            $resultado = $this->Conexion->EjecutarInstruccion($sql10);
            foreach ($resultado as $key => $fila10) {}
                $Cantidades = $copiaCantidadRegistrados[$indice];
                $NuevaCantidad=$fila10['Cantidad']+$Cantidades;



            $sql11 = "UPDATE herramientainsumo SET 
            Cantidad = '" . $NuevaCantidad . "'
            WHERE IdHerramientaInsumo = " . $IddeHerramientas;
            $Resultado11=$this->Conexion->EjecutarInstruccion($sql11);
        }
    }else{
        echo"Cambio Realizado";

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

$modificado2 = $this->Conexion->EjecutarInstruccion($sql2);
$modificado = $this->Conexion->EjecutarInstruccion($sql);

if ($modificado and $modificado2 ) {
    echo "Se ha modificado correctamente.";
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
                    $resultado4 = $this->Conexion->EjecutarInstruccion($InstruccionSQL4);
                    foreach ($resultado4 as $key => $CantidadInventario) {
                    }
                    $NuevaCantidad = $CantidadInventario['Cantidad'] - $Cantidad[0];
                    $InstruccionSQL20 = "UPDATE herramientainsumo SET Cantidad = $NuevaCantidad WHERE  IdHerramientaInsumo=" .$UnicoIdDiferente;
                    $resultado20 = $this->Conexion->EjecutarInstruccion($InstruccionSQL20);
                  
                    
                }
            }else{
                foreach ($diferentesIdacumuladas as $key => $UnicoIdDiferente2) {

                    $UnicoIdDiferente2;
                    $InstruccionSQL4 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $UnicoIdDiferente2;
                    $resultado4 = $this->Conexion->EjecutarInstruccion($InstruccionSQL4);
                    foreach ($resultado4 as $key => $CantidadInventario) {
                    }
                    $NuevaCantidad = $CantidadInventario['Cantidad'] - $Cantidad[0];
                    $InstruccionSQL20 = "UPDATE herramientainsumo SET Cantidad = $NuevaCantidad WHERE  IdHerramientaInsumo=" .$UnicoIdDiferente2;
                    $resultado20 = $this->Conexion->EjecutarInstruccion($InstruccionSQL20);
    
    
                }   
            }
                $InstruccionSQL4 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $UnicoIdDiferente;
                $resultado4 = $this->Conexion->EjecutarInstruccion($InstruccionSQL4);
                foreach ($resultado4 as $key => $CantidadInventario) {
                }
                $key = array_search($UnicoIdDiferente, $copiaIdRegistrados);
                $NuevaCantidad = $CantidadInventario['Cantidad'] + $copiaCantidadRegistrados[$key];
                $InstruccionSQL20 = "UPDATE herramientainsumo SET Cantidad = $NuevaCantidad WHERE  IdHerramientaInsumo=" .$UnicoIdDiferente;
                $resultado20 = $this->Conexion->EjecutarInstruccion($InstruccionSQL20);

            
            }
       




            foreach ($iguales as $key => $IdIguales){
                $ValorAcomparar = array_search($IdIguales,$copiaIdRegistrados);
                $InstruccionSQL42 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $IdIguales;
                $resultado42 = $this->Conexion->EjecutarInstruccion($InstruccionSQL42);
                foreach ($resultado42 as $key => $CantidadInventario2) {
                }
                if($copiaCantidadRegistrados[$ValorAcomparar]>$Cantidad[$ValorAcomparar]){

                    $NuevaCantidad2 = $copiaCantidadRegistrados[$ValorAcomparar]-$Cantidad[$ValorAcomparar];
                    $CantidadActulizar = $CantidadInventario2['Cantidad']+$NuevaCantidad2;

                    $InstruccionSQL25 = "UPDATE herramientainsumo SET Cantidad =" . $CantidadActulizar . " WHERE IdHerramientaInsumo = " . $IdIguales;
                    $resultado5 = $this->Conexion->EjecutarInstruccion($InstruccionSQL25);
                    
                   
                    

                }elseif($copiaCantidadRegistrados[$ValorAcomparar]<$Cantidad[$ValorAcomparar]){


                    $NuevaCantidad2 = $Cantidad[$ValorAcomparar]-$copiaCantidadRegistrados[$ValorAcomparar];
                    $CantidadActulizar = $CantidadInventario2['Cantidad']-$NuevaCantidad2;

                    $InstruccionSQL25 = "UPDATE herramientainsumo SET Cantidad =" . $CantidadActulizar . " WHERE IdHerramientaInsumo = " . $IdIguales;
                    $resultado5 = $this->Conexion->EjecutarInstruccion($InstruccionSQL25);

                    

                    

                }elseif($copiaCantidadRegistrados[$ValorAcomparar]==$Cantidad[$ValorAcomparar]){

                    

                

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
    
        $modificado2 = $this->Conexion->EjecutarInstruccion($sql2);
        $modificado = $this->Conexion->EjecutarInstruccion($sql);
        if ($modificado== true and $modificado2 == true) {
            echo "Se ha modificado correctamente.";
             $IdAcumuladas=array();
            $Cantidad=array();

        }else{
            echo "No se ha modificado";
        } 
        }else{
            foreach ($diferentesIdacumuladas as $key => $IdParaActualizar) {
                $ValorAcomparar = array_search($IdParaActualizar,$IdAcumuladas);

                $InstruccionSQL4 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $IdParaActualizar;
                $resultado4 = $this->Conexion->EjecutarInstruccion($InstruccionSQL4);
                foreach ($resultado4 as $key => $CantidadInventario) {
                }
                $NuevaCantidad = $CantidadInventario['Cantidad'] - $Cantidad[$ValorAcomparar];

    
        
                $InstruccionSQL5 = "UPDATE herramientainsumo SET Cantidad =" . $NuevaCantidad . " WHERE IdHerramientaInsumo = " . $IdParaActualizar;
                $resultado5 = $this->Conexion->EjecutarInstruccion($InstruccionSQL5);
                
            
            }
            foreach ($iguales as $key => $IdIguales){
                $ValorAcomparar = array_search($IdIguales,$IdAcumuladas);
                $InstruccionSQL42 = "SELECT Cantidad FROM herramientainsumo WHERE  IdHerramientaInsumo=" . $IdIguales;
                $resultado42 = $this->Conexion->EjecutarInstruccion($InstruccionSQL42);
                foreach ($resultado42 as $key => $CantidadInventario2) {
                }
                if($copiaCantidadRegistrados[$ValorAcomparar]>$Cantidad[$ValorAcomparar]){

                    $NuevaCantidad2 = $copiaCantidadRegistrados[$ValorAcomparar]-$Cantidad[$ValorAcomparar];
                    $CantidadActulizar = $CantidadInventario2['Cantidad']+$NuevaCantidad2;

                    $InstruccionSQL25 = "UPDATE herramientainsumo SET Cantidad =" . $CantidadActulizar . " WHERE IdHerramientaInsumo = " . $IdIguales;
                    $resultado5 = $this->Conexion->EjecutarInstruccion($InstruccionSQL25);
                    
                
                    

                }elseif($copiaCantidadRegistrados[$ValorAcomparar]<$Cantidad[$ValorAcomparar]){


                    $NuevaCantidad2 = $Cantidad[$ValorAcomparar]-$copiaCantidadRegistrados[$ValorAcomparar];
                    $CantidadActulizar = $CantidadInventario2['Cantidad']-$NuevaCantidad2;

                    $InstruccionSQL25 = "UPDATE herramientainsumo SET Cantidad =" . $CantidadActulizar . " WHERE IdHerramientaInsumo = " . $IdIguales;
                    $resultado5 = $this->Conexion->EjecutarInstruccion($InstruccionSQL25);

                 
                    
                    

                }elseif($copiaCantidadRegistrados[$ValorAcomparar]==$Cantidad[$ValorAcomparar]){

                   
               
                

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
    
        $modificado2 = $this->Conexion->EjecutarInstruccion($sql2);
        $modificado = $this->Conexion->EjecutarInstruccion($sql);
        if ($modificado== true and $modificado2 == true) {
            echo "Se ha modificado correctamente.";
            $IdAcumuladas=array();
            $Cantidad=array();
        }else{
            echo "No se ha modificado";
        } 



        }
}


 }














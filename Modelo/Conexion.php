<?php

class PDODB
{
    private $Host; // Atributo HOST
    private $Usuario; // Atributo Usuario
    private $Con; // Atributo Contraseña
    private $Bd; // Atributo Nombre de Base de datos

    private $Conexion; // Atributo Conexión, aquí se guardá la conexión una vez que se crea.

    function __Construct() // Este método es el que le asigna los valores a cada atributo de la clase
    // El valor asignado es el que esta entre Comillas.
    {
        $this->Host = "localhost";
        $this->Usuario = "root";
        $this->Con = "";
        $this->Bd = "maxisoft";
    }

    function Conectar() // Este método lo que hace es definir a la variable $Opciones algunas 
    // configuraciones como el tipo de escritura de texto, para que nos acepta la escritura latina.
    {
        $Opciones = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        );
        // En este siguiente punto exactamente se esta creando la conexión
        // al decir new PDO y dentro del paréntesis asignando los atributos todo eso queda asignado
        // al objeto Connection
        $this->Conexion = new PDO(
            'mysql:host=' . $this->Host . ';dbname=' . $this->Bd,
            $this->Usuario,
            $this->Con,
            $Opciones
        );
    }

    function ObtenerDatos($Sql) // Este método tiene como objetivo obtener datos, por ejemplo el listado
    // de registros para ser mostrados en la tabla
    {
        try {
            $Datos = array();
            $Resultado = $this->Conexion->query($Sql);
            if ($Resultado->rowCount() > 0) {
                while ($Fila = $Resultado->fetch(PDO::FETCH_ASSOC)) {
                    array_push($Datos, $Fila);
                }
            }
            return $Datos;
        } catch (\Throwable $Th) {
            die("Algo salio mal en el codigo para listar, Error " + $Th);
        }
    }

    // function Acceso($Correo, $Contrasena) // Este metodo es para iniciar sesion
    // // Admin o usuarios 
    // {
    // $Conexion = new PDODB();

    // $Conexion->Conectar();
    //     $consulta = "SELECT *
    //     FROM usuario
    //     INNER JOIN rol ON usuario.IdRol = rol.IdRol
    //     WHERE Correo = :Correo;";
    //     $stmt = $Conexion->ObtenerDatos($consulta);
    //     $stmt->bindParam(':Correo', $Correo);
    //     $stmt->execute();
    //     $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    //     if ($resultado && $Contrasena == $resultado['Contrasena']) {
    //         return $resultado;
    //     } else {
    //         return false;
    //     }
    // }


    function EjecutarInstruccion($Sql) // Este método tiene como objetivo ejecutar instrucciones
    // como por ejemplo cuando vamos a guardar, modificar o eliminar un regístro en la base de datos.
    {
        try {
            $Resultado = $this->Conexion->query($Sql);
            return $Resultado;
        } catch (Exception $e) {
            die("Algo salio mal en el codigo, Error " + $e);
        }
    }

    function Cerrar() // Este método tiene como objetivo cerrar la conexión
    // vaciando los valores del objeto Connection.
    {
        $this->Conexion = null;
    }
}
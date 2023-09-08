


var Asigna = 0
var IdRegistrados = []
var CantidadRegistrados = []
var NuevaCantidad=0
var  Copia = new Object;
var  valorNulo = new Object;
var ValidarAgendadelEmpleado = false


function ValidarElTamañoMaximoFecha(){
  // Obtén una referencia al elemento de entrada date
  var fechaInput = document.getElementById("Fecha");

  // Obtén la fecha actual en formato ISO (AAAA-MM-DD)
  var fechaActual = new Date().toISOString().split("T")[0];
  // Establece la fecha mínima como la fecha actual
  fechaInput.setAttribute("min", fechaActual);

  // Establece la fecha máxima como, por ejemplo, 30 días después de la fecha actual
  var fechaMaxima = new Date();
  fechaMaxima.setDate(fechaMaxima.getDate() + 120);
  fechaInput.setAttribute("max", fechaMaxima.toISOString().split("T")[0]);

  }

  


  function ValidacionDeServiciosEmpleados(){
    var IdEmpleado= document.getElementById("Empleado").value
    var FechaServicio = document.getElementById("Fecha").value

    

    $.ajax({
      type: "POST",
      url: "../Controlador/Agendamiento.php",
      data: {
          'IdEmpleado': IdEmpleado,
          'FechaServicio': FechaServicio,
          'Metodo': "ValidacionDeServiciosEmpleados"
      },
      datatype: "html",
      success: function (data) {
        if(data==="Este usuario ya tiene la agenda llena para esta fecha."){
          Swal.fire({
            icon: 'error',      
            text: 'Este usuario ya tiene la agenda llena para esta fecha.'      
          });
          ValidarAgendadelEmpleado = false
          ValidarAgendamiento();
        }else{
          ValidarAgendadelEmpleado = true
          ValidarAgendamiento();
        }
    
      },
  });

}








function CambiarInsumos(){
  var table = document.getElementById('AgendarInsumos');
  var rows = table.getElementsByTagName('tr');
  for (var i = 2; i < rows.length; i++) {
    var cells = rows[i].getElementsByTagName('td');
    if (cells.length > 0) {
      var cellValue = cells[0].innerHTML;
      console.log(cellValue);
    }
  }

}

function ModalEliminarAgendamiento(Id) {
  window.modal.showModal();
  $.ajax({
      type: "POST",
      url: "../Controlador/Agendamiento.php",
      data: {
          'Id': Id,
          'Metodo': "ModalEliminarAgendamiento"
      },
      datatype: "html",
      success: function (data) {
          $('.modal-body').text("");
          $('.modal-body').append(data);
      },
  });
}

function ModalNovedadAgendamiento() {
  var IdUsuario = document.getElementById("IdUsuario").value
  $.ajax({
      type: "POST",
      url: "../Controlador/Agendamiento.php",
      data: {
          'IdUsuario': IdUsuario,
          'Metodo': "ModalNovedadAgendamiento"
      },
      datatype: "html",
      success: function (data) {
          $('#novedadAgendamiento').text("");
          $('#novedadAgendamiento').append(data);
      },
  });
}

function ModalPrestamoAgendamiento() {
  var IdUsuario = document.getElementById("IdUsuario").value
  $.ajax({
      type: "POST",
      url: "../Controlador/Agendamiento.php",
      data: {
          'IdUsuario': IdUsuario,
          'Metodo': "ModalPrestamoAgendamiento"
      },
      datatype: "html",
      success: function (data) {
          $('#PrestamoAgendamiento').text("");
          $('#PrestamoAgendamiento').append(data);
      },
  });
}







function GuardarAgendamiento() {
  event.preventDefault();
    if (CantidadRegistrados.length === 0 && IdRegistrados.length===0) { 
        CantidadRegistrados=['0']
        IdRegistrados=['Ninguno']
        $.ajax({
            type: "POST",
            url: "../Controlador/Agendamiento.php",
            data: {
                'NombreCliente': $('#NombreCliente').val(),
                'IdUsuario': $('#Empleado').val(),
                'CantidadRegistrados': CantidadRegistrados,
                'IdRegistrados': IdRegistrados,
                'TelefonoCliente': $('#Telefono').val(),
                'FechaServicio': $('#Fecha').val(),
                'HoraAgendamiento': $('#Hora').val(),
                'IdServicio': $('#Servicio').val(),
                'IdHerramientaInsumo': $('#Insumos').val(),
                'Cantidad': $('#Cantidad').val(),
                'Descripcion': $('#Descripcion').val(),
                'DireccionCliente': $('#Direccion').val(),
                'Metodo': 'GuardarAgendamiento'
            },
            success: function (data) {
              Swal.fire({
                icon: 'success',
                text: data
              });
                $('#NombreCliente').val('');
                $('#Telefono').val('');
                $('#Fecha').val('');
                $('#Servicio').val('');
                $('#Insumos').val('');
                $('#Cantidad').val('');
                $('#Direccion').val('');
                $('#Descripcion').val('');
                CantidadRegistrados=[]
                IdRegistrados=[]
                
            }
        });
        Metodo("Particiones/ListarAgendamientoAdmin.php")
    }else{
        $.ajax({
            type: "POST",
            url: "../Controlador/Agendamiento.php",
            data: {
                'NombreCliente': $('#NombreCliente').val(),
                'IdUsuario': $('#Empleado').val(),
                'CantidadRegistrados': CantidadRegistrados,
                'IdRegistrados': IdRegistrados,
                'TelefonoCliente': $('#Telefono').val(),
                'FechaServicio': $('#Fecha').val(),
                'HoraAgendamiento': $('#Hora').val(),
                'IdServicio': $('#Servicio').val(),
                'IdHerramientaInsumo': $('#Insumos').val(),
                'Cantidad': $('#Cantidad').val(),
                'Descripcion': $('#Descripcion').val(),
                'DireccionCliente': $('#Direccion').val(),
                'Metodo': 'GuardarAgendamiento'
            },
            success: function (data) {
              Swal.fire({
                icon: 'success',
                text: data
              });
                $('#NombreCliente').val('');
                $('#Telefono').val('');
                $('#Fecha').val('');
                $('#Servicio').val('');
                $('#Insumos').val('');
                $('#Cantidad').val('');
                $('#Direccion').val('');
                $('#Descripcion').val('');
                CantidadRegistrados=[]
                IdRegistrados=[]
                
            }
        });
        Metodo("Particiones/ListarAgendamientoAdmin.php")

    }
   
}



function GuardarInsumosAgendamiento() {

    var table = document.getElementById("AgendarInsumos");
    var Cantidad = document.getElementById("Cantidad");
    var Insumo = document.getElementById("Insumos");
    var errorMsg = document.getElementById("MensajeInsumo");
    var CantidadActual = document.getElementById("CantidadActual"+Insumo.value);
    var IdInsumo = document.getElementById("IdInsumo"+Insumo.value);
    if (Cantidad.value != "0" && Insumo.value!=""){
    NuevaCantidad=CantidadActual.value-Cantidad.value;
    if (NuevaCantidad>=0) {
      errorMsg.textContent=""
        var row = table.insertRow(2);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        IdRegistrados.push(IdInsumo.value)
        CantidadRegistrados.push(Cantidad.value)
        cell1.innerHTML = Insumo.value;
        cell2.innerHTML = Cantidad.value+'<input id="CantidadAgendada'+IdInsumo.value+'" type="hidden" value="'+Cantidad.value+'"></input>';
        cell3.innerHTML = '<button  title ="Eliminar Insumo" class="btn-azul-eliminar" Id="IdHerramienta'+IdInsumo.value+'" onclick="EliminarInsumosAgendamiento('+IdInsumo.value+')"></button>';

        $.ajax({
            type: "POST",
            url: "../Controlador/Agendamiento.php",
            data: {
                
                'IdHerramientaInsumo': $('#Insumos').val(),
                'CantidadRegistrados': CantidadRegistrados,
                'IdRegistrados': IdRegistrados,
                'NuevaCantidad': NuevaCantidad,
                'Cantidad': $('#Cantidad').val(),
                'Id': $('#IdInsumo').val(),
                'Metodo': 'GuardarInsumosAgendamiento'
            },
            success: function () {
                SelectInsumo();
                $('#Insumos').val('');
                $('#Cantidad').val('0');
                $('#Medida').val('');
                
            }
        });
 
}else{
  errorMsg.textContent="Cantidad de Insumo Insuficiente,Tiene esta cantidad de Insumo disponible : "+CantidadActual.value;}
}

}





function ValidarTamañoNombreCliente(elemento) {
  let inputValue = elemento.value;

    var errorMsg = document.getElementById("ValidarCliente");

    if (inputValue.length < 2|| inputValue.length >=50) {
      errorMsg.textContent = "No se permiten más de 50 caracteres o menos de 2.";
    }else if (inputValue.trim() !== inputValue) {
        errorMsg.textContent = "La descripcion no puede iniciar ni terminar con un espacio"
      }
    else if (!/^[a-zA-Z0-9ñÑ\s]+$/.test(inputValue) || /^\s/.test(inputValue) || /\s$/.test(inputValue) || /\s\s/.test(inputValue)) {
    
      errorMsg.textContent="El nombre del cliente no puede tener caracteres numericos o especiales"
      }
    else {
      errorMsg.textContent = "";
    }
    ValidarAgendamiento();
  }


  function ValidarEmpleado() {
  let inputValue = document.getElementById("Empleado");
    var errorMsg = document.getElementById("MensajeEmpleado");
  
    if (inputValue.value == null || inputValue.value == "") { 
      errorMsg.textContent = "Ingrese un empleado.";
    } else {
      errorMsg.textContent = "";
    }
    ValidarAgendamiento();
  }


  function ValidarUsuario() {
    let inputValue = document.getElementById("Usuario");
      var errorMsg = document.getElementById("MensajeEmpleado");
    
      if (inputValue.value == null || inputValue.value == "") { 
        errorMsg.textContent = "Ingrese un empleado.";
      } else {
        errorMsg.textContent = "";
      }
      ValidarAgendamiento();
    }
  




function ValidarServicio() {
  let inputValue = document.getElementById("Servicio");
  var errorMsg = document.getElementById("MensajeServicio");

  if (inputValue.value == null || inputValue.value == "") { 
    errorMsg.textContent = "Ingrese un servicio.";
  } else {
    errorMsg.textContent = "";
  }
  ValidarAgendamiento();
}

function ValidarServicioModal() {
  let inputValue = document.getElementById("ServicioModal");
  var errorMsg = document.getElementById("MensajeServicio");

  if (inputValue.value == null || inputValue.value == "") { 
    errorMsg.textContent = "Ingrese un servicio.";
  } else {
    errorMsg.textContent = "";
  }
  ValidarAgendamiento();
}




  function ValidarFechaDelAgendamiento() {
    var fechaInput = document.getElementById("Fecha").value;
    var parts = fechaInput.split('-');
    var Fecha = new Date(parts[0], parts[1] - 1, parts[2]); // Restar 1 al mes para que sea compatible con la indexación de JavaScript
    var hoy = new Date();
    var errorMsg = document.getElementById("MensajeFecha");

    // Convertir las fechas a formato de solo fecha (sin hora) para comparar
    var fechaFormateada = new Date(Fecha.getFullYear(), Fecha.getMonth(), Fecha.getDate());
    var hoyFormateado = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());

    if (fechaFormateada.getTime() === hoyFormateado.getTime()) {
        errorMsg.textContent = "No se pueden agendar servicios para el mismo día.";
    } else if (Fecha < hoy) {
        errorMsg.textContent = "La fecha seleccionada ya ha pasado.";
    } else {
        errorMsg.textContent = "";
    }
   ValidarAgendamiento(); 
}


function ValidarAgendamiento() {

  let Nombre = document.getElementById("NombreCliente").value
  let Direccion = document.getElementById("Direccion").value.trim();
  let Descripcion = document.getElementById("Descripcion").value.trim();
  let Empleado = document.getElementById("Empleado").value.trim();
  let Fecha = document.getElementById("Fecha").value.trim();
  let Servicio = document.getElementById("Servicio").value.trim();
  let Telefono = document.getElementById("Telefono").value.trim();





  let NombreValido = Nombre.length > 1 && Nombre.length <= 50 && /^[a-zA-Z0-9ñÑ\s]+$/.test(Nombre) && !/^\s/.test(Nombre) && !/\s$/.test(Nombre) && !/\s\s/.test(Nombre);
  let DireccionValido = Direccion.length >= 10 && Direccion.length <=200;
  let DescripcionValido = Descripcion.length >= 10 && Descripcion.length<= 200 ;
  let EmpleadoValido = Empleado!="";
  let ServicioValido =  Servicio !="";
  let FechaValido =  Fecha!="";
  let TelefonoValido = Telefono.length==10 && /^[0-9]{1,11}$/.test(Telefono) ;


  

  let submitButton = document.getElementById("Agendar");
  if (NombreValido &&  DireccionValido && DescripcionValido && EmpleadoValido && ServicioValido && FechaValido && TelefonoValido && ValidarAgendadelEmpleado) {
      submitButton.disabled = false;
  } else {
      submitButton.disabled = true;
  }
}

function ValidarDescripcionAgendamiento(elemento){
  let inputValue = elemento.value
  var errorMsg = document.getElementById("MensajeDescripcion");

if (inputValue.trim() !== inputValue) {
  errorMsg.textContent = "La descripcion no puede iniciar ni terminar con un espacio"
}
  else if (inputValue.length == 0){
    errorMsg.textContent="El Ingrese alguna descripcion."
    
  }else if(inputValue.length<=10){
    errorMsg.textContent="El minimo de caracteres para aceptar la descripcion es de 10."
  }else if(inputValue.length>=200){
  errorMsg.textContent="El maximo de caracteres para la descripcion es de 200."
  }
  else{
    errorMsg.textContent=""
  }
  ValidarAgendamiento()
  }








  
function ValidarTamañoNumero(elemento) {
    let inputValue = elemento.value.trim();

    var errorMsg = document.getElementById("MensajeNumero");

    if (inputValue.length >10) {
     // Limita el contenido a los primeros 100 caracteres.
      errorMsg.textContent = "Se permiten máximo  10 numeros.";
    }
    else if (!/^[0-9]{1,11}$/.test(inputValue)) {
      errorMsg.textContent = "El telefono no puede contener caracteres especiales.";
  }else if(inputValue.length <10){

    errorMsg.textContent = "Minimo se permiten 10 numeros.";

  }
    else {
      errorMsg.textContent = "";
    }

    ValidarAgendamiento();
  }

  function ValidarTamañoDireccion(elemento){
    let inputValue = elemento.value;
    var errorMsg = document.getElementById("MensajeDireccion");
    if (inputValue.length == 0) {
      errorMsg.textContent="Ingrese una dirección."
    }
    if (inputValue.trim() !== inputValue) {
      errorMsg.textContent = "La direccion no puede iniciar ni terminar con un espacio"
    
  }else if(inputValue.length<=10){
    errorMsg.textContent="El minimo de caracteres para aceptar la direccion es de 10."
  }else if(inputValue.length>=200){
  errorMsg.textContent="El maximo de caracteres para la descripcion es de 60."
  }
     else {
      errorMsg.textContent = "";
    }
    ValidarAgendamiento();
  }
  
      

  


function EliminarInsumosAgendamiento(Id) {
    $(document).on('click', '.btn-azul-eliminar', function(event) {
        event.preventDefault();
        $(this).closest('tr').remove();
      });

      var idNumero = Id.toString(); // Convierte la cadena en un número
      var index = IdRegistrados.indexOf(idNumero);
      
      if (index !== -1) {
        IdRegistrados.splice(index, 1);
        CantidadRegistrados.splice(index,1);
        console.log("ID", idNumero, "eliminado.");
        console.log("Nuevo array IdRegistrados:", IdRegistrados);
      } else {
        console.log("ID", idNumero, "no encontrado en el array.");
      }

    $.ajax({
        type: "POST",
        url: "../Controlador/Agendamiento.php",
        data: {
            
            'CantidadRegistrados': CantidadRegistrados,
            'IdRegistrados': IdRegistrados,
            'NuevaCantidad': NuevaCantidad,
            'Metodo': 'EliminarInsumosAgendamiento'
        },
        success: function (data) {
            SelectInsumo();
            $('#Insumos').val('');
            $('#Cantidad').val('0');
            
        }
    });
    
}


function ListarAgendamientoAdministrador(Pagina) {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    PaginacionActual = Pagina
    $.ajax({
        type: "POST",
        url: "../Controlador/Agendamiento.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'Busca': Busca,
            'CantidadDatos': CantidadDatos,
            'Metodo': "ListarAgendamientoAdministrador"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();


}



function CambiarEstado(IdAgendamiento) {
  CerrarModalAgendamiento();
    $.ajax({
        type: "POST",
        url: "../Controlador/Agendamiento.php",
        data: {
            'IdAgendamiento': IdAgendamiento,
            'Metodo': "CambiarEstado"
        },
        success: function (data) {
          Swal.fire({
            icon: 'success',
            text: data
          });
            ListarAgendamientoAdministrador(PaginacionActual);

        }
    });
}




function  SelectAgendamiento(){
    $.ajax({
        type: "POST",
        url: "../Controlador/Agendamiento.php",
        data: {
            'Metodo': "SelectAgendamiento"
        },
        datatype: "html",
        success: function (data) {
            $('#nombre').text("");
            $('#nombre').append(data);
        },
    });
}




function SelectServicio() {
    $.ajax({
        type: 'POST',
        url: "../Controlador/Agendamiento.php",
        data: {
            'Metodo': "SelectServicio"
        },
        success: function (data) {
            $('#Servicio').text("");
            $('#Servicio').append(data);
        }
    });
}



function SelectUsuario() {
    $.ajax({
        type: 'POST',
        url: "../Controlador/Agendamiento.php",
        data: {
            'Metodo': "SelectUsuario"
        },
        success: function (data) {
            $('#Empleado').text("");
            $('#Empleado').append(data);
        }
    });
}
function SelectInsumo() {
    if(IdRegistrados.length>0){ 
        $.ajax({
            type: 'POST',
            url: "../Controlador/Agendamiento.php",
            data: {
                'IdRegistrados': IdRegistrados,
                'Metodo': "SelectInsumo"
            },
            success: function (data) {
                $('#Insumos').text("");
                $('#Insumos').append(data);
                
            }
        });
        
    }else{
    Remplazo=["Ninguno"]
    $.ajax({
    type: 'POST',
    url: "../Controlador/Agendamiento.php",
    data: {
        'IdRegistrados': Remplazo,
        'Metodo': "SelectInsumo"
    },
    success: function (data) {
        $('#Insumos').text("");
        $('#Insumos').append(data);
    }
});
}

}



 

function ModalAgendamiento(IdAgendamiento) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Agendamiento.php",
        data: {
            'IdAgendamiento': IdAgendamiento,
            'Metodo': "ModalAgendamiento"
        },
        success: function (data) {
          console.log(data)
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function agregarValores() {
  var idHerramientas = document.querySelectorAll('[id*="IdHerramienta"]');
  idHerramientas.forEach(function(idElement) {
    var idHerramienta = idElement.value;
    IdRegistrados.push(idHerramienta);
  });

  

  var cantidadHerramientas = document.querySelectorAll('[id*="CantidadHerramienta"]');
  cantidadHerramientas.forEach(function(cantidadElement) {
    var cantidadAgendada = cantidadElement.value;
    CantidadRegistrados.push(cantidadAgendada);
  });
  console.log(CantidadRegistrados)
  console.log(IdRegistrados)


   valorNulo = hacerCopiasValorNulo();
   console.log(valorNulo)
 
    Copia = hacerCopias(); 
   console.log(Copia)
}


function hacerCopiasValorNulo(){
  var copiaIdRegistrados = ['Ninguno'];
  var copiaCantidadRegistrados = [0];
  return { copiaIdRegistrados, copiaCantidadRegistrados };
}


function hacerCopias() {
  var copiaIdRegistrados = IdRegistrados.slice();
  var copiaCantidadRegistrados = CantidadRegistrados.slice();
  return { copiaIdRegistrados, copiaCantidadRegistrados };
}


function CerrarModalAgendamiento() {
  event.preventDefault();
  CerrarModal();
  CantidadRegistrados=[]
  IdRegistrados=[]
  delete Copia.copiaCantidadRegistrados;
  delete Copia.copiaIdRegistrados;
}


function ModificarAgendamiento() {
  CerrarModal();
  
  const longitudIdRegistrados = Copia.copiaIdRegistrados.length;
  const longitudCantidadRegistrado = Copia.copiaCantidadRegistrados.length;
  console.log(longitudCantidadRegistrado)
  if(longitudCantidadRegistrado>0){
    console.log("tiene algo")
    var copiaJSON= JSON.stringify(Copia)
  }else{
    console.log("No tiene nada")
    copiaJSON=JSON.stringify(valorNulo)
  }
  // var copiaJSON = Object.keys(valorNulo).length === 0 ? JSON.stringify(Copia): JSON.stringify(valorNulo);
    if (CantidadRegistrados.length === 0 && IdRegistrados.length===0) { 
        CantidadRegistrados=['0']
        IdRegistrados=['Ninguno']
       

        $.ajax({
            type: "POST",
            url: "../Controlador/Agendamiento.php",
            data: {
                'IdAgendamiento': $('#Agendamiento').val(),
                'NombreCliente': $('#NombreCliente').val(),
                'IdUsuario': $('#Usuario').val(),
                'CantidadRegistrados': CantidadRegistrados,
                'IdRegistrados': IdRegistrados,
                'Copia': copiaJSON,
                'TelefonoCliente': $('#Telefono').val(),
                'FechaServicio': $('#Fecha').val(),
                'HoraAgendamiento': $('#Hora').val(),
                'IdServicio': $('#ServicioModal').val(),
                'IdHerramientaInsumo': $('#Insumos').val(),
                'Cantidad': $('#Cantidad').val(),
                'Descripcion': $('#Descripcion').val(),
                'DireccionCliente': $('#Direccion').val(),
                'Metodo': 'ModificarAgendamiento'
            },
            success: function (data) {
              Swal.fire({
                icon: 'success',
                text: data
              });
              console.log(data)
                ListarAgendamientoAdministrador(PaginacionActual);
                CantidadRegistrados=[]
                IdRegistrados=[]
                delete Copia.copiaCantidadRegistrados;
                delete Copia.copiaIdRegistrados;
            
                
            }
        });
    }else{

     

        $.ajax({
            type: "POST",
            url: "../Controlador/Agendamiento.php",
            data: {
                'IdAgendamiento': $('#Agendamiento').val(),
                'NombreCliente': $('#NombreCliente').val(),
                'IdUsuario': $('#Usuario').val(),
                'CantidadRegistrados': CantidadRegistrados,
                'IdRegistrados': IdRegistrados,
                'Copia': copiaJSON,
                'TelefonoCliente': $('#Telefono').val(),
                'FechaServicio': $('#Fecha').val(),
                'IdServicio': $('#ServicioModal').val(),
                'IdHerramientaInsumo': $('#Insumos').val(),
                'Cantidad': $('#Cantidad').val(),
                'Descripcion': $('#Descripcion').val(),
                'DireccionCliente': $('#Direccion').val(),
                'Metodo': 'ModificarAgendamiento'
            },
            success: function (data) {
              Swal.fire({
                icon: 'success',
                text: data
              });
                console.log(data)
                ListarAgendamientoAdministrador(PaginacionActual);
                CantidadRegistrados=[]
                IdRegistrados=[]
                delete Copia.copiaCantidadRegistrados;
                delete Copia.copiaIdRegistrados;

                
            }
        });

    }

}
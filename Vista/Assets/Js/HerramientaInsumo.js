function ValidarHerramientaInsumo() {
    let Nombre = document.getElementById("Nombre").value.trim();
    let Descripcion = document.getElementById("Descripcion").value.trim();
    let Cantidad = document.getElementById("Cantidad").value.trim();
  
    let NombreValido = Nombre.length >= 2 && Nombre.length <= 50 && /^[a-zA-Z0-9ñÑ\s]*$/.test(Nombre);
    let DescripcionValido = Descripcion.length >= 2 && Descripcion.length <= 200 && /^[a-zA-Z0-9ñÑ\s]*$/.test(Descripcion);
    let CantidadValido = /^[0-9]{1,11}$/.test(Cantidad);

    let submitButton = document.getElementById("registrar");
    if (NombreValido && DescripcionValido && CantidadValido) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

function ValidarNombre(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("NombreError");

    if (inputValue.length < 2 || inputValue.length > 50 || !/^[a-zA-Z0-9ñÑ\s]*$/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "El nombre debe tener entre 2 y 50 caracteres, no puede contener caracteres especiales.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarHerramientaInsumo();
}

function ValidarDescripcion(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("DescripcionError");

    if (inputValue.length < 2 || inputValue.length > 200 || !/^[a-zA-Z0-9ñÑ\s]*$/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "La descripción debe tener entre 2 y 200 caracteres, no puede contener caracteres especiales.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarHerramientaInsumo();
}

function ValidarCantidad(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("CantidadError");

    if (!/^[0-9]{1,11}$/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "La cantidad debe contener solo números y tener una longitud de 11 caracteres.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarHerramientaInsumo();
}

function guardarHerramienta() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/HerramientaInsumo.php",
        data: {
            'Nombre': $('#Nombre').val(),
            'Tipo': $('#Tipo').val(),
            'Categoria': $('#Categoria').val(),
            'Descripcion': $('#Descripcion').val(),
            'Medida': $('#Medida').val(),
            'Cantidad': $('#Cantidad').val(),
            'Metodo': 'GuardarHerramienta'            
        },
        success: function (data) {    
            if(data === "Registrado Correctamente"){
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
            Metodo("Particiones/MasterHerramientas.php")
        }
        else{
            Swal.fire({
                icon: 'error',
                text: data
              });
        }
    }

    }
      
    )
}



function ListarHerramienta(Pagina) {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    PaginacionActual = Pagina
    $.ajax({
        type: "POST",
        url: "../Controlador/HerramientaInsumo.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'Busca': Busca,
            'CantidadDatos': CantidadDatos,
            'Metodo': "ListarHerramientas"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();
}

function ModalModificarHerramienta(Id) {
    $.ajax({
        type: "POST",
        url: "../Controlador/HerramientaInsumo.php",
        data: {
            'Id': Id,
            'Metodo': "ModalModificarHerramienta"
        },
        datatype: "html",
        success: function (data) {
            $('macaco').text("");
            $('macaco').append(data);
        },
    });
}


function ModalEliminarHerramienta(Id) {
    $.ajax({
        type: "POST",
        url: "../Controlador/HerramientaInsumo.php",
        data: {
            'Id': Id,
            'Metodo': "ModalEliminarHerramienta"
        },
        datatype: "html",
        success: function (data) {
            $('macaco').text("");
            $('macaco').append(data);
        },
    });
}

function ModalDesactivarHerramientaInsumo(Id, Estado) {
    window.modal.showModal();
    $.ajax({
        type: "POST",
        url: "../Controlador/HerramientaInsumo.php",
        data: {
            'Id': Id,
            'Estado': Estado,
            'Metodo': "ModalDesactivarHerramientaInsumo"
        },
        datatype: "html",
        success: function (data) {
            $('macaco').text("");
            $('macaco').append(data);
        },
    });
}



function ModificarHerramientas(){
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/HerramientaInsumo.php",
        data: {
            'Id': $('#Id').val(),
            'Nombre': $('#Nombre').val(),
            'Tipo': $('#Tipo').val(),
            'Categoria': $('#Categoria').val(),
            'Descripcion': $('#Descripcion').val(),
            'Medida': $('#Medida').val(),
            'Cantidad': $('#Cantidad').val(),
            'Metodo': 'ModificarHerramientas'
        },
        success: function (data) {
            CerrarModal();
            if (data === "Modificado Correctamente"){
            Swal.fire({
                icon: 'success',
                text: data
              });
            ListarHerramienta(PaginacionActual);
            ListarPaginacion(PaginacionActual);
            }
            else{
                Swal.fire({
                    icon: 'error',
                    text: data
                  });  
            }
        },
    })
}


function Cambio(){
    var tipo= document.getElementById('Tipo').value;
    var medida = document.getElementById('Medida');
     if (tipo == 'Herramienta'){
        medida.disabled = true
        document.getElementById('Manual').style.display = 'block';
        document.getElementById('Electrica').style.display = 'block';
        document.getElementById('Mecanica').style.display = 'block';
        document.getElementById('Otros1').style.display = 'block';
        document.getElementById('Cable').style.display = 'none';
        document.getElementById('Switch').style.display = 'none';
        document.getElementById('Router').style.display = 'none';
        document.getElementById('Categoria').value = "Manual"
        document.getElementById('Otros').style.display = 'none';
    }
    if (tipo == 'Insumo'){
        medida.disabled = false
        document.getElementById('Manual').style.display = 'none';
        document.getElementById('Electrica').style.display = 'none';
        document.getElementById('Mecanica').style.display = 'none';
        document.getElementById('Otros').style.display = 'none';
        document.getElementById('Cable').style.display = 'block';
        document.getElementById('Switch').style.display = 'block';
        document.getElementById('Router').style.display = 'block';
        document.getElementById('Categoria').value = "Cable"
        document.getElementById('Otros1').style.display = 'block';
    }
    
}
function DesactivarHerramientaInsumo(){
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/HerramientaInsumo.php",
        data: {
            'IdHerramientaInsumo':  $('#Id').val(),
            'Estado':  $('#Estado').val(),
            'Metodo': 'DesactivarHerramientaInsumo'
        },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                text: data
              });
              CerrarModal();
            ListarHerramienta(PaginacionActual);
            ListarPaginacion(PaginacionActual);
        },
    })
}


function EliminarHerramienta(){
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/HerramientaInsumo.php",
        data: {
            'IdHerramientaInsumo':  $('#Id').val(),
            'Metodo': 'EliminarHerramienta'
        },
        success: function (data) {
            if(data === "Eliminado correctamente"){
            Swal.fire({
                icon: 'success',
                text: data
              });
            }
              else{
                Swal.fire({
                    icon: 'error',
                    text: data
                  });
              }
            CerrarModal();
            ListarHerramienta(PaginacionActual);
            ListarPaginacion(PaginacionActual);},
    })  
}

function MensajeStock(){
    $.ajax({
        type: "POST",
        url: "../Controlador/HerramientaInsumo.php",
        data: {
            'Metodo': 'MensajeStock'
        },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                text: data
              });
          },
    })  
}


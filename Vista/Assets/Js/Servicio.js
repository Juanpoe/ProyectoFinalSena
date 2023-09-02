
function GuardarServicio() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Servicio.php",
        data: {
            'Nombre': $('#NombredelServicio').val(),
            'Metodo': 'GuardarServicio'
        },
        success: function (data) {
            if(data === "Registrado Correctamente"){
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                Metodo("Particiones/ListarServicios.php")
            }
            else{
                Swal.fire({
                    icon: 'error',
                    text: data
                  });
            }
        }
    });
}

function ListarServicios(Pagina) {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    PaginacionActual = Pagina
    $.ajax({
        type: "POST",
        url: "../Controlador/Servicio.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'Busca': Busca,
            'CantidadDatos': CantidadDatos,
            'Metodo': "ListarServicios"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();
}






function DesactivarServicio() {
    event.preventDefault();
    CerrarModal();
    $.ajax({
        type: "POST",
        url: "../Controlador/Servicio.php",
        data: {
            'IdServicio': $('#Id').val(),
            'Estado': $('#Estado').val(),
            'Metodo': "DesactivarServicio"
        },
        success: function (data) {
            if(data ==="Desactivado correctamente" || data === "Activado correctamente"){
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
            ListarServicios(PaginacionActual);
        }
        else{
            Swal.fire({
                icon: 'error',
                text: data
              });
        }
    }
    });
}




function ModalListarServicio(IdServicio) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Servicio.php",
        data: {
            'IdServicio': IdServicio,
            'Metodo': "ModalListarServicio"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}




function ModalDesactivarServicio(Id, Estado){
    window.modal.showModal();
    $.ajax({
        type: "POST",
        url: "../Controlador/Servicio.php",
        data: {
            'Id': Id,
            'Estado': Estado,
            'Metodo': "ModalDesactivarServicio"
        },
        datatype: "html",
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        },
    });
}




function ModificarListar() {
    event.preventDefault();
    CerrarModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Servicio.php",
        data: {
            'IdServicio': $('#Servicio').val(),
            'Nombre': $('#NombredelServicio').val(),
            'Metodo': 'ModificarListar'
        },
        success: function (data) {
            if(data==="Modificado correctamente"){
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
            ListarServicios(PaginacionActual);
          }
            else{
                Swal.fire({
                    icon: 'error',
                    text: data
                  });
            }
        }
    });
}



























function ValidarCrearServicio(){
    let Nombre = document.getElementById("NombredelServicio")
    ValidadoNombre = Nombre.style.borderColor == "green"

    Boton = document.getElementById("CrearServicio2");
    if (ValidadoNombre) {
        Boton.disabled = false;
    } else {
        Boton.disabled = true;
    }
}
function ValidarNombredelServicio(elemento){
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("NombredelServicioError");

    if (inputValue.length < 2 || inputValue.length > 30 || !/^[a-zA-Z0-9ñÑ\s]*$/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "El nombre debe tener entre 2 y 30 caracteres, no puede contener caracteres especiales.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCrearServicio();
}
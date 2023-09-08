function ListarHerramientasSP(Pagina) {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    $.ajax({
        type: "POST",
        url: "../Controlador/SolicitarPrestamo.php",
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

function ListarPrestamosSolicitados(Pagina) {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    PaginacionActual = Pagina;
    $.ajax({
        type: "POST",
        url: "../Controlador/SolicitarPrestamo.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'Busca': Busca,
            'CantidadDatos': CantidadDatos,
            'Metodo': "ListarPrestamosSolicitados"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();
}


function ModalSolicitar(IdHerramienta, Cantidad) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/SolicitarPrestamo.php",
        data: {
            'IdHerramienta': IdHerramienta,
            'Cantidad': Cantidad,
            'Metodo': "ModalSolicitar"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}









function GuardarSolicitud(IdHerramienta) {
    event.preventDefault();
    CantidadSolicitud = document.getElementById("CantidadSolicitud").value
    Observacion = document.getElementById("Observacion").value

 
        CerrarModal();
        $.ajax({
            type: 'POST',
            url: "../Controlador/SolicitarPrestamo.php",
            data: {
                'CantidadSolicitud': CantidadSolicitud,
                'IdHerramienta': IdHerramienta,
                'Observacion': Observacion,
                'Metodo': 'GuardarSolicitud'
            },
            success: function (data) {
                if(data === "Se ha realizado la solicitud"){
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                  Metodo("Particiones/ListarSolicitudPrestamo.php")}
                  else{
                    Swal.fire({
                        icon: 'error',
                        text: data
                      });
                  }
            }
        }); 
}


function ModalEditarSolicitudPrestamo(IdSolicitud, CantidadHerramienta, CantidadSolicitud, Observacion){
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/SolicitarPrestamo.php",
        data: {
            'IdSolicitud': IdSolicitud,
            'CantidadHerramienta': CantidadHerramienta,
            'CantidadSolicitud': CantidadSolicitud,
            'Observacion': Observacion,
            'Metodo': "ModalEditarSolicitudPrestamo"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function ModalRechazarSolicitudPrestamo(IdSolicitud){
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/SolicitarPrestamo.php",
        data: {
            'IdSolicitud': IdSolicitud,
            'Metodo': "ModalRechazarSolicitudPrestamo"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function ModalAceptarSolicitudPrestamo(IdSolicitud, CantidadSolicitud, IdHerramienta, IdUsuario){
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/SolicitarPrestamo.php",
        data: {
            'IdSolicitud': IdSolicitud,
            'CantidadSolicitud': CantidadSolicitud,
            'IdHerramienta': IdHerramienta,
            'IdUsuario': IdUsuario,
            'Metodo': "ModalAceptarSolicitudPrestamo"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function EditarSolicitud(IdSolicitud){
    event.preventDefault();
    CantidadSolicitud = document.getElementById("CantidadSolicitud").value
    Observacion = document.getElementById("Observacion").value
        CerrarModal();
        $.ajax({
            type: 'POST',
            url: "../Controlador/SolicitarPrestamo.php",
            data: {
                'IdSolicitud': IdSolicitud,
                'Observacion': Observacion,
                'CantidadSolicitud': CantidadSolicitud,
                'Metodo': 'EditarSolicitud'
            },
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                  ListarPrestamosSolicitados(PaginacionActual);
                ListarPaginacion(PaginacionActual);
            }
        }); 
}
function AceptarSolicitudPrestamo(IdSolicitud, CantidadSolicitud, IdHerramienta, IdUsuario){
    event.preventDefault();
        CerrarModal();
        $.ajax({
            type: 'POST',
            url: "../Controlador/SolicitarPrestamo.php",
            data: {
                'IdSolicitud': IdSolicitud,
                'CantidadSolicitud': CantidadSolicitud,
                'IdHerramienta': IdHerramienta,
                'IdUsuario': IdUsuario,
                'Metodo': 'AceptarSolicitudPrestamo'
            },
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                  ListarPrestamosSolicitados(PaginacionActual);
                ListarPaginacion(PaginacionActual);
            }
        }); 
}
function RechazarSolicitudPrestamo(IdSolicitud){
    event.preventDefault();
        CerrarModal();
        $.ajax({
            type: 'POST',
            url: "../Controlador/SolicitarPrestamo.php",
            data: {
                'IdSolicitud': IdSolicitud,
                'Metodo': 'RechazarSolicitudPrestamo'
            },
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                  ListarPrestamosSolicitados(PaginacionActual);
                ListarPaginacion(PaginacionActual);
            }
        }); 
}

function EditarSolicitud(IdSolicitud){
    event.preventDefault();
    CantidadSolicitud = document.getElementById("CantidadSolicitud").value
    Observacion = document.getElementById("Observacion").value
        CerrarModal();
        $.ajax({
            type: 'POST',
            url: "../Controlador/SolicitarPrestamo.php",
            data: {
                'IdSolicitud': IdSolicitud,
                'Observacion': Observacion,
                'CantidadSolicitud': CantidadSolicitud,
                'Metodo': 'EditarSolicitud'
            },
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                  ListarPrestamosSolicitados(PaginacionActual);
                ListarPaginacion(PaginacionActual);
            }
        }); 
}

// Validaciones
// Para cuando se solicita
function ValidacionSolicitar() {
    CantidadSolicitud = document.getElementById("CantidadSolicitud").value
    Faull = document.getElementById("CantidadSolicitud")
    CantidadHerramienta = document.getElementById("CantidadHerramienta").value
    Mensaje = document.getElementById("CantidadError")
    CantidadSolicitud = parseInt(CantidadSolicitud)
    Faull.style.borderColor = "red";
    if (!/^[0-9]{1,11}$/.test(CantidadSolicitud)){
        Mensaje.textContent = "La cantidad no puede contener caracteres especiales.";
    }
    else if(CantidadSolicitud > CantidadHerramienta)
    {
        Mensaje.textContent = "La cantidad no puede ser superior a "+CantidadHerramienta+".";
    }
    else if(CantidadSolicitud < 1)
    {
        Mensaje.textContent = "La cantidad no puede ser inferior a 1.";
    }
    else{
        Faull.style.borderColor = "green";
        Mensaje.textContent = "";
    }
    ValidarCamposSolicitarPrestamo()    
}

function ValidacionObservacionSolicitarPrestamo(){
    Mensaje = document.getElementById("ObservacionError")
    
    Observacion = document.getElementById("Observacion").value
    Faull = document.getElementById("Observacion")
    Faull.style.borderColor = "red";
    if (Observacion == "") {
        Mensaje.textContent = "Ingrese un motivo"
    }
    else if (Observacion.trim() !== Observacion) {
        Mensaje.textContent = "La observacion no puede iniciar ni terminar con un espacio"
    }
    else{
        Faull.style.borderColor = "green";
        Mensaje.textContent = "";
    }
    ValidarCamposSolicitarPrestamo()
}
function ValidarCamposSolicitarPrestamo() {

    CantidadValidar = document.getElementById("CantidadSolicitud").style.borderColor == "green"; 
    ObservacionValidar = document.getElementById("Observacion").style.borderColor == "green"; 
    let submitButton = document.getElementById("BotonSolicitar");
    if (CantidadValidar && ObservacionValidar) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
    }
    


function ValidarCamposUsuario() {
    let nombre = document.getElementById("Nombre").value.trim();
    let apellido = document.getElementById("Apellido").value.trim();
    let documento = document.getElementById("Documento").value.trim();
    let correo = document.getElementById("Correo").value.trim();
    let contrasena = document.getElementById("Contrasena").value.trim();
    let telefono = document.getElementById("Telefono").value.trim();
    let direccion = document.getElementById("Direccion").value.trim();

    let nombreValido = nombre.length >= 2 && nombre.length <= 20 && /^[a-zA-Z\s]+$/.test(nombre) && !/^\s/.test(nombre) && !/\s$/.test(nombre) && !/\s\s/.test(nombre);
    let apellidoValido = apellido.length >= 2 && apellido.length <= 20 && /^[a-zA-Z\s]+$/.test(apellido) && !/^\s/.test(apellido) && !/\s$/.test(apellido) && !/\s\s/.test(apellido);
    let documentoValido = /^[0-9]{6,20}$/.test(documento);
    let correoValido = /^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,20}$/.test(correo);
    let contrasenaValido = contrasena.length >= 5 && contrasena.length <= 20;
    let telefonoValido = /^[0-9]{10,10}$/.test(telefono);
    let direccionValido = direccion.length >= 10 && direccion.length <= 50;

    let submitButton = document.getElementById("submitButton");
    if (nombreValido && apellidoValido && documentoValido && contrasenaValido && telefonoValido && correoValido && direccionValido) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

function ValidarNombreUsuario(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("NombreError");

    if (inputValue.length < 2 || inputValue.length > 20 || !/^[a-zA-Z\s]+$/.test(inputValue) || /^\s/.test(inputValue) || /\s$/.test(inputValue) || /\s\s/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "El nombre debe tener entre 2 y 20 caracteres, no puede contener números ni caracteres especiales.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposUsuario();
}

function ValidarApellidoUsuario(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("ApellidoError");

    if (inputValue.length < 2 || inputValue.length > 20 || !/^[a-zA-Z\s]+$/.test(inputValue) || /^\s/.test(inputValue) || /\s$/.test(inputValue) || /\s\s/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "El apellido debe tener entre 2 y 20 caracteres, no puede contener números ni caracteres especiales.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposUsuario();
}

function ValidarDocumentoUsuario(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("DocumentoError");

    if (!/^[0-9]{6,20}$/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "El documento debe contener solo números y tener una longitud entre 6 y 20 caracteres.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposUsuario();
}

function ValidarCorreoUsuario(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("CorreoError");

    if (!/^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,20}$/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "Ingrese un correo electrónico válido.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposUsuario();
}

function ValidarContrasenaUsuario(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("ContrasenaError");

    if (inputValue.length < 5 || inputValue.length > 20) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "La contraseña debe tener entre 5 y 20 caracteres.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposUsuario();
}

function ValidarTelefonoUsuario(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("TelefonoError");

    if (!/^[0-9]{10,10}$/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "El Teléfono debe contener solo números y tener una longitud de 10 caracteres.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposUsuario();
}

function ValidarDireccionUsuario(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("DireccionError");

    if (inputValue.length < 10 || inputValue.length > 50) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "La Dirección debe tener entre 10 y 50 caracteres.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposUsuario();
}

function RegistrarUsuario() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Usuario.php",
        data: {
            'IdRol': $('#IdRol').val(),
            'Nombre': $('#Nombre').val(),
            'Apellido': $('#Apellido').val(),
            'TipoDocumento': $('#TipoDocumento').val(),
            'Documento': $('#Documento').val(),
            'Correo': $('#Correo').val(),
            'Contrasena': $('#Contrasena').val(),
            'Telefono': $('#Telefono').val(),
            'Direccion': $('#Direccion').val(),
            'Metodo': 'RegistrarUsuario'
        },
        success: function (data) {
            if(data === "Registrado correctamente"){
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
            Metodo("Particiones/ListarUsuarios.php")
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

function ListarUsuario(Pagina) {
    var BusquedaUsuario = $('#Busqueda').val();
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    PaginacionActual = Pagina;
    $.ajax({
        type: "POST",
        url: "../Controlador/Usuario.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'CantidadDatos': CantidadDatos,
            'BusquedaUsuario': BusquedaUsuario,
            'Metodo': "ListarUsuario"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();
}

function MostrarRolesEmpleados() {
    $.ajax({
        type: "POST",
        url: "../Controlador/Usuario.php",
        data: {
            'Metodo': "MostrarRolesEmpleados"
        },
        datatype: "html",
        success: function (data) {
            $('#IdRol').text("");
            $('#IdRol').append(data);
        },
    });
}

function ConsultarUsuario(IdUsuario) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Usuario.php",
        data: {
            'IdUsuario': IdUsuario,
            'Metodo': "ConsultarUsuario"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function ModalDesactivarUsuario(IdUsuario, Estado) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Usuario.php",
        data: {
            'Id': IdUsuario,
            'Estado': Estado,
            'Metodo': "ModalDesactivarUsuario"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function ModificarUsuario() {
    event.preventDefault();
    var IdUsuarioActual = $('#IdUsuarioActual').val();
    var IdUsuario = $('#IdUsuario').val();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Usuario.php",
        data: {
            'IdUsuario': $('#IdUsuario').val(),
            'IdRol': $('#IdRol').val(),
            'Nombre': $('#Nombre').val(),
            'Apellido': $('#Apellido').val(),
            'TipoDocumento': $('#TipoDocumento').val(),
            'Documento': $('#Documento').val(),
            'Correo': $('#Correo').val(),
            'Telefono': $('#Telefono').val(),
            'Direccion': $('#Direccion').val(),
            'Metodo': 'ModificarUsuario'
        },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                text: data
              });
            if (IdUsuarioActual == IdUsuario) {
                window.location='../Controlador/CerrarSesion.php';
            }else{
                ListarUsuario(PaginacionActual);
                ListarPaginacion(PaginacionActual);
                CerrarModal();
            }
        }
    });
}

function DesactivarActivarUsuario() {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Usuario.php",
        data: {
            'IdUsuario': $('#Id').val(),
            'Estado': $('#Estado').val(),
            'Metodo': 'DesactivarActivarUsuario'
        },
        success: function (data) {
            CerrarModal();
            if(data === "Activado correctamente" || data === "Desactivado correctamente"){
            Swal.fire({
                icon: 'success',
                text: data
              });
            ListarUsuario(PaginacionActual);
            ListarPaginacion(PaginacionActual);}
            else{
                Swal.fire({
                    icon: 'error',
                    text: data
                  });
            }
        }
    });
}
function validarCamposRol() {
    let nombre = document.getElementById("NombreRol").value.trim();
    let permisos = document.getElementById("Permisos").value.trim();

    let nombreValido = nombre.length >= 2 && nombre.length <= 20 && /^[a-zA-Z\s]+$/.test(nombre) && !/^\s/.test(nombre) && !/\s$/.test(nombre) && !/\s\s/.test(nombre);
    let permisosValidos = permisos !== "0,0,0,0,0,0,0";

    let submitButton = document.getElementById("submitButton");

    if (nombreValido && permisosValidos) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

function ValidarNombreRol(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("NombreRolError");

    if (inputValue.length < 2 || inputValue.length > 20 || !/^[a-zA-Z\s]+$/.test(inputValue) || /^\s/.test(inputValue) || /\s$/.test(inputValue) || /\s\s/.test(inputValue)) {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "El nombre debe tener entre 2 y 20 caracteres, no puede contener números ni caracteres especiales, y solo puede tener espacios en medio del texto.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    validarCamposRol();
}

function ValidarPermisosRol(elemento) {
    let inputValue = elemento.value.trim();
    let errorSpan = document.getElementById("PermisosError");

    if (inputValue == "0,0,0,0,0,0,0") {
        // No cumple con las reglas
        elemento.style.borderColor = "red";
        errorSpan.textContent = "Debe de haber como minimo un permiso.";
    } else {
        // Cumple con las reglas
        elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    validarCamposRol();
}

function RegistrarRol() {
    event.preventDefault();
    var NombreRol = $('#NombreRol').val();
    var Permisos = $('#Permisos').val();

    // Validar campos vacíos
    // if (NombreRol === '') {
    //     alert('Por favor, ingresa un nombre.');
    //     return;
    // } else if (Permisos === '0,0,0,0,0,0,0') {
    //     alert('Por favor, ingresa permisos.');
    //     return;
    // } else if (NombreRol.trim() !== NombreRol) {
    //     alert('El nombre no debe tener espacios al principio.');
    //     return;
    // }

    $.ajax({
        type: "POST",
        url: "../Controlador/Roles.php",
        data: {
            'NombreRol': $('#NombreRol').val(),
            'Rol': $('#Rol').val(),
            'Permisos': Permisos,
            'Metodo': 'RegistrarRol'
        },
        success: function (data) {
            if(data === "Registrado correctamente"){
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
            Metodo("Particiones/ListarRoles.php")
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

function ListarRoles(Pagina) {
    var BusquedaRol = $('#Busqueda').val();
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    PaginacionActual = Pagina;
    $.ajax({
        type: "POST",
        url: "../Controlador/Roles.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'CantidadDatos': CantidadDatos,
            'BusquedaRol': BusquedaRol,
            'Metodo': "ListarRoles"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();
}

function ConsultarRol(IdRol) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Roles.php",
        data: {
            'IdRol': IdRol,
            'Metodo': "ConsultarRol"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function ModalDesactivarRol(Id, Estado) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Roles.php",
        data: {
            'Id': Id,
            'Estado': Estado,
            'Metodo': "ModalDesactivarRol"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function DesactivarActivarRol() {
    event.preventDefault();
    CerrarModal()
    $.ajax({
        type: 'POST',
        url: "../Controlador/Roles.php",
        data: {
            'IdRol': $('#Id').val(),
            'EstadoRol': $('#Estado').val(),
            'Metodo': 'DesactivarActivarRol'
        },
        success: function (data) {
            if (data === "Activado correctamente" || data === "Desactivado correctamente"){
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                  ListarRoles(PaginacionActual);
                  ListarPaginacion(PaginacionActual);
                }
                else{  Swal.fire({
                    icon: 'error',
                    text: data
                  });}
            
        }
    });
}

function ModificarRol() {
    event.preventDefault();
    var IdRol = $('#IdRol').val();
    var IdRolActual = $('#IdRolActual').val();
    CerrarModal()
    
    $.ajax({
        type: 'POST',
        url: "../Controlador/Roles.php",
        data: {
            'IdRol': $('#IdRol').val(),
            'IdRolNombre': $('#IdRolNombre').val(),
            'NombreRol': $('#NombreRol').val(),
            'Rol': $('#Rol').val(),
            'Permisos': $('#Permisos').val(),
            'Metodo': 'ModificarRol'
        },
        success: function (data) {
            if (data === "Modificado correctamente"){
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                  if (IdRol == IdRolActual) {
                    window.location = '../Controlador/CerrarSesion.php';
                } else {
                    ListarRoles(PaginacionActual);
                    ListarPaginacion(PaginacionActual);
                    CerrarModal();
                }
                }
                else{  Swal.fire({
                    icon: 'error',
                    text: data
                  });}
        }
    });
}

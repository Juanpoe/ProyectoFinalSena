function ValidarCorreo(Correo) {
    // Expresión regular para validar el formato del correo electrónico
    var Patron = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Verificar si el correo coincide con el patrón
    if (Patron.test(Correo)) {
        return true; // El correo es válido
    } else {
        return false; // El correo no es válido
    }
}
function RecuperarContrasena() {
    event.preventDefault();
    var Nombre = $('#Nombre').val();
    var Apellido = $('#Apellido').val();
    var Documento = $('#Documento').val();
    var Correo = $('#Correo').val();
    if (Nombre === '' || Apellido === '' || Documento === '' || Correo === '') {
        alert('Por favor, completa todos los campos obligatorios.');
        return;
    } else if (Nombre.trim() !== Nombre || Apellido.trim() !== Apellido || Documento.trim() !== Documento || Correo.trim() !== Correo) {
        alert('Los campos no deben tener espacios al principio.');
        return;
    } else if (Documento.length < 4 || Documento.length > 15) {
        alert("El numero de Documento es invalido");
        return;
    } else if (Nombre.length < 1 || Nombre.length > 100) {
        alert("El Nombre del empleado es invalido (Minimo 10 caracteres Maximo 100)");
        return;
    } else if (Apellido.length < 1 || Apellido.length > 100) {
        alert("El Apellido del empleado es invalido (Minimo 10 caracteres Maximo 100)");
        return;
    } else if (!ValidarCorreo(Correo)) {
        alert("El correo no es válido");
        return;
    }
    $.ajax({
        type: "POST",
        url: "../Controlador/RecuperarContrasena.php",
        data: {
            'Nombre': $('#Nombre').val(),
            'Apellido': $('#Apellido').val(),
            'Documento': $('#Documento').val(),
            'Correo': $('#Correo').val(),
            'Contrasena': $('#Contrasena').val(),
            'Metodo': 'RecuperarContrasena'
        },
        success: function (data) {
            alert(data);
            $('#Nombre').val('');
            $('#Apellido').val('');
            $('#Correo').val('');
            $('#Documento').val('');
            $('#Contrasena').val('');
        }
    });
}

function CambiarContrasena() {
    event.preventDefault();
    var Contrasena = $('#Contrasena').val();
    var Contrasena2 = $('#Contrasena2').val();
    if (Contrasena != Contrasena2) {
        alert("Las Contraseñas no son iguales");
        return;
    }
    $.ajax({
        type: "POST",
        url: "../Controlador/RecuperarContrasena.php",
        data: {
            'Contrasena': $('#Contrasena').val(),
            'Contrasena2': $('#Contrasena2').val(),
            'Metodo': 'CambiarContrasena'
        },
        success: function (data) {
            alert(data);
            $('#Contrasena').val('');
            $('#Contrasena2').val('');
        }
    });
}
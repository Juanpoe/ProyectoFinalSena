function Loguear() {
    event.preventDefault();
    var Correo = $('#Correo').val();
    var Contrasena = $('#Contrasena').val();
    console.log("Correo " + Correo + " Contraseña " + Contrasena);
    if (Correo.trim() === '' || Contrasena.trim() === '') {
        alert('Por favor, complete todos los campos');
        return; // Evita el envío del formulario
    }
    $.ajax({
        type: "POST",
        url: "../Controlador/Login.php",
        data: {
            'Correo': $('#Correo').val(),
            'Contrasena': $('#Contrasena').val(),
            'Metodo': 'Loguear'
        },
        success: function (data) {
            alert(data)
        }
    });

}
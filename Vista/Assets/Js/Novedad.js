
// Función para obtener la fecha actual en Colombia
function getCurrentDateInColombia() {
    // Obtener la fecha/hora actual en UTC
    let date = new Date();

    // Convertir a zona horaria de Colombia (UTC-5)
    let utcOffset = -5 * 60;
    date.setMinutes(date.getMinutes() + utcOffset);

    // Restar 1 día a la fecha
    date.setDate(date.getDate());

    return date;
}

function ValidarCamposNovedad() {
    let Peticion = document.getElementById("Peticion").value;

    let Descripcion = document.getElementById("Descripcion").value;

    let FechaInicioValue = document.getElementById("FechaInicio").value;
    let FechaInicio = new Date(FechaInicioValue);
    let FechaActual = getCurrentDateInColombia();

    let FechaFinValue = document.getElementById("FechaFin").value;
    let FechaFin = new Date(FechaFinValue);
    let FechaMax = new Date(FechaActual);
    FechaMax.setMonth(FechaMax.getMonth() + 1);

    let HoraInicioValue = document.getElementById("HoraInicio").value;
    let HoraInicioParts = HoraInicioValue.split(':');
    let HoraInicioHour = parseInt(HoraInicioParts[0]);
    let HoraInicioMinutes = parseInt(HoraInicioParts[1]);

    let HoraFinValue = document.getElementById("HoraFin").value;
    let HoraFinParts = HoraFinValue.split(':');
    let HoraFinHour = parseInt(HoraFinParts[0]);
    let HoraFinMinutes = parseInt(HoraFinParts[1]);

    let PeticionValido = Peticion.trim() == Peticion && Peticion.length >= 5 && Peticion.length <= 100 && /^[a-zA-Z\s]+$/.test(Peticion) && !/^\s/.test(Peticion) && !/\s$/.test(Peticion) && !/\s\s/.test(Peticion)
    let DescripcionValido = Descripcion.trim() == Descripcion && Descripcion.length > 10 && Descripcion.length <= 200 
    let FechaInicioValido = FechaInicio >= FechaActual && FechaInicio <= FechaMax
    let FechaFinValido = FechaInicio <= FechaFin && FechaFin <= FechaMax
    let HoraInicioValido = HoraInicioHour >= 8 && HoraInicioHour < 17 





    let HoraFinValido = HoraFinHour >= 8 && HoraFinHour <= 17 && ((HoraInicioHour < HoraFinHour) || (HoraInicioHour === HoraFinHour && HoraInicioMinutes < HoraFinMinutes));





    
    let submitButton = document.getElementById("submitButton");
    console.log(HoraFinHour + ">=" + 8 + "&&" + HoraFinHour + "<=" + 17 + "&& (" + HoraInicioHour + "<=" + HoraFinHour + "&&" + HoraInicioMinutes + "<=" + HoraFinMinutes + ") && (" + HoraInicioHour + "!=" + HoraFinHour + "&&" + HoraInicioMinutes + "<=" + HoraFinMinutes + ")")
    console.log(PeticionValido + " " + DescripcionValido + " " + HoraInicioValido + " " + HoraFinValido + " " + FechaInicioValido + " " + FechaFinValido)

    if (PeticionValido && DescripcionValido && FechaInicioValido && FechaFinValido && HoraInicioValido && HoraFinValido) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

function ValidarCamposNovedadModal() {
    let Peticion = document.getElementById("PeticionModal").value;

    let Descripcion = document.getElementById("DescripcionModal").value;

    let FechaInicioValue = document.getElementById("FechaInicioModal").value;
    let FechaInicio = new Date(FechaInicioValue);
    let FechaActual = getCurrentDateInColombia();

    let FechaFinValue = document.getElementById("FechaFinModal").value;
    let FechaFin = new Date(FechaFinValue);
    let FechaMax = new Date(FechaActual);
    FechaMax.setMonth(FechaMax.getMonth() + 1);

    let HoraInicioValue = document.getElementById("HoraInicioModal").value;
    let HoraInicioParts = HoraInicioValue.split(':');
    let HoraInicioHour = parseInt(HoraInicioParts[0]);
    let HoraInicioMinutes = parseInt(HoraInicioParts[1]);

    let HoraFinValue = document.getElementById("HoraFinModal").value;
    let HoraFinParts = HoraFinValue.split(':');
    let HoraFinHour = parseInt(HoraFinParts[0]);
    let HoraFinMinutes = parseInt(HoraFinParts[1]);

    let PeticionValido = Peticion.trim() == Peticion && Peticion.length >= 5 && Peticion.length <= 100 && /^[a-zA-Z\s]+$/.test(Peticion) && !/^\s/.test(Peticion) && !/\s$/.test(Peticion) && !/\s\s/.test(Peticion)
    let DescripcionValido = Descripcion.trim() == Descripcion && Descripcion.length > 10 && Descripcion.length <= 200 
    let FechaInicioValido = FechaInicio >= FechaActual && FechaInicio <= FechaMax
    let FechaFinValido = FechaInicio <= FechaFin && FechaFin <= FechaMax
    let HoraInicioValido = HoraInicioHour >= 8 && HoraInicioHour <= 17
    let HoraFinValido = HoraFinHour >= 8 && HoraFinHour <= 17 && ((HoraInicioHour < HoraFinHour) || (HoraInicioHour === HoraFinHour && HoraInicioMinutes < HoraFinMinutes));

    let submitButton = document.getElementById("SubmitButtonModal");

    console.log(PeticionValido + " " + DescripcionValido + " " + HoraInicioValido + " " + HoraFinValido + " " + FechaInicioValido + " " + FechaFinValido)

    if (PeticionValido && DescripcionValido && FechaInicioValido && FechaFinValido && HoraInicioValido && HoraFinValido) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

function ValidaPeticionNovedad(Elemento) {

    let inputValue = Elemento.value
    let errorSpan = document.getElementById("PeticionError");

    if (inputValue.length < 5 || inputValue.length > 100 || !/^[a-zA-Z\s]+$/.test(inputValue) || /^\s/.test(inputValue) || /\s$/.test(inputValue) || /\s\s/.test(inputValue)) {
        // No cumple con las reglas
        Elemento.style.borderColor = "red";
        errorSpan.textContent = "La peticion debe tener entre 5 y 100 caracteres, no puede contener números ni caracteres especiales, y solo puede tener espacios en medio del texto.";
    } else {
        // Cumple con las reglas
        Elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposNovedad()
}
function ValidaPeticionNovedadModal(Elemento) {

    let inputValue = Elemento.value
    let errorSpan = document.getElementById("PeticionModalError");

    if (inputValue.trim() !== inputValue || inputValue.length < 5 || inputValue.length > 100 || !/^[a-zA-Z\s]+$/.test(inputValue) || /^\s/.test(inputValue) || /\s$/.test(inputValue) || /\s\s/.test(inputValue)) {
        // No cumple con las reglas
        Elemento.style.borderColor = "red";
        errorSpan.textContent = "La peticion debe tener entre 5 y 100 caracteres, no puede contener números ni caracteres especiales, y solo puede tener espacios en medio del texto.";
    } else {
        // Cumple con las reglas
        Elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposNovedadModal()
}

function ValidaDescripcionNovedad(Elemento) {
    let inputValue = Elemento.value
    let errorSpan = document.getElementById("DescripcionError");

    if (inputValue.trim() !== inputValue || inputValue.length < 10 || inputValue.length > 200) {
        // No cumple con las reglas
        Elemento.style.borderColor = "red";
        errorSpan.textContent = "La descripcion debe tener entre 10 y 200 caracteres y no puede tener espacios en al inicio o al final del texto.";
    } else {
        // Cumple con las reglas
        Elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposNovedad()
}

function ValidaDescripcionNovedadModal(Elemento) {
    let inputValue = Elemento.value
    let errorSpan = document.getElementById("DescripcionModalError");

    if (inputValue.trim() !== inputValue || inputValue.length < 10 || inputValue.length > 200) {
        // No cumple con las reglas
        Elemento.style.borderColor = "red";
        errorSpan.textContent = "La descripcion debe tener entre 10 y 200 caracteres y no puede tener espacios al inicio o al final del texto.";
    } else {
        // Cumple con las reglas
        Elemento.style.borderColor = "green";
        errorSpan.textContent = "";
    }
    ValidarCamposNovedadModal()
}

function ValidateFechaInicioModificar() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedadModal').val(),
            'IdUsuario': $('#IdUsuarioModal').val(),
            'FechaInicio': $('#FechaInicioModal').val(),
            'metodo': 'ValidateFechaInicioModificar'
        },
        success: function (data) {
            if (data) {
                let FechaInicioElement = document.getElementById("FechaInicioModal");
                let errorSpan = document.getElementById("FechaInicioModalError");
                FechaInicioElement.style.borderColor = "red";
                errorSpan.textContent = "La fecha de inicio no puede ser igual o estar dentro de otra novedad que se encuentre pendiente o aceptada.";
                let submitButton = document.getElementById("SubmitButtonModal");
                submitButton.disabled = true;
            }
            ValidateFechaFinModificar();
        }
    });
}

function ValidateFechaInicioPhp() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedad').val(),
            'FechaInicio': $('#FechaInicio').val(),
            'metodo': 'ValidarFechaInicioPhp'
        },
        success: function (data) {
            if (data) {
                let FechaInicioElement = document.getElementById("FechaInicio");
                let errorSpan = document.getElementById("FechaInicioError");
                FechaInicioElement.style.borderColor = "red";
                errorSpan.textContent = "La fecha de inicio no puede ser igual o estar dentro de otra novedad que se encuentre pendiente o aceptada.";
                let submitButton = document.getElementById("submitButton");
                submitButton.disabled = true;
            }
        }
    });
}

function ValidateFechaInicioPhpModal() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedadModal').val(),
            'FechaInicio': $('#FechaInicioModal').val(),
            'metodo': 'ValidarFechaInicioPhp'
        },
        success: function (data) {
            if (data) {
                let FechaInicioElement = document.getElementById("FechaInicioModal");
                let errorSpan = document.getElementById("FechaInicioModalError");
                FechaInicioElement.style.borderColor = "red";
                errorSpan.textContent = "La fecha de inicio no puede ser igual o estar dentro de otra novedad que se encuentre pendiente o aceptada.";
                let submitButton = document.getElementById("SubmitButtonModal");
                submitButton.disabled = true;
            }
        }
    });
}


function ValidateFechaInicio() {
    let FechaInicioElement = document.getElementById("FechaInicio");
    let FechaInicioValue = FechaInicioElement.value;
    let FechaInicio = new Date(FechaInicioValue);
    let FechaActual = getCurrentDateInColombia();
    let FechaMax = new Date(FechaActual);
    FechaMax.setMonth(FechaMax.getMonth() + 1);

    if (FechaInicio <= FechaActual) {
        FechaInicioElement.style.borderColor = "red";
        document.getElementById("FechaInicioError").textContent = "La fecha de inicio debe ser 1 día mayor a la fecha actual de Colombia.";
    } else if (FechaInicio > FechaMax) {
        FechaInicioElement.style.borderColor = "red";
        document.getElementById("FechaInicioError").textContent = "La fecha de inicio no puede ser mayor a 1 mes de la fecha actual.";
    } else {
        FechaInicioElement.style.borderColor = "green";
        document.getElementById("FechaInicioError").textContent = "";
    }
    ValidarCamposNovedad()
}

function ValidateFechaInicioModal() {
    let FechaInicioElement = document.getElementById("FechaInicioModal");
    let FechaInicioValue = FechaInicioElement.value;
    let FechaInicio = new Date(FechaInicioValue);
    let FechaActual = getCurrentDateInColombia();
    let FechaMax = new Date(FechaActual);
    FechaMax.setMonth(FechaMax.getMonth() + 1);

    if (FechaInicio <= FechaActual) {
        FechaInicioElement.style.borderColor = "red";
        document.getElementById("FechaInicioModalError").textContent = "La fecha de inicio debe ser 1 día mayor a la fecha actual de Colombia.";
    } else if (FechaInicio > FechaMax) {
        FechaInicioElement.style.borderColor = "red";
        document.getElementById("FechaInicioModalError").textContent = "La fecha de inicio no puede ser mayor a 1 mes de la fecha actual.";
    } else {
        FechaInicioElement.style.borderColor = "green";
        document.getElementById("FechaInicioModalError").textContent = "";
    }
    ValidarCamposNovedadModal()
}

function ValidateFechaInicioYFinModificar() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedadModal').val(),
            'IdUsuario': $('#IdUsuarioModal').val(),
            'FechaInicio': $('#FechaInicioModal').val(),
            'FechaFin': $('#FechaFinModal').val(),
            'metodo': 'ValidateFechaInicioYFinModificar'
        },
        success: function (data) {
            if (data) {
                let FechaInicioElement = document.getElementById("FechaInicioModal");
                let FechaFinElement = document.getElementById("FechaFinModal");
                let errorSpan = document.getElementById("FechaInicioModalError");
                let errorSpan1 = document.getElementById("FechaFinModalError");
                FechaInicioElement.style.borderColor = "red";
                FechaFinElement.style.borderColor = "red";
                errorSpan.textContent = "La fecha de inicio no puede abarcar otra novedad que se encuentre pendiente o aceptada.";
                errorSpan1.textContent = "La fecha final no puede abarcar otra novedad que se encuentre pendiente o aceptada.";
                let submitButton = document.getElementById("SubmitButtonModal");
                submitButton.disabled = true;
            }
        }
    });
}

function ValidateFechaInicioYFinVista() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedad').val(),
            'FechaInicio': $('#FechaInicio').val(),
            'FechaFin': $('#FechaFin').val(),
            'metodo': 'ValidateFechaInicioYFinVista'
        },
        success: function (data) {
            if (data) {
                let FechaInicioElement = document.getElementById("FechaInicio");
                let FechaFinElement = document.getElementById("FechaFin");
                let errorSpan = document.getElementById("FechaInicioError");
                let errorSpan1 = document.getElementById("FechaFinError");
                FechaInicioElement.style.borderColor = "red";
                FechaFinElement.style.borderColor = "red";
                errorSpan.textContent = "La fecha de inicio no puede abarcar otra novedad que se encuentre pendiente o aceptada.";
                errorSpan1.textContent = "La fecha final no puede abarcar otra novedad que se encuentre pendiente o aceptada.";
                let submitButton = document.getElementById("submitButton");
                submitButton.disabled = true;
            }
        }
    });
}

function ValidateFechaFinModificar() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedadModal').val(),
            'IdUsuario': $('#IdUsuarioModal').val(),
            'FechaFin': $('#FechaFinModal').val(),
            'metodo': 'ValidateFechaFinModificar'
        },
        success: function (data) {
            if (data) {
                let FechaInicioElement = document.getElementById("FechaFinModal");
                let errorSpan = document.getElementById("FechaFinModalError");
                FechaInicioElement.style.borderColor = "red";
                errorSpan.textContent = "La fecha final no puede ser igual o estar dentro de otra novedad que se encuentre pendiente o aceptada.";
                let submitButton = document.getElementById("SubmitButtonModal");
                submitButton.disabled = true;
            }
            ValidateFechaInicioModificar()
        }
    });
}

function ValidateFechaFinPhpModal() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedadModal').val(),
            'FechaFinal': $('#FechaFinModal').val(),
            'metodo': 'ValidarFechaFinPhp'
        },
        success: function (data) {
            if (data) {
                let FechaFinElement = document.getElementById("FechaFinModal");
                let errorSpan = document.getElementById("FechaFinErrorModal");
                FechaFinElement.style.borderColor = "red";
                errorSpan.textContent = "La fecha del fin no puede ser igual o estar dentro de otra novedad que se encuentre pendiente o aceptada.";
                let submitButton = document.getElementById("SubmitButtonModal");
                submitButton.disabled = true;
            }
        }
    });
}

function ValidateFechaFinPhp() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedad').val(),
            'FechaFinal': $('#FechaFin').val(),
            'metodo': 'ValidarFechaFinPhp'
        },
        success: function (data) {
            if (data) {
                let FechaFinElement = document.getElementById("FechaFin");
                let errorSpan = document.getElementById("FechaFinError");
                FechaFinElement.style.borderColor = "red";
                errorSpan.textContent = "La fecha del fin no puede ser igual o estar dentro de otra novedad que se encuentre pendiente o aceptada.";
                let submitButton = document.getElementById("submitButton");
                submitButton.disabled = true;
            }
        }
    });
}

function ValidateFechaFin() {
    let FechaInicioValue = document.getElementById("FechaInicio").value;
    let FechaInicio = new Date(FechaInicioValue);
    let FechaFinElement = document.getElementById("FechaFin");
    let FechaFinValue = FechaFinElement.value;
    let FechaFin = new Date(FechaFinValue);
    let FechaActual = getCurrentDateInColombia();

    let FechaMax = new Date(FechaActual);
    FechaMax.setMonth(FechaMax.getMonth() + 1);

    if (FechaInicio > FechaFin) {
        FechaFinElement.style.borderColor = "red";
        document.getElementById("FechaFinError").textContent = "La fecha de inicio no puede ser mayor a la fecha de fin.";
    } else if (FechaFin > FechaMax) {
        FechaFinElement.style.borderColor = "red";
        document.getElementById("FechaFinError").textContent = "La fecha de fin no puede ser mayor a 1 mes de la fecha actual.";
    } else {
        FechaFinElement.style.borderColor = "green";
        document.getElementById("FechaFinError").textContent = "";
    }
    ValidarCamposNovedad()
}

function ValidateFechaFinModal() {
    let FechaInicioValue = document.getElementById("FechaInicioModal").value;
    let FechaInicio = new Date(FechaInicioValue);
    let FechaFinElement = document.getElementById("FechaFinModal");
    let FechaFinValue = FechaFinElement.value;
    let FechaFin = new Date(FechaFinValue);
    let FechaActual = getCurrentDateInColombia();

    let FechaMax = new Date(FechaActual);
    FechaMax.setMonth(FechaMax.getMonth() + 1);

    if (FechaInicio > FechaFin) {
        FechaFinElement.style.borderColor = "red";
        document.getElementById("FechaFinModalError").textContent = "La fecha de inicio no puede ser mayor a la fecha de fin.";
    } else if (FechaFin > FechaMax) {
        FechaFinElement.style.borderColor = "red";
        document.getElementById("FechaFinModalError").textContent = "La fecha de fin no puede ser mayor a 1 mes de la fecha actual.";
    } else {
        FechaFinElement.style.borderColor = "green";
        document.getElementById("FechaFinModalError").textContent = "";
    }
    ValidarCamposNovedadModal()
}

function ValidateHoraInicio() {
    let HoraInicioElement = document.getElementById("HoraInicio");
    let HoraInicioValue = HoraInicioElement.value;
    let HoraInicioParts = HoraInicioValue.split(':');
    let HoraInicioHour = parseInt(HoraInicioParts[0]);
    let HoraInicioMinutes = parseInt(HoraInicioParts[1]);

    if (HoraInicioHour < 8 || (HoraInicioHour >= 17 && HoraInicioMinutes > 0) || HoraInicioHour > 17) {
        HoraInicioElement.style.borderColor = "red";
        document.getElementById("HoraInicioError").textContent = 'La hora de inicio debe estar entre 8:00 y 17:00.';
    } else {
        HoraInicioElement.style.borderColor = "green";
        document.getElementById("HoraInicioError").textContent = '';
    }
    ValidarCamposNovedad()
}

function ValidateHoraInicioModal() {
    let HoraInicioElement = document.getElementById("HoraInicioModal");
    let HoraInicioValue = HoraInicioElement.value;
    let HoraInicioParts = HoraInicioValue.split(':');
    let HoraInicioHour = parseInt(HoraInicioParts[0]);
    let HoraInicioMinutes = parseInt(HoraInicioParts[1]);

    if (HoraInicioHour < 8 || HoraInicioHour > 17 || (HoraInicioHour >= 17 && HoraInicioMinutes > 0)) {
        HoraInicioElement.style.borderColor = "red";
        document.getElementById("HoraInicioModalError").textContent = 'La hora de inicio debe estar entre 8:00 y 17:00.';
    } else {
        HoraInicioElement.style.borderColor = "green";
        document.getElementById("HoraInicioModalError").textContent = '';
    }
    ValidarCamposNovedadModal()
}

function ValidateHoraFin() {
    let HoraInicioValue = document.getElementById("HoraInicio").value;
    let HoraInicioParts = HoraInicioValue.split(':');
    let HoraInicioHour = parseInt(HoraInicioParts[0]);
    let HoraInicioMinutes = parseInt(HoraInicioParts[1]);

    let HoraFinElement = document.getElementById("HoraFin");
    let HoraFinValue = HoraFinElement.value;
    let HoraFinParts = HoraFinValue.split(':');
    let HoraFinHour = parseInt(HoraFinParts[0]);
    let HoraFinMinutes = parseInt(HoraFinParts[1]);

    if (HoraFinHour < 8 || HoraFinHour > 17 || (HoraFinHour >= 17 && HoraFinMinutes > 0)) {
        HoraFinElement.style.borderColor = "red";
        document.getElementById("HoraFinError").textContent = 'La hora de fin debe estar entre 8:00 y 17:00.';
    } else if (HoraInicioHour > HoraFinHour || (HoraInicioMinutes > HoraFinMinutes && HoraInicioHour >=  HoraFinHour)) {
        HoraFinElement.style.borderColor = "red";
        document.getElementById("HoraFinError").textContent = 'La hora de inicio no puede ser mayor a la de fin.';
    } else if ((HoraInicioHour == HoraFinHour && HoraInicioMinutes > HoraFinMinutes) || (HoraInicioHour + 1 == HoraFinHour && HoraInicioMinutes > HoraFinMinutes)) {
        HoraFinElement.style.borderColor = "red";
        document.getElementById("HoraFinError").textContent = 'Tiene que haber minimo 1 hora para hacer una novedad.';
    } else {
        HoraFinElement.style.borderColor = "green";
        document.getElementById("HoraFinError").textContent = '';
    }
    ValidarCamposNovedad()
}

function ValidateHoraFinModal() {
    let HoraInicioValue = document.getElementById("HoraInicioModal").value;
    let HoraInicioParts = HoraInicioValue.split(':');
    let HoraInicioHour = parseInt(HoraInicioParts[0]);
    let HoraInicioMinutes = parseInt(HoraInicioParts[1]);

    let HoraFinElement = document.getElementById("HoraFinModal");
    let HoraFinValue = HoraFinElement.value;
    let HoraFinParts = HoraFinValue.split(':');
    let HoraFinHour = parseInt(HoraFinParts[0]);
    let HoraFinMinutes = parseInt(HoraFinParts[1]);

    if (HoraFinHour < 8 || HoraFinHour > 17 || (HoraFinHour >= 17 && HoraFinMinutes > 0)) {
        HoraFinElement.style.borderColor = "red";
        document.getElementById("HoraFinModalError").textContent = 'La hora de fin debe estar entre 8:00 y 17:00.';
    } else if (HoraInicioHour >= HoraFinHour) {
        HoraFinElement.style.borderColor = "red";
        document.getElementById("HoraFinModalError").textContent = 'La hora de inicio no puede ser mayor a la de fin.';
    } else if ((HoraInicioHour == HoraFinHour && HoraInicioMinutes < HoraFinMinutes) || (HoraInicioHour + 1 == HoraFinHour && HoraInicioMinutes > HoraFinMinutes)) {
        HoraFinElement.style.borderColor = "red";
        document.getElementById("HoraFinModalError").textContent = 'Tiene que haber minimo 1 hora para hacer una novedad.';
    } else {
        HoraFinElement.style.borderColor = "green";
        document.getElementById("HoraFinModalError").textContent = '';
    }
    ValidarCamposNovedadModal()
}

function GuardarNovedad() {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedad').val(),
            'Peticion': $('#Peticion').val(),
            'Descripcion': $('#Descripcion').val(),
            'Cambio': $('#Cambio').val(),
            'HoraInicio': $('#HoraInicio').val(),
            'HoraFinal': $('#HoraFin').val(),
            'FechaInicio': $('#FechaInicio').val(),
            'FechaFinal': $('#FechaFin').val(),
            'metodo': 'GuardarNovedad'
        },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                text: data
              });
        Metodo("Particiones/ListarNovedades.php")
        }
    });
}

function MostrarEmpleadosNovedad() {
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'metodo': "MostrarEmpleadosNovedad"
        },
        datatype: "html",
        success: function (data) {
            $('#IdNovedad').text("");
            $('#IdNovedad').append(data);
        },
    });
}

function ListarNovedad(Pagina) {
    var BusquedaNovedad = $('#Busqueda').val();
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    PaginacionActual = Pagina;
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'CantidadDatos': CantidadDatos,
            'BusquedaNovedad': BusquedaNovedad,
            'metodo': "ListarNovedad"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();
}

function ModalNovedad(IdNovedad) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': IdNovedad,
            'metodo': "ModalNovedad"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function ModalAceptarNovedad(IdNovedad) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': IdNovedad,
            'metodo': "ModalAceptarNovedad"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function ModalRechazarNovedad(IdNovedad) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': IdNovedad,
            'metodo': "ModalRechazarNovedad"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function ModificarNovedad() {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedadModal').val(),
            'IdUsuario': $('#IdUsuarioModal').val(),
            'Peticion': $('#PeticionModal').val(),
            'Descripcion': $('#DescripcionModal').val(),
            'HoraInicio': $('#HoraInicioModal').val(),
            'HoraFinal': $('#HoraFinModal').val(),
            'FechaInicio': $('#FechaInicioModal').val(),
            'FechaFinal': $('#FechaFinModal').val(),
            'metodo': 'ModificarNovedad'
        },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                text: data
              });
            ListarNovedad(PaginacionActual);
            ListarPaginacion(PaginacionActual);
            CerrarModal();
        }

    });
}

function AceptarRechazarNovedad() {
    $.ajax({
        type: "POST",
        url: "../Controlador/Novedad.php",
        data: {
            'IdNovedad': $('#IdNovedad').val(),
            'opcion': $('#opcion').val(),
            'metodo': "AceptarRechazarNovedad"
        },
        success: function (data) {
            Swal.fire({
                icon: 'success',
                text: data
              });
            ListarNovedad(PaginacionActual);
            ListarPaginacion(PaginacionActual);
            CerrarModal();
        }
    });
}
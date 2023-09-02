var PaginacionActual = 1;

var menuItems = document.querySelectorAll('.has-submenu');

menuItems.forEach(function (item) {
    item.addEventListener('click', function () {
        this.classList.toggle('open');
        var submenu = this.querySelector('.submenu');
        submenu.classList.toggle('open');
    });
});

// metodo para pasar de pagina
function Metodo(pagina) {
    $.ajax({
        type: "POST",
        url: pagina,
        data: {},
        success: function (data) {
            $("#qCarga").html(data);
        }
    }
    );
};

// Cerrar modal
function CerrarModal() {
    event.preventDefault();
    const modal = document.querySelector("#modal");
    modal.classList.add("hide");
    modal.addEventListener("animationend", function close() {
        modal.classList.remove("hide");
        modal.close();
        modal.removeEventListener("animationend", close);
    });
}

// Alerta personalizada

function AlertMaxi(texto) {
    var alertDiv = document.createElement('div');
    alertDiv.className = 'custom-alert';

    var textParagraph = document.createElement('p');
    textParagraph.innerHTML = texto;
    alertDiv.appendChild(textParagraph);

    var closeButton = document.createElement('button');
    closeButton.innerHTML = 'Aceptar';
    closeButton.onclick = function () {
        alertDiv.classList.add('hidden');
        setTimeout(function () {
            document.body.removeChild(alertDiv);
        }, 500);
    };

    alertDiv.appendChild(closeButton);
    document.body.appendChild(alertDiv);

    // Establecer el z-index y posición del elemento .custom-alert
    alertDiv.style.zIndex = '9999';
    alertDiv.style.position = 'fixed';
}


//Metodo para Ordenar los datos segun la columna
function Resaltar(Elemento, Columna) {
    var ths = document.getElementsByTagName('th');

    for (var i = 0; i < ths.length; i++) {
        ths[i].classList.remove('brillante');
        ths[i].classList.remove('rojo');
    }
    ultimoResaltado = document.getElementById("OrdenInput").value

    if (document.getElementById("ColumnaInput").value != Columna) {
        ultimoResaltado = "DESC";
    }

    if (ultimoResaltado == "DESC") {
        Elemento.classList.add('brillante');
        document.getElementById("OrdenInput").value = "ASC";
    } else {
        Elemento.classList.add('rojo');
        document.getElementById("OrdenInput").value = "DESC";
    }
    document.getElementById("ColumnaInput").value = Columna
    $.ajax({
        type: "POST",
        url: "../Controlador/Main.php",
        data: {
            'Metodo': "ObtenerFuncionJs"
        },
        datatype: "html",
        success: function (data) {
            FuncionListar = data;
            FuncionListar += "(1)";
            eval(FuncionListar)
        },
    });
}

//Metodo para cambiar la cantidad de datos que se muestran  
function CantidadDatosT() {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    $.ajax({
        type: "POST",
        url: "../Controlador/Main.php",
        data: {
            'CantidadDatos': CantidadDatos,
            'Busca': Busca,
            'Metodo': "CantidadDatosT"
        },
        datatype: "html",
        success: function (data) {
            $('.CantidadDatos').text("");
            $('.CantidadDatos').append(data);
        },
    });
}

// Metodo para la paginacion de la tabla
function ListarPaginacion(Pagina) {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    $.ajax({
        type: "POST",
        url: "../Controlador/Main.php",
        data: {
            'Pagina': Pagina,
            'Busca': Busca,
            'CantidadDatos': CantidadDatos,
            'Metodo': "ListarPaginacion"
        },
        datatype: "html",
        success: function (data) {
            $('.paginacion').text("");
            $('.paginacion').append(data);
        },
    });
}
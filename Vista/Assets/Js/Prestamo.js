// Inicio para realizar Prestamo
var Asigna = 0

//Copiar y pegar todo menos el nombre de la funcion para listar los datos
function ListarRealizarP(Pagina) {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    $.ajax({
        type: "POST",
        url: "../Controlador/Prestamo.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'Busca': Busca,
            'CantidadDatos': CantidadDatos,
            'Metodo': "ListarRealizarP"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();
}

function CambiarImagen(Id) {
    if (IdRegistrados.includes(Id)) {
        Boton = document.getElementById("boton" + Id)
        Boton.title = "Descartar"
        Boton.src = 'Assets/Img/Iconos/eliminar.svg'
    }
}

function Asignar(Id) {
    Boton = document.getElementById("boton" + Id)
    if (IdRegistrados.includes(Id)) {
        Referencia = document.getElementById("referencia" + Id)
        Div = Referencia.parentNode
        Referencia.parentNode.parentNode.removeChild(Div)
        for (let i = 0; i < IdRegistrados.length; i++) {
            if (Id == IdRegistrados[i]) {
                IdRegistrados.splice(i, 1);
            }
        }
        Boton.title = "Asignar"

        Boton.src = `Assets/Img/Iconos/agregar.svg`
    }
    else {
        Boton.title = "Descartar"

        Boton.src = 'Assets/Img/Iconos/eliminar.svg'
        Asigna++
        Nombre = document.getElementById("Nombre" + Id).value
        Cantidad = document.getElementById("cantidadd" + Id).value
        //  if(Cantidad == ""){
        //     Cantidad = 1 
        //     document.getElementById("cantidad"+Id).value = 1
        //  }

        var Cosa = document.createElement('tr');
        Cosa.setAttribute("id", "div" + Asigna);
        Cosa.setAttribute("class", "divAsigna");


        var Th = document.createElement("th");
        var Input = document.createElement("input");
        Input.setAttribute("type", "text");
        Input.setAttribute("id", "Nombres" + Asigna);
        Input.setAttribute("class", "campoprestar");
        Input.setAttribute("tabindex", "-1");
        Input.setAttribute("value", Nombre);
        Input.setAttribute("readonly", true)
        Th.appendChild(Input)
        var Input = document.createElement("input");
        Input.setAttribute("type", "hidden");
        Input.setAttribute("Id", "CantidadAsignado" + Id);
        Input.setAttribute("value", document.getElementById("cantidadd" + Id).value);
        Th.appendChild(Input)
        var Input = document.createElement("input");
        Input.setAttribute("type", "hidden");
        Input.setAttribute("id", "ides" + Asigna);
        Input.setAttribute("value", Id);
        Th.appendChild(Input)
        Cosa.appendChild(Th)




        var Th = document.createElement("th");
        var Input = document.createElement("input");
        Input.setAttribute("type", "number");
        Input.setAttribute("id", "cantidades" + Asigna);
        Input.setAttribute("class", "campoprestar" + " cantidad" + Id);
        Input.setAttribute("placeholder", "Ingrese la cantidad a prestar: ");
        Input.setAttribute("onkeyup", "Validacion(" + Id + ")");
        Th.appendChild(Input)
        Th.appendChild(document.createElement("br"))
        var Mensaje = document.createElement("span");
        Mensaje.setAttribute("id", "CantidadError" + Id);
        Mensaje.setAttribute("style", "font-size: 12px; display:block;")
        Th.appendChild(Mensaje)
        Cosa.appendChild(Th)



        var Input = document.createElement("div");
        Input.setAttribute("id", "referencia" + Id);
        Cosa.appendChild(Input)


        var Th = document.createElement("th");
        var Input = document.createElement("div");
        Input.setAttribute("class", "SalirPrestar");
        Input.setAttribute("title", "Descartar");
        Input.setAttribute("tabindex", "-1");
        Input.innerHTML = "X";
        Input.setAttribute("onclick", "Asignar(" + Id + ")");
        Th.appendChild(Input)
        Cosa.appendChild(Th)


        document.getElementById("herramienta").appendChild(Cosa);
        IdRegistrados.push(Id)
    }
    if (IdRegistrados.length != 0) {
        document.querySelector('.herramientasAsignadas').style.display = 'block';
    }
    else {
        document.querySelector('.herramientasAsignadas').style.display = 'none';
    }
}

function Prestar() {
    event.preventDefault();
    Empleado = document.getElementById("id_empleado").value
        Cantidades = []
        Id = []
        Ins = 1
        Inst = 0
        while (Ins <= IdRegistrados.length) {
            Inst++
            try {
        
                    Cantidades.push(document.getElementById("cantidades" + Inst).value)
                    Id.push(document.getElementById("ides" + Inst).value)
                    Ins++
                
            }
            catch (error) {
                console.log(Ins)
            }
        }
  
            $.ajax({
                type: "POST",
                url: "../Controlador/Prestamo.php",
                data: {
                    'Ides': Id,
                    'Cantidades': Cantidades,
                    'IdEmpleado': Empleado,
                    'Metodo': "Prestar"
                },
                datatype: "html",
                success: function (data) {
                    if(!data.includes("No fué posible prestar")){
                        Swal.fire({
                            icon: 'success',
                            text: data
                          });
                          ListarPrestamos();
                          Metodo("Particiones/ListarPrestamos.php")
                        }
                        else{
                            Swal.fire({
                                icon: 'error',
                                text: data
                              }); 
                        }
                   
                    
                },
            });
   
    
}
function Borrado() {
    try {
        Todo = document.getElementById("todo")
        Viejo = document.getElementById("herramienta")
        Todo.removeChild(Viejo)
        var Nuevo = document.createElement("table");
        Nuevo.setAttribute("id", "herramienta");
        Todo.appendChild(Nuevo)
        Asigna = 0
        IdRegistrados = []
        document.querySelector('.herramientasAsignadas').style.display = 'none';
    }
    catch (error) {
        Asigna = 0
        IdRegistrados = []
    }
}
function ListarNombresEmpleado() {
    $.ajax({
        type: "POST",
        url: "../Controlador/Prestamo.php",
        data: {
            'Metodo': "ListarNombresEmpleado"
        },
        datatype: "html",
        success: function (data) {
            $('#id_empleado').text("");
            $('#id_empleado').append(data);
        },
    });
}


// Fin para realizar Prestamo


function ListarPrestamos(Pagina) {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    PaginacionActual = Pagina
    $.ajax({

        type: "POST",
        url: "../Controlador/Prestamo.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'Busca': Busca,
            'CantidadDatos': CantidadDatos,
            'Metodo': "ListarPrestamos"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();
}
function ListarPrestamoDañado(Pagina) {
    Busca = document.getElementById("Busqueda").value
    CantidadDatos = document.getElementById("CantidadDatos").value
    Orden = [document.getElementById("OrdenInput").value, document.getElementById("ColumnaInput").value]
    PaginacionActual = Pagina
    $.ajax({
        type: "POST",
        url: "../Controlador/Prestamo.php",
        data: {
            'Orden': Orden,
            'Pagina': Pagina,
            'Busca': Busca,
            'CantidadDatos': CantidadDatos,
            'Metodo': "ListarPrestamoDañado"
        },
        datatype: "html",
        success: function (data) {
            $('tbody').text("");
            $('tbody').append(data);
        },
    });
    CantidadDatosT();
}




function ModalModificarPrestamo(IdPrestamo) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Prestamo.php",
        data: {
            'IdPrestamo': IdPrestamo,
            'Metodo': "ModalModificarPrestamo"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}



function ModificarPrestamo() {
    event.preventDefault();
    CantidadPrestamo = document.getElementById("CantidadPrestamo").value
    IdPrestamo = document.getElementById("IdPrestamo").value

 
        CerrarModal();
        $.ajax({
            type: 'POST',
            url: "../Controlador/Prestamo.php",
            data: {
                'CantidadPrestamo': CantidadPrestamo,
                'IdPrestamo': IdPrestamo,
                'Metodo': 'ModificarPrestamo'
            },
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                ListarPrestamos(PaginacionActual);
                ListarPaginacion(PaginacionActual);
            }
        }); 
}


function ModalDevolverHerramienta(IdPrestamo) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Prestamo.php",
        data: {
            'IdPrestamo': IdPrestamo,
            'Metodo': "ModalDevolverHerramienta"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}



function DevolverHerramienta() {
    event.preventDefault();
    IdPrestamo = document.getElementById("IdPrestamo2").value
    CantidadDevolver = document.getElementById("NoDevolver").value
    Select = document.getElementById("Select").value
    CantidadDañado = ""
    Observacion = ""
    if (Select == "si") {
        CantidadDañado = document.getElementById("CantidadDañado").value
        Observacion = document.getElementById("Observacion").value
    }

        
        $.ajax({
            type: "POST",
            url: "../Controlador/Prestamo.php",
            data: {
                'IdPrestamo': IdPrestamo,
                'Select': Select,
                'CantidadDañado': CantidadDañado,
                'Observacion': Observacion,
                'CantidadDevolver': CantidadDevolver,
                'Metodo': "DevolverHerramienta"
            },
            datatype: "html",
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                  CerrarModal();
                ListarPrestamos(PaginacionActual)
                ListarPaginacion(PaginacionActual);
            },
        });
    
}

function DevolverDañada(Id) {
    event.preventDefault();
    Cantidad = document.getElementById("CantidadPrestamo").value

        $.ajax({
            type: "POST",
            url: "../Controlador/Prestamo.php",
            data: {
                'Id': Id,
                'Cantidad': document.getElementById("CantidadHerramienta").value,
                'CantidadArreglada': Cantidad,
                'Metodo': "DevolverDañada"
            },
            datatype: "html",
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                CerrarModal()
                ListarPrestamoDañado(PaginacionActual)
                ListarPaginacion(PaginacionActual);
            },
        });
    
}




function ModalArreglarH(Id, Cantidad) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Prestamo.php",
        data: {
            'Id': Id,
            'Cantidad': Cantidad,
            'Metodo': "ModalArreglarH"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}

function ModalEditarDanada(Id, Observacion) {
    window.modal.showModal();
    $.ajax({
        type: 'POST',
        url: "../Controlador/Prestamo.php",
        data: {
            'Id': Id,
            'Observacion': Observacion,
            'Metodo': "ModalEditarDanada"
        },
        success: function (data) {
            $('.modal-body').text("");
            $('.modal-body').append(data);
        }
    });
}


function ModificarDanada(Id) {
    event.preventDefault();

        $.ajax({
            type: "POST",
            url: "../Controlador/Prestamo.php",
            data: {
                'Id': Id,
                'Observacion': Observacion,
                'Metodo': "ModificarDanada"
            },
            datatype: "html",
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    text: data
                  });
                CerrarModal()
                ListarPrestamoDañado(PaginacionActual)
                ListarPaginacion(PaginacionActual);
            },
        });
    }




//Validaciones

//Validacion para realizar prestamo
function Validacion(Values) {
    Cantidadd = parseInt(document.getElementById("CantidadAsignado" + Values).value)

    Faull = document.getElementsByClassName("cantidad" + Values)
    Mensaje = document.getElementById("CantidadError" + Values)
    Cantidad = parseInt(Faull[0].value)
    Faull = Faull[0]

    Faull.style.borderColor = "red";
    if (!/^[0-9]{1,11}$/.test(Cantidad)){
        Mensaje.textContent = "La cantidad no puede contener caracteres especiales.";
    }
    else if(Cantidad > Cantidadd)
    {
        Mensaje.textContent = "La cantidad no puede ser superior a "+Cantidadd+".";
    }
    else if(Cantidad < 1)
    {
        Mensaje.textContent = "La cantidad no puede ser inferior a 1.";
    }
    else{
        Faull.style.borderColor = "green";
        Mensaje.textContent = "";
    }
    ValidarCamposRealizarPrestamo()    
}
function ValidarCamposRealizarPrestamo() {
    Campos = []
    for (let index = 0; index < IdRegistrados.length; index++) {
        CantidadValidar = document.getElementsByClassName("cantidad"+IdRegistrados[index]); 
        Campos.push(CantidadValidar[0].style.borderColor == "green")
    }

    let submitButton = document.getElementById("BotonRealizarPrestar");
    if (Campos.includes(false)) {
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
    }
    }
    
//Validacion para devolver herramienta

function Validacion3() {
    CantidadDañado = document.getElementById("CantidadDañado").value
    CantidadDevolver = document.getElementById("NoDevolver").value
    Mensaje = document.getElementById("CantidadDevolverError")
    Faull = document.getElementById("CantidadDañado")
    $(Faull).val(CantidadDañado);
    CantidadDañado = parseInt(CantidadDañado)
    CantidadDevolver = parseInt(CantidadDevolver)
    Faull.style.borderColor = "red";
 if (!/^[0-9]{1,11}$/.test(CantidadDañado)){
        Mensaje.textContent = "La cantidad no puede contener caracteres especiales.";
    }
    else if (CantidadDañado < 1) {
        Mensaje.textContent = "La cantidad no puede ser inferior a 1.";
    }
    else if (CantidadDañado > CantidadDevolver) {
        Mensaje.textContent = "La cantidad no puede ser superior a "+CantidadDevolver+".";
    }
    else{
        Faull.style.borderColor = "green";
        Mensaje.textContent = "";
    }
    ValidarCamposPrestamo()
}

function Validacion5(){
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
ValidarCamposPrestamo()
}

function Validacion4() {
    CantidadBase = document.getElementById("CantidadBase").value
    CantidadDevolver = document.getElementById("NoDevolver").value
    Faull = document.getElementById("NoDevolver")
    Mensaje = document.getElementById("CantidadError")

    $(Faull).val(CantidadDevolver);
    CantidadDevolver = parseInt(CantidadDevolver)
    CantidadBase = parseInt(CantidadBase)



    Faull.style.borderColor = "red";
    if (!/^[0-9]{1,11}$/.test(CantidadDevolver)){
        Mensaje.textContent = "La cantidad no puede contener caracteres especiales.";
    }
    else if (CantidadDevolver < 1) {
        Mensaje.textContent = "La cantidad no puede ser inferior a 1.";
    }
    else if (CantidadDevolver > CantidadBase) {
        Mensaje.textContent = "La cantidad no puede ser superior a "+CantidadBase+".";
    }
    else{
        Faull.style.borderColor = "green";
        Mensaje.textContent = "";
    }
    ValidarCamposPrestamo()
}


//Validacion para modificar prestamo
function Validacion2() {
    CantidadHerramienta = document.getElementById("CantidadHerramienta").value
    Mensaje = document.getElementById("CantidadError")
    CantidadPrestamo = document.getElementById("CantidadPrestamo").value
    CantidadPrestamoActual = document.getElementById("CantidadPrestamoActual").value
    CantidadPrestamoActual = parseInt(CantidadPrestamoActual);
    Faull = document.getElementById("CantidadPrestamo")
    $(Faull).val(CantidadPrestamo);
    CantidadPrestamo = parseInt(CantidadPrestamo)
    CantidadHerramienta = parseInt(CantidadHerramienta)
    Total = CantidadHerramienta + CantidadPrestamoActual
    if (!/^[0-9]{1,11}$/.test(CantidadPrestamo)) {
        Mensaje.textContent = "La cantidad no puede contener caracteres especiales.";
        Faull.style.borderColor = "red";
    }
    else if (CantidadPrestamo > (Total)) {
        Mensaje.textContent = "La cantidad no puede ser superior a "+Total+".";
        Faull.style.borderColor = "red";
    }
    else if (CantidadPrestamo < 1) {
        Mensaje.textContent = "La cantidad no puede ser inferior a 1.";
        Faull.style.borderColor = "red";
    }
    else{
        Mensaje.textContent = "";
        Faull.style.borderColor = "green";
    }
    ValidarCamposPrestamo()   
}

//EU
function ValidarCamposPrestamo() {
    TipoParaValidadModificarPrestamo = document.getElementById("Metodo2").value;
    let submitButton = document.getElementById("BotonPrestamo");
    if (TipoParaValidadModificarPrestamo == "Modificar"){ 
        CantidadValidar = document.getElementById("CantidadPrestamo"); 
        ValidadoCantidad = CantidadValidar.style.borderColor == "green"
        if (ValidadoCantidad) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true ;
        }
}
    else{
        if(document.getElementById("Select").value == "si"){
            CantidadValidar = document.getElementById("NoDevolver"); 
            CantidadDañado = document.getElementById("CantidadDañado")
            Observacion = document.getElementById("Observacion")
            Valida3 = Observacion.style.borderColor == "green"
            Valida2 = CantidadDañado.style.borderColor == "green"
            ValidadoCantidad = CantidadValidar.style.borderColor == "green"
            if (ValidadoCantidad && Valida2 && Valida3) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true ;
            }
        }
        else{
            CantidadValidar = document.getElementById("NoDevolver"); 
            ValidadoCantidad = CantidadValidar.style.borderColor == "green"
            if (ValidadoCantidad) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true ;
            }
        }
    }
    }

    
function Siono() {
    if (document.getElementById("Select").value == "si") {
        document.getElementById("CantidadDañado").style.display = 'block'
        document.getElementById("Observacion").style.display = 'block'
        document.getElementById("Label1").style.display = 'block'
        document.getElementById("Label2").style.display = 'block'
        document.getElementById("CantidadDevolverError").style.display = 'block'
        document.getElementById("ObservacionError").style.display = "block"

    }
    else {
        document.getElementById("CantidadDañado").style.display = 'none'
        document.getElementById("Observacion").style.display = 'none'
        document.getElementById("Label1").style.display = 'none'
        document.getElementById("Label2").style.display = 'none'
        document.getElementById("CantidadDevolverError").style.display = 'none'
        document.getElementById("ObservacionError").style.display = "none"
        document.getElementById("Observacion").value = ""
        document.getElementById("Observacion").style.borderColor = "white"
        document.getElementById("CantidadDañado").style.borderColor = 'white'
        document.getElementById("CantidadDañado").value = ''
        document.getElementById("CantidadDevolverError").textContent = ""
        document.getElementById("ObservacionError").textContent = ""
    }
}

// Validacion para arreglar herramienta
function Validacion6() {
    CantidadHerramienta = document.getElementById("CantidadHerramienta").value
    Mensaje = document.getElementById("ArreglarError")
    CantidadPrestamo = document.getElementById("CantidadPrestamo").value
    Faull = document.getElementById("CantidadPrestamo")
    $(Faull).val(CantidadPrestamo);
    CantidadPrestamo = parseInt(CantidadPrestamo)
    CantidadHerramienta = parseInt(CantidadHerramienta)
    if (!/^[0-9]{1,11}$/.test(CantidadPrestamo)) {
        Mensaje.textContent = "La cantidad no puede contener caracteres especiales.";
        Faull.style.borderColor = "red";
    }
    else if (CantidadPrestamo > (CantidadHerramienta)) {
        Mensaje.textContent = "La cantidad no puede ser superior a "+CantidadHerramienta+".";
        Faull.style.borderColor = "red";
    }
    else if (CantidadPrestamo < 1) {
        Mensaje.textContent = "La cantidad no puede ser inferior a 1.";
        Faull.style.borderColor = "red";
    }
    else{
        Mensaje.textContent = "";
        Faull.style.borderColor = "green";
    }
    ValidarCamposArreglar()   
}
function ValidarCamposArreglar(){
    CantidadValidar = document.getElementById("CantidadPrestamo"); 
    ValidadoCantidad = CantidadValidar.style.borderColor == "green"
    Boton = document.getElementById("BotonArreglar");
    if (ValidadoCantidad) {
        Boton.disabled = false;
    } else {
        Boton.disabled = true ;
    }   
}

//Validacion para modificar una herramienta dañada

function Validacion7() {
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
    ValidarCamposModificarD()   
}
function ValidarCamposModificarD(){
    ObservacionValidar = document.getElementById("Observacion"); 
    ValidadoObservacion = ObservacionValidar.style.borderColor == "green"
    Boton = document.getElementById("BotonObservacion");
    if (ValidadoObservacion) {
        Boton.disabled = false;
    } else {
        Boton.disabled = true ;
    }   
}
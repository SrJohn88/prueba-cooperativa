const formulario = document.getElementById('formAsociados');
const inputs = formulario.querySelectorAll('#formAsociados input');
const textarea = document.getElementById('txtDireccion');


//JQUERI PARA PETICION (OBTENER UN USUARIO POR ID )
$("#tableAsociados").on("click", ".editar", function() {
    const id = $(this).attr('idAsociado');
    console.log(id);

    $.ajax({
        url: 'controllers/Api/AsociadosApiController.php',
        data: {
            metodo: 'GET',
            id: id
        },
        method: "GET",
        dataType: 'JSON',
        success: function(json) {
            console.log(json);
            trueForm();
            $('#txtNombre').val(json['nombre']);
            $('#txtApellido').val(json['apellido']);
            $('#txtEdad').val(json['edad']);
            $('#txtDireccion').val(json['direccion']);
            $('#txtDui').val(json['dui']);
            $('#txtNit').val(json['nit']);
            $('#txtProfesion option[value="' + json['profesion_id'] + '"]').attr('selected', 'selected');
            $('#txtAgencia option[value="' + json['agencia_id'] + '"]').attr('selected', 'selected');
            $('#txtId').val(json['id']);
        },
        error: function(xhr, status) {
            //console.log(status);
            console.log('Disculpe, existió un problema');
        },
        complete: function(xhr, status) {
            console.log('Petición realizada');
        }
    });
});

// JQUERY PETICION PARA INSERTAR DATOS
$('#formAsociados').on('submit', function(e) {
    e.preventDefault();

    if (campos.txtNombre && campos.txtApellido && campos.txtEdad && campos.txtDui && campos.txtNit && campos.txtDireccion) {
        const data = $(this).serialize();
        console.log(data)

        $.ajax({
            url: 'controllers/Api/AsociadosApiController.php',
            data: data,
            method: "POST",
            dataType: 'JSON',
            success: function(json) {
                console.log(json)
                var asociado = json.objeto;
                console.log(asociado)
                if (json.status) {
                    $('#exampleModal').modal('hide')
                    if (json.accion === 'update') {
                        update(asociado.id, asociado.nombre, asociado.apellido, asociado.direccion, asociado.edad, asociado.dui, asociado.nit, asociado.profesion, asociado.agencia)
                    } else {
                        insert(asociado.id, asociado.nombre, asociado.apellido, asociado.direccion, asociado.edad, asociado.dui, asociado.nit, asociado.profesion, asociado.agencia)
                    }
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Valores Almacenados',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: json.mensaje,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(xhr, status) {
                console.log(xhr);
                console.log('Disculpe, existió un problema');
            },
            complete: function(xhr, status) {
                console.log('Petición realizada');
            }
        });


    } else {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: '¿Completaste todos los campos?',
            showConfirmButton: false,
            timer: 1500
        })
    }
})

//JQUERY PARA ELIMINACION LOGICA DE UN REGISTRO
$('#tableAsociados').on('click', '.eliminar', function() {

    const id = $(this).attr('idAsociado');
    // console.log(id);

    $.ajax({
        url: 'controllers/Api/AsociadosApiController.php',
        data: {
            id,
            metodo: 'DELETE'
        },
        method: 'GET',
        dataType: 'JSON',
        success: function(response) {
            console.log(response);
            if (response.status) {
                $("#row" + id).remove();
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Asociado Eliminado',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    });

});

const insert = function(id, nombre, apellido, direccion, edad, dui, nit, profesion, agencia) {
    $("#tableAsociados > tbody").append(
        `<tr id="row` + id + `">` +
        `<td id="tableId"> ` + id + `</td>` +
        `<td id="tableNombre"> ` + nombre + `</td>` +
        `<td id="tableApellido"> ` + apellido + `</td>` +
        `<td id="tableDireccion">` + direccion + `</td>` +
        `<td id="tableEdad">` + edad + `</td>` +
        `<td id="tableDui">` + dui + `</td>` +
        `<td id="tableNit">` + nit + `</td>` +
        `<td id="tableProfesionId">` + profesion + `</td>` +
        `<td id="tableAgenciaId">` + agencia + `</td>` +
        `<td>` +
        `<a class="btn btn-sm btn-info" href="index.php?controller=Asociados&action=historial&id=<?=$asociado->id ?>">Historial</a>` +
        `<button class="btn btn-warning editar m-1" idAsociado="` + id + `" id="editarAsociado" data-toggle="modal" data-target="#exampleModal"><i class="bi bi-pen-fill"></i></button>` +
        `<button class="btn btn-danger eliminar m-1" idAsociado="` + id + `" id="eliminarAsociado"><i class="bi bi-trash"></i></button>` +
        `</td>` +
        `</tr>`
    );
}

const update = function(id, nombre, apellido, direccion, edad, dui, nit, profesion, agencia) {

    var row = $('#row' + id);

    row.children("#tableNombre").text(nombre);
    row.children("#tableApellido").text(apellido);
    row.children("#tableDireccion").text(direccion);
    row.children("#tableEdad").text(edad);
    row.children("#tableDui").text(dui);
    row.children("#tableNit").text(nit);
    row.children("#tableProfesionId").text(profesion);
    row.children("#tableAgenciaId").text(agencia);
}

// METODOS DE VALIDACION DE FORMULARIO JAVASCRIPT

const rules = {
    nombre: /^[A-Za-z ]{3,20}$/,
    apellido: /^[A-Za-z ]{4,20}$/,
    edad: /^[0-9]{2}$/,
    dui: /^[0-9]{8}-[0-9]{1}$/,
    nit: /^[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}$/,
    direccion: /^[a-zA-Z0-9 ]{2,100}$/,
}

const campos = {
    txtNombre: false,
    txtApellido: false,
    txtEdad: false,
    txtDui: false,
    txtNit: false,
    txtDireccion: false
}

const validarFormulario = (e) => {
    switch (e.target.name) {
        case 'nombre':
            validate(rules.nombre, e.target, 'txtNombre');
            break;
        case 'apellido':
            validate(rules.apellido, e.target, 'txtApellido');
            break;
        case 'edad':
            validate(rules.edad, e.target, 'txtEdad');
            break;
        case 'dui':
            validate(rules.dui, e.target, 'txtDui');
            break;
        case 'nit':
            validate(rules.nit, e.target, 'txtNit');
            break;
        case 'direccion':
            validate(rules.direccion, e.target, 'txtDireccion');
            break;

        default:
            break;
    }
}

const validate = (expresion, input, id) => {

    if (expresion.test(input.value)) {
        document.getElementById(id).classList.remove('is-invalid')
        document.getElementById(id).classList.add('is-valid')
        campos[id] = true
    } else {
        document.getElementById(id).classList.add('is-invalid')
        document.getElementById(id).classList.remove('is-valid')
        campos[id] = false
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', validarFormulario)
    input.addEventListener('blur', validarFormulario)
});

textarea.addEventListener('keyup', validarFormulario)
textarea.addEventListener('blur', validarFormulario)

const trueForm = () => {
    campos.txtNombre = true;
    campos.txtApellido = true;
    campos.txtDireccion = true;
    campos.txtEdad = true;
    campos.txtDui = true;
    campos.txtNit = true;
}

$('#exampleModal').on('hidden.bs.modal', function(e) {

    var nombre = $('#txtNombre');
    nombre.val('');
    nombre.removeClass(['is-valid', 'is-invalid'])

    var apellido = $('#txtApellido')
    apellido.val('')
    apellido.removeClass(['is-valid', 'is-invalid'])

    var edad = $('#txtEdad')
    edad.val('')
    edad.removeClass(['is-valid', 'is-invalid'])

    var direccion = $('#txtDireccion')
    direccion.val('')
    direccion.removeClass(['is-valid', 'is-invalid'])

    var dui = $('#txtDui')
    dui.val('')
    dui.removeClass(['is-valid', 'is-invalid'])

    var nit = $('#txtNit')
    nit.val('')
    nit.removeClass(['is-valid', 'is-invalid'])

    $('#txtId').val('');
})
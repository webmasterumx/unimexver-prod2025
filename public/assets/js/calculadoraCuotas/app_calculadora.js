function envioFormulario(form) {
    $("#envio_caluladora").prop("disabled", true);
    $('#envio_caluladora').html(`
            <div class="spinner-border me-1" style="width: 20px; height: 20px;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            Calculando
        `);

    let nombreNivel = $('select[name="selectNivel"] option:selected').text();
    let nombrePlantel = $('select[name="selectPlantel"] option:selected').text();
    let nombrePeriodo = $('select[name="selectPeriodo"] option:selected').text();

    let formData = new FormData(form);
    formData.append('nombreNivel', nombreNivel);
    formData.append('nombrePlantel', nombrePlantel);
    formData.append('nombrePeriodo', nombrePeriodo);

    let ruta = setUrlBase() + "insertar/prospecto/calculadora";

    $.ajax({
        method: "POST",
        url: ruta,
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
    }).done(function (data) {
        let respuesta = JSON.parse(data);
        console.log(respuesta);

        let estatusCorreo = respuesta.estadoCorreo;
        if (estatusCorreo == true) {
            console.log("correo enviado correctamente");
            $('#mensajeCorrreo').html(`
                    <div id="alertSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                        ¡Correo enviado correctamente!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
        } else {
            console.log("error en el envio del correo ");
            $('#mensajeCorrreo').html(`
                    <div id="alertError" class="alert alert-danger alert-dismissible fade show" role="alert">
                        ¡Error al enviar correo!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
        }

        setTimeout(function () {
            $('#alertSuccess').addClass('d-none');
            $('#alertError').addClass('d-none');
        }, 5000);

        let nombreProspecto = $('#nombreProspecto').val() + " " + $('#apellidosProspecto').val();
        let periodoProspecto = $('select[name="selectPeriodo"] option:selected').text();
        let nivelProspecto = $('select[name="selectNivel"] option:selected').text();

        $('#folioCrm').val('Folio: ' + respuesta.FolioCRM);
        $('#nombreCrm').val(nombreProspecto);
        $('#periodoCrm').val(periodoProspecto);
        $('#nivelCrm').val(nivelProspecto);
        establecerTextoComboCarrera();

        let carrera_calculadora = getCarreraPrecargada();

        if (carrera_calculadora != null) {
            getCarrerasWithVariableEstablecida(carrera_calculadora);
        }
        else {
            getCarreras();
        }

        $("#nombreProspecto").prop("disabled", true);
        $("#apellidosProspecto").prop("disabled", true);
        $("#telefonoProspecto").prop("disabled", true);
        $("#emailProspecto").prop("disabled", true);
        $("#telefono_celular").prop("disabled", true);
        $("#telefono_fijo").prop("disabled", true);

        $('#terminosCondicionesText').html(respuesta.legales);
        $('#terminosCondiciones').removeClass('d-none');
        $('#separacionTerminosCondiciones').removeClass('d-none');

        $('#envio_caluladora').html(`Calcular`);

        $('#carrucelCalBeca').addClass('d-none');
        $('#informacionCRM').removeClass('d-none');



    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function selectHorario(turno, beca, element) {

    $("#redireccionPEL").prop("disabled", false);
    $("#redireccionPEL").html("PREINSCRIPCIÓN EN LINEA");

    $('.style_prevu_kit').removeClass("active");
    $(element).addClass('active');
    $('#cargador_costos').removeClass('d-none');
    $('#grupoInformacion').addClass('d-none');

    let PlantelId = $('select[name=selectPlantel]').val();
    let claveCarrera = $('select[name=selectCarrera]').val();
    let claveTurno = turno;
    let claveNivel = $('select[name=selectNivel]').val();
    let clavePeriodo = $('select[name=selectPeriodo]').val();
    let claveBeca = beca;
    let egresado = 0;

    let data = {
        "PlantelId": PlantelId,
        "claveCarrera": claveCarrera,
        "claveTurno": claveTurno,
        "claveNivel": claveNivel,
        "clavePeriodo": clavePeriodo,
        "claveBeca": claveBeca,
        "egresado": egresado,
    };

    console.log(data);

    actualizarProspectoCalculadora(turno);

    let ruta = setUrlBase() + "get/detalle/beca";

    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ruta,
        data: data
    }).done(function (data) {
        console.log(data);

        if (data.Beca != undefined) {
            establecerValoresCosto(data);
            //establecerVariablesPromo(data);
        }
        else {
            if ($("#grupoInformacion").hasClass("d-none") === false) {
                $('#grupoInformacion').addClass('d-none');
            }
            $('#cargador_costos').addClass('d-none');
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Ups! Ups! Ups! ... Algo salió mal, pronto lo resolveremos.<br>Mándanos un mensaje dando <strong><a href='https://www.facebook.com/unimex/' target='_blank'>click aquí</a></strong> y atenderemos tu solicitud.<br>Disculpe las molestias que esto le pueda causar.",
                showConfirmButton: true,
                confirmButtonText: "Ok",
            });
        }

    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function establecerValoresCosto(data) {
    let nombreNivel = $('select[name="selectNivel"] option:selected').text();
    let nombreCarrera = $('select[name="selectCarrera"] option:selected').text();
    let nombrePlantel = $('select[name="selectPlantel"] option:selected').text();

    //datos de costos
    $('#costoCnPromocion').html(`$${data.InscCB}`);
    $('#porcentajeBeca').html(`Beca del ${data.Beca}%`);
    $('#costoBeca').html(`$${data.ParcCB}`);
    $('#costoPromocion').html(`$${data.TotalCB}`);

    //datos de informacion
    $('#carreraInfo').html(`<b>${nombreNivel} en ${nombreCarrera}</b>`);
    $('#plantelInfo').html(`<b>${nombrePlantel}</b>`);
    $('#turnoInfo').html(`<b>${data.Turno}</b>`);
    $('#horarioInfo').html(`<b>${data.Horario}</b>`);
    $('#incioInfo').html(`<b>${data.DescripPer}</b>`);
    $('#vigenciaInfo').html(`<b>${data.Vigencia}</b>`);

    conservarVariablesDetalleCalculadora(nombreNivel, nombreCarrera, nombrePlantel, data);

    $('#cargador_costos').addClass('d-none');
    $('#grupoInformacion').removeClass('d-none');
}

function getCarreras() {

    $("#selectCarrera").empty();
    $("#selectCarrera").append(`<option><div class="spinner-border" role="status"><span class="visually-hidden">Calculando...</span></div></option>`);

    let clavePlantel = $('select[name=selectPlantel]').val();
    let clavePeriodo = $('select[name=selectPeriodo]').val();
    let claveNivel = $('select[name=selectNivel]').val();

    let data = {
        "plantel": clavePlantel,
        "nivel": claveNivel,
        "periodo": clavePeriodo
    }
    console.log(data);

    let ruta = setUrlBase() + "getCarreras";

    $.ajax({
        method: "POST",
        url: ruta,
        dataType: "json",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).done(function (data) {
        console.log(data);
        $("#selectCarrera").empty();
        $("#selectCarrera").append(`<option class="text-center" value=""> - Selecciona una Carrera - </option>`);
        for (let index = 0; index < data.length; index++) { //recorrer el array de carreras
            const element = data[index]; // se establece un elemento por carrera optenida
            let option = `<option class="text-center" value="${element.clave}">${element.descrip}</option>`; //se establece la opcion por carrera
            $("#selectCarrera").append(option); // se inserta la carrera de cada elemento
        }

    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function getNiveles() {

    $("#selectNivel").empty();
    $("#selectNivel").append(`<option value="" selected disabled>Selecciona el nivel</option>`);

    let plantel = $('select[name=selectPlantel]').val();
    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: setUrlBase() + "getNiveles",
        data: {
            plantel: plantel
        }
    }).done(function (data) {
        console.log(data);
        $.each(data, function (index, value) {
            $('#selectNivel').append("<option value='" + value.clave + "'>" + value
                .descrip + "</option>");
        });

    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function setCarreraSeleccionada() {
    let carrera = $('select[name=selectCarrera]').val();

    return carrera;
}

function setNombreCarrreraSaleccionada() {
    let nombre = $('select[name="selectCarrera"] option:selected').text();

    return nombre;
}

/**
 * Esta funcion permite establcer ls varibles carrera para hacer recalculos
 */
function setVariablesCombosReguardadas(carrera, nombre) {

    console.log(carrera);
    console.log(nombre);

    sessionStorage.setItem("nombreCarrera", nombre);

    let ruta = setUrlBase() + "set/variables/combos/calculadora/" + carrera + "/" + nombre;

    $.ajax({
        method: "GET",
        url: ruta,
        dataType: "html",
    }).done(function (data) {

        console.log(data);

    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function getVariablesCombosResguardadas() {

    let carreraResguardo = 0;
    //let nombreCarreraRes = data.nombre;

    let nombreCarreraRes = sessionStorage.getItem("nombreCarrera");
    console.log(nombreCarreraRes);

    recalculoDeCombos(carreraResguardo, nombreCarreraRes);

}

function recalculoDeCombos(carreraResguardo, nombreCarreraRes) {
    // se resguarda la carrera previamente seleccinada


    console.log(carreraResguardo);
    console.log(nombreCarreraRes);

    let cont;
    let clavePlantel = $('select[name=selectPlantel]').val();
    let clavePeriodo = $('select[name=selectPeriodo]').val();
    let claveNivel = $('select[name=selectNivel]').val();

    let data = {
        "plantel": clavePlantel,
        "nivel": claveNivel,
        "periodo": clavePeriodo
    }
    console.log(data);

    let ruta = setUrlBase() + "getCarreras";

    $.ajax({
        method: "POST",
        url: ruta,
        dataType: "json",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).done(function (data) {
        console.log(data);
        $("#selectCarrera").empty();
        $("#selectCarrera").append(`<option selected disabled> - Selecciona una Carrera - </option>`);

        for (let index = 0; index < data.length; index++) { //recorrer el array de carreras
            const element = data[index]; // se establece un elemento por carrera optenida
            if (element.clave == carreraResguardo || element.descrip == nombreCarreraRes) {
                cont = cont + 1;
                console.log('la carrera esta en el catalogo nuevo');
                option = `<option value="${element.clave}" selected>${element.descrip}</option>`; //se establece la opcion por carrera

            } else {
                console.log('la carrera no esta en el catalogo nuevo');
                option = `<option value="${element.clave}">${element.descrip}</option>`; //se establece la opcion por carrera
            }
            $("#selectCarrera").append(option); // se inserta la carrera de cada elemento

        }

        obtenerHorariosBeca();

    }).fail(function () {
        console.log("Algo salió mal");
    });

}

function obtenerHorariosBeca() {

    $('#cargador_horarios').removeClass('d-none');

    let carrera = $('select[name=selectCarrera]').val();
    let nivel = $('select[name=selectNivel]').val();
    let periodo = $('select[name=selectPeriodo]').val();
    let plantel = $('select[name=selectPlantel]').val();

    let data = {
        "claveCarrera": carrera,
        "claveNivel": nivel,
        "clavePeriodo": periodo,
        "PlantelId": plantel,
    }

    console.log(data);
    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: setUrlBase() + "get/horarios/calculadora",
        data: data
    }).done(function (data) {
        $('#grupoBotones').empty();
        console.log(data);
        if (data.ClaveBeca != undefined) {
            let option = `
            <div class="col-6 col-md-6 col-lg-3 mt-3"> 
                <button class="btn btn-outline-primary style_prevu_kit w-100" onclick="selectHorario(${data.ClaveTurno}, ${data.ClaveBeca}, this)">
                    ${data.Turno} <br>
                    ${data.Horario} <br>
                    Beca : ${data.ValorBeca}%
                </button>
            </div>
            `;
            $('#grupoBotones').append(option);
        }
        else if (data.error == undefined) {
            let arrayColor = ['btn-outline-primary', 'btn-outline-info', 'btn-outline-secondary', 'btn-outline-success', 'btn-outline-danger', 'btn-outline-warning', 'btn-outline-dark', 'bg-outline-purple', 'bg-outline-orange', 'bg-outline-teal', 'bg-outline-pink', 'bg-outline-vine', 'bg-outline-brisa', 'bg-outline-durazno', 'bg-outline-pasto', 'bg-outline-paleta'];
            let cont = 0;
            $.each(data, function (index, value) {
                let option = `
                <div class="col-6 col-md-6 col-lg-3 mt-3">
                    <button class="btn ${arrayColor[Math.floor(Math.random() * arrayColor.length)]}  style_prevu_kit w-100" onclick="selectHorario(${value.ClaveTurno}, ${value.ClaveBeca}, this)">
                        ${value.Turno} <br>
                        ${value.Horario} <br>
                        Beca : ${value.ValorBeca}%
                    </button>
                </div>
                `;
                $('#grupoBotones').append(option);

                cont = cont + 1;
            });
        }
        else {
            let option = `
            <div class="col-3 mt-3">
                <p class="text-danger">No hay horarios disponibles</p>
            </div>
            `;
            $('#grupoBotones').append(option);
        }

        $('#cargador_horarios').addClass('d-none');

    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function getPeriodos() {


    let plantel = $('select[name=selectPlantel]').val();
    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: setUrlBase() + "getPeriodos",
        data: {
            plantel: plantel
        }
    }).done(function (data) {

        $("#selectPeriodo").empty();
        $("#selectPeriodo").append(`<option value="" selected disabled>¿Cuándo deseas iniciar?</option>`);

        console.log(data);
        if (data.clave == undefined || data.clave == null) {
            $.each(data, function (index, value) {
                $('#selectPeriodo').append("<option value='" + value.clave + "'>" + value
                    .descrip + "</option>");
            });
        } else {
            $('#selectPeriodo').append("<option value='" + data.clave + "'>" + data
                .descrip + "</option>");
        }

    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function actualizarProspectoCalculadora(turno) {
    /**
     * este metodo solo actualiza la oferta academica que el prospecto eligio 
     * no actualiza sus datos como nombre, telefono o apellidos
     * esto pasa incluso si el prospecto ya esta matriculado
     * 
     * esto tambien hace que el prospecto    pase al estado matriculado pero con el estatus considerar para el 
     * algirtimo de preinscripcion en linea
     */
    let rutaActualizar = setUrlBase() + 'actualiza/prospecto/calculadora';

    let editor = $('#folioCrm').val();
    let fagmentoCRM = editor.split(' ');

    let data = {
        clavePeriodo: $('select[name=selectPeriodo]').val(),
        clavePlantel: $('select[name=selectPlantel]').val(),
        claveNivel: $('select[name=selectNivel]').val(),
        claveCarrera: $('select[name=selectCarrera]').val(),
        claveTurno: turno,
        folioCrm: fagmentoCRM[1],
    };

    /*  let data = {
         clavePeriodo:108,
         clavePlantel: 2,
         claveNivel: 1,
         claveCarrera: 10,
         claveTurno: 6,
         folioCrm: 1206180,
     };  */

    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: rutaActualizar,
        data: data
    }).done(function (data) {
        console.log(data);

    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function establecerVariablesPromo(data) {

    let ruta = setUrlBase() + 'establecer/variables/oferta';

    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ruta,
        data: data
    }).done(function (data) {
        console.log(data);

    }).fail(function () {
        console.log("Algo salió mal");
    });

}

function enviarDetallesHorarioBeca() {

    $("#correoButton").prop("disabled", true);
    $('#correoButton').html(`
        <div class="spinner-border me-1" style="width: 20px; height: 20px; color: #de951b;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        Enviando correo
    `);

    let rutaActualizar = setUrlBase() + 'enviar/detalles/beca';

    $.ajax({
        method: "GET",
        url: rutaActualizar,
    }).done(function (data) {
        console.log(data);
        if (data.result == true) {
            Swal.fire({
                icon: "success",
                text: "Los detalles de tu Beca se han enviado a tu correo.",
            });
        } else {
            Swal.fire({
                icon: "error",
                text: "¡Error al enviar correo!",
            });
        }

        $("#correoButton").prop("disabled", false);
        $('#correoButton').html(`
            <i class="bi bi-envelope" style="color: #de951b;"></i>
            Enviar a correo
        `);

    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function getCarrerasWithVariableEstablecida(carreraEnVariable) {

    carreraFinal = carreraEnVariable.replaceAll("_", " ");
    console.log(carreraFinal);

    $("#selectCarrera").empty();
    $("#selectCarrera").append(`<option><div class="spinner-border" role="status"><span class="visually-hidden">Calculando...</span></div></option>`);

    let clavePlantel = $('select[name=selectPlantel]').val();
    let clavePeriodo = $('select[name=selectPeriodo]').val();
    let claveNivel = $('select[name=selectNivel]').val();

    let data = {
        "plantel": clavePlantel,
        "nivel": claveNivel,
        "periodo": clavePeriodo
    }
    console.log(data);

    let ruta = setUrlBase() + "getCarreras";

    $.ajax({
        method: "POST",
        url: ruta,
        dataType: "json",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).done(function (data) {
        console.log(data);
        $("#selectCarrera").empty();
        $("#selectCarrera").append(`<option class="text-center" value=""> - Selecciona una Carrera - </option>`);
        for (let index = 0; index < data.length; index++) { //recorrer el array de carreras
            const element = data[index]; // se establece un elemento por carrera optenida
            if (element.descrip == carreraFinal) {
                estado = "selected";
            }
            else {
                estado = "";
            }
            let option = `<option class="text-center" value="${element.clave}" ${estado}>${element.descrip}</option>`; //se establece la opcion por carrera
            $("#selectCarrera").append(option); // se inserta la carrera de cada elemento
        }

        setVariablesCombosReguardadas(0, carreraFinal);
        obtenerHorariosBeca();

    }).fail(function () {
        console.log("Algo salió mal");
    });
}

function redireccionPreinscripcionEnLinea() {

    $("#redireccionPEL").prop("disabled", true);
    $('#redireccionPEL').html(`
        <div style="width: 20px !important; height: 20px !important;"
            class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        Redirigiendo
    `);

    //! codigo de verificacion del prospecto dentro de preinscripcion en linea queda pendiente por mantenimiento
    let formData = new FormData();
    formData.append("correo", $('#emailProspecto').val());
    formData.append("telefono", $("#telefonoProspecto").val());

    formData.append("utm_source", $("#utm_source").val());
    formData.append("utm_medium", $("#utm_medium").val());
    formData.append("utm_campaign", $("#utm_campaign").val());
    formData.append("utm_term", $("#utm_term").val());
    formData.append("utm_content", $("#utm_content").val());

    let ruta = setUrlBase() + "validacion/preinscripcion";

    $.ajax({
        method: "POST",
        url: ruta,
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).done(function (data) {
        console.log(data);

        /**
         * para este caso debe hacer la misma validacion
         * @return true --> pasa al sig formulario
         * @return false --> mensaje de agenda
         * @eretun descartado --> no pasa a ningun lado y termian el proceso
         * 
         */

        let respuesta = JSON.parse(data);

        if (respuesta.acceso == true) {
            // se hace la redireccion al formulario
            let redireccion = setUrlBase() + "form/datos_generales/preinscripcion";

            //setTimeout(`location.href='${redireccion}'`, 2000);
            window.open(redireccion, '_blank');

            $('#redireccionPEL').html(`
                <i class="bi bi-check-circle"></i>
                Redirección exitosa.
            `);

        }
        else if (respuesta.acceso == false) {
            $('#redireccionPEL').html(`
                <i class="bi bi-calendar2-check"></i>
                Agendar llamada
            `);

            $('#statictConfirmPreinscripcion').modal('show');


        }
        else if (respuesta.acceso == "Descartar") {
            $('#redireccionPEL').html(`
            <i class="bi bi-x-circle"></i>
            Redirección no permitida
            `);

            Swal.fire({
                icon: "error",
                title: "Correo ya registrado",
            });
        }


    }).fail(function () {
        console.log("Algo salió mal");
    });


}

function conservarVariablesDetalleCalculadora(nombreNivel, nombreCarrera, nombrePlantel, data) {

    sessionStorage.setItem("nombreNivel", nombreNivel);
    sessionStorage.setItem("nombreCarrera", nombreCarrera);
    sessionStorage.setItem("nombrePlantel", nombrePlantel);
    sessionStorage.setItem("Turno", data.Turno);
    sessionStorage.setItem("Horario", data.Horario);
    sessionStorage.setItem("Beca", data.Beca);
    sessionStorage.setItem("DescripPer", data.DescripPer);
    sessionStorage.setItem("Vigencia", data.Vigencia);

    console.log(sessionStorage.getItem("Horario"));

}

function enviarCorreoConVariablesGuardadas() {
    $("#correoButton").prop("disabled", true);
    $('#correoButton').html(`
        <div class="spinner-border me-1" style="width: 20px; height: 20px; color: #de951b;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        Enviando correo
    `);

    let ruta = setUrlBase() + "enviar/correo/detalles/beca";

    console.log(ruta);


    let data = {
        nombreNivel: sessionStorage.getItem("nombreNivel"),
        nombreCarrera: sessionStorage.getItem("nombreCarrera"),
        nombrePlantel: sessionStorage.getItem("nombrePlantel"),
        Turno: sessionStorage.getItem("Turno"),
        Horario: sessionStorage.getItem("Horario"),
        Beca: sessionStorage.getItem("Beca"),
        DescripPer: sessionStorage.getItem("DescripPer"),
        Vigencia: sessionStorage.getItem("Vigencia"),
    }

    console.log(data);

    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ruta,
        data: data,
        dataType: 'json'
    }).done(function (data) {

        console.log(data);
        if (data.result == true) {
            Swal.fire({
                icon: "success",
                text: "Los detalles de tu Beca se han enviado a tu correo.",
            });
        } else {
            Swal.fire({
                icon: "error",
                text: "¡Error al enviar correo!",
            });
        }

        $("#correoButton").prop("disabled", false);
        $('#correoButton').html(`
            <i class="bi bi-envelope" style="color: #de951b;"></i>
            Enviar a correo
        `);

    }).fail(function (e) {
        console.log("Algo salió mal");
        console.log(e);
    });

}

function establecerTextoComboCarrera() {

    let nivelSelect = $('#selectNivel').val();

    if (nivelSelect == 1) {
        text = `Elige la Licenciatura de interés y después el horario que prefieres.`;

    } else if (nivelSelect == 2) {
        text = `Elige la Especialidad de interés y después el horario que prefieres.`;
    }
    else if (nivelSelect == 3) {
        text = `Elige la Maestría de interés y después el horario que prefieres.`;
    }

    console.log(text);

    $('#textComboCarreras').html(text);

}

function aceptoAgendar() {

    $("#aceptarActividad").prop("disabled", true);
    $('#aceptarActividad').html(`
        <div style="width: 20px !important; height: 20px !important;"
        class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        Agendando Llamada
    `);

    let ruta = setUrlBase() + "agendar/actividad/preinscripcion";

    $.ajax({
        method: "GET",
        url: ruta,
        dataType: "html",
    }).done(function (data) {
        console.log(data);

        $("#aceptarActividad").prop("disabled", false);
        $('#aceptarActividad').html(`
            Si
        `);

        $('#redireccionPEL').html(`
            Preinscripción en Linea
        `);



        $('#statictConfirmPreinscripcion').modal('hide');

        Swal.fire("Llamada agendada, más tarde uno de nuestros asesores se comunicara contigo", "", "success");

    }).fail(function () {
        console.log("Algo salió mal");
    });


}

function rechazoAgendar() {

    $('#redireccionPEL').html(`
        Preinscripción en Linea
    `);

    $('#statictConfirmPreinscripcion').modal('hide');

    Swal.fire("¡Proceso Terminado!", "", "error");

}



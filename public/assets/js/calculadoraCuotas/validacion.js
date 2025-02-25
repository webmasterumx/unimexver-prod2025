$("#form_calculadora").validate({
    // wrapper: "span",
    rules: {
        selectPlantel: {
            required: true,
        },
        selectPeriodo: {
            required: true,
        },
        selectNivel: {
            required: true,
        },
        nombreProspecto: {
            required: true,
            maxlength: 50,
        },
        apellidosProspecto: {
            required: true,
            maxlength: 60,
        },
        telefonoProspecto: {
            required: true,
        },
        emailProspecto: {
            required: true,
            email: true,
            maxlength: 50,
        },
    },
    messages: {
        selectPlantel: {
            required: "",
        },
        selectPeriodo: {
            required: "",
        },
        selectNivel: {
            required: "",
        },
        nombreProspecto: {
            required: "Nombre obligatorio.",
            maxlength: "El número de caracteres máximo es 50."
        },
        apellidosProspecto: {
            required: "Apellidos obligatorios",
            maxlength: "El número de caracteres máximo es 60."
        },
        telefonoProspecto: {
            required: "Teléfono obligatorio",
            minlength: "El teléfono celular debe tener mínimo 10 digitos.",
            maxlength: "El teléfono celular debe tener máximo 10 digitos."
        },
        emailProspecto: {
            required: "Correo obligatorio.",
            email: "Ingresa un formato valido de correo.",
            maxlength: "El número de caracteres máximo es 50."
        },
    },
    submitHandler: function (form) {
        console.log("envio de formulario");


        let nombreProspecto = $('#nombreProspecto').val().replace(/ /g, "");
        let apellidosProspecto = $('#apellidosProspecto').val().replace(/ /g, "");

        if (nombreProspecto == "") {
            Swal.fire({
                icon: "error",
                text: "El campo de nombre no puede estar vacío",
            });
        }
        else if (apellidosProspecto == "") {
            Swal.fire({
                icon: "error",
                text: "El campo de apellidos no puede estar vacío",
            });
        }
        else {
            let selectNivelComp = $('select[name=selectNivel]').val();

            if (selectNivelComp > 1) {
                if ($('input:radio[name=typeProspecto]:checked').val() == undefined) {
                    Swal.fire({
                        icon: "error",
                        title: "Campo obligatorio",
                        text: "Por favor indica si eres egresado o no.",
                        showConfirmButton: true,
                    });
                } else {
                    if ($('input:radio[name=typeTelefono]:checked').val() == undefined) {
                        Swal.fire({
                            icon: "error",
                            title: "Campo obligatorio",
                            text: "Por favor indica de que tipo es tu teléfono",
                            showConfirmButton: true,
                        });

                    } else {
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

                            carrera_calculadora = getCarreraSelect();
                            console.log(carrera_calculadora);


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
                }
            } else {
                if ($('input:radio[name=typeTelefono]:checked').val() == undefined) {
                    Swal.fire({
                        icon: "error",
                        title: "Campo obligatorio",
                        text: "Por favor indica de que tipo es tu teléfono",
                        showConfirmButton: true,
                    });

                } else {
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

                        carrera_calculadora = getCarreraSelect();
                        console.log(carrera_calculadora);

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
            }
        }


    }
});
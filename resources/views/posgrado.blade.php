@extends('layouts.layout')

@section('metas')
    @include('metas.posgrados.condicional')
@endsection

@section('styles')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
@endsection

<style>
    #contraportada {
        background-position: center;
        background-size: cover;
        background-image: url("{{ asset($contraportada) }}");
    }

    .bg_campo_laboral {
        background: url("{{ asset('assets/img/extras/campo_laboral.jpg') }}");
        background-position: center;
        background-size: cover;
    }

    .bg_contacto {
        background: url("{{ asset('assets/img/extras/bg-01.webp') }}");
        background-position: center;
        background-size: cover;
    }

    .bg_requisitos {
        background: url("{{ asset('assets/img/extras/requisitos.png') }}");
        background-position: center;
        background-size: cover;
    }


    #peridoSelectFolleto-error,
    #plantelSelectFolleto-error {
        display: none !important;
    }
</style>

@section('content')
    <!-- Inicio de portada -->
    <section id="portada" style="background-image: url({{ asset($posgrado->portada) }}); position: relative;">
        <h1 class="etiqueta-titulo p-3 text-uppercase" style="font-size: 30px;"> {{ $posgrado->nombre }} </h1>
    </section>
    <!-- Fin de portada -->

    <!-- Inicio de la sección de objetivo -->
    <section class="container-fluid px-5 py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="underlined_head_obj text-center text-uppercase fw-normal" style="font-size: 1.438rem;">
                    especialidad y maestría en {{ $posgrado->nombre }}
                </h2>
            </div>
            <div class="col-12">
                {!! $posgrado->objetivo !!}
            </div>
            <div class="col-12 mt-3">
                <div class="row">
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <div class="d-grid gap-2">
                            <a id="redireccionCTCL" href="javascript:calculadoraHeader('{{ $posgrado->abreviatura }}')"
                                class="btn btn-outline-primary">
                                Calculadora de Cuotas
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <div class="d-grid gap-2">
                            <a id="redireccionPELL" href="javascript:preinscripcionHeader('{{ $posgrado->abreviatura }}')"
                                class="btn text-white" style="background-color: #de951b;">
                                Preinscripción En Línea
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la sección de objetivo -->

    <!-- Inicio de la sección de ventajas -->
    <section class="container-fluid bg-articule">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 p-0">
                <img src="{{ asset($contraportada) }}" alt="" style="width: 100%; height:100%;">
            </div>
            @if ($posgrado->nombre == 'Docencia' || $posgrado->nombre == 'Impuestos')
                <div id="text_ventajasPosDistancia" class="col-12 col-md-6 col-lg-6 bg-articule p-5">
                    <h3 class="underlined-head text-uppercase fw-normal">
                        Ventajas de estudiar el posgrado en {{ $posgrado->nombre }}
                    </h3>
                    <p>
                        Obtienes un nivel de preparación profesional superior que te permitirá alcanzar mejores
                        oportunidades.
                        <br><br>
                        Estudia la Especialidad en Docencia en 1 año. <br><br>
                        Válido para <button style="font-size: 100%;" type="button" class="btn btn-link p-0" data-bs-toggle="modal"
                            data-bs-target="#titulacionEstudiosPosgrado">Titulación de Licenciatura vía
                            estudios de
                            Posgrado.</button> <br><br>
                        Horarios accesibles que te permiten estudiar y trabajar. <br><br>
                        Beca especial para egresados de Licenciatura UNIMEX<sup>®</sup>.
                    </p>
                </div>
            @else
                <div id="text_ventajasPosDistancia" class="col-12 col-md-6 col-lg-6 bg-articule p-5">
                    <h3 class="underlined-head text-uppercase fw-normal">
                        Ventajas de estudiar el posgrado en {{ $posgrado->nombre }}
                    </h3>
                    <p>
                        Obtienes un nivel de preparación profesional superior que puede facilitarte alcanzar las mejores
                        oportunidades.
                        <br><br>
                        Beca UNIMEX<sup>®</sup> para Especialidades hasta del 35% y para Maestrías hasta del 20%.
                        <br><br>
                        Puedes aplicar el Programa “Continúa con tu Maestría en UNIMEX<sup>®</sup>”:
                        En Universidad Mexicana puedes estudiar tu Maestría como continuación de tu Especialidad UNIMEX<sup>®</sup>. Al
                        terminar los 3 ciclos escolares de la Especialidad, puedes solicitar tu equivalencia de materias
                        para
                        continuar con la Maestría cursando únicamente los últimos dos ciclos del programa equivalente. <br>
                        Nota: Para más información consulta la sección <button style="font-size: 100%;" type="button" class="btn btn-link p-0"
                            data-bs-toggle="modal" data-bs-target="#continuaConTuMaestria">Continúa con tu
                            Maestría.</button>
                        <br><br>
                        Variedad de horarios que te permiten estudiar y trabajar.
                        <br>
                    <ul>
                        <li>Sabatino: sólo sábados de 8:00 a 13:00 h.</li>
                        @if ($posgrado->id != 37)
                            <li>Vespertino: sólo 2 tardes entre semana de 19:30 a 22:00 h.</li>
                        @endif
                    </ul>
                    Nota: La inscripción está sujeta a la apertura y cupo en el grupo seleccionado. La apertura de los
                    grupos está sujeta a la disponibilidad del programa en el plantel deseado y a un mínimo de 25 alumnos
                    inscritos por grupo, previo al inicio de clases. Consulta los programas que se impartirán en el ciclo de
                    tu interés y en el plantel deseado.
                    <br><br>
                    Válido para titulación de Licenciatura vía estudios de Posgrado.
                    Si concluiste al 100% los créditos de tu Licenciatura y tienes disponible la opción de Titulación vía
                    Estudios de Posgrado, regístrate, llámanos o ven al plantel para brindarte mayor información. <br><br>
                    Consulta los requisitos en la sección <button style="font-size: 100%;" type="button" class="btn btn-link p-0"
                        data-bs-toggle="modal" data-bs-target="#titulacionEstudiosPosgrado">Titulación de Licenciatura vía
                        estudios de
                        Posgrado.</button>
                    </p>
                </div>
            @endif
        </div>
    </section>
    <!-- Fin de la sección de ventajas -->

    <!-- Inicio de temario de especialidad y maestria -->
    <section class="py-3">
        <div class="container-fluid p-5">
            <div class="col-12">
                <h2 class="underlined-head fw-normal" style="font-size: 1.438rem;">
                    PLAN DE ESTUDIOS Y RVOES
                </h2>
                <p>
                    Es ideal para alumnos que trabajan, ya que cada Ciclo se forma por 3 módulos, cada uno enfocado en una
                    sola materia, facilitando tu proceso de aprendizaje.
                    <br><br>
                    <b>Especialidad con Reconocimiento de Validez Oficial de Estudios de la SEP:</b>
                    <br><br>
                    @for ($i = 0; $i < sizeof($rvoe_especialidad); $i++)
                        {{ $rvoe_especialidad[$i] }} <br>
                    @endfor
                </p>
            </div>
            <div id="temario_especialidad" class="col-12 mt-1">
                @for ($i = 0; $i < sizeof($temario_especialidad); $i++)
                    <div class="card border-0 mx-3 h-100">
                        <h5 class="card-header bg-unimex text-white text-center">
                            {{ $temario_especialidad[$i]['nombrecuatrimestre'] }}</h5>
                        <div class="card-body bg-articule cardBodyPosgradosMet">
                            <ul>
                                @for ($j = 0; $j < sizeof($temario_especialidad[$i]['temas']); $j++)
                                    <li class="py-1">
                                        {{ $temario_especialidad[$i]['temas'][$j] }}
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-12">
                <p>
                    <b>
                        Maestría con Reconocimiento de Validez Oficial de Estudios de la SEP:
                    </b>
                    <br><br>
                    @for ($i = 0; $i < sizeof($rvoe_maestria); $i++)
                        {{ $rvoe_maestria[$i] }} <br>
                    @endfor
                </p>
            </div>
            <div id="temario_maestria" class="col-12 mt-1">
                @for ($i = 0; $i < sizeof($temario_maestria); $i++)
                    <div class="card border-0 mx-3 h-100">
                        <h5 class="card-header bg-unimex text-white text-center">
                            {{ $temario_maestria[$i]['nombrecuatrimestre'] }}</h5>
                        <div class="card-body bg-articule cardBodyPosgradosMet">
                            <ul>
                                @for ($j = 0; $j < sizeof($temario_maestria[$i]['temas']); $j++)
                                    <li class="py-1">
                                        {{ $temario_maestria[$i]['temas'][$j] }}
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-12">
                <p>
                    <b>Duración:</b> <br>
                    Duración de la Especialidad: 3 Ciclos (1 año) <br>
                    Duración de la Maestría: 5 ciclos (1 año 8 meses) <br>
                    Nota: La duración mencionada está sujeta al curso continuo de los estudios; consulta la programación de
                    aperturas en el plantel de tu elección.
                    <br><br>
                    <button data-bs-toggle="modal" data-bs-target="#continuaConTuMaestria" type="button"
                        class="btn btn-primary mb-2 mb-md-0">Continúa con tu maestría en UNIMEX<sup>®</sup></button>
                    <button data-bs-toggle="modal" data-bs-target="#titulacionEstudiosPosgrado" type="button"
                        class="btn btn-primary mb-2 mb-md-0">Titulación vía estudios de posgrados</button>
                </p>
            </div>
        </div>
    </section>
    <!-- Fin de temario de especialidad y maestria -->

    @include('include.folletoForm')

    <!-- Inicio de la Sección de Contacto -->
    @php
        $nivel = 'posgrado';
    @endphp
    @include('include.contactoForm')
    <!-- Fin de la Sección de Contacto -->

    <!-- Inicio de Campo Laboral -->
    <section class="bg_campo_laboral container-fluid px-5 py-5 text-white">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <h1 style="font-size: 1.50rem;" class="underlined-head text-uppercase text-white">
                    bolsa de trabajo
                </h1>
                <p class="text-justify">
                    Ofertas laborales en la Bolsa de Trabajo <br>
                    Universidad Mexicana recibe las vacantes de cientos de empresas interesadas en contratar a nuestros
                    alumnos y egresados. Para revisar las ofertas exclusivas para nuestra comunidad.
                </p>
            </div>
            <div class="col-12 col-md-6">
                <p class="text-center text-white">
                    <a target="_blank" href="https://unimex.occ.com.mx/Bolsa_Trabajo">
                        <i class="fas fa-briefcase fa-5x text-white"></i>
                    </a><br>
                    Consulta la Bolsa de Trabajo OCC-UNIMEX<sup>®</sup>
                </p>
            </div>
        </div>
    </section>
    <!-- Fin de Campo Laboral -->

    <!-- Inicio de la Sección de Requisitos -->
    <section class="container-fluid px-5 py-5">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3 bg_requisitos">

            </div>
            <div class="col-12 col-md-8 col-lg-9">
                <h2 class="underlined-head fw-normal" style="font-size: 1.438rem;">
                    REQUISITOS
                </h2>
                <div id="requisitos">
                    <div class="card border-0">
                        <div class="card-body cardBodyPosgrado">
                            <p>
                                <b>
                                    Si cuentas con Título de Licenciatura
                                </b><br><br>
                                Original y copia del Acta de Nacimiento. <br>
                                Copia del Título o Cédula Profesional. <br>
                                Original y una fotocopia del Certificado Total de Estudios de Licenciatura* <br><br>
                                *En caso de no contar con este documento presentar una Constancia de Terminación con el 100%
                                de las materias acreditadas. Si su título está en trámite en su Universidad de origen,
                                presentar la constancia del trámite de Titulación y/o Cédula Profesional, especificando la
                                fecha de obtención del mismo (deberá presentarlo dentro del plazo señalado por UNIMEX<sup>®</sup>).
                            </p>
                        </div>
                    </div>
                    <div class="card border-0">
                        <div class="card-body cardBodyPosgrado">
                            <p>
                                <b>Si deseas titularte de Licenciatura mediante estudios de Posgrado</b> <br><br>
                                Original o copia certificada del Acta de Nacimiento y una fotocopia. <br><br>
                                Original y una fotocopia del Certificado Total de Estudios de Licenciatura* <br><br>
                                En caso de cursar el Posgrado como medio de Titulación, presentar una Carta de Autorización.
                                <br>
                                para Titularse vía créditos de Posgrado, emitida por tu Universidad de origen**, indicando
                                el porcentaje de créditos necesarios.
                                <br><br>
                                * Legalizado, en caso de Universidades no incorporadas a la S.E.P. <br>
                                ** únicamente para egresados de otras instituciones que desean estudiar un Posgrado en
                                UNIMEX<sup>®</sup> como opción de titulación.

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de la Sección de Requisitos -->

    <!-- Inicio de la Sección de disponibilidad -->
    <section class="container-fluid px-5 py-5 bg_planteles_dis">
        <div class="row">
            <div class="col-12 text-center p-0 mb-3">
                <h1 class="fw-light" style="font-size: 1.438rem; color: #ffff;">HORARIOS:</h1>
                <p class="text-white">
                    En Universidad Mexicana estamos conscientes de la necesidad de contar con opciones de estudio que
                    permitan al alumno estudiar <br>
                    y trabajar, por lo que ofrecemos los siguientes horarios: <br>
                </p>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="text-center bg_planteles_dis text-white">
                                SABATINO <br>
                                Sólo sábados de 8:00 a 13:00 h.
                            </td>
                            @if ($posgrado->id != 37)
                                <td class="text-center bg_planteles_dis text-white">
                                    VESPERTINO <br>
                                    Sólo 2 tardes entre semana de 19:30 a 22:00 h.
                                </td>
                            @else
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- Fin de la Sección de disponibilidad -->

    @include('modales.continuaConTuMaestria')
    @include('modales.titulacionViaEstudiosPosgrado')

    <!-- del Modal de errores de Folleto-->
    @include('modales.folleto.ModalMensajeFolleto')
    <!-- del Modal de errores de Folleto-->
@endsection

@section('scripts')
    <script>
        $('#temario_especialidad').slick({
            infinite: false,
            autoplay: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            arrows: true,
            autoplaySpeed: 2000,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ],
            prevArrow: '<button type="button" class="slick-prev-tema"><i class="bi bi-chevron-compact-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next-tema"><i class="bi bi-chevron-compact-right"></i></button>',
        });

        $('#temario_maestria').slick({
            infinite: false,
            autoplay: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            arrows: true,
            autoplaySpeed: 2000,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ],
            prevArrow: '<button type="button" class="slick-prev-tema"><i class="bi bi-chevron-compact-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next-tema"><i class="bi bi-chevron-compact-right"></i></button>',
        });

        $('#requisitos').slick({
            infinite: false,
            autoplay: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            autoplaySpeed: 2000,
            prevArrow: '<button type="button" class="slick-prev-tema"><i class="bi bi-chevron-compact-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next-tema"><i class="bi bi-chevron-compact-right"></i></button>',
        });


        function getCarreraPosicion() {
            let carreraPosicionado = "{{ $posgrado->nombre }}";

            return carreraPosicionado;
        }

        function getNivelPosicion() {
            let nivelPosicionado = 2;

            return nivelPosicionado;
        }

        function getNivelPagina() {
            let nivelPosicionado = 3;

            return nivelPosicionado;
        }

        var nivelPosicionado = "Especialidad";
        var carreraPosicionado = "{{ $posgrado->nombre }}";

        $('#aceptarAvisoPrivacidadFolleto').on('click', function() {
            if ($(this).is(':checked')) {
                // Hacer algo si el checkbox ha sido seleccionado
                //console.log("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
                $('#descargaFolleto').attr('disabled', false);
            } else {
                // Hacer algo si el checkbox ha sido deseleccionado
                //console.log("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
                $('#descargaFolleto').attr('disabled', true);
            }
        });
    </script>

    @php
        $complementoJsOferta = filemtime('assets/js/combosCarrerasNew.js');
        $rutaJsOferta = 'assets/js/combosCarrerasNew.js?' . $complementoJsOferta;

        $complementoJsOferta1 = filemtime('assets/js/folletoUnimex/combos.js');
        $rutaJsOferta1 = 'assets/js/folletoUnimex/combos.js?' . $complementoJsOferta1;

        $complementoJsOferta2 = filemtime('assets/js/folletoUnimex/form.js');
        $rutaJsOferta2 = 'assets/js/folletoUnimex/form.js?' . $complementoJsOferta2;

        $compCalJs3 = filemtime('assets/js/folletoUnimex/errores.js');
        $rutaCalJs3 = 'assets/js/folletoUnimex/errores.js?' . $compCalJs3;
    @endphp

    <script src="{{ asset($rutaJsOferta) }}"></script>
    <script src="{{ asset($rutaJsOferta1) }}"></script>
    <script src="{{ asset($rutaJsOferta2) }}"></script>
    <script src="{{ asset($rutaCalJs3) }}"></script>

    @include('include.redirecciones.inOfertaAcademica')
@endsection

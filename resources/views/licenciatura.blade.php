@extends('layouts.layout')

@section('metas')
    @include('metas.licenciaturas.condicional')
@endsection

@section('styles')
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
@endsection

@section('content')
    <!-- Inicio de portada -->
    <section id="portada" style="background-image: url({{ asset($licenciatura->portada) }}); position: relative;">
        <h1 class="etiqueta-titulo p-3 text-uppercase">
            LICENCIATURA EN {{ $licenciatura->nombre }}
        </h1>
        @if ($licenciatura->statusVer == true)
            <button style="position: relative; bottom: 100%; left: 86%;" type="button" class="btn btn-primary">
                SOLO EN PLANTEL <br>
                VERACRUZ
            </button>
        @endif
    </section>
    <!-- Fin de portada -->

    <!-- Inicio de la sección de objetivo -->
    <section class="container-fluid px-5 py-5">
        <div class="row">
            <div class="col-12 mb-2">
                <h2 class="underlined_head_obj fw-normal" style="font-size: 1.438rem;">
                    OBJETIVO
                </h2>
            </div>
            <div class="col-12 text-center mb-3">
                {!! $licenciatura->objetivo !!}
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="d-grid gap-2">
                            <a id="redireccionCTCL" href="javascript:calculadoraHeader('{{ $licenciatura->abreviatura }}')"
                                class="btn mt-2 btn-outline-primary">
                                Calculadora de Cuotas
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-primary mt-2 mt-mb-0" data-bs-toggle="modal"
                                data-bs-target="#comoObtengoMiBecaModal">
                                Más información
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="d-grid gap-2">
                            <a id="redireccionPELL"
                                href="javascript:preinscripcionHeader('{{ $licenciatura->abreviatura }}')"
                                class="btn text-white mt-2 mt-mb-0" style="background-color: #de951b;">
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
    <section class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-6 col-xl-6 p-0">
                <img src="{{ asset($contraportada) }}" alt="" style="width: 100%; height:100%;">
            </div>
            <div class="col-12 col-md-12 col-lg-6 col-xl-6 bg-articule p-5">
                <h3 class="underlined-head fw-normal">
                    Ventajas de estudiar la Licenciatura en {{ $licenciatura->nombre }}
                </h3>
                <ul class="text-justify">
                    @if (
                        $licenciatura->id == 5 ||
                            $licenciatura->id == 6 ||
                            $licenciatura->id == 11 ||
                            $licenciatura->id == 14 ||
                            $licenciatura->id == 7)
                        <li>
                            <b>Plan de estudios renovado que cumple con las necesidades del mercado laboral y las nuevas
                                tendencias.</b>
                        </li>
                    @endif
                    @if ($licenciatura->id == 22 || $licenciatura->id == 21)
                        <li>
                            <b>Beca anual renovable hasta del 60%</b> en licenciaturas matutinas. Obtén una beca durante el primer año de estudios.
                        </li>
                    @else
                        <li>
                            <b>Beca anual renovable hasta del 60%.</b> Sin importar tu promedio, obtén una beca durante el
                            primer año de estudios.
                        </li>
                    @endif
                    <li>
                        <b>Cuotas muy accesibles.</b>
                    </li>
                    <li>
                        <b>Terminas tu carrera en 3 años 4 meses.</b> Nuestro Plan de Estudios te ayuda a aprovechar
                        mejor tú tiempo y terminar en 10 cuatrimestres.
                    </li>
                    <li>
                        <b>Horarios que te permiten estudiar y trabajar.</b>
                    </li>
                    <li>
                        <b>Inglés y Cómputo.</b> Dentro del plan de estudios.
                    </li>
                    <li>
                        <b>Carta de Pasante al 2º año de estudios.</b> Para que puedas ejercer como profesionista.
                    </li>
                    <li>
                        <b>Reconocimiento de Validez Oficial de Estudios de la SEP.</b>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Fin de la sección de ventajas -->

    <!-- Inicio de temario -->
    <section class="py-3 container-fluid px-5">
        <div class="row">
            <div class="col-12">
                <h2 style="font-size: 1.438rem;" class="text-center underlined-head-center fw-normal">
                    PLAN DE ESTUDIOS
                </h2>
            </div>
            <div id="temario" class="col-12 mt-5">
                @for ($i = 0; $i < sizeof($temario); $i++)
                    <div id="cardTemarioLicenciatura" class="card border-0 mx-3 h-100">
                        <h5 class="card-header bg-unimex text-white text-center">
                            {{ $temario[$i]['nombrecuatrimestre'] }}</h5>
                        <div id="cardTemarioBodyLicenciatura" class="card-body bg-articule">
                            <ul>
                                @for ($j = 0; $j < sizeof($temario[$i]['temas']); $j++)
                                    <li class="py-1">
                                        {{ $temario[$i]['temas'][$j] }}
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>
    <!-- Fin de temario -->

    @include('include.folletoForm')

    @php
        $nivel = 'licenciatura';
    @endphp
    <!-- Inicio de la Sección de Contacto -->
    @include('include.contactoForm')
    <!-- Fin de la Sección de Contacto -->

    <!-- Inicio de Campo Laboral -->
    <section class="bg_campo_laboral container-fluid px-5 py-5 text-white">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <h1 style="font-size: 1.50rem;" class="underlined-head text-uppercase text-white">
                    licenciatura en {{ $licenciatura->nombre }}
                </h1>
                <p class="text-center">
                    Campo Laboral
                </p>
                <p class="text-justify">
                    {{ $licenciatura->campo_laboral }}
                </p>
            </div>
            <div class="col-12 col-md-6 col-lg-6 px-3">
                <div id="campo_laboral">
                    @for ($z = 0; $z < sizeof($campo_laboral); $z++)
                        <div class="card bg-transparent border-0">
                            <div class="card-body text-center text-white">
                                <center>
                                    <img src="{{ asset('assets/img/extras/organization.png') }}" alt="">
                                </center>
                                <br>
                                <p>
                                    {!! $campo_laboral[$z] !!}
                                </p>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>
    <!-- Fin de Campo Laboral -->

    <!-- Inicio de la Sección de Requisitos -->
    <section id="requesitos_licenciatura" class="container-fluid px-5 py-5">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3 bg_requisitos">

            </div>
            <div class="col-12 col-md-8 col-lg-9">
                <h2 class="underlined-head fw-normal" style="font-size: 1.438rem;">
                    REQUISITOS
                </h2>
                @if ($licenciatura->id == 21 || $licenciatura->id == 22)
                    @include('components.requisitos.requisitosv2')
                @else
                    @include('components.requisitos.requisitosv1')
                @endif
            </div>
        </div>
    </section>
    <!-- Fin de la Sección de Requisitos -->

    <!-- Inicio de la Sección de disponibilidad -->
    <section class="container-fluid px-5 py-5 bg_planteles_dis">
        <div class="row">
            <div class="col-12 text-center p-0 mb-3">
                <h1 class="fw-light" style="font-size: 1.438rem; color: #ffff;">ESTA LICENCIATURA ESTÁ DISPONIBLE EN LOS
                    PLANTELES:</h1>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4 row-cols-lg-4 g-4">
            @for ($d = 0; $d < sizeof($disponibilidad); $d++)
                <div class="col p-1">
                    <div class="card p-0 border-0 bg-transparent text-white">
                        <div class="card-body p-0">
                            <p class="card-text" style="font-size: 0.9rem !important;">
                                {{ $disponibilidad[$d]['palantel'] }} <br>
                                @if ($licenciatura->id == 16 || $licenciatura->id == 17)
                                    {{ $disponibilidad[$d]['escolarizado'] }} <br>
                                    {{ $disponibilidad[$d]['mixto'] }} <br>
                                @else
                                    Escolarizado {{ $disponibilidad[$d]['escolarizado'] }} <br>
                                    @if ($disponibilidad[$d]['mixto'] != null)
                                        Mixto {{ $disponibilidad[$d]['mixto'] }} <br>
                                    @endif
                                @endif
                                <a style="color: #fff !important;" href="https://sirvoes.sep.gob.mx/sirvoes"
                                    target="_blank">https://sirvoes.sep.gob.mx/sirvoes</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </section>
    <!-- Fin de la Sección de disponibilidad -->

    <!-- Inicio del Modal Como Obtengo Mi Beca -->
    @include('modales.comoObtengoMiBeca')
    <!-- Fin del Modal Como Obtengo Mi Beca --->

    <!-- del Modal de errores de Folleto-->
    @include('modales.folleto.ModalMensajeFolleto')
    <!-- del Modal de errores de Folleto-->
@endsection

@section('scripts')
    <script>
        $('#temario').slick({
            infinite: false,
            autoplay: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: true,
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
            autoplaySpeed: 2000,
            prevArrow: '<button type="button" class="slick-prev-tema"><i class="bi bi-chevron-compact-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next-tema"><i class="bi bi-chevron-compact-right"></i></button>',
        });

        $('#campo_laboral').slick({
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
            prevArrow: '<button type="button" class="slick-prev-campo"><i class="bi bi-chevron-compact-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next-campo"><i class="bi bi-chevron-compact-right"></i></button>',
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
            let carreraPosicionado = "{{ $licenciatura->nombre }}";

            return carreraPosicionado;
        }

        function getNivelPosicion() {
            let nivelPosicionado = 1;

            return nivelPosicionado;
        }

        function getNivelPagina() {
            let nivelPosicionado = 1;

            return nivelPosicionado;
        }

        var nivelPosicionado = "Licenciatura";
        var carreraPosicionado = "{{ $licenciatura->nombre }}";

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
        $rutaJSLicEs = 'assets/js/combosCarrerasNew.js?' . $complementoJsOferta;

        $complementoJsOferta1 = filemtime('assets/js/folletoUnimex/combos.js');
        $rutaJSLicEs1 = 'assets/js/folletoUnimex/combos.js?' . $complementoJsOferta1;

        $complementoJsOferta2 = filemtime('assets/js/folletoUnimex/form.js');
        $rutaJSLicEs2 = 'assets/js/folletoUnimex/form.js?' . $complementoJsOferta2;

        $compCalJs3 = filemtime('assets/js/folletoUnimex/form.js');
        $rutaCalJs3 = 'assets/js/folletoUnimex/errores.js?' . $compCalJs3;
    @endphp

    <script src="{{ asset($rutaJSLicEs) }}"></script>
    <script src="{{ asset($rutaJSLicEs1) }}"></script>
    <script src="{{ asset($rutaJSLicEs2) }}"></script>
    <script src="{{ asset($rutaCalJs3) }}"></script>

    @include('include.redirecciones.inOfertaAcademica')
@endsection

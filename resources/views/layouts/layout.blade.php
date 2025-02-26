<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    <!-- METAS -->
    @yield('metas')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N5DW5H');
    </script>
    <!-- End Google Tag Manager -->
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '205536339078564');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=205536339078564&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    <!--Tiktok Pixel Code-->
    <script>
        ! function(w, d, t) {
            w.TiktokAnalyticsObject = t;
            var ttq = w[t] = w[t] || [];
            ttq.methods = ["page", "track", "identify", "instances", "debug", "on", "off", "once", "ready", "alias",
                "group", "enableCookie", "disableCookie"
            ], ttq.setAndDefer = function(t, e) {
                t[e] = function() {
                    t.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                }
            };
            for (var i = 0; i < ttq.methods.length; i++) ttq.setAndDefer(ttq, ttq.methods[i]);
            ttq.instance = function(t) {
                for (var e = ttq._i[t] || [], n = 0; n < ttq.methods.length; n++) ttq.setAndDefer(e, ttq.methods[n]);
                return e
            }, ttq.load = function(e, n) {
                var i = "https://analytics.tiktok.com/i18n/pixel/events.js";
                ttq._i = ttq._i || {}, ttq._i[e] = [], ttq._i[e]._u = i, ttq._t = ttq._t || {}, ttq._t[e] = +new Date,
                    ttq._o = ttq._o || {}, ttq._o[e] = n || {};
                var o = document.createElement("script");
                o.type = "text/javascript", o.async = !0, o.src = i + "?sdkid=" + e + "&lib=" + t;
                var a = document.getElementsByTagName("script")[0];
                a.parentNode.insertBefore(o, a)
            };
            ttq.load('CHT3MJJC77U0O25ESA0G');
            ttq.page();
        }(window, document, 'ttq');
    </script>
    <!--Tiktok Pixel Code-->
    <!--LinkedIn Pixel Code-->
    <script type="text/javascript">
        _linkedin_partner_id = "4929644";
        window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
        window._linkedin_data_partner_ids.push(_linkedin_partner_id);
    </script>
    <script type="text/javascript">
        (function(l) {
            if (!l) {
                window.lintrk = function(a, b) {
                    window.lintrk.q.push([a, b])
                };
                window.lintrk.q = []
            }
            var s = document.getElementsByTagName("script")[0];
            var b = document.createElement("script");
            b.type = "text/javascript";
            b.async = true;
            b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
            s.parentNode.insertBefore(b, s);
        })(window.lintrk);
    </script>
    <noscript>
        <img height="1" width="1" style="display:none;" alt=""
            src="https://px.ads.linkedin.com/collect/?pid=4929644&fmt=gif" />
    </noscript>
    <!--End LinkedIn Pixel Code-->

    <!-- FONTS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- SLICK CAROUSEL -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- ICONOS BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- SWAL JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!---  DateTable --->
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css">

    @php
        $complemento = filemtime('assets/css/app.css');
        $rutaCss = 'assets/css/app.css?' . $complemento;

        $complemento1 = filemtime('assets/css/mediaQuery.css');
        $rutaCss1 = 'assets/css/mediaQuery.css?' . $complemento1;

        $complemento2 = filemtime('assets/css/non-critical-styles10062022.min.css');
        $rutaCss2 = 'assets/css/non-critical-styles10062022.min.css?' . $complemento2;

        $complemento3 = filemtime('assets/css/flotante.min.css');
        $rutaCss3 = 'assets/css/flotante.min.css?' . $complemento3;
    @endphp

    <link rel="stylesheet" href="{{ asset($rutaCss) }}">
    <link rel="stylesheet" href="{{ asset($rutaCss1) }}">
    <link rel="stylesheet" href="{{ asset($rutaCss2) }}">
    <link rel="stylesheet" href="{{ asset($rutaCss3) }}">

    @yield('styles')

</head>

<body>

    <!-- Inicio de Barra de navegacion -->
    @include('include.menu')
    <!-- Fin de Barra de navegacion -->

    <!-- Inico de Contenido -->
    @yield('content')
    <!-- Fin de Contemido -->

    <!-- Inicio de Modales -->
    @include('modales.protocolo')
    <!-- Fin de Modales -->

    <!-- Inicio de Footer -->
    <footer class="bg-footer container-fluid text-center px-5 text-white">
        <div class="row">
            <div class="col-12 mt-5">
                <p class="fs-6">SÍGUENOS</p>
            </div>
            <div class="col-12 col-md-12 mb-4">
                <a href="https://www.facebook.com/UnimexEnVeracruz/" target="_blank"><img
                        src="{{ asset('assets/img/social_media/facebook.png') }}" alt=""></a>
                <a class="ms-2" href="https://www.instagram.com/universidadmexicana/" target="_blank"><img
                        src="{{ asset('assets/img/social_media/instagram.png') }}" alt=""></a>
                <a class="ms-2" href="https://mx.linkedin.com/school/universidad-mexicana/" target="_blank"><img
                        src="{{ asset('assets/img/social_media/linkedin.png') }}" alt=""></a>
                <a class="ms-2" href="https://twitter.com/unimexver" target="_blank"><img
                        src="{{ asset('assets/img/social_media/twitter.png') }}" alt=""></a>
                <a class="ms-2" href="https://www.youtube.com/user/SoyUNIMEX" target="_blank"><img
                        src="{{ asset('assets/img/social_media/youtube.png') }}" alt=""></a>
            </div>
            <div class="col-12 col-md-2 col-lg-2 mt-2">
                <a class="text-white" href="{{ route('investigacion') }}" target="_blank">INVESTIGACIÓN</a>
            </div>
            <div class="col-12 col-md-2 col-lg-2 mt-2">
                <a class="text-white" href="http://comunimex.lat/KioscoProfesionistasInt/" target="_blank">KIOSCO DE
                    <br> PROFESIONISTAS</a>
            </div>
            <div class="col-12 col-md-2 col-lg-2 mt-2">
                <a class="text-white" href="https://unimex.edu.mx/soyUNIMEX/" target="_blank">BLOG SOY
                    UNIMEX<sup>®</sup></a>
            </div>
            <div class="col-12 col-md-2 col-lg-2 mt-2">
                <a class="text-white" href="{{ route('aviso_de_privacidad') }}" target="_blank">AVISO DE <br>
                    PRIVACIDAD</a>
            </div>
            <div class="col-12 col-md-2 col-lg-2 mt-2">
                <a class="text-white" href="{{ route('preguntas.frecuentes') }}" target="_blank">PREGUNTAS <br>
                    FRECUENTES</a>
            </div>
            <div class="col-12 col-md-2 col-lg-2 mt-2">
                <a class="text-white" target="_blank" href="{{ route('rvoes') }}">RVOES</a>
            </div>
            <hr class="my-3">
            <div class="col-12 mb-3">
                UNIVERSIDAD MEXICANA {{ date('Y') }}<sup>®</sup>
            </div>
        </div>
    </footer>
    <!-- Fin de Footer -->

    <span class="flotante-whats">
        <button id="f-boton">
            <img class=" lazyloaded" width="80" height="70" id="f-whats-boton" alt="iamgen-whats"
                src="{{ asset('assets/img/extras/whats.webp') }}">
        </button>
        <div>
        </div>
        <div id="f-msj-boton">
            <button id="contactanos" type="button" class="btn btn-secondary" data-bs-toggle="tooltip"
                data-bs-placement="left" title="Tooltip on left" style="display: none;">
                ¡Contáctanos vía<br>WhatsApp...!
            </button>
        </div>
    </span>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <!-- slick-carousel js -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- Validate -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <!-- DataTables -->
    <script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>

    <!-- script de validacion de entrada de caracteres a inputs -->
    <script
        src="https://rawcdn.githack.com/franz1628/validacionKeyCampo/bce0e442ee71a4cf8e5954c27b44bc88ff0a8eeb/validCampoFranz.js">
    </script>

    @php
        $comJsInit = filemtime('assets/js/app.js');
        $rutaJsInit = 'assets/js/app.js?' . $comJsInit;

        $comJsInit1 = filemtime('assets/js/main.js');
        $rutaJsInit1 = 'assets/js/main.js?' . $comJsInit1;

        $comJsInit2 = filemtime('assets/js/custom.js');
        $rutaJsInit2 = 'assets/js/custom.js?' . $comJsInit2;

        $comJsInit3 = filemtime('assets/js/form.js');
        $rutaJsInit3 = 'assets/js/form.js?' . $comJsInit3;
    @endphp


    <!-- Template Main JS File -->
    <script src="{{ asset($rutaJsInit) }}"></script>
    <script src="{{ asset($rutaJsInit1) }}"></script>
    <script src="{{ asset($rutaJsInit2) }}"></script>
    <script src="{{ asset($rutaJsInit3) }}"></script>

    <script>
        function setUrlBase() {
            let urlBase = "{{ env('APP_URL') }}";
            return urlBase;
        }

        const obtenHover = document.getElementById('f-boton'),
            mensajeW = document.getElementById('f-msj'),
            btnCerrar = document.getElementById('boton-cerrar');

        obtenHover.addEventListener('mouseover', () => {
            let mensaje = document.getElementById('f-msj-boton');
            mensaje.innerHTML = `
                <button id="contactanos" type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="Tooltip on left">
                    ¡Contáctanos vía<br>WhatsApp...!
                </button>
            `;
        });
        obtenHover.addEventListener('mouseout', (e) => {
            let contactanos = document.getElementById('contactanos');
            contactanos.style.display = 'none';
        });

        /*mostrar planteles y whats*/
        obtenHover.addEventListener('click', () => {

            window.open(
                'https://api.whatsapp.com/send/?phone=525511020290&text=Hola%21+Me+gustaría+recibir+más+información+sobre+los+programas%2C+cuotas+y+promociones+de+UNIMEX%3B+me+interesó+lo+que+vi+en+Página+Web+Veracruz+sobre+contacto+en+WhatsApp+%28botón%29.+¡Gracias%21&type=phone_number&app_absent=0'
            );
        });

        /*
         *   codigo de redireccionamiento dinamico para contacto 
         *   #contactoHeader se asume que entra al formulario desde la parte de contacto que este en el menu
         *   -> formularioContactanos
         *   #contactoBolsaTrabajo se asume que entra al formulario desde la parte de bolsa de trabajo por ello
         *   se hara enfasis en dicho formulario
         *   -> formularioTrabajaUnimex
         * 
         */
        function redirectContactoHeader() {
            console.log("entra al formulario desde la parte de contacto");
            let elementForm = "formularioContactanos";

            utm_source = "{{ session('utm_source') }}";
            utm_medium = "{{ session('utm_medium') }}";
            utm_campaign = "{{ session('utm_campaign') }}";
            utm_term = "{{ session('utm_term') }}";
            utm_content = "{{ session('utm_content') }}";

            console.log(utm_content);


            if (utm_medium == null || utm_medium == "" || utm_medium == "organico" || utm_medium == "Organico" ||
                utm_medium == "ORGANICO") {
                utm_source = "Website+Veracruz";
                utm_medium = "Organico";
                utm_campaign = "Home+header";
                utm_term = "Botón+informes";
                utm_content = "Informes";
            }


            let ruta = setUrlBase() +
                `contacto?utm_source=${utm_source}&utm_medium=${utm_medium}&utm_campaign=${utm_campaign}&utm_term=${utm_term}&utm_content=${utm_content}`

            console.log(ruta);

            $.ajax({
                method: "GET",
                url: setUrlBase() + "set/variables/contactForm/" + elementForm,
            }).done(function(data) {
                console.log(data);

            }).fail(function() {
                console.log("Algo salió mal");
            });

            window.open(ruta, '_self');
        }

        $('#linkSmContacto').click(function(event) {
            console.log("entra al formulario desde la parte de contacto");
            let elementForm = "formularioContactanos";

            $.ajax({
                method: "GET",
                url: setUrlBase() + "set/variables/contactForm/" + elementForm,
            }).done(function(data) {
                console.log(data);

            }).fail(function() {
                console.log("Algo salió mal");
            });
            window.open("{{ route('contacto') }}", '_blank');
        });

        function redirigirContactoHeader() {
            console.log("entra al formulario desde la parte de contacto");
            let elementForm = "formularioContactanos";

            utm_source = "{{ session('utm_source') }}";
            utm_medium = "{{ session('utm_medium') }}";
            utm_campaign = "{{ session('utm_campaign') }}";
            utm_term = "{{ session('utm_term') }}";
            utm_content = "{{ session('utm_content') }}";

            if (utm_medium == null || utm_medium == "" || utm_medium == "organico" || utm_medium == "Organico" ||
                utm_medium == "ORGANICO") {
                utm_source = "Website+Metro";
                utm_medium = "Organico";
                utm_campaign = "Home+header";
                utm_term = "Botón+informes";
                utm_content = "Informes";
            }


            let ruta = setUrlBase() +
                `contacto?utm_source=${utm_source}&utm_medium=${utm_medium}&utm_campaign=${utm_campaign}&utm_term=${utm_term}&utm_content=${utm_content}`

            console.log(ruta);


            $.ajax({
                method: "GET",
                url: setUrlBase() + "set/variables/contactForm/" + elementForm,
            }).done(function(data) {
                console.log(data);

            }).fail(function() {
                console.log("Algo salió mal");
            });
            window.open(ruta, '_self');
        }

        function redirectContactBolsaTrabajo() {
            console.log("entra al formulario desde la parte de bolsa de trabajo");

            let elementForm = "formularioTrabajaUnimex";

            $.ajax({
                method: "GET",
                url: setUrlBase() + "set/variables/contactForm/" + elementForm,
            }).done(function(data) {
                console.log(data);

            }).fail(function() {
                console.log("Algo salió mal");
            });
            window.open("{{ route('contacto') }}", '_blank');
        }

        $('#nombre_prospecto').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiíoóuú');
        $('#apellidos_prospecto').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiíoóuú');
        $('#nombreFolleto').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéiíoóuú');
    </script>

    @yield('scripts')

</body>

</html>

<?php

namespace App\Http\Controllers;

use App\Mail\ContactoProspecto;
use App\Mail\EmpresasOcc;
use App\Mail\QuejasSugerencias;
use App\Mail\ServicioAlumno;
use App\Mail\TrabajaUnimex;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Spatie\FlareClient\Api;

class FormController extends Controller
{

    private $utm_recurso;

    public function contactoProspecto(Request $request)
    {
        /**
         * utm_source
         * utm_medium
         * utm_campaign
         * utm_term
         * utm_content
         * gad_source
         */

        $source = session("utm_source");
        $medium = session("utm_medium");
        $content = session("utm_content");
        $campaign = session("utm_campaign");
        $term = session("utm_term");

        $valores = array(
            "pNombre" => $request->nombre_prospecto,
            "pApPaterno" => $request->apellidos_prospecto,
            "pApMaterno" => "",
            "pTelefono" => $request->telefono_prospecto,
            "pCelular" => $request->celular_prospecto,
            "pCorreo" => $request->mail_prospecto,
            "pPeriodoEscolar" => $request->periodoSelect,
            "pPlantel" => $request->plantelSelect,
            "pNivel_Estudio" => $request->nivelSelect,
            "pCarrera" => $request->carreraSelect,
            "pHorario" => $request->horarioSelect,
            "pOrigen" => 11,
            "utpsource" =>  $source,
            "descripPublicidad" => $campaign,
            "campaignMedium" => $medium,
            "campaignTerm" => $term,
            "campaignContent" => $content,
            "websiteURL" => "https://unimex.edu.mx/",
            "folioReferido" => "0"
        );

        //dd($valores);

        $respuesta = app(ApiConsumoController::class)->agregarProspectoCRM($valores); //! envio de datos al WS
        /* $respuesta = array(
            "FolioCRM" => 1206174,
            "Mensaje" => "",
            "Nombre" => "prueba desde rectoria",
            "Ciclo" => "Septiembre - 2024",
            "Nivel" => "Licenciatura",
            "Carrera" => "Administración de Empresas Turísticas",
            "Turno" => "Sabatino B Sábado 07:00 a 16:00",
            "Plantel" => "SATELITE",
            "FechaVigenciaPromocion_Incio" => "Lunes 19 de Febrero del 2024",
            "FechaVigenciaPromocion_Final" => "Domingo 24 de Diciembre del 2017",
            "Email" => "rectoria_testing@gmial.com"
        ); */

        //$recive = $request->mail_prospecto;
        $correos = [
            "umrec_cdbd@unimex.edu.mx",
            "lishanxime201099@gmail.com"
        ];
        $envio =  Mail::to($correos)->bcc("umrec_web@unimex.edu.mx")->send(new ContactoProspecto($request, $respuesta)); //! envio del correo

        return view('registroExitoso', [
            "respuesta" => $respuesta,
            "datos" => $request,
        ]);
    }

    /** nueva funcion de procesamiento de datos para formulario de contacto */
    public function procesaFormularioContacto(Request $request)
    {
        $origen = $request->origen;
        $abreviatura = $request->abreviatura;
        $abreviaturaFormateada = str_replace("+", " ", $abreviatura);
        $utmMedium = $request->utm_medium;
        $urlEnvioForm = $request->urlVisitada;

        $this->utm_recurso = new UtmController();

        //! se conservan las variables de session

        if ($utmMedium == "organico" || $utmMedium  == "ORGANICO" || $utmMedium == "Organico" || $utmMedium == null) { // la utm en session no es organica

            if ($origen == "slider") { //! si osi vienen desde una oferta academica
                $source = "Website Veracruz";
                $campaign = "Home body";
                $content = "Slider" . $abreviaturaFormateada . " Oacademica form";
            } else if ($origen == "menu") { //! si osi vienen desde una oferta academica
                $source = "Website Veracruz";
                $campaign = "Home header";
                $content = "Oacademica " . $abreviaturaFormateada . " body form";
            } else if ($origen == "Home") { // viene desde la pagina home 
                $source = "Website Veracruz";
                $campaign = "Home body";
                $content = "Form Informes";
            } else if ($origen == "Info") { // viene desde la pagina contacto
                $source = "Website Veracruz";
                $campaign = "Home header";
                $content = "Botón informes";
            } else {
                $source = "Website Veracruz";
                $campaign = "Oacademica body";
                $content = "Form " . $abreviaturaFormateada . " Informes";
            }

            $medium = "Organico";
            $term = "Informes";
        } else {
            $source = session("utm_source");
            $medium = session("utm_medium");
            $content = session("utm_content");
            $campaign = session("utm_campaign");
            $term = session("utm_term");
        }

        //! creando array de datos a procesar
        $valores = array(
            "pNombre" => $request->nombre_prospecto,
            "pApPaterno" => $request->apellidos_prospecto,
            "pApMaterno" => "",
            "pTelefono" => $request->telefono_prospecto,
            "pCelular" => $request->celular_prospecto,
            "pCorreo" => $request->mail_prospecto,
            "pPeriodoEscolar" => $request->periodoSelect,
            "pPlantel" => $request->plantelSelect,
            "pNivel_Estudio" => $request->nivelSelect,
            "pCarrera" => $request->carreraSelect,
            "pHorario" => $request->horarioSelect,
            "pOrigen" => 11,
            "utpsource" =>  $source,
            "descripPublicidad" => $campaign,
            "campaignMedium" => $medium,
            "campaignTerm" => $term,
            "campaignContent" => $content,
            "websiteURL" => $urlEnvioForm,
            "folioReferido" => "0"
        );

        //var_dump($valores);

        //! envio de datos al WS
        $respuesta = app(ApiConsumoController::class)->agregarProspectoCRM($valores); //! envio de datos al WS

        /**
         * Evalua la respuesta del web service 
         *! Si el folio es 0 ocurrio un error y se redirigira a la vista de error 
         *? Si es diferente a 0 se enviara un correo y redireccionara a la vista de exito
         */
        if ($respuesta['FolioCRM'] != 0) {

            //? se intenta enviar el correo
            try {
                $correos = [
                    "umrec_web@unimex.edu.mx"
                ];

                $dataCorreo["folio"] = $respuesta['FolioCRM'];
                $dataCorreo["nombre"] = $request->nombre_prospecto . " " . $request->apellidos_prospecto;
                $dataCorreo["nivel"] = $request->nivelSeleccion;
                $dataCorreo["plantel"] = $request->plantelSeleccion;
                $dataCorreo['carrera'] = $request->carreraSeleccion;
                $dataCorreo["ciclo"] = $request->periodoSeleccion;
                $dataCorreo["horario"] = $request->horarioSeleccion;


                Mail::to($correos)->bcc($request->mail_prospecto)->send(new ContactoProspecto($dataCorreo)); //! envio del correo

                $messageCorreo  = "Correo enviado correctamente.";
                $resultCorreo  = true;
            } catch (\Throwable $th) {
                //resguardar variables por si necerita
                $messageCorreo = "Error al enviar correo.";
                $resultCorreo = false;
            }

            //* se establecen variables de session para imprimir datos en la vista de registro exitoso
            session(["registroExitNombre" => $request->nombre_prospecto]);
            session(["registroExitFolio" => $respuesta['FolioCRM']]);
            session(["registroExitPlantel" => $request->plantelSeleccion]);
            session(["registroExitNivel" => $request->nivelSeleccion]);
            session(["registroExitCarrera" => $request->carreraSeleccion]);
            session(["registroExitPeriodo" => $request->periodoSeleccion]);

            $respuestaFinal['estado'] = true;
            $respuestaFinal['estadoCorreo'] = $resultCorreo;
            $respuestaFinal['ruta'] = "registro_exitoso";
        } else {

            $respuestaFinal['estado'] = false;
            $respuestaFinal['estadoCorreo'] = false;
            $respuestaFinal['ruta'] = "error_de_registro";
        }

        return response()->json($respuestaFinal);
    }

    public function servicioAlumnos(Request $request)
    {
        $valores = array(
            "nombre" => $request->name_service,
            "mail" => $request->email_service,
            "tel_casa" => $request->phone_casa_service,
            "tel_celular" => $request->movil_service,
            "plantel" => $request->select_plantel,
            "asunto" => $request->asunto_service,
            "matricula" => $request->matricula_service,
            "mensaje" => $request->mensaje_service
        );

        $correos = [
            "umrec_cdbd@unimex.edu.mx",
            "umrec_gccsasist@unimex.edu.mx"
        ];
        $envio =  Mail::to($correos)->bcc("umrec_web@unimex.edu.mx")->send(new ServicioAlumno($valores));

        var_dump($envio);
    }

    public function trabajaUnimex(Request $request)
    {
        $valores = array(
            "nombre" => $request->nombre_trabajo,
            "mail" => $request->email_trabaja,
            "telefono_casa" => $request->telefono_casa_trabaja,
            "telefono_celular" => $request->telefono_movil_trabaja,
            "plantel" => $request->plantel_trabaja,
            "nivel_estudios" => $request->nivel_est_trabaja,
            "puesto_interes" => $request->puesto_interes,
            "experiencia_laboral" => $request->experiencia_trabaja
        );

        $file = $request->file('cv_trabaja');

        $correos = [
            "umrec_cdbd@unimex.edu.mx",
            "reclutamiento@unimex.edu.mx"
        ];
        $envio =  Mail::to($correos)->bcc("umrec_web@unimex.edu.mx")->send(new TrabajaUnimex($valores, $file));

        var_dump($envio);
    }

    public function quejasYsugerencias(Request $request)
    {
        $valores = array(
            "nombre" => $request->nombre_qys,
            "mail" => $request->mail_qys,
            "telefono_casa" => $request->telefono_casa_qys,
            "telefono_celular" => $request->telefono_movil_qys,
            "matricula" => $request->matricula_qys,
            "asunto" => $request->asunto_qys,
            "mensaje" => $request->mensaje_qys
        );

        $correos = [
            "umrec_cdbd@unimex.edu.mx",
            "francisco.montalvo@unimex.edu.mx",
            "umrec_gccsasist@unimex.edu.mx"
        ];
        $envio = Mail::to($correos)->bcc("umrec_web@unimex.edu.mx")->send(new QuejasSugerencias($valores));

        var_dump($envio);
    }

    public function empresasOCC(Request $request)
    {
        $valores = array(
            "empresa" => $request->nombre_empresaOCC,
            "contacto" => $request->contacto_empresaOCC,
            "email" => $request->email_empresaOCC,
            "telefono" => $request->telefono_empresaOCC,
            "celular" => $request->celular_empresaOCC,
            "razon" => $request->razon_empresaOCC,
            "rfc" => $request->rfc_empresaOCC,
            "comentarios" => $request->comentarios_empresaOCC,
        );

        if ($request->type_empresaOCC == 1) //tiene cuenta en occ
        {
            $asunto = "Empresas Registradas en OCC Veracruz";
        } else //no tiene cuenta en occ
        {
            $asunto = "Empresas por Registrar en OCC Veracruz";
        }

        $correos = [
            "umrec_cdbd@unimex.edu.mx",
            "vinculacion@unimex.edu.mx"
        ];
        $envio = Mail::to($correos)->bcc("umrec_web@unimex.edu.mx")->send(new EmpresasOcc($valores, $asunto));

        var_dump($envio);
    }

    public function testerEnvio()
    {
        $recive = "lishanxime201099@gmail.com";
        //$envio =  Mail::to($recive)->bcc("umrec_web@unimex.edu.mx")->send(new ServicioAlumno());
        //dd($envio);
    }

    public function agregrarProspectoSinEroi(Request $request)
    {
        $params = $request->all();

        var_dump($params);

        $agregar = app(ApiConsumoController::class)->registraProspectoCRMDesdePreinscripcionEnLinea($params);

        var_dump($agregar);
    }

    public function buscarProspectoForFolio($folio)
    {
        $valores = array(
            "folioCRM" => $folio,
        );

        $resultado = app(ApiConsumoController::class)->getProspectoPreinscripcionEnLinea($valores);

        return view('preinscripcionEnLinea.formaDePago', [
            "informacion" => $resultado
        ]);
    }

    /**
     * valida si el prospecto que si existe tiene matricula
     * esto se hace a travez de una busqeda por medio del correo 
     * con esto se optiene su detalle de informacion
     */
    /*  public function validarMatriculacion($correo)
    {
        $valores = array(
            "tipoBusqueda" => 4,
            "textoBuscar" => $correo,
            "clavePlantel" => 0
        );

        $busqueda = app(ApiConsumoController::class)->buscarProspectoPorCorreo($valores);

        return response()->json($busqueda);
    } */

    public function getResultadosExamen(Request $request)
    {
        $valores = array(
            "Matricula" => $request->matriculaResultado
        );

        $resultados = app(ApiConsumoController::class)->resultadosExamen($valores);

        return response()->json($resultados);
    }

    public function procesaFormularioFolletos(Request $request)
    {

        $utm_source = $request->utm_source;
        $utm_medium = $request->utm_medium;
        $utm_campaign = $request->utm_campaign;
        $utm_term = $request->utm_term;
        $utm_content = $request->utm_content;
        $urlVisitada = $request->urlVisitada;

        $licenciatura = $request->carreraPosicion;
        $plantel = $request->plantelSelectFolleto;
        $periodo = $request->peridoSelectFolleto;
        $nivel  = $request->nivelPosicion;
        $horario = $request->turnoPosicionado;
        $claveCarrera = SELF::getIdentificarCarrera($licenciatura, $plantel, $periodo, $nivel);

        //echo $claveCarrera;

        if ($claveCarrera == 0) {

            $respuesta['estado'] = false;
            $respuesta["mensaje"] = "";
            $respuesta['ruta'] = "";
        } else {

            $archivo = SELF::getRutaFolleto($plantel, $nivel, $horario, $claveCarrera);

            $respuesta['estado'] = true;
            $respuesta['ruta'] = $archivo['ruta_archivo'];
        }

        //var_dump($rutaArchivo);

        $valores = array(
            "campaingContent" => $utm_content,
            "campaignMedium" => $utm_medium,
            "campaignTerm" => $utm_term,
            "descripPublicidad" => $utm_campaign,
            "folioReferido" => "0",
            "pApMaterno" => "",
            "pApPaterno" => "",
            "pCarrera" => $claveCarrera,
            "pCelular" => $request->celularFolleto,
            "pCorreo" => $request->correoFolleto,
            "pHorario" => 0,
            "pNivel_Estudio" => $nivel,
            "pNombre" => $request->nombreFolleto,
            "pOrigen" => 11,
            "pPeriodoEscolar" => $request->peridoSelectFolleto,
            "pPlantel" => $request->plantelSelectFolleto,
            "pTelefono" => "",
            "utpsource" => $utm_source,
            "websiteURL" => $urlVisitada,
        );

        $agregarProspecto = app(ApiConsumoController::class)->agregarProspectoCRM($valores);

        return response()->json($respuesta);
    }

    //? nueva funcion de procesamiento de folleto
    public function procesarFormularioFolleto(Request $request)
    {
        $licenciatura = $request->carreraPosicion;
        $plantel = $request->plantelSelectFolleto;
        $periodo = $request->peridoSelectFolleto;
        $nivel  = $request->nivelPosicion;
        $indentificadorEs = $request->identificadorEsp;

        $origen = $request->origen;
        $abreviatura = $request->abreviatura;
        $abreviaturaFormateada = str_replace("+", " ", $abreviatura);
        $utmMedium = $request->utm_medium;
        $urlEnvioForm = $request->urlVisitada;

        $this->utm_recurso = new UtmController();

        //! se conservan las variables de session

        if ($utmMedium == "organico" || $utmMedium  == "ORGANICO" || $utmMedium == "Organico" || $utmMedium == null) { // la utm en session no es organica

            if ($origen == "slider") { //! si osi vienen desde una oferta academica
                $source = "Website Veracruz";
                $campaign = "Home body";
                $content = "Slider" . $abreviaturaFormateada . " Oacademica Folleto";
            } else if ($origen == "menu") { //! si osi vienen desde una oferta academica
                $source = "Website Veracruz";
                $campaign = "Home header";
                $content = "Oacademica " . $abreviaturaFormateada . " body Folleto";
            } else {
                $source = "Website Veracruz";
                $campaign = "Oacademica body";
                $content = "Folleto " . $abreviaturaFormateada . " Informes";
            }

            $medium = "Organico";
            $term = "Folleto";
        } else {
            $source = session("utm_source");
            $medium = session("utm_medium");
            $content = session("utm_content");
            $campaign = session("utm_campaign");
            $term = session("utm_term");
        }

        /*  var_dump([
             $source,
             $medium,
             $content,
             $campaign,
             $term
         ]); */

        $datos = app(FolletoController::class)->leerExcelFolletos($plantel, $nivel, $licenciatura, $indentificadorEs);

        $ruta = $datos["rutaRedireccion"];
        $carrera = $datos["id_carrera"];

        $valores = array(
            "campaignContent" => $content,
            "campaignMedium" => $medium,
            "campaignTerm" => $term,
            "descripPublicidad" => $campaign,
            "folioReferido" => "0",
            "pApMaterno" => "",
            "pApPaterno" => "",
            "pCarrera" => $carrera,
            "pCelular" => $request->celularFolleto,
            "pCorreo" => $request->correoFolleto,
            "pHorario" => 0,
            "pNivel_Estudio" => $nivel,
            "pNombre" => $request->nombreFolleto,
            "pOrigen" => 11,
            "pPeriodoEscolar" => $request->peridoSelectFolleto,
            "pPlantel" => $request->plantelSelectFolleto,
            "pTelefono" => "",
            "utpsource" => $source,
            "websiteURL" => $urlEnvioForm,
        );

        $agregarProspecto = app(ApiConsumoController::class)->agregarProspectoCRM($valores);

        //var_dump($agregarProspecto);

        return $ruta; 
    }

    public function getIdentificarCarrera($licenciatura, $plantel, $periodo, $nivel)
    {

        $claveCarrera = 0;

        $valores = [
            "clavePlantel" => $plantel,
            "claveNivel" => $nivel,
            "clavePeriodo" => $periodo,
        ];

        //var_dump($valores);

        $catalogoCarreras = app(ApiConsumoController::class)->getCarrerasMethod($valores);

        foreach ($catalogoCarreras as $carrera) {
            if ($licenciatura == $carrera['descrip']) {
                $claveCarrera = $carrera['clave'];
            }
        }

        return $claveCarrera;
    }

    public function getRutaFolleto($plantel, $nivel, $horario, $claveCarrera)
    {
        $valores = [
            "clavePlantel" => $plantel,
            "claveNivel" => $nivel,
            "claveCarrera" => $claveCarrera,
            "claveTurno" => $horario,
            "tipoDocumento" => 1
        ];

        //var_dump($valores);

        $rutaArchivo = app(ApiConsumoController::class)->getDocumentosFolleto($valores);

        return $rutaArchivo;
    }

    public function getClaveHorarioForPlantel()
    {
        $matHorarios = [""];
    }

    public function añadirProspectoDiaUnimex(Request $request)
    {
        $nombre = $request->nombre;
        $celular = $request->celular;
        $email = $request->email;
        $periodos = $request->periodo;
        $carrera = $request->carrera;
        $horario = $request->horario;
        $escuela = $request->escuela;

        $valores = array(
            "pNombre" => $nombre,
            "pApPaterno" => "",
            "pApMaterno" => "",
            "pTelefono" => $celular,
            "pCelular" => $celular,
            "pCorreo" => $email,
            "pPeriodoEscolar" => $periodos,
            "pPlantel" => 5,
            "pNivel_Estudio" => 1,
            "pCarrera" => $carrera,
            "pHorario" => $horario,
            "pOrigen" => 28,
            "utpsource" => "",
            "descripPublicidad" => "",
            "campaignMedium" => "",
            "campaignTerm" => "",
            "campaignContent" => "",
            "websiteURL" => "https://unimexver.edu.mx/dia-unimex",
            "folioReferido" => "0",
        );

        $envio = app(ApiConsumoController::class)->addDiaUnimex($valores);

        if ($envio == null) {
            $respuesta['estado'] = false;
            $respuesta["mensaje"] = "Ocurrió un error. Inténtalo más tarde.";
        } else {
            if ($envio['FolioCRM'] != 0) {
                $respuesta['estado'] = true;
                $respuesta['FolioCRM'] = $envio['FolioCRM'];
                $respuesta['Nombre'] = $envio['Nombre'];
                $respuesta['Email'] = $envio['Email'];
                $respuesta["mensaje"] = "Registro exitoso";
            } else {
                $respuesta['estado'] = false;
                $respuesta["mensaje"] = "Ocurrió un error. Inténtalo más tarde.";
            }
        }

        return response()->json($respuesta);
    }
}

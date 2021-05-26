<?php

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ruta de la Landing Page

Route::get('/', function () {
    return view('auth.login');
});

//Ruta principal de la web

Route::get('/app', function () {
    return view('plantillas.paginaprincipal');
});

//Ruta para crear proyectos usando ajax

Route::post('/crear_proyecto', function (Request $request) {
    // Cabecera de resultado en JSON.
    header('Content-Type: application/json');

    // Constantes de configuración de la aplicación.

    /* Parte de conexion a la base de datos */

    define('DB_SERVIDOR', 'localhost');
    define('DB_PUERTO', '3306');
    define('DB_BASEDATOS', 'todolist');
    define('DB_USUARIO', 'todolist');
    define('DB_PASSWORD', 'abc123.');

    try {
        $cadenaConexion = "mysql:host=" . DB_SERVIDOR . ";port=" . DB_PUERTO . ";dbname=" . DB_BASEDATOS . ";charset=utf8";
        $pdo = new PDO($cadenaConexion, DB_USUARIO, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error conectando a servidor de base de datos: " . $e->getMessage());
    }

    /* ---------------------------------------------------------------------------------------- */

    /* Parte de insercion a la base de datos */

    // Variables (fundamentales para pdo, sino no deja bindear parametros)

    $titulo = $request->input('titulo');
    $fecha = date('Y-m-d G:i:s');
    $descripcion = $request->input('descripcion');

    // Insercion a la base de datos

    if (isset($_POST['titulo']) and $_POST['titulo'] != "") {

        /* Consulta crear proyecto */

        // Preparar consulta

        $smtp = $pdo->prepare("insert into proyectos (nombre, descripcion, fecha_creacion) values (:titulo,:descripcion,:fecha_creacion)");

        // Bindeo de parametros

        $smtp->bindParam(":titulo", $titulo);
        $smtp->bindParam(":descripcion", $descripcion);
        $smtp->bindParam(":fecha_creacion", $fecha);

        // Ejecutar consulta

        $smtp->execute();

        /* consulta para obtener id del ultimo proyecto */

        $smtp = $pdo->prepare("SELECT id FROM `proyectos` ORDER by id desc limit 1");
        $smtp->execute();

        $id_proyecto = $smtp->fetch();

        /* consulta crear registro en la tabla usuario_proyectos */

        // creando consulta

        $smtp = $pdo->prepare("INSERT INTO `usuario_proyectos`(`admin`, `user_id`, `proyecto_id`) VALUES (:admin,:user_id,:proyecto_id)");

        // variables para bindear

        $numero = 1;

        // variable del id de usuario
        $id = Auth::id();

        $smtp->bindParam(":admin", $numero);
        $smtp->bindParam(":user_id", $id);
        $smtp->bindParam(":proyecto_id", $id_proyecto['id']);

        // ejecutar consulta

        $smtp->execute();
    }
});

Route::post('/crear_lista', function (Request $request) {
    // Cabecera de resultado en JSON.
    header('Content-Type: application/json');

    // Constantes de configuración de la aplicación.

    /* Parte de conexion a la base de datos */

    define('DB_SERVIDOR', 'localhost');
    define('DB_PUERTO', '3306');
    define('DB_BASEDATOS', 'todolist');
    define('DB_USUARIO', 'todolist');
    define('DB_PASSWORD', 'abc123.');

    try {
        $cadenaConexion = "mysql:host=" . DB_SERVIDOR . ";port=" . DB_PUERTO . ";dbname=" . DB_BASEDATOS . ";charset=utf8";
        $pdo = new PDO($cadenaConexion, DB_USUARIO, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error conectando a servidor de base de datos: " . $e->getMessage());
    }

    /* ---------------------------------------------------------------------------------------- */

    /* Parte de insercion a la base de datos */

    // Variables (fundamentales para pdo, sino no deja bindear parametros)

    $titulo = $request->input('titulo');
    $fecha = date('Y-m-d G:i:s');
    $descripcion = $request->input('descripcion');
    $recursiva = 0;

    // Insercion a la base de datos

    if (isset($_POST['titulo']) and $_POST['titulo'] != "") {

        /* Consulta crear proyecto */

        // Preparar consulta

        $smtp = $pdo->prepare("insert into listas (nombre, descripcion, fecha_creacion, recursiva) values (:titulo,:descripcion,:fecha_creacion, :recursiva)");

        // Bindeo de parametros

        $smtp->bindParam(":titulo", $titulo);
        $smtp->bindParam(":descripcion", $descripcion);
        $smtp->bindParam(":fecha_creacion", $fecha);
        $smtp->bindParam(":recursiva", $recursiva);

        // Ejecutar consulta

        $smtp->execute();

        $smtp = $pdo->prepare("SELECT id FROM `listas` ORDER by id desc limit 1");
        $smtp->execute();

        $id_lista = $smtp->fetch();

        $smtp = $pdo->prepare("INSERT INTO `usuario_listas` (`admin`, `user_id`, `lista_id`) VALUES (:admin, :user_id, :id_lista)");

        // variables para bindear

        $numero = 1;

        // variable del id de usuario
        $id = Auth::id();

        $smtp->bindParam(":admin", $numero);
        $smtp->bindParam(":user_id", $id);
        $smtp->bindParam(":id_lista", $id_lista['id']);

        // ejecutar consulta

        $smtp->execute();
    }
});

Route::post('/obtener_proyectos', function (Request $request) {
    // Cabecera de resultado en JSON.
    header('Content-Type: application/json');

    // Constantes de configuración de la aplicación.

    /* Parte de conexion a la base de datos */

    define('DB_SERVIDOR', 'localhost');
    define('DB_PUERTO', '3306');
    define('DB_BASEDATOS', 'todolist');
    define('DB_USUARIO', 'todolist');
    define('DB_PASSWORD', 'abc123.');

    try {
        $cadenaConexion = "mysql:host=" . DB_SERVIDOR . ";port=" . DB_PUERTO . ";dbname=" . DB_BASEDATOS . ";charset=utf8";
        $pdo = new PDO($cadenaConexion, DB_USUARIO, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error conectando a servidor de base de datos: " . $e->getMessage());
    }

    $objeto = new stdClass();

    $id = Auth::id();

    $smtp = $pdo->prepare("SELECT up.id as usuarioProyectosID, up.admin as usuarioProyectosAdmin, up.user_id as usuarioProyectosUID,up.proyecto_id as usuarioProyectosPID, u.id as UserID, u.name as UserName, p.id as proyectoID, p.nombre as proyectoNombre, p.descripcion as proyectoDescripcion FROM `usuario_proyectos` up inner join users u on up.user_id = u.id INNER JOIN proyectos p on up.proyecto_id = p.id where `user_id` = :user_id");
    $smtp->bindParam(":user_id", $id);
    $smtp->execute();
    $objeto->resultados = $smtp->fetchAll();
    echo json_encode($objeto);
});

Route::get('/proyecto/{id}', function (Request $request) {
     
    $listas = DB::table('proyectos_listas')->join("listas","listas.id","=","proyectos_listas.lista_id")->where("proyecto_id","=",$request->id)->get();

     return view("plantillas.listas")->with("datos",$listas)->with("id",$request->id);
});

Route::post('/crear_listaProyecto', function (Request $request) {

    // Cabecera de resultado en JSON.
    header('Content-Type: application/json');

    // Constantes de configuración de la aplicación.

    /* Parte de conexion a la base de datos */

    define('DB_SERVIDOR', 'localhost');
    define('DB_PUERTO', '3306');
    define('DB_BASEDATOS', 'todolist');
    define('DB_USUARIO', 'todolist');
    define('DB_PASSWORD', 'abc123.');

    try {
        $cadenaConexion = "mysql:host=" . DB_SERVIDOR . ";port=" . DB_PUERTO . ";dbname=" . DB_BASEDATOS . ";charset=utf8";
        $pdo = new PDO($cadenaConexion, DB_USUARIO, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error conectando a servidor de base de datos: " . $e->getMessage());
    }

    $titulo = $request->input('titulo');
    $fecha = date('Y-m-d G:i:s');
    $descripcion = $request->input('descripcion');

    /* Consulta crear proyecto */

        // Preparar consulta

        $smtp = $pdo->prepare("insert into listas (nombre, descripcion, fecha_creacion) values (:titulo,:descripcion,:fecha_creacion)");

        // Bindeo de parametros

        $smtp->bindParam(":titulo", $titulo);
        $smtp->bindParam(":descripcion", $descripcion);
        $smtp->bindParam(":fecha_creacion", $fecha);

        // Ejecutar consulta

        $smtp->execute();

        $proyectoID = $request->input('proyectoID');
        $userID = $request->input('userID');
        $listaID = DB::table('listas')->latest('id')->first()->id;


        $smtp = $pdo->prepare("insert into proyectos_listas (proyecto_id, lista_id, user_id) values (:proyectoID,:listaID, :userID)");

        // Bindeo de parametros

        $smtp->bindParam(":proyectoID", $proyectoID);
        $smtp->bindParam(":listaID", $listaID);
        $smtp->bindParam(":userID", $userID);

        // Ejecutar consulta

        $smtp->execute();

        $smtp = $pdo->prepare("SELECT id FROM `listas` ORDER by id desc limit 1");
        $smtp->execute();

        $id_lista = $smtp->fetch();

        $smtp = $pdo->prepare("INSERT INTO `usuario_listas` (`admin`, `user_id`, `lista_id`) VALUES (:admin, :user_id, :id_lista)");

        // variables para bindear

        $numero = 1;

        // variable del id de usuario
        $id = Auth::id();

        $smtp->bindParam(":admin", $numero);
        $smtp->bindParam(":user_id", $userID);
        $smtp->bindParam(":id_lista", $listaID);

        // ejecutar consulta

        $smtp->execute();
});

Route::get('/lista/{id}', function (Request $request) {

    $tareas = DB::table('tareas')->where("lista_id","=",$request->id)->get();

     return view("plantillas.tareas")->with("tareas", $tareas)->with("listaID", $request->id);
});

Route::get('/listar_proyectos/{userID}', function (Request $request) {

    return view('plantillas.paginaprincipal');
});

Route::get('/listar_listas', function (Request $request) {

    define('DB_SERVIDOR', 'localhost');
    define('DB_PUERTO', '3306');
    define('DB_BASEDATOS', 'todolist');
    define('DB_USUARIO', 'todolist');
    define('DB_PASSWORD', 'abc123.');

    try {
        $cadenaConexion = "mysql:host=" . DB_SERVIDOR . ";port=" . DB_PUERTO . ";dbname=" . DB_BASEDATOS . ";charset=utf8";
        $pdo = new PDO($cadenaConexion, DB_USUARIO, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error conectando a servidor de base de datos: " . $e->getMessage());
    }

    $id = Auth::id();

    $smtp = $pdo->prepare("SELECT usuario_listas.admin, usuario_listas.user_id,proyectos_listas.proyecto_id,listas.nombre,listas.descripcion, usuario_listas.lista_id FROM `usuario_listas` INNER join listas on usuario_listas.lista_id = listas.id INNER join proyectos_listas on listas.id = proyectos_listas.lista_id where usuario_listas.user_id = :userID");

    // Bindeo de parametros

    $smtp->bindParam(":userID", $id);

    // Ejecutar consulta

    $smtp->execute();

    $listas = $smtp->fetchAll();

    return view('plantillas.listarListas')->with('listas', $listas);
});

Route::post('/crear_tarea', function (Request $request) {

    define('DB_SERVIDOR', 'localhost');
    define('DB_PUERTO', '3306');
    define('DB_BASEDATOS', 'todolist');
    define('DB_USUARIO', 'todolist');
    define('DB_PASSWORD', 'abc123.');

    try {
        $cadenaConexion = "mysql:host=" . DB_SERVIDOR . ";port=" . DB_PUERTO . ";dbname=" . DB_BASEDATOS . ";charset=utf8";
        $pdo = new PDO($cadenaConexion, DB_USUARIO, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error conectando a servidor de base de datos: " . $e->getMessage());
    }

    $listaID = $request->listaID;
    $nombre = $request->titulo;
    $descripcion = $request->descripcion;
    $fecha = date('Y-m-d G:i:s');

    $smtp = $pdo->prepare("INSERT INTO `tareas`(`nombre`, `descripcion`, `fecha_creacion`, `lista_id`) values (:nombre, :descripcion, :fecha_creacion, :listaID)");

    // Bindeo de parametros

    $smtp->bindParam(":nombre", $nombre);
    $smtp->bindParam(":descripcion", $descripcion);
    $smtp->bindParam(":fecha_creacion", $fecha);
    $smtp->bindParam(":listaID", $listaID);

    // Ejecutar consulta

    $smtp->execute();
});

Route::POST('/cantidad_tareas', function (Request $request) {

    $objeto = new stdClass();

    $users = DB::table('tareas')->select('id')->where('lista_id', '=', $_POST['listaid'])->get();

    $objeto->resultados = $users;
    echo json_encode($objeto);

});

Route::POST('/completar_tarea', function (Request $request) {

    $id = $request->id;

    $affected = DB::table('tareas')
              ->where('id', '=', $id)
              ->update(['fin' => true]);

});

/* ---------------------------------------------------------------------------------------------- */

// Rutas del modulo de autenticacion

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

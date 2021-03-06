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

    $titulo = strip_tags($request->input('titulo'));
    $fecha = date('Y-m-d G:i:s');
    $descripcion = strip_tags($request->input('descripcion'));

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

    $titulo = strip_tags($request->input('titulo'));
    $fecha = date('Y-m-d G:i:s');
    $descripcion = strip_tags($request->input('descripcion'));
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

    /* define('DB_SERVIDOR', 'localhost');
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
    } */

    $objeto = new stdClass();

    $id = Auth::id();

    /* $smtp = $pdo->prepare("SELECT up.id as usuarioProyectosID, cast(up.admin as int) as usuarioProyectosAdmin, up.user_id as usuarioProyectosUID,up.proyecto_id as usuarioProyectosPID, u.id as UserID, u.name as UserName, p.id as proyectoID, p.nombre as proyectoNombre, p.descripcion as proyectoDescripcion FROM `usuario_proyectos` up inner join users u on up.user_id = u.id INNER JOIN proyectos p on up.proyecto_id = p.id where `user_id` = :user_id");
    $smtp->bindParam(":user_id", $id);
    $smtp->execute(); */

    $consulta = DB::table('usuario_proyectos')->join("users", "users.id", "=", "usuario_proyectos.user_id")->join("proyectos","proyectos.id", "usuario_proyectos.proyecto_id")->where("usuario_proyectos.user_id","=", $id)->get();

    // $consulta = DB::table('usuario_proyectos')->get();

    // $objeto->resultados = $smtp->fetchAll();
    $objeto->resultados = $consulta;
    echo json_encode($objeto);
});

Route::get('/proyecto/{id}', function (Request $request) {

    return view("plantillas.listas")->with("id", $request->id);
});

Route::post('/obtener_listas_proyetos', function (Request $request) {

    $id = strip_tags($request->id);

    $objeto = new stdClass();

    $listas = DB::table('proyectos_listas')->join("listas", "listas.id", "=", "proyectos_listas.lista_id")->where("proyecto_id", "=", $id)->get();

    $objeto->resultados = $listas;
    echo json_encode($objeto);

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

    $titulo = strip_tags($request->input('titulo'));
    $fecha = date('Y-m-d G:i:s');
    $descripcion = strip_tags($request->input('descripcion'));

    /* Consulta crear proyecto */

    // Preparar consulta

    if($request->input('titulo') != ''){

    $smtp = $pdo->prepare("insert into listas (nombre, descripcion, fecha_creacion) values (:titulo,:descripcion,:fecha_creacion)");

    // Bindeo de parametros

    $smtp->bindParam(":titulo", $titulo);
    $smtp->bindParam(":descripcion", $descripcion);
    $smtp->bindParam(":fecha_creacion", $fecha);

    // Ejecutar consulta

    $smtp->execute();

    $proyectoID = strip_tags($request->input('proyectoID'));
    $userID = strip_tags($request->input('userID'));
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

    }
});

Route::get('/lista/{id}', function (Request $request) {

    // $tareas = DB::table('tareas')->where("lista_id", "=", $request->id)->get();

    // return view("plantillas.tareas")->with("tareas", $tareas)->with("listaID", $request->id);
    return view("plantillas.tareas")->with("tareas", $request->id);
});

Route::post('/obtener_tareas', function (Request $request) {

    $objeto = new stdClass();
    $id = strip_tags($request->listaid);

    $tareas = DB::table('tareas')->where("lista_id", "=", $id)->get();

    $objeto->resultados = $tareas;
    echo json_encode($objeto);
    
});

Route::get('/listar_proyectos/{userID}', function (Request $request) {

    return view('plantillas.paginaprincipal');
});

Route::get('/listar_listas', function (Request $request) {

    return view('plantillas.listarListas');

});

Route::post('/obtener_listas', function (Request $request) {

    $objeto = new stdClass();

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

    $smtp = $pdo->prepare("SELECT usuario_listas.admin, usuario_listas.user_id,proyectos_listas.proyecto_id,listas.nombre,listas.descripcion, usuario_listas.lista_id FROM `usuario_listas` left join listas on usuario_listas.lista_id = listas.id left join proyectos_listas on listas.id = proyectos_listas.lista_id where usuario_listas.user_id = :userID");

    // Bindeo de parametros

    $smtp->bindParam(":userID", $id);

    // Ejecutar consulta

    $smtp->execute();

    $objeto->resultados = $smtp->fetchAll();
    echo json_encode($objeto);

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

    $listaID = strip_tags($request->listaID);
    $nombre = strip_tags($request->titulo);
    $descripcion = strip_tags($request->descripcion);
    $fecha = date('Y-m-d G:i:s');

    if($request->titulo != '') {

    $smtp = $pdo->prepare("INSERT INTO `tareas`(`nombre`, `fecha_creacion`, `lista_id`) values (:nombre, :fecha_creacion, :listaID)");

    // Bindeo de parametros

    $smtp->bindParam(":nombre", $nombre);
    $smtp->bindParam(":fecha_creacion", $fecha);
    $smtp->bindParam(":listaID", $listaID);

    // Ejecutar consulta

    $smtp->execute();
    }
});

Route::POST('/cantidad_tareas', function (Request $request) {

    $objeto = new stdClass();

    $users = DB::table('tareas')->select('id')->where('lista_id', '=', $_POST['listaid'])->get();

    $objeto->resultados = $users;
    echo json_encode($objeto);
});

Route::POST('/completar_tarea', function (Request $request) {

    $id = strip_tags($request->tareaid);

    $affected = DB::table('tareas')
        ->where('id', '=', $id)
        ->update(['fin' => true]);
});

Route::POST('/borrar_tarea', function (Request $request) {

    $id = strip_tags($request->tareaid);

    DB::table('tareas')->where('id', '=', $id)->delete();
});

Route::POST('/obtener_emails', function (Request $request) {

    $objeto = new stdClass();
    $usermail = auth()->user()->email;

    $emails = DB::table('users')
        ->select('email')->where('email','!=',$usermail)
        ->get();

    $objeto->resultados = $emails;
    echo json_encode($objeto);
});

Route::POST('/compartir', function (Request $request) {

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

    if ($request->opcion == 1 or $request->opcion == 0) {
        # code...


        if ($request->opcion == 1) {
            $email = strip_tags($request->email);
            $smtp = $pdo->prepare("SELECT id FROM `users` where email = :email");
            $smtp->bindParam(":email", $email);
            $smtp->execute();
            $id = $smtp->fetch()['id'];
            $listaID = strip_tags($request->listaID);
            $admin = strip_tags($request->admin);

            $smtp = $pdo->prepare("INSERT INTO `usuario_listas`(`admin`, `user_id`, `lista_id`) values (:admin, :user_id, :listaID)");

            // Bindeo de parametros

            $smtp->bindParam(":admin", $admin, PDO::PARAM_BOOL);
            $smtp->bindParam(":user_id", $id, PDO::PARAM_INT);
            $smtp->bindParam(":listaID", $listaID, PDO::PARAM_INT);

            // Ejecutar consulta

            $smtp->execute();
        } else {
            $email = strip_tags($request->email);
            $smtp = $pdo->prepare("SELECT id FROM `users` where email = :email");
            $smtp->bindParam(":email", $email);
            $smtp->execute();
            $id = $smtp->fetch()['id'];
            $listaID = strip_tags($request->listaID);
            $admin = strip_tags($request->admin);

            $smtp = $pdo->prepare("INSERT INTO `usuario_proyectos`(`admin`, `user_id`, `proyecto_id`) values (:admin, :user_id, :listaID)");

            // Bindeo de parametros

            $smtp->bindParam(":admin", $admin, PDO::PARAM_BOOL);
            $smtp->bindParam(":user_id", $id, PDO::PARAM_INT);
            $smtp->bindParam(":listaID", $listaID, PDO::PARAM_INT);

            // Ejecutar consulta

            $smtp->execute();
        }
    }
});

Route::POST('/borrar_elemento', function (Request $request) {

    if ($request->opcion == 1 or $request->opcion == 0) {
        $id = strip_tags($request->id);

        if ($request->opcion == 1) {
            DB::table('listas')->where('id', '=', $id)->delete();
        }else{
            $ids = DB::table('proyectos_listas')->select('lista_id')->where('proyecto_id','=',$id)->get();
            if (count($ids)!=0) {
                for($i=0;$i<count($ids);$i++){
                    DB::table('listas')->where('id','=',$ids[$i]->lista_id)->delete();
                }
            }
            DB::table('proyectos')->where('id', '=', $id)->delete();
        }
    }
});

Route::POST('/editar_proyecto', function (Request $request) {
    $objeto = new stdClass();
    $id = strip_tags($request->proyectoid);
    $query = DB::table('proyectos')->select('nombre', 'descripcion')->where('id','=', $id)->get();
    $objeto->resultados = $query;
    echo json_encode($objeto);
});

Route::POST('/editar_lista', function (Request $request) {
    $objeto = new stdClass();
    $id = strip_tags($request->proyectoid);
    $query = DB::table('listas')->select('nombre', 'descripcion')->where('id','=', $id)->get();
    $objeto->resultados = $query;
    echo json_encode($objeto);
});

Route::POST('/modificar_proyecto', function (Request $request) {
    if($request->nombre != '' and $request->descripcion != ''){
    $affected = DB::table('proyectos')
              ->where('id','=', $request->proyectoid)
              ->update(['nombre' => $request->nombre, 'descripcion' => $request->descripcion]);
    }
});

Route::POST('/modificar_lista', function (Request $request) {
    if($request->nombre != '' and $request->descripcion != ''){
    $affected = DB::table('listas')
              ->where('id','=', $request->proyectoid)
              ->update(['nombre' => $request->nombre, 'descripcion' => $request->descripcion]);
    }
});

Route::POST('/probas', function (Request $request) {
    $objeto = new stdClass();
    $query = DB::table('usuario_proyectos')
              ->select('admin')
              ->get();
    $objeto->resultados = $query;
    echo json_encode($objeto);
});

Route::POST('/buscar_elemento', function (Request $request) {
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
    $nombre = '%'.strip_tags($request->string).'%';

    /* $consulta = DB::table('usuario_proyectos')->join("users", "users.id", "=", "usuario_proyectos.user_id")->join("proyectos","proyectos.id", "usuario_proyectos.proyecto_id")->where("proyectos.nombre","LIKE", '%'.$nombre.'%')->get();
    $objeto->resultados = $consulta; */

    $smtp = $pdo->prepare("SELECT * FROM `usuario_proyectos` INNER join users on usuario_proyectos.user_id = users.id INNER join proyectos on proyectos.id = usuario_proyectos.proyecto_id where proyectos.nombre LIKE :patron");

            // Bindeo de parametros

            $smtp->bindParam(":patron", $nombre);

            // Ejecutar consulta

            $smtp->execute();
            $objeto->resultados = $smtp->fetchAll();
            // $objeto->resultados = $nombre;
    echo json_encode($objeto);
});

Route::POST('/buscar_listaProyecto', function (Request $request) {
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
    $nombre = '%'.strip_tags($request->string).'%';

    /* $consulta = DB::table('usuario_proyectos')->join("users", "users.id", "=", "usuario_proyectos.user_id")->join("proyectos","proyectos.id", "usuario_proyectos.proyecto_id")->where("proyectos.nombre","LIKE", '%'.$nombre.'%')->get();
    $objeto->resultados = $consulta; */

    $smtp = $pdo->prepare("SELECT * FROM `proyectos_listas` INNER join listas on proyectos_listas.lista_id = listas.id where listas.nombre like :patron");

            // Bindeo de parametros

            $smtp->bindParam(":patron", $nombre);

            // Ejecutar consulta

            $smtp->execute();
            $objeto->resultados = $smtp->fetchAll();
            // $objeto->resultados = $nombre;
    echo json_encode($objeto);
});

Route::POST('/buscar_lista', function (Request $request) {
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
    $nombre = '%'.strip_tags($request->string).'%';

    /* $consulta = DB::table('usuario_proyectos')->join("users", "users.id", "=", "usuario_proyectos.user_id")->join("proyectos","proyectos.id", "usuario_proyectos.proyecto_id")->where("proyectos.nombre","LIKE", '%'.$nombre.'%')->get();
    $objeto->resultados = $consulta; */

    $smtp = $pdo->prepare("SELECT usuario_listas.admin, usuario_listas.user_id,proyectos_listas.proyecto_id,listas.nombre,listas.descripcion, usuario_listas.lista_id FROM `usuario_listas` left join listas on usuario_listas.lista_id = listas.id left join proyectos_listas on listas.id = proyectos_listas.lista_id where usuario_listas.user_id = :id and listas.nombre like :patron");

            // Bindeo de parametros

            $smtp->bindParam(":patron", $nombre);
            $smtp->bindParam(":id", $id);

            // Ejecutar consulta

            $smtp->execute();
            $objeto->resultados = $smtp->fetchAll();
            // $objeto->resultados = $nombre;
    echo json_encode($objeto);
});

Route::POST('/obtener_admin_proyecto', function (Request $request) {

    $objeto = new stdClass();
    $user_id = Auth::id();
    $proyecto_id = strip_tags($request->id);

    $consulta = DB::table('usuario_proyectos')->select('admin')->where("proyecto_id","=", $proyecto_id)->where('user_id','=',$user_id)->get();
    $objeto->resultados = $consulta;

            $objeto->resultados = $consulta;
    echo json_encode($objeto);
});

/* ---------------------------------------------------------------------------------------------- */

// Rutas del modulo de autenticacion

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

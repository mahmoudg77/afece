<?
session_start();
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
*/


define('SCRIPT_DIR',"");
define('PATH',$_SERVER["DOCUMENT_ROOT"].SCRIPT_DIR."/");

include "framework/init.php";
include "models/init.php";

if(!env("is_debug",false)){
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}else{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
$Database=new Framework\Database();


use App\Models\Auth\User as User;


use Framework\Request as Request;
use Framework\Context as Context;
use \Exception as Exception;
use Framework\Addons\Validator as Validator;

function CustomException($number=0,$message){
    if($number==8) return;
    return view('error',compact('number','message'));
    exit();
}

//set_error_handler('CustomException');
try{
    $context=new Context();
    $controller__path=$_GET['controller'];

    $context->method=$_GET['method'];

    $lang=isset($_GET['lang'])?$_GET['lang']:'en';	
    define('LANG',$lang);

    if(!$controller__path)$controller__path="home";
    if(!$context->method)$context->method="index";

    if(in_array($controller__path,$APP_Controllers)){
         include('framework/controller/'.str_replace(".","/",$controller__path).'.php');
    }else{
         include('controller/'.str_replace(".","/",$controller__path).'.php');
    }

    $SET=new App\Models\Admin\Setting;


     $class=explode(".",$controller__path);
     //echo $class[count($class)-1];
     $context->controller_name="App\\Controllers\\".$class[count($class)-1];
     $context->controller_path=$controller__path;

     $request=new Request();
     $context->request= $request;

    if(!$request->Check_CSRF()){
         if($request->isAjax()){
              json_error("Invalid Request");
              exit();
          }else{
              echo "Invalied Request !" ;
               exit();
          }
    }
    if($request->UseApi()){

  //if(!in_array('api_token',$request->get) && !in_array('email',$request->post) && !in_array('password',$request->post)){
        //    return json_error("OAuth: Invalid token or must be login !!");
        //}

        if(array_key_exists('client_token',$request->get) ){
             $v=new Validator;
            $v->Validate($request->get,['client_token'=>'Required|Guid']);
            $user=new User();
            $user=$user->where('api_token',$request->get['client_token'])->limit(1)->supperUser()->get();
            $user=$user[0];
            $context->user=$user;
            $context->userid=$user->data[$user->col_pk];

        }
    }elseif(isset($_SESSION['USER_TOKEN'])){
         $user=new User();
         $user=$user->where('token',$_SESSION['USER_TOKEN'])->limit(1)->supperUser()->get();
         $user=$user[0];
         $context->user=$user;
         $context->userid=$user->data[$user->col_pk];
         // $context->accountid=$user->accid->id;

    }


    if(file_exists(PATH.'controller/'.str_replace(".","/",$context->controller_path).'.php') || file_exists(PATH.'framework/controller/'.str_replace(".","/",$context->controller_path).'.php')){

        $context->controller=new $context->controller_name;

     }else{

         header("HTTP/1.0 404 Not Found");

          $Error=new App\Controllers\BaseController;
          return $Error->view("Error/index",['ErrorNumber'=>404]);
         //return redirectTo("Error/?number=404");
	}





    GV();

     $context->SERIALIZED_OBJECTS=[];
      if($request->isBody()){
          $method="body".ucwords($context->method);
      }elseif($request->isPost()){
          $method="post".ucwords($context->method);
      }else{

          $method=$context->method;
      }
      //print_r($context->controller);
  if(method_exists($context->controller,$method)){
		$context->controller->$method($request);
	}else{
		header("HTTP/1.0 404 Not Found");
		return $context->controller->view("Error/index",['ErrorNumber'=>404]);
	}
  //print_r($context->SERIALIZED_OBJECTS);


  }catch(\Exception $ex){

    $message=$ex->getMessage();
    if($request->UseApi()){
        return json_error($message);
    }
    //$trace=$ex->getTrace();
    //print_r($trace);
    return view('error',compact('message','trace'));
  }
?>
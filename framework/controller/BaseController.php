<?
namespace App\Controllers;
use \Exception as Exception;
use Framework\Addons\Validator as Validator;


class BaseController{
    protected $model;
    public $authRequired=false;
    protected $class;
    function __construct(){
	global $context;
        $this->class= get_called_class();
		if($this->authRequired && !$context->user){

            if($context->request->isAjax()){
                //return json_error("Sorry, You must be logining to access this page !!");
            }else{
                return redirectTo('Login');
            }

 		}
    }

    function getModel(){
        return $this->model;
    }

    function getClass(){
        return $this->class;
    }

    function index($request){
          return $this->view();
    }

    //Get list of all records in table.
    function all($request){
       global $context;
        $i= new $this->model;

       if(!$this->authRequired){
            $i->supperUser();
       }

       $data=$i->get();

       if($request->UseApi() ){
              json_success("Success",$data);//where(['id','<','50'])->orderBy('id','desc')->limit(2,1)->
        }else{
            return $this->view(compact('data'));
        }

    }

    //Get list of filtered records in table.
    function filter($request){
        global $context;
        $i= new $this->model;

        if(!$this->authRequired){
            $i->supperUser();
        }

        foreach($request->get as $key=>$value){
            if($i->field_exists($key)){
                $i->where($key,$value);
            }
        }

        $data=$i->get();

        if($request->UseApi() ){
            json_success("Success",$data);//where(['id','<','50'])->orderBy('id','desc')->limit(2,1)->
        }else{
            return $this->view(compact('data'));
        }
    }

    //Get list of filtered records in table.
    function postFilter($request){
        global $context;
        $i= new $this->model;

        if(!$this->authRequired){
            $i->supperUser();
        }

        foreach($request->post as $key=>$value){
            if($i->field_exists($key)){
                $i->where($key,$value);
            }
        }

        $data=$i->get();

        if($request->UseApi() ){
            json_success("Success",$data);//where(['id','<','50'])->orderBy('id','desc')->limit(2,1)->
        }else{
            return $this->view(compact('data'));
        }
    }

    //Get list of filtered records in table.
    function bodyFilter($request){
        global $context;
        $i= new $this->model;

        if(!$this->authRequired){
            $i->supperUser();
        }

        foreach($request->body as $key=>$value){
            if($i->field_exists($key)){
                $i->where($key,$value);
            }
        }

        $data=$i->get();

        if($request->UseApi() ){
            json_success("Success",$data);//where(['id','<','50'])->orderBy('id','desc')->limit(2,1)->
        }else{
            return $this->view(compact('data'));
        }
    }

    //Get one record by ID.
    function item($request){
        try{
            $data= new $this->model;


            $validate=new Validator();
            $validate->validate($request->get,['id'=>'Requierd|Integer']);

	  if(!$this->authRequired){
            $data->supperUser();
        	}


            $data= $data::find($request->get['id'],!$this->authRequired);
            if(!$data){
                if($request->UseApi())
                {
                    return json_error("Not found item");
                }
                header("HTTP/1.0 404 Not Found");
                return $this->view("Error/index",['ErrorNumber'=>404]);
            }
            $data->mode='view';
            if($request->UseApi())
            {
                return json_success("Getting success",$data);
             }

            //if($request->isAjax() ){
           //     return json_success("Success",$data);
           // }else{
                return $this->view(compact('data'));
            //}
        }catch(Exception $ex){
            if($request->isAjax() ){
               return json_error($ex->getMessage());
            }
            //else{
                echo $ex->getMessage();
            // }
        }
    }

    //GET : open empty form to add new record
    function add($request){
         return $this->view();
    }
    //POST : send form data to insert record
    function postAdd($request){
         global $context;
         $data= new $this->model;
          if(!$this->authRequired){
            $data->supperUser();
           }
          foreach($data->fields as $key=>$field){
              if($field['type']!='One2many' && $field['type']!='Many2many' ){
                    $data->data[$key]=$request->post[$key];
              }
          }

          if(!$data->insert()){
                    if($request->isAjax()) return json_error($data->error);
                    throw new \Exception($data->error);
                }
          if($request->isAjax()) return json_success("Save Success !!".$data->error,$data);


            redirectTo($context->controller_path."/all");
    }
    //BODY : send form data to insert record
    function bodyAdd($request){
        global $context;
        $data= new $this->model;
         if(!$this->authRequired){
	            $data->supperUser();
	           }
        foreach($data->fields as $key=>$field){
            if($field['type']!='One2many' && $field['type']!='Many2many' ){
                $data->data[$key]=$request->body[$key];
            }
        }

        if(!$data->insert()){
            if($request->isAjax()) return json_error($data->error);
            throw new \Exception($data->error);
        }
        if($request->isAjax()) return json_success("Save Success !!".$data->error,$data);


        redirectTo($context->controller_path."/all");
    }

    //GET : get one record by ID and open edit form to update record
    function edit($request){
        //get edit

        	$obj= new $this->model;
        	  if(!$this->authRequired){
	            $obj->supperUser();
	           }
            $validate=new Validator();
            $validate->validate($request->get,['id'=>'Requierd|Integer']);



            $data= $obj::find($request->get['id'],!$this->authRequired);

            if(!$data){
                header("HTTP/1.0 404 Not Found");
                if($request->UseApi())
                {
                    return json_error("Not found item");
                }

                return $this->view("Error/index",['ErrorNumber'=>404]);
            }
            $data->mode='edit';

            if($request->UseApi())
            {
                return json_success("Getting success",$data);
            }
            return $this->view(compact('data'));



    }
    //POST : send form data to update record
    function postEdit($request){
        global $context;
        $data=new $this->model;
          if(!$this->authRequired){
            $data->supperUser();
           }

        try
        {
            foreach($data->fields as $key=>$field){
            if($field['type']!='One2many' && $field['type']!='Many2many')
                $data->data[$key]=$request->post[$key];
            }

              //print_r($data);
            if(!$data->update()){

               if($request->isAjax()) return json_error($data->error);
                throw new \Exception($data->error);

            }


            if($request->isAjax()) return json_success("Save Success !!");


            redirectTo($context->controller_path."/all");
        }
        catch (\Exception $ex)
        {
            if($request->isAjax()) return json_error($ex->getMessage().$obj->error);
            return $this->view("Error/index",['ErrorNumber'=>0,'ErrorMessage'=>$ex->getMessage().$obj->error]);
        }
    }
    //BODY : send form data to update record
    function bodyEdit($request){
        global $context;
        try{
            $data=new $this->model;
	   if(!$this->authRequired){
            $data->supperUser();
           }
            foreach($data->fields as $key=>$field){
                if($field['type']!='One2many' && $field['type']!='Many2many')
                    $data->data[$key]=$request->body[$key];
            }
            //print_r($data);
            if(!$data->update()){
                if($request->isAjax()) return json_error($data->error);
                throw new \Exception($data->error);
            }
            if($request->isAjax()) return json_success("Save Success !!");


            redirectTo($context->controller_path."/all");
        }
        catch (\Exception $ex)
        {
            if($request->isAjax()) return json_error($ex->getMessage().$obj->error);
            return $this->view("Error/index",['ErrorNumber'=>0,'ErrorMessage'=>$ex->getMessage().$obj->error]);
        }
    }

    //POST : delete record by id
    function postDelete($request){
          global $context;
          try{
                $data= new $this->model;
                if(!$this->authRequired){
	            $data->supperUser();
	           }
                $validate=new Validator();
                $validate->validate($request->post,[$data->col_pk=>'Requierd|Integer']);

                if(count($request->post)==0){
                    return $this->view("Error/index",['ErrorNumber'=>0,'ErrorMessage'=>"Invalid Request !!"]);
                }else{

                    $data->data[$data->col_pk]=$request->post[$data->col_pk];
                    if(!$data->delete()){
                        if($request->isAjax()) return json_error($data->error);
                        throw new \Exception($data->error);
                    }
                    if($request->isAjax()) return json_success("Delete Success !!");
                    redirectTo($context->controller_path."/all");
                }

        }
        catch (\Exception $ex)
        {
            if($request->isAjax()) return json_error($ex->getMessage().$obj->error);
            return $this->view("Error/index",['ErrorNumber'=>0,'ErrorMessage'=>$ex->getMessage().$obj->error]);
        }
    }
    //POST : destroy record by id
    function postDestroy($request){
        global $context;
        try{
          if(count($request->post)==0){
              return $this->view("Error/index",['ErrorNumber'=>0,'ErrorMessage'=>"Invalid Request !!"]);
          }else{
              $data=new $this->model;
                if(!$this->authRequired){
	            $data->supperUser();
	           }
              $data->data[$data->col_pk]=$request->post[$data->col_pk];

                if(!$data->destroy()){
                        if($request->isAjax()) return json_error($data->error);
                        throw new \Exception($data->error);
                    }
                    if($request->isAjax()) return json_success("Deleted forever Success !!");
                   redirectTo($context->controller_path."/all");      }
        }
        catch (\Exception $ex)
        {
            if($request->isAjax()) return json_error($ex->getMessage().$obj->error);
            return $this->view("Error/index",['ErrorNumber'=>0,'ErrorMessage'=>$ex->getMessage().$obj->error]);
        }
    }
    //POST : restore record by id
    function postRestore($request){
        global $context;

      if(count($request->post)==0){
          return $this->view("Error/index",['ErrorNumber'=>0,'ErrorMessage'=>"Invalid Request !!"]);
      }else{
          $data=new $this->model;
            if(!$this->authRequired){
	            $data->supperUser();
	           }
          $data->data[$data->col_pk]=$request->post[$data->col_pk];

        if(!$data->restore()){
                    if($request->isAjax()) return json_error($data->error);
                    throw new \Exception($data->error);
                }
                if($request->isAjax()) return json_success("Restore Success !!");
               redirectTo($context->controller_path."/all");

         }
      }

    function search($request){

     }
    function postSearch($request){
        global $context;

      if(count($request->post)>0){
          $data=new $this->model;
            if(!$this->authRequired){
	            $data->supperUser();
	           }
          $fields=$data->fields;


              for($x=0;$x<count($request->post['filter']);$x++){
                //   echo "relation", $request->post['relation'][$x];
                  if($request->post['relation'][$x]==''){
                      if($data->field_exists($request->post['filter'][$x])){
                          $data->where($request->post['filter'][$x],$request->post['value'][$x]);
                      }
                  }else{
                      $table=explode(".",$request->post['relation'][$x])[0];
                      $interClass=new $table;
                      $thisid=explode(".",$request->post['relation'][$x])[1];
                      $classid=$request->post['filter'][$x];
                      $value=$request->post['value'][$x];

                      $data->where($data->col_pk,"in_query","(select {$classid} from ".$interClass->tablename." where {$thisid}='{$value}' )");
                  }
              }


          $data=$data->supperUser()->get();

          return $this->view('all',compact('data'));
      }

    }


    function kanban($request){
          $i= new $this->model;
            if(!$this->authRequired){
	            $i->supperUser();
	           }
          $data=$i->get();

       if($request->UseApi() ){
              json_success("Success",$data);
        }else{
            return $this->view(compact('data'));
        }
    }


    function view(){
       global $request;
        $args=func_get_args();

        if(count($args)==0){
          $view='';
          $arr=[];
        }elseif(count($args)==1){
            if(is_array($args[0])){
                $view='';
                $arr=$args[0];
            }else{
                $view=$args[0];
                $arr=[];
            }

        }elseif(count($args)==2){
            $view=$args[0];
            $arr=$args[1];
        }else{
            $view=$args[0];
            $arr=$args[1];
        }


        if($view==''){
            $trace = debug_backtrace();
            $method = $trace[1]['function'];
            if(!array_key_exists('data',$arr) && $this->model!=''){

                $data= new $this->model;

               $data->mode=$method;
               $arr['data']=$data;
            }
            $view=str_replace("App\\Controllers\\","",$this->class)."/$method";
         }
        elseif(count(explode("/",$view))<2){
            $cntrl=get_called_class();
            $view=$cntrl."/".$view;
            $view=str_replace("App\\Controllers\\","",$view);
        }


        //echo PATH.'views/'.str_replace("App\\Controllers\\","",$view).'.php';
         if(!file_exists(PATH.'views/'.str_replace("App\\Controllers\\","",$view).'.php')){

          $view="BaseController/$method";
        }


         echo view($view,$arr);




    }

    function find($request){
         return $this->item($request);
    }

}

?>
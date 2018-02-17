<?
namespace App\Models\Media;

use Framework\Database;
use Framework\BLL;

class Images extends BLL{
	var $tablename="images";
	var $col_pk="id";

    var $img;

	var $fields=[

	    ];
    function name(){
        return $this->file_name;
    }
    function __construct(){

         $args = func_get_args();
         if(count($args)==0){
             $model='undifined';
             $id='0';
             $tag="Default";
         }
         if(count($args)==1 && !is_object($args[0])){
             $model='undifined';
             $id='0';
             $tag="Default";
             //return ['type'=>'error','message'=>'Construct function arguemts 1 error.'];
         }
         if(count($args)==1){
             $obj=$args[0];
             $model=get_class($obj);
             $id=$obj->id;
             $tag="Default";

         }
         if(count($args)==1 && !is_object($args[0])){
             return ['type'=>'error','message'=>'Construct function arguemts 1 error.'];
         }
         if(count($args)==2){
             $obj=$args[0];
             $model=get_class($obj);
             $id=$obj->id;
             $tag=$args[1];
         }
         if(count($args)==3 && !is_object($args[0])){
             return ['type'=>'error','message'=>'Construct function arguemts 1 error.'];
         }
         if(count($args)==3){
             $obj=$args[0];
             $model=get_class($obj);
             $id=$obj->id;
             $tag=$args[1];
             $img=$args[2];
         }
         if(count($args)==4 && is_object($args[0])){
             echo 'Construct function arguemts 1 error.';
             return ['type'=>'error','message'=>'Construct function arguemts 1 error.'];
         }
         if(count($args)==4){
             $model=$args[0];
             $id=$args[1];
             $tag=$args[2];
             $img=$args[3];
         }
         parent::__construct();

         $this->data['model_id']=$id;
         $this->data['model_name']=$model;
         $this->tag=$tag;
         $this->img=$img;
    }


	function __set($key,$value){
        parent::__set($key,$value);

				if($key!="model_name") return;

        if($this->model_name=="") return;

        $c=new $this->model_name;

				$this->fields['model_id']=['name'=>'Releted Record',
							'type'=>'Many2one','visible'=>true,
							'serialize'=>true,
							'relation'=>['class'=>$this->model_name,'classid'=>$c->getPKname(),'controller'=>'Comp']];
		}

    function upload(){
        //print_r( $this->model_name);
        $model_name=str_replace("App\Models\\","",$this->model_name);
        $model_name=str_replace("\\","/",$model_name);

        $arr=upload_image($this->img,"uploads/{$model_name}/{$this->data['model_id']}/{$this->tag}");

        if(array_key_exists($arr,'error')) throw new \Exception( $arr['error']);

        $this->file_name=$arr['filename'];

        if(!$this->supperUser()->insert()) throw new \Exception( $this->error);

        return true;
    }

    function orignal(){
        return $this->getImageBySize('orignal');
    }
     function medium(){
        return $this->getImageBySize('medium');
    }
     function thumb(){
        return $this->getImageBySize('thumb');
    }
     function getImageBySize($size){
        $model_name=str_replace("App\Models\\","",$this->model_name);
        $model_name=str_replace("\\","/",$model_name);

        return "/uploads/". $model_name."/".$this->data['model_id']."/".$this->tag."/{$size}/". $this->file_name;
    }
}
?>

<?php
namespace Framework;
use Framework;
class Models extends BLL
{
	//var $list=[];
	var $fields=[
	        'name'=>[
	                'name'=>'Name',
	                'type'=>'nvarchar',
	                'size'=>255,
	            ],
			'id'=>[
	            'name'=>'id',
	            'type'=>'nvarchar',
	            'size'=>255,
	            ],
            'namespace'=>[
	            'name'=>'Namespacse',
	            'type'=>'nvarchar',
	            'size'=>255,
	            ],
	    ];
	function __construct(){

	}
    static function namespacess(){
        $namespacess=[];
        $list=[];
        foreach(Framework\Models::models() as $model){
            $split=explode("\\",$model->name);
            $fullname='';
            for($i =0 ;$i<count($split)-1;$i++){
                $fullname.=($fullname==""?"":"\\").$split[$i];
                if(!in_array($fullname."\*",$namespacess)) $namespacess[]=$fullname."\*";
            }


        }

        foreach ($namespacess as $name){
            $obj= new Models;
            $obj->name=$name;
            $obj->id=$name;

            $split=explode("\\",$class);
            $fullname='';
            for($i =0 ;$i<count($split)-2;$i++){
                $fullname.=($fullname==""?"":"\\").$split[$i];
            }
            $obj->namespace=$fullname;
            $list[]=$obj;

        }
        return $list;
    }

    static function models(){

        $list=[];
        foreach(get_declared_classes() as $class){
            if(strpos($class,'App\\Models\\',0)!==false){
                $obj= new Models;
                $obj->name=$class;
                $obj->id=$class;
                $split=explode("\\",$class);
                $fullname='';
                for($i =0 ;$i<count($split)-1;$i++){
                    $fullname.=($fullname==""?"":"\\").$split[$i];
                }
                $obj->namespace=$fullname;
                $list[]=$obj;
            }
        }




        return $list;
	}

	static function all(){
        return array_merge(Framework\Models::namespacess(),Framework\Models::models());
	}
function get(){
    $arr=Models::all();

    if($this->where_arr){
        $arr=array_filtercolumn($arr,$this->where_arr);
    }

    return $arr;
}
function Many2one($class,$foraginkey='',$classid='',$where = NULL){
	    $obj=new Models;
			$this->where_arr[]=$where;
			$obj=$this->supperUser()->get();
		return $obj[0];
}


}

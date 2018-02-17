<?
namespace App\Models\Notify;

use Framework\Database;
use Framework\BLL;

class Waitinglist extends BLL{

    use \Framework\NotifyModel;

	var $tablename="waitinglist";
	var $col_pk="id";

	var $fields=[
        'userId'=>[
            'name'=>'Requested By',
            'type'=>'Many2one',
            'serialize'=>true,
            'relation'=>['class'=>'App\Models\Auth\User','classid'=>'id','controller'=>'Users']],
        //'model_name'=>[
        //    'name'=>'Model Name',
        //    'type'=>'Many2one',
        //    'serialize'=>true,
        //    'relation'=>['class'=>'Framework\Models','classid'=>'id','controller'=>'Models']]
 	    ];

    function name(){
        return $this->userId->name . "(" .$this->model_name .")";
    }


	function __set($key,$value){
        parent::__set($key,$value);
        if($key!="model_name") return;

        if($this->model_name=="") return;

        $c=new $this->model_name;
        $arr=explode("\\",$this->model_name);
        $controller=array_pop($arr);
       // echo "Col_pk",$this->model_name,$c->getPKname();
        $this->fields['model_id']=['name'=>'Releted Record',
    			'type'=>'Many2one','visible'=>true,
    			'serialize'=>true,
    			'relation'=>['class'=>$value,'classid'=>$c->getPKname(),'controller'=>$controller]];
    }





}
?>

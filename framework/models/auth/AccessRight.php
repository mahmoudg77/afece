<?
namespace App\Models\Auth;

use Framework\Database;
use Framework\BLL as BLL;

class AccessRight extends BLL{
	var $tablename="sec_accessright";
	var $col_pk="id";
      var $fields=[
	    'groupid'=>['name'=>'Group',
	            'default'=>'2',
	            'compute'=>'',
	            'type'=>'Many2one',
	            'serialize'=>true,
	            'relation'=>['class'=>"App\Models\Auth\UserGroup",'classid'=>'id','controller'=>'UserGroup']],
	    ];

	 function name(){
	     return $this->model_name." ( ".$this->accesstype." )";
	 }



}
?>

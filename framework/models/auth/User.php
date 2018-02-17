<?
namespace App\Models\Auth;

use Framework\Database;
use Framework\BLL;

class User extends BLL{
	var $tablename="users";
	public $col_pk="id";

	var $fields=[
       // 'profileName'=>['name'=>'Profile Name','type'=>'calculated','compute'=>'getprofilename','serialize'=>true],
        //'PersonalImage'=>['name'=>'Personal Image','type'=>'calculated','compute'=>'getPersonalImage','serialize'=>true],
        //'CoverImage'=>['name'=>'Cover Image','type'=>'calculated','compute'=>'getCoverImage','serialize'=>true],
	    
        /*'accid'=>['name'=>'Profile',
	            'compute'=>'',
	            'type'=>'Many2one',
	            'serialize'=>true,
	            'relation'=>['class'=>"App\Models\Profile\Profile",'classid'=>'Profile_ID','controller'=>'Profile']],*/
	     'groups'=>['name'=>'Groups',
	            'compute'=>'',
	            'type'=>'Many2many',
	            'serialize'=>true,
	            'relation'=>['class'=>"App\Models\Auth\UserGroup",'table'=>"App\Models\Auth\UserGroupRel",'classid'=>'groupid','thisid'=>'userid','controller'=>'UserGroup']],
	'password'=>['name'=>'Password','type'=>'varchar','serialize'=>false],
        'token'=>['name'=>'token','type'=>'varchar','serialize'=>false],
        'remember_token'=>['name'=>'remember_token','type'=>'varchar','serialize'=>false],
                ];

    function joined($g){
    	foreach($this->groups as $group) if($group->groupkey==$g) return true;
    	return false;
    }
    /*function getprofilename(){
        return $this->accid->name;
    }
    function getPersonalImage(){
        return $this->accid->PersonalImage()->thumb;
    }
    function getCoverImage(){
        return $this->accid->CoverImage()->thumb;
    }*/
    function allow($model,$access){
        $class=new AccessRight;
        $class->supperUser();
		$models=explode("\\",$model);
		$itm="";
		$new_models=[$model];
		foreach($models as $m){
			$itm.=(($itm=="")?"":"\\").$m;
			$new_models[]=$itm."\*";
		}

    	$arr=$class->where("model_name","in",$new_models)
				   ->where("accesstype",$access)
				   ->where("groupid","in",array_getcolumn($this->groups,"id"))
				   ->get();
		//print_r($new_models);
     	return count($arr)>0 ? true:false;
    }

    function allowfilter($model,$access,$groupkey=''){
    	$class=new AccessRight;
    	$class->supperUser();

		$models=explode("\\",$model);
		$itm="";
		$new_models=[$model];
		foreach($models as $m){
			$itm.=(($itm=="")?"":"\\").$m;
			$new_models[]=$itm."\*";
		}
        $class->where("model_name","in",$new_models) ;
    	$class->where("accesstype",$access);
     	$class->where("groupid","in",array_getcolumn($this->groups,"id"));
		// 	if($groupkey!='') $list->where("groupid",array_column($this->groups,"id"));

		//  				(($groupkey=='')?'':" and (select name from user_group where groupid=user_group.id)='".$groupname."'"));

		// print_r(array_getcolumn($this->groups,"id"));
    	$data=$class->get();
       	return array_getcolumn($data,"filter",false);
    }

}
?>
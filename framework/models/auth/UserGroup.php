<?
namespace App\Models\Auth;

use Framework\Database;
use Framework\BLL;

class UserGroup extends BLL{
	var $tablename="sec_group";
	var $col_pk="id";


	  var $fields=[
	    'access'=>['name'=>'Access',
	            'default'=>'2',
	            'compute'=>'',
	            'type'=>'One2many',
	            'serialize'=>false,
	            'relation'=>['class'=>"App\Models\Auth\AccessRight",'classid'=>'groupid','controller'=>'AccessRight']],
	     'members'=>['name'=>'Members',
	            'default'=>'2',
	            'compute'=>'',
	            'type'=>'Many2many',
	            'serialize'=>false,
	            'relation'=>['class'=>"App\Models\Auth\User",'classid'=>'userid','thisid'=>'groupid','table'=>"App\Models\Auth\UserGroupRel",'controller'=>'Users']],
	    'categoryid'=>['name'=>'Category',
	            'default'=>'2',
	            'compute'=>'',
	            'type'=>'Many2one',
	            'serialize'=>true,
	            'relation'=>['class'=>"App\Models\Auth\GroupCategory",'classid'=>'id','controller'=>'GroupCategory']],
	    ];

}
?>

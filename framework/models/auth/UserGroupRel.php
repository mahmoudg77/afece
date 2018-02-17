<?
namespace App\Models\Auth;

use Framework\Database;
use Framework\BLL;

class UserGroupRel extends BLL{
	var $tablename="sec_user_group_rel";
	var $col_pk="id";

     var $fields=[
	    'groupid'=>['name'=>'Group',
	            'default'=>'2',
	            'type'=>'Many2one',
	            'serialize'=>true,
	            'relation'=>['class'=>"App\Models\Auth\UserGroup",'classid'=>'id','controller'=>'UserGroup']],
	   'userid'=>['name'=>'User',
	            'default'=>'2',
	            'type'=>'Many2one',
	            'serialize'=>true,
	            'relation'=>['class'=>"App\Models\Auth\User",'classid'=>'id','controller'=>'Users']],

	    ];

}
?>

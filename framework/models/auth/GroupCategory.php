<?
namespace App\Models\Auth;

use Framework\Database;
use Framework\BLL;

class GroupCategory extends BLL{
	var $tablename="sec_group_category";
	var $col_pk="id";

	 var $fields=[
	    'groups'=>['name'=>'Groups',
	            'default'=>'2',
	            'type'=>'One2many',
	            'serialize'=>true,
	            'relation'=>['class'=>"App\Models\Auth\UserGroup",'classid'=>'categoryid','controller'=>'UserGroup']],

	    ];

}
?>

<?
namespace App\Models\Content;

use Framework\Database;
use Framework\BLL;

class Post extends BLL{
	var $tablename="posts";
	var $col_pk="id";
	protected $showDeleted=true;

	var $fields=[
		'category_id'=>['name'=>'Category',
			 		'type'=>'Many2one',
			 		'serialize'=>true,
			 		'relation'=>['class'=>"App\Models\Content\Category",'classid'=>'id','where'=>[],'controller'=>'Category']],
            
	    ];
}
?>
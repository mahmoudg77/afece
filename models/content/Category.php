<?
namespace App\Models\Content;

use Framework\Database;
use Framework\BLL;

class Category extends BLL{
	var $tablename="category";
	var $col_pk="id";
	protected $showDeleted=true;

	var $fields=[

	    ];
}
?>
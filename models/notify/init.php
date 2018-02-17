<?
namespace App;

use Models\Database;
use Models\BLL;

foreach (glob(dirname(__FILE__)."/*.php") as $filename)
{

   if($filename!=dirname(__FILE__).'/init.php') include_once $filename;
}


?>

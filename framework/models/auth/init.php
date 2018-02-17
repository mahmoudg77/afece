<?
namespace App;

use Framework\Database;
use Framework\BLL;

foreach (glob(dirname(__FILE__)."/*.php") as $filename)
{

   if($filename!=dirname(__FILE__).'/init.php') include_once $filename;
}


?>

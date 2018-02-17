<?
namespace App;


foreach (glob(dirname(__FILE__)."/*/init.php") as $filename)
{
  include_once $filename;
}


// include 'auth/init.php';
// include 'account/init.php';
// include 'articles/init.php';
// include 'finance/init.php';

?>

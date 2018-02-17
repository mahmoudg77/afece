<?
namespace Framework;
use \Exception as Exception;

class APPException extends Exception
{
    function __construct($number,$message){
        parent::__construct();
        if($_GET && isset($_GET['api'])){
            echo(json_encode(['type'=>'error','message'=>'['.$number.'] Error : '.$message,'result'=>null]));
        }else{
            echo('['.$number.'] Error : '.$message);
        }

    }
}
?>

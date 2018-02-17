<?
namespace App\Controllers;
class Error extends BaseController
{
    protected  $model="";

    function index($request){
        
        $ErrorNumber=$request->get['number'];
        return $this->view(compact('ErrorNumber'));
    }


}

?>

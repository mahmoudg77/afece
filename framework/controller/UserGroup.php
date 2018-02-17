<?
namespace App\Controllers;
class UserGroup extends BaseController
{
    protected  $model="App\Models\Auth\UserGroup";
    public $authRequired=true;
    function index($request){
        global $context;
        // $data=new $this->model;
        // $data=$data->get();
        return redirectTo($context->controller_path.'/all');
    }

}

?>
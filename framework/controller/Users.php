<?
namespace App\Controllers;
use App\Addons\Validator as Validator;

class Users extends BaseController
{
    protected  $model="App\Models\Auth\User";
    public $authRequired=true;

    function postAdd($request){
        if(strlen($request->post['password'])<8) {
            $message="The password is too short !!";
        }
        if(strlen($request->post['email'])<8) {
            $message="The email is too short !!";
        }

        if($request->post['cpassword'] != $request->post['password']) {
            $message="Confirm password and passord not matches !!";
        }

        $found=new \App\Models\Auth\User;
        $found= $found->where('email',$request->post['email'])->get();

        if(count($found)>0) {
            $message="This email or username is existing !!";
        }

        if(isset($message)){
            if($request->isAjax()){
                return json_error($message);
            }else{
                echo $message;
            }
        }
        if(isset($request->post['password'])) {
            $request->post['password']=md5($request->post['password']);
            $request->post['token']=guid();
        }
        parent::postAdd($request);
    }
}

?>
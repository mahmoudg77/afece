<?
namespace App\Controllers;
use Framework\Addons\Validator as Validator;
class AccessRight extends BaseController
{
    protected  $model="App\Models\Auth\AccessRight";
    public $authRequired=true;

}

?>
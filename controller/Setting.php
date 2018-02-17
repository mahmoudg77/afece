<?
namespace App\Controllers;
use App;
use Framework\Addons\Validator as Validator;
class Setting extends BaseController
{
    protected  $model="App\Models\Admin\Setting";
    public $authRequired=false;

    function index($request){
         if(isset($request->get['group'])){

            $group=addslashes(htmlspecialchars($request->get['group']));

            $groups=new \App\Models\Admin\Setting;

            $groups=$groups->where('setting_group',$group)->get();

            $Languages=new \App\Models\Lookup\Languages;
            $Languages=$Languages->get() ;
            return $this->view(compact('groups','Languages'));

        }else{ 
            $groups=new \App\Models\Admin\Setting;

            $groups=$groups->get();
            //$groups=arr_obj_group($groups,"setting_group");
            return $this->view("all",compact('groups'));
        }
    }

    function postIndex($request){
        $valid=new Validator();
        try{
            $valid->validate($request->post,["IDs"=>"Requierd|Integer"]);

        }
        catch(\Exception $ex){

            return json_error($ex->getMessage());

        }

        try
        {
        	for($x=0;$x<=count($request->post['IDs']);$x++){
                $value= addslashes($request->post['value'][$x]);
                $value= trim($value);
                $setting= App\Models\Admin\Setting::find($request->post['IDs'][$x]);
                if($setting){
                    $setting->data['value']=$value;
                    $setting->update();
                }

                //$query =  mysql_query("UPDATE sms_setting SET `value`='$value' where  `id`='".$_POST['IDs'][$x]."'") or die(mysql_error());

            }
        }
        catch (\Exception $ex)
        {
            return json_error($ex->getMessage());
        }



        return json_success("Save Success !");
    }
}

?>
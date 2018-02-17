<?
namespace App\Models\Admin;

use Framework\Database;
use Framework\BLL;

class Setting extends BLL{
	var $tablename="setting";
	var $col_pk="id";
	protected $showDeleted=true;
	var $fields=[

  	    ];
    var $settings=[];


    function getAllSetting(){
        global $context;
        $cLang=LANG;
        if($cLang=='LANG') $cLang="en";
        $data=$this->where('lang','in',['*',$cLang])->supperUser()->get();
        foreach($data as $setting)
		{
            $this->settings[strtoupper($setting->setting_group.'_'.$setting->setting_key)]=stripslashes($setting->value);
		}
	}

	function getSetting($setting_key,$module='GENERAL'){
		if(!$this->settings)$this->getAllSetting();
		return $this->settings[strtoupper($module.'_'.$setting_key)];
	}


}
?>
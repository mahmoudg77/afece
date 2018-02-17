<?php
namespace Framework\Addons;
use \Exception as Exception;

class Validator {

    static  function Check($data,$rules){
    	$vlied=new Validator();
    	return $vlied->Validate($data,$rules);
    }



    function Validate($data,$rules)
    {
        $valed = TRUE;
        foreach ($rules as $key => $rule)
        {

            $callbacks = explode('|', $rule);
            foreach ($callbacks as $callback)
            {
                $callback="Check".$callback;
                $value=  isset($data[$key])? $data[$key] : NULL ;


                if (is_array($value))
                {
                    foreach ($value as $val) {
                    	try{
                            if ($this->$callback($val,$key)== FALSE)
                                $valed = FALSE;
	                    }catch(Exception $ex){
	                	     throw $ex;
	                    }
                    }
                } else {
                   	try{
                        if ($this->$callback($value,$key)== FALSE)
                            $valed = FALSE;
	                }catch(Exception $ex){
	                	 throw $ex;
	                }
                }
            }
        }
        return $valed;
    }

    function CheckStrings($value, $key)
    {
        if(empty($value)) return true;
        //$pattern="/^[a-zA-Z\p{Cyrillic}0-9\s\-\.]+$/u";
        $validate = $this->is_clean($value);//preg_match($pattern, $value);
        if ($validate)
        {
            return $validate;
        }
        else {
            throw new Exception("!Error: the $key must be a valid string");
        }
    }
    

    function CheckGuid($value, $key)
    {
        if(empty($value)) return true;
        $pattern="/^([0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12})$/";
        $validate = preg_match($pattern, $value);
        if ($validate)
        {
            return $validate;
        }
        else {
            throw new Exception("!Error: the $key must be a valid code");
        }
    }

    function CheckEmail($value, $key)
    {
        if(empty($value)) return true;
        $validate = filter_var($value, FILTER_VALIDATE_EMAIL);
        if ($validate)
        {
            return $validate;
        }
        else {
            throw new Exception("!Error: the $key must be a valid email");
        }
    }

    function CheckURL($value, $key)
    {
        if(empty($value)) return true;
        $validate = filter_var($value, FILTER_VALIDATE_URL);
        if ($validate == FALSE)
            throw new Exception("!Error: the $key must be a valid URL");

        return $validate;
    }

    function CheckIP($value, $key)
    {
        if(empty($value)) return true;
        $validate = filter_var($value, FILTER_VALIDATE_IP);
        if ($validate == FALSE)
            throw new Exception("!Error: the $key must be a valid IP");

        return $validate;
    }

    function CheckInteger($value, $key)
    {
        if(empty($value)) return true;
        $validate = filter_var($value, FILTER_VALIDATE_INT);
        if ($validate == FALSE)
            throw new Exception("!Error: the $key must be a valid INT");

        return $validate;
    }

    function CheckRequired($value, $key)
    {
        $validate = ! empty($value);
        if ($validate == FALSE)
            throw new Exception("!Error: the $key is required:");

        return $validate;
    }
    function CheckRequierd($value, $key)
    {
        $validate = ! empty($value);
        if ($validate == FALSE)
            throw new Exception("!Error: the $key is required:");

        return $validate;
    }

    function CheckDate($value, $key)
    {

        //if(empty($value)) return true;
        try
        {
        	 $t = strtotime($value);
        }
        catch (Exception $exception)
        {
            throw new Exception("!Error: the $key must be Date");
        }

        if(empty($t))
            throw new Exception("!Error: the $key must be Date");

        $m = date('m',$t);
        $d = date('d',$t);
        $y = date('Y',$t);

        $validate=checkdate ($m, $d, $y);

        if ($validate == FALSE)
            throw new Exception("!Error: the $key must be Date");

        return $validate;
     }

    function SanitizeItem($value, $key)
    {
        $flag = null;
        switch ($flag) {
            case email:
                $value = substr($value, 0 , 250);
                $filter = FILTER_SANITIZE_EMAIL;
                break;

            case url:
                $filter = FILTER_SANITIZE_URL;
                break;

            case int:
                $filter = FILTER_SANITIZE_NUMBER_INT;
                break;

            default:
                $filter = FILTER_SANITIZE_STRING;
                $flag = FILTER_FLAG_NO_ENCODE_QUOTES;
                break;
        }
        $validate = filter_var($value,$filter,$flag);
        if ($validate == FALSE)
            throw new Exception("!Error: the $key is invalid");

        return $validate;
    }

    /**
     * A simple function to check file from bad codes.
     *
     * @param (string) $file - file path.
     * @author Yousef Ismaeil - Cliprz[at]gmail[dot]com.
     */
    function is_clean_file($file) {
        if (file_exists($file)) {
            $contents = file_get_contents($file);
        } else {
            exit($file . " Not exists.");
        }
	return $this->is_clean($contents);
    }
    function is_clean($contents){

        if (preg_match('/(base64_|eval|system|shell_|exec|php_)/i', $contents)) {
            return false;
        } else if (preg_match("#&\#x([0-9a-f]+);#i", $contents)) {
            return false;
        } elseif (preg_match('#&\#([0-9]+);#i', $contents)) {
            return false;
        } elseif (preg_match("#([a-z]*)=([\`\'\"]*)script:#iU", $contents)) {
            return false;
        } elseif (preg_match("#([a-z]*)=([\`\'\"]*)javascript:#iU", $contents)) {
            return false;
        } elseif (preg_match("#([a-z]*)=([\'\"]*)vbscript:#iU", $contents)) {
            return false;
        } elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*expression\([^>]*>#iU", $contents)) {
            return false;
        } elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*behaviour\([^>]*>#iU", $contents)) {
            return false;
        } elseif (preg_match("#</*(applet|link|style|script|iframe|frame|frameset|html|body|title|div|p|form)[^>]*>#i", $contents)) {
            return false;
        } else {
            return true;
        }
    }

    function clean_values($data,$keys='') {
    	if(is_array($keys)){
    		$keyarray=$keys;
    	}else{
    		$keyarray= explode(',', $keys);
    	}

    	foreach($keyarray as $key){
    		$data[$key]=htmlspecialchars(addslashes(trim($data[$key])));
    	}
    }

}
?>

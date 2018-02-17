<?php
namespace Framework;
class Request
{

    var $get;
    var $post;
    var $body;
    var $files;
    var $server;

    function __construct(){
      global $_GET,$_POST,$_FILES,$_SERVER;
         $this->get=$_GET;
         $this->post=$_POST;
         $this->files=$_FILES;
         $this->server=$_SERVER;
         $this->body=json_decode(file_get_contents('php://input'), true);
         return $this;
    }
	static function CSRF(){
            //$token = md5(uniqid(rand(), TRUE));
            $csrf_key   = "TOKEN_" . mt_rand(0, mt_getrandmax());
            $csrf_token = hash("sha512", mt_rand(0, mt_getrandmax()));


            $_SESSION[$csrf_key] = $csrf_token;
            $_SESSION['CSRF_TOKEN_TIME'] = time();
            echo "<input type='hidden' name='__FORM_TOKEN_KEY__' value='" . $csrf_key . "' />";
            echo "<input type='hidden' name='__FORM_TOKEN__' value='" . $csrf_token . "' />";
	}

	function Check_CSRF(){
         if($this->UseApi || $this->isAjax()) return true;
	     if((!array_key_exists('__FORM_TOKEN_KEY__',$this->post) || !isset($_SESSION[$this->post['__FORM_TOKEN_KEY__']]))  && count($this->post)>0 ) return false;
	     if((!array_key_exists('__FORM_TOKEN__',$this->post) ||  $this->post['__FORM_TOKEN__']!=$_SESSION[$this->post['__FORM_TOKEN_KEY__']]) && count($this->post)>0 ) return false;

	    return true;
	}

	function UseApi(){
	    return (count($this->get)>0 && isset($this->get['api']))?true:false;
	}
	function isBody(){
	    if($this->body){
	        return true;
	    }
	     return false;
	}
	function isPost(){
	    if(!$this->isBody()){
	        if(count($this->post)>0){
	            return true;
	        }
	    }
	    return false;
	}
	function isGet(){
	    if(!$this->isPost()){
	            return true;
	    }
	    return false;
	}
	function hasFiles(){
	    if(!count($this->files)>0){
	            return true;
	    }
	    return false;
	}
	function isAjax(){
	    if(!empty($this->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	        return true;
	    }
        if($this->UseApi()) return true;
	    return false;
	}
}

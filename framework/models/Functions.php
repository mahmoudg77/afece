<?php
function time_string($ptime,$incTime=true)
{
global $LANG,$cLang;
//if(!validateDate($ptime))$ptime=strtotime($ptime);
    $etime = time() - $ptime ;


    if($etime>=86400*2 || $etime<0){
    		$d=date("d",$ptime);
    		$m=date("m",$ptime);
    		$y=date("Y",$ptime);
    		$t=date("h:i",$ptime);
    		$A=date("A",$ptime);

    	return  $d.' '.
    		$LANG['Months'][$m-1].' '.
    		$y.' '.
    		($incTime?$t.' '.
    		$LANG[$A]:'');// date("d-M-y h:i A",$ptime);
    }
     if ($etime < 1)
    {

        	return   $LANG['now'];

    }

    $a = $LANG['times_value'];
    $a_plural = $LANG['times_name'];


    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;

        if ($d >= 1)
        {
            $r = round($d);
	        if($LANG['dir']=="rtl"){
			return $LANG['ago'] . ' ' . $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) ;
	        }else{
	        	return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' '.$LANG['ago'];
	        }
        }
    }

}
function shortString($str,$count){
$pieces = explode(" ", strip_tags($str));
$first_part = implode(" ", array_splice($pieces, 0, $count));
$other_part = implode(" ", array_splice($pieces, $count));
return  $first_part ;
}

function get_word_counts($str) {
   $counts = array();
    preg_replace("/\W(?=.*\.[^.]*$)/", "", $str);
   try{
        $words = explode(' ', $str);

        foreach ($words as $word) {
	        if(strlen($word)>7){
	           $word = preg_replace("/[^$word]/", "", $word);
	           $counts[$word] += 1;
	        }
        }

    arsort($counts);
    return $counts;
     }catch(Exception $ex){
 	return $counts;
    }
}
function get_keywords($str,$count=5){
global $LANG,$cLang;
$str=strip_tags($str);
$ignore_keywords_en=array('to','from','of','all','but','no','yes','do'.'are','is','can','not');
$ignore_keywords_ar=array('��',
				'��'
				,'���'
				,'���'
				,'���'
				,'��'
				,'��'
				,'��'
				,'����'
				,'��'
				,'������'
				,'���'
				,'��'
				,'���'
				,'���'
				,'���'
				,'��',
				'�',
				'����',
				);

$str=str_replace($ignore_keywords_ar,"",$str);
$str=str_replace($ignore_keywords_en,"",$str);
$str=str_replace("'","",$str);
$str=str_replace('"',"",$str);
$str=str_replace("\\","",$str);

$arr=get_word_counts($str);

$keyword=array();
$n=0;
if($arr){
	foreach($arr  as $w=>$c){
		$keyword[]=$w;
		$n++;
		if($n>$count) return $keyword;
	}
}
return $keyword;

}




function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function langurl($newlang="en"){
if(!$newlang)$newlang="en";
//global $_GET;
$url=preg_replace('/(en|ar)\//',"$newlang/",$_SERVER['REQUEST_URI']);
if(!preg_match('/(en|ar)\//',$_SERVER['REQUEST_URI'])){
$url="/$newlang".$_SERVER['REQUEST_URI'];
}
return $url;

}


function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
///////////////////////////////////
function upload_image($img,$path="uploads",$allowedexts=['jpg','png','gif','jpeg'],$maxsize=4000000){
	$arr=array();
	if( !isset($img))
	{
	    $arr['error']="Error in upload image !";

	    return $arr;
	}

    $fileName = $img['name'];
	$tmpName  = $img['tmp_name'];
	$fileSize = $img['size'];
	$fileType = $img['type'];

    if(empty($fileName))
    {
        $arr['error'] = "Cannot upload empty file !";
         return $arr;
    }
    $fileex = explode('.', $fileName);
    $ext = strtolower(array_pop($fileex));

    if(in_array($ext, $allowedexts)=== FALSE)
    {
        $arr['error'] = "File type is not allowed !";
         return $arr;
    }
    if ($fileSize > $maxsize)
    {
       $arr['error'] = "File size must be less than (".($maxsize/1024).") KB !";
        return $arr;
    }


	$uploadDir=$path;
	$dirlist=explode("/",$uploadDir);
	$cpath='';

	foreach( $dirlist as $dir){
	    $cpath.=(($cpath=='')?'':'/').$dir;
		if (!file_exists($cpath))
		{
			mkdir($cpath);
			$indexFile=fopen($cpath."/index.html","w" );
			fclose( $indexFile);
		}

	}

		if (!file_exists( $uploadDir."/thumb/"))
		{
			mkdir($uploadDir."/thumb/" )  ;
			$indexFile=fopen($uploadDir."/thumb/index.html","w" );
			fclose( $indexFile);
		}
		 if (!file_exists( $uploadDir."/orignal/")) {
			mkdir($uploadDir."/orignal/")  ;
			$indexFile=fopen($uploadDir."/orignal/index.html","w" );
			fclose( $indexFile);
		}
		if (!file_exists( $uploadDir."/medium/")) {
			mkdir($uploadDir."/medium/")  ;
			$indexFile=fopen($uploadDir."/medium/index.html","w" );
			fclose( $indexFile);
		}







			$time = time();
			$randName = md5(rand() * time());
			$randName = substr($randName, 0, 5);
            $nameindatabase =  $randName . '.' . $ext;

            $orignalPath = $uploadDir."/orignal/".  $randName . '.' . $ext;

			$result = move_uploaded_file($tmpName, $orignalPath);

	        if (!$result) {
				return ['error'=>'Cannot upload this file !!'];
			}

            $arr['filename']=$nameindatabase;
			$arr['orignal']=$orignalPath;

            $size="thumb";
			$wmax = 200;
			$hmax = 150;
			$thumb_file = "$uploadDir/$size/$nameindatabase";
            ak_img_resize($orignalPath, $thumb_file, $wmax, $hmax, $ext);

			$arr[$size]=$thumb_file;

            $size="medium";
			$medium_file = "$uploadDir/$size/$nameindatabase";
			$wmax = 600;
			$hmax = 400;
			ak_img_resize($orignalPath, $medium_file, $wmax, $hmax, $ext);

			$arr[$size]=$thumb_file;

                    /////////////////////////////////////////////////////
	return $arr;

}
function ak_img_resize($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
           $w = $h * $scale_ratio;
    } else {
           $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){
      $img = imagecreatefromgif($target);
    } else if($ext =="png"){
      $img = imagecreatefrompng($target);
    } else {
      $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);

}


function sendmail($from,$to,$subject,$body,$otherheader=""){
	$header= "From: ".$from;
	if($otherheader!="")$header.="\r\n".$otherheader;

	if(mail($to,$subject,$body,$header)) return true;
	else return false;
}
 function arr_obj_group($array,$group,$arrayfield='data'){
		foreach( $array as $elem){
			$values_arr=[];
			for( $x=count($group)-1;$x>=0;$x--)
			{
				foreach($elem->$arrayfield as $k=>$v){
					if($k==$group[$x]){
						$values_arr[]=$v;
						//echo $v;
					}
				}

				//$values_arr[$group[$x]]=$elem->$arrayfield[$group[$x]];

			}

			switch(count($group)){

			case 1:
				$arr[$values_arr[0]]=$elem;
				break;
			case 2:
				$arr[$values_arr[1]][$values_arr[0]]=$elem;
				break;
			case 3:
				$arr[$values_arr[2]][$values_arr[1]][$values_arr[0]]=$elem;
				break;
			case 3:
				$arr[$values_arr[3]][$values_arr[2]][$values_arr[1]][$values_arr[0]]=$elem;
				break;

			default:
				$arr=$elem;
				break;
			}


		}
		return $arr;


}

function view($view,$arr=[]){
    global $context,$request,$SET;

        //echo json_encode($context->user);
        foreach($arr as $key=>$value){
            $$key=$value;
        }
        ob_start();
        include (PATH.'views/'.$view.'.php');
        $content = ob_get_contents();
        ob_end_clean();


        if(in_array('sys_admin',array_getcolumn( $context->user->groups,'groupkey'))) return $content;

        preg_match_all("/<(.*?)>/u",$content,$tags);

        //print_r($tags);
        foreach( $tags[0] As $tag){
            preg_match_all("/(groups)=[\"']?((?:.(?![\"']?\s+(?:\S+)=|[>\"']))+.)[\"']?/u",$tag,$str_groups);

            //print_r($str_groups);

            if(count($str_groups[2])>0){
                $sel_groups=explode(",",$str_groups[2][0]);

                //echo ($str_groups[2][0]);
                //echo ($tag);
                $allow = False;
                foreach($sel_groups as $g){
                    $allow = in_array($g,array_getcolumn( $context->user->groups,'groupkey'));
                    if($allow) break;
                }

                If($allow == False) {
                    $newtag = str_replace($str_groups[0][0],"style='display:none;'",$tag) ;
                    $content = str_replace($tag, $newtag,$content);
                }else{
                    $newtag = str_replace($str_groups[0][0],"",$tag) ;
                    $content = str_replace($tag, $newtag,$content);
                }
            }

        }

         return $content;

    }

    function redirectTo($url,$lang=""){
        if($lang=="") $lang=LANG;
       header('Location:/'.$lang."/".$url);
    }
    function json($type,$message,$result){
       header('Content-Type: application/json');

       //foreach($result as $r)$r->fields=null;

       echo json_encode(compact('type','message','result'),JSON_UNESCAPED_UNICODE);
    }
     function json_success($message,$result=null){
         json("success",$message,$result);
     }
     function json_error($message,$result=null){
         json("error",$message,$result);
     }


    /*function array_getcolumn($array,$column_name)
    {

        return array_map(function($element) use($column_name){echo $column_name; return $element->$column_name;}, $array);

    }
	*/
	function array_getcolumn($array,$column_name,$alldata=true)
    {
		$arr=[];
		foreach($array as $item){
			if(!$alldata){
				if($item->$column_name!='') $arr[]=$item->$column_name;
			}else{
							$arr[]=$item->$column_name;
			}
		}
         return $arr;
		//return array_map(function($element) use($column_name){echo $column_name; return $element->$column_name;}, $array);

    }

    function array_filtercolumn($array,$whr=[])
    {


        $new_array = array_filter($array, function($index)use($array,$whr){
                         if(!is_array($whr)) return;

     	                      foreach($whr as $con){
                                    if(count($con)==3){
                                        $opr=$con[1];
                                        $column_name=$con[0];
                                        $value=$con[2];
                                    }elseif(count($con)==2){
                                        $opr="=";
                                        $column_name=$con[0];
                                        $value=$con[1];
                                    }elseif(count($con)==1){
                                        $opr="=";
                                        $column_name=$con[0];
                                        $value=true;
                                    }
                                    if(is_object($array[$index]->$column_name)){
                                        $field=$array[$index]->$column_name->id;
                                    }else{
                                        $field=$array[$index]->$column_name;
                                    }
                                    switch($opr){
                                    case "=":
                                        if($field!=$value) return false;
                                        break;
                                    case "<":
                                        if(!$field<$value) return false;
                                        break;
                                    case ">":
                                        if(!$field>$value) return false;
                                        break;
                                    case "<=":
                                        if(!$field<=$value) return false;
                                        break;
                                    case ">=":
                                        if(!$field>=$value) return false;
                                        break;
                                    case "like":
                                        if(strpos($value,$field)===false) return false;
                                        break;
                                    case "not like":
                                        if(strpos($value,$field)===true) return false;
                                        break;
                                    case "in":
                                        if(!in_array($field,$value)) return false;
                                        break;
                                    case "not in":
                                        if(in_array($field,$value)) return false;
                                        break;
                                }

                           }


                    return true;

        },ARRAY_FILTER_USE_KEY);

        return array_values($new_array);;

    }





 function GV(){
     global $context;

	    $data=json_encode($context);
	    $data=json_decode($data);

	         foreach($data as $key=>$value){
	             $c_name=$key;

	             if(is_array($value)){
	                 defineArray($c_name,$value);
	             }elseif(is_object($value)){
	                 defineObject($c_name,$value);
	             }else{
	                 define(strtoupper($c_name),$value);
	                   // echo strtoupper($c_name).'='.$value.'</br>';
	             }
	         }


	 return true;
	}

  function defineArray($base_name,$arr){
	    foreach($arr as $key=>$value){
	        $c_name=$base_name."_".$key;

	         if(is_array($value)){
                  defineArray($c_name,$value);
             }elseif(is_object($value)){
                 defineObject($c_name,$value);
             }else{
                  define(strtoupper($c_name),$value);
                //   echo strtoupper($c_name).'='.$value.'</br>';
             }
	    }

	}
 function defineObject($base_name,$obj){
    foreach($obj as $key=>$value){
        $c_name=$base_name."_".$key;
         if(is_array($value)){
          defineArray($c_name,$value);
     }elseif(is_object($value)){
          defineObject($c_name,$value);
     }else{
          define(strtoupper($c_name),$value);
     }
    }

}
function guid(){
    if (function_exists('com_create_guid')){
        return str_replace(['}','{'],'',com_create_guid());
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid =
                substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
         return $uuid;
    }
}
function env($key,$default=''){
  $ini = parse_ini_file(PATH.'.env');
  if($ini[$key]!='') return $ini[$key];
  return $default;
}

function assets($path){
  return "/templates/assets/".$path;
}
function fileds_cmp($a, $b)
{
    return ($a["sequence"]<$b["sequence"])?true:false;
}
function actionLink($action='',$controller='',$data=[]){
  if($controller=='')$controller=str_replace("App\Controllers\\","",CONTROLLER_PATH);
  //if($action=='')$action="index";
  if(array_key_exists('id',$data))$id=$data['id'];
  $qs="";
  foreach($data as $key=>$value){
    if($key!='id'){
        $qs.=($qs==''?'':'&').$key."=".$value;
    }
  }

    return "/".LANG."/".$controller.($action==''?'':"/".$action).($id==''?'':"/".$id).($qs==''?'':'?'.$qs);

}
?>
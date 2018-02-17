<?
namespace Framework;
use \Exception as Exception;
use \PDO as PDO;
use \JsonSerializable as JsonSerializable;

class BLL implements JsonSerializable{
var $tablename;
public $col_pk;
protected $Database;
var $fields;
protected $showDeleted=false;
protected $where_arr;
protected $limit;
protected $offset;
protected $order_arr;
protected $where_values=[];
protected $withSupperUser=false;
private $record = array();

var $error="";
var  $data=array();
var  $relatedField=array();
var $mode="view";

	function __construct(){
		global $Database;
		try{
            $this->Database=$Database;
            if($this->tablename=="") return;
		    $q = $this->Database->prepare("DESCRIBE ".$this->tablename);
            $q->execute();


            $rows = $q->fetchAll();
            foreach($rows as $field)
            {
                 if(!array_key_exists($field['Field'],$this->fields)) {
                     preg_match_all("/\d+/",$field['Type'],$sizes);
                     $visible=true;
                     $serialize=true;
                     if(in_array($field['Field'],['created_at','created_by','updated_at','updated_by','deleted_at','deleted_by','is_deleted'])){
							$visible=false;
						}

			//print_r($field);
                     $this->fields[$field['Field']]=[
	                     				'name'=>$field['Field'],
	                     				'type'=>preg_replace("/\(\d+\)/","",$field['Type']),
	                     				'size'=>$sizes[0][0],
	                     				'default'=>'',
	                     				'visible'=>$visible,
                                        'serialize'=>$serialize,
										 'required'=>$field['Null']=='NO'?true:false,
	                     			    ];
                 }
            }

            foreach($this->fields as $key=>$value)
            {
                if(!$value['type']<>"Many2many" && !$value['type']<>"One2many"){
                    $this->data[$key]=$value['default'];
					$this->fields[$key]['sequence']=0;
                }else{
					$this->fields[$key]['sequence']=555;
				}
                if(!array_key_exists('visible',$value)){
                 	$this->fields[$key]['visible']=true;
                }
                if(!array_key_exists('serialize',$value)){
                    $this->fields[$key]['serialize']=true;
                }
				if(!array_key_exists('required',$value)){
                 	$this->fields[$key]['required']=false;
                }
            }

		}catch(\Exception $ex){
           echo $ex->getMessage();
        }

	}



	public function getPKname(){
		return $this->col_pk;
	}

	public function id(){
		return $this->{$this->col_pk};
	}

	static function model(){
		return get_called_class();
	}
	function field_exists($key){
	    return array_key_exists($key,$this->fields);
	}
	function data_exists($key){
	    return array_key_exists($key,$this->data);
	}
	public function __get($name) {


//print_r($this->data);
        if($this->field_exists($name)){
              switch($this->fields[$name]['type']){
                    case "One2many":
                        if(!$this->relatedField[$name])
                            $this->relatedField[$name]=$this->One2many($this->fields[$name]['relation']['class'],$this->fields[$name]['relation']['classid']);
                        return $this->relatedField[$name];
                        break;
                    case "Many2many":
                        if(!$this->relatedField[$name])
                            $this->relatedField[$name]=$this->Many2many($this->fields[$name]['relation']['class'],$this->fields[$name]['relation']['table'],
                                                                        $this->fields[$name]['relation']['thisid'],$this->fields[$name]['relation']['classid']);
                        return $this->relatedField[$name];
                        break;
                    case "Many2one":
                        if($this->data_exists($name)){
                            if(!$this->relatedField[$name])
                            $this->relatedField[$name]=$this->Many2one($this->fields[$name]['relation']['class'],$name,$this->fields[$name]['relation']['classid']);
                            return $this->relatedField[$name];

                        }else{
                            $TYPE=get_called_class();
                            if(method_exists(get_called_class(),$name)){
                                $this->data[$name]= $this->$name();
                                return $this->data[$name];
                            }
                        }
                        break;
                    case "calculated":
                        $fun=$this->fields[$name]['compute'];
                     
                        if(method_exists(get_called_class(),$fun)){
                            $this->data[$name]=  $this->$fun();
                            return $this->data[$name];
                        }
                       
                        break;
                    default:
                        if($this->data_exists($name)){
                            return $this->data[$name];
                        }else{
                            
                            if(method_exists(get_called_class(),$name)){
                                $this->data[$name]= $this->$name();
                                return $this->data[$name];
                            }
                        }
                        break;
            }
	    }else{
	         $TYPE=get_called_class();
                if(method_exists(get_called_class(),$name)){
                    $this->relatedField[$name]= $this->$name();
                    return $this->relatedField[$name];
                }
	    }
	   //  return  $this->data[$name];
	}
	public function __set($name, $value) {
	    $this->data[$name] = $value;
	}

	function insert(){

		global $context;
		// Get class name
		$TYPE=get_called_class();

		if(!$this->withSupperUser){
			if(!$context->user || !$context->user->allow($TYPE,"add")){
				$this->error="403 Not Authorized !";
				throw new \Exception("403 Not Authorized !");
			}
		}
		try{
    		$fields_statment="";
    		$values_statment="";
    	    $values=[];
    	    if($this->field_exists('created_by')){
    	        $this->data['created_by']=intval($context->userid);
    	    }
    	     if($this->field_exists('created_at')){
    	        $this->data['created_at']=Date("Y-m-d H:i:s");
    	    }
    		foreach($this->fields as $key=>$value){
              if(!in_array($value['type'],['One2many','Many2many','calculated'] ) && !in_array($key,['updated_at','updated_by','deleted_at','deleted_by','is_deleted']) && $this->data_exists($key)){
					if($key!=$this->col_pk){
            			$fields_statment.=(($fields_statment=="")?"":",")."`".$key."`";
            			$values_statment.=(($values_statment=="")?"":",").":".$key;
            			$values[":".$key]=$this->data[$key];
    		        }
    		    }
    		}
     		$query=$this->Database->prepare("insert into `$this->tablename` ($fields_statment) values($values_statment);");
      		$query->execute($values);
    		$this->error=$query->errorInfo()[2];
    		$this->data[$this->col_pk]=intval($this->Database->lastInsertId());

    		return $this->data[$this->col_pk]>0?true:false;
		}catch(Exception $ex){
			$this->error=$ex->getMessage();
		}
	}

	function update(){
		global $context;
		// Get class name
		$TYPE=get_called_class();
		if(!$this->withSupperUser){
			if(!$context->user || !$context->user->allow($TYPE,"edit")){
				$this->error="403 Not Authorized !";
				throw new \Exception("403 Not Authorized !");
			}
		}
		try{
    		$set_statment="";

    	    $values=[];

    	    if($this->field_exists('updated_by')){
    	        $this->data['updated_by']=$context->userid;
    	    }
    	     if($this->field_exists('updated_at')){
    	        $this->data['updated_at']=Date("Y-m-d H:i:s");
    	    }

    		foreach($this->fields as $key=>$value){
              if(!in_array($value['type'],['One2many','Many2many','calculated'] ) && !in_array($key,['created_at','created_by','deleted_at','deleted_by','is_deleted']) && $this->data_exists($key)){
    		        if($key!=$this->col_pk){
            			$set_statment.=(($set_statment=="")?"":",")."`".$key."`=:".$key;
            			$values[":".$key]=$this->data[$key];
    		        }
    		    }
    		}

    		$values[":".$this->col_pk]=$this->data[$this->col_pk];
			//echo $set_statment;
    		$query=$this->Database->prepare("update `$this->tablename` set $set_statment where {$this->col_pk}=:{$this->col_pk}");
			$result= $query->execute($values);

			$this->error=$query->errorInfo()[2];
			return $result;


		}catch(\Exception $ex){
			$this->error=$ex->getMessage();
		}
	}
	function delete(){
		global $context;
		// Get class name
		$TYPE=get_called_class();
		if(!$this->withSupperUser){
			if(!$context->user || !$context->user->allow($TYPE,"delete")){
				$this->error="403 Not Authorized !";
				throw new \Exception("403 Not Authorized !");
			}
		}
         if($this->field_exists('is_deleted')){
    	        $this->data['is_deleted']=1;
    	         $values[':'.$this->col_pk]=$this->data[$this->col_pk];
    	         $values[':is_deleted']=1;
    	         $set_statment='is_deleted=:is_deleted';

	            if($this->field_exists('deleted_by')){
        	        $this->data['deleted_by']=$context->userid;
        	        $values[':deleted_by']=$context->userid;
    	            $set_statment.=',deleted_by=:deleted_by';
        	    }
    	        if($this->field_exists('deleted_at')){
        	        $this->data['deleted_at']=Date("Y-m-d H:i:s");
        	         $values['deleted_at']=Date("Y-m-d H:i:s");
        	         $set_statment.=',deleted_at=:deleted_at';
        	    }

             $query=$this->Database->prepare("update `$this->tablename` set $set_statment where {$this->col_pk}=:{$this->col_pk}");
            // echo "update `$this->tablename` set $set_statment where {$this->col_pk}=:{$this->col_pk}";
            // print_r($values);

    		 $result= $query->execute($values);
			 $this->error=$query->errorInfo()[2];
			 return $result;
         }else{
    	     return  $this->destroy();
    	 }
	}
	function restore(){
		global $context;
		// Get class name
		$TYPE=get_called_class();
		if(!$this->withSupperUser){
			if(!$context->user || !$context->user->allow($TYPE,"delete")){
				$this->error="403 Not Authorized !";
				throw new \Exception("403 Not Authorized !");
			}
		}
         if($this->field_exists('is_deleted')){
    	         $this->data['is_deleted']=0;
    	         $values[':'.$this->col_pk]=$this->data[$this->col_pk];
    	         $values[':is_deleted']=0;
    	         $set_statment='is_deleted=:is_deleted';


             $query=$this->Database->prepare("update `$this->tablename` set $set_statment where {$this->col_pk}=:{$this->col_pk}");
            // echo "update `$this->tablename` set $set_statment where {$this->col_pk}=:{$this->col_pk}";
            // print_r($values);
    		$result= $query->execute($values);
			 $this->error=$query->errorInfo()[2];
			 return $result;
         }else{
    	     return  $this->destroy();
    	 }
	}

	function destroy(){
		global $context;
		// Get class name
		$TYPE=get_called_class();
		if(!$this->withSupperUser){
			if(!$context->user || !$context->user->allow($TYPE,"delete")){
				$this->error="403 Not Authorized !";
				throw new \Exception("403 Not Authorized !");
			}
		}

	    $values[":".$this->col_pk]=$this->data[$this->col_pk];

		try{
    		$query=$this->Database->prepare("delete from `$this->tablename` where {$this->col_pk}=:{$this->col_pk}");

    		$result= $query->execute($values);
			 $this->error=$query->errorInfo()[2];
			 return $result;

		}catch(Exception $ex){
			$this->error=$ex->getMessage();
		}
	}

	function Many2many($class,$intertable,$foraginkey='',$classid='',$where=null){
	    $interClass=new $intertable;

		if($foraginkey=='')$foraginkey=$this->tablename."_id";
		$t=new $class;

		if($classid=='')$classid=$t->tablename."_id";
         $rows= $t->where($t->col_pk,'in_query' ,"select $classid from {$interClass->tablename} where $foraginkey='".$this->{$this->col_pk}."'")->supperUser()->get();
        if($where!=null)$t->where($where);
	    //   if(!$rows) $rows=[$t];
	     // echo $t->tablename,$classid ,$foraginkey,"\n\r";
		return $rows;


	}
	function One2many($class,$classid='',$thisid='',$where=null){
		if($thisid=='')$thisid=$this->col_pk;
		$t=new $class;

		if($classid=='')$classid=$t->tablename."_id";
		 if($where!=null)$t->where($where);
		$rows= $t->where($classid ,$this->$thisid)->supperUser()->get();

		return $rows;

	}

	function Many2one($class,$foraginkey='',$classid='',$where=null){
		if($foraginkey=='')$foraginkey=$this->tablename."_id";
		$t=new $class;

		if($classid=='')$classid=$t->tablename."_id";

		$TYPE=get_called_class();
    if($where!=null)$t->where($where);

   		$rows= $t->where($classid,$this->data[$foraginkey])->limit(1)->supperUser()->get();
		
		return $rows[0];

	}



	static function select_where_static($whr=""){
		global $user;
		// Get class name
		$TYPE=get_called_class();
		/*if(!$user->allow($TYPE,"view")){
			throw new Exception("403 Not Authorized !");
		}*/
		$d=new $TYPE;
		$db =new Database();
		$rows=$db->query("select * from `$d->tablename` ".$whr);
		//$query=$db->result;
		$returned=array();
	   //   echo "select * from `$d->tablename` ".$whr;
		if(!$rows)return $returned;
		foreach($rows as $row){
			//Get dynamic object from class name
			$obj =new $TYPE;

			$obj->data=array();

			foreach($row as $key=>$value)
			    if(!is_numeric($key)){
			        $obj->$key=$value;
			        $obj->mode='view';
			    }
			//print_r($obj);
			$returned[]=$obj;
		}
		$rows=null;
		$db=null;
		return $returned;
	}



	function where(){
	    $args = func_get_args();
	    if(!is_array($args)) return;

	    if(is_array($args[0])){
    	    foreach($args as $con){
    	         $this->where_arr[]=$con;
            }
	    }else{
	         $this->where_arr[]=$args;
	    }
           return $this;
	}
	function withDeleted(){
		if($this->field_exists('is_deleted')){
	       $this->showDeleted=true;
	   }
	   return  $this;
	}
	function supperUser(){

	       $this->withSupperUser=true;

	   return  $this;
	}
	function limit(){
	     $args = func_get_args();
	    $this->limit=$args[0];
	    if(count($args)==2)$this->offset=$args[1];
        return $this;
	}

	function orderBy(){
	    $args = func_get_args();
	    if(!is_array($args)) return;
	    if(is_array($args[0])){
    	    foreach($args as $con){
    	         $this->order_arr[]=$con;
            }
	    }else{
	         $this->order_arr[]=$args;
	    }
	   
           return $this;
	}

	function exists_where($key){
	      if(in_array($key,$this->where_arr)){
                    return true;
            }
	     foreach($this->where_arr as $arr){
	       //   print_r($arr);
	         if(is_array($arr)){
                if(in_array($key,$arr)){
                    return true;
                }
	         }else{
	             if($key==$arr){
                    return true;
                }
	         }
        }
         return false;
	}
	function get(){
	    global $context;
	    $TYPE=get_called_class();

		if(!$this->withSupperUser){
		   if(!$context->user) throw new Exception("401 Access Denied !");
 		   if(!$context->user->allow($TYPE,"view")) throw new Exception("403 Not Authorized !");
            
            //print_r($context->user);
            $filter= $context->user->allowfilter($TYPE,'view');

 			if($filter){
				foreach($filter as $fltr){
					eval("\$whrfilter = $fltr;");
					if(is_array($whrfilter[0])){
						foreach ($whrfilter as $itm) {
							$this->where($itm);
						}
					}else{
						$this->where($whrfilter);
					}
				}



            }
        }

        if(!$this->exists_where('is_deleted')){
    	    if(!$this->showDeleted && array_key_exists('is_deleted',$this->fields)){
               $this->where('ifnull(is_deleted,0)',0);
            }
        }



	    $str_whr=$this->addWhere();
	    $str_order=$this->addOrder();

  		$stmt=$this->Database->prepare("select * from `$this->tablename` ".($str_whr==""?"":" where ".$str_whr).
  		                            ($str_order==""?"":" order by ".$str_order).
  		                            ($this->limit==""?"":" limit ".$this->limit.($this->offset==""?"":",".$this->offset)));
  		                            
  		                             /*echo "select * from `$this->tablename` ".($str_whr==""?"":" where ".$str_whr).
  		                            ($str_order==""?"":" order by ".$str_order).
  		                            ($this->limit==""?"":" limit ".$this->limit.($this->offset==""?"":",".$this->offset)); */
  	    if(! $stmt->execute($this->where_values)){
					// echo $this->tablename , ":",$stmt->errorInfo()[2];
				}
  		$rows = $stmt->fetchAll();
		//$query=$db->result;
		 $returned=array();
        //return $rows;
		 if(!$rows)return $returned;

		foreach($rows as $row){
			//Get dynamic object from class name
			$obj =new $TYPE;

			$obj->data=array();

			foreach($row as $key=>$value)
			    if(!is_numeric($key)){
			        $obj->$key=$value;
			        $obj->mode='view';
			    }
			 //print_r($obj);
			$returned[]=$obj;
		}

		return $returned;


		}



	function addWhere(){
	    if(count($this->where_arr)==0)return "";
	    foreach($this->where_arr as $con){
	            if(is_array($con[0])){
	                $sub_where="(";
    	             foreach($con as $cond){
    	                  $sub_where.=($sub_where=="("?"":" and ").$this->addWhereItem($cond);
    	             }
    	              $sub_where.=")";
    	              $str_whr.=($str_whr==""?"":" and ").$sub_where;
    	        }else{
    	            $str_whr.=($str_whr==""?"":" and ").$this->addWhereItem($con);
    	        }


	    }
	 
	    return $str_whr;

	}
	function addWhereItem($con){
	    $str_whr="";
	     if(count($con)==1){
    	            $str_whr.=($str_whr==""?"":" and ").$con[0]."=?";
    	            $this->where_values[]=1;
    	        }

    	        if(count($con)==2){
    	            $str_whr.=($str_whr==""?"":" and ").$con[0]."=?";
    	            $this->where_values[]=$con[1];
    	        }

    	        if(count($con)==3){
    	            if($con[1]=='like' || $con[1]=='not like'){
    	                $w=$con[0].' '.$con[1].' ?';
    	                 $this->where_values[]="%".$con[2]."%";
    	            }
    	            else if($con[1]=='llike'){
    	                $w=$con[0].' like ?';
    	                 $this->where_values[]=$con[2]."%";
    	            }
    	            else if($con[1]=='rlike' ){
    	                $w=$con[0].' like ?';
    	                 $this->where_values[]="%".$con[2];
    	            }
    	            else if($con[1]=='in' || $con[1]=='not in'){
    	                 $w=json_encode($con[2]);
    	                 $w=str_replace("[","(",$w);
    	                 $w=str_replace("]",")",$w);
    	                $w=$con[0].' '.$con[1].' '.$w;
    	            }
    	           else if($con[1]=='in_query'){
    	               $w=$con[0].' in ('.$con[2].')';}
    	           else if($con[1]=='not in_query'){
    	               $w=$con[0].' not in ('.$con[2].')';
    	           }else{

    	                $w=$con[0].' '.$con[1].'?';
    	                $this->where_values[]=$con[2];
    	           }



    	            $str_whr.=($str_whr==""?"":" and ").$w;
    	        }
    	        return $str_whr;
	}
	function addOrder(){
	    if(count($this->order_arr)==0)return "";
	    foreach($this->order_arr as $order){
    	        if(count($order)==1){
    	            $str_order.=($str_order==""?"":" ,").$order[0];
    	        }

    	        if(count($order)==2){
    	            $str_order.=($str_order==""?"":" , ").$order[0]." ".$order[1];
    	        }
	    }
	   
        return $str_order;
	}
	static function find($id,$supperUser=false){
		$TYPE=get_called_class();
		$data=new 	$TYPE;
		
		if(!$supperUser){
			if(!$context->user || !$context->user->allow($TYPE,"view")){
				$data->error="403 Not Authorized !";
				throw new \Exception("403 Not Authorized !");
			}
		}else{
			$data->withSupperUser=true;
		}
		
 		$list=$data->where($data->col_pk,$id)->get();
		
		return $list[0];
	}


	// From JsonSerializable
    public function jsonSerialize(){
        global $context;

        foreach($this->fields as $key=>$value) {
            
            
            if($value['serialize'] ){
                $hash=(get_class($this)."(".$this->data[$this->col_pk].")"."->".$key);//$value['relation']['class']."->".$key."(".$this->data[$this->col_pk].")";//$value['relation']['class']."->".$key."(".$this->data[$this->col_pk].")";
 
                if (!in_array($hash,$context->SERIALIZED_OBJECTS)) {//if (!isset($this->record[$hash])) {//
                     
                     $context->SERIALIZED_OBJECTS[]=$hash;
                     $this->$key;
                     if($context->request->UseApi() && in_array($value['type'],['One2many','Many2many'])){
                         $this->{$key."_count"}=count($this->relatedField[$key]);
                         $this->relatedField[$key]=null;
                     }
                     if($context->request->UseApi() && in_array($value['type'],['Many2one'])){
                         $this->relatedField[$key]=$this->data[$key];
                     }
                }
            }
            else{
                 $this->data[$key]=null;
                 $this->relatedField[$key]=null;
            }


        }

        $newarray=array_merge($this->data,$this->relatedField);
        array_walk_recursive($newarray,function(&$val){
            $val = $val;
        });


        return $newarray;
    }

    static function query($sql){
		
 		// Get class name 
		$TYPE=get_called_class();
		$d=new $TYPE;
		if(!$sql)return $returned;
        $stmt=$d->Database->prepare($sql);
		
        if(! $stmt->execute()){
              echo $stmt->errorInfo()[2];
            

        }
        $rows = $stmt->fetchAll();
         $returned=array();
        //return $rows;
        if(!$rows)return $returned;

		foreach($rows as $row){
			//Get dynamic object from class name
			$obj =new $TYPE;

			$obj->data=array();

			foreach($row as $key=>$value)
			    if(!is_numeric($key)){
			        $obj->$key=$value;
			        $obj->mode='view';
			    }
            //print_r($obj);
			$returned[]=$obj;
		}

		return $returned;


	}

	function DrawField($field,$widget="",$mode="",$attrs=[]){
	    global $context;
        if($mode=="")$mode=$this->mode;
       
        if($widget==""){
            // Default widget
            if(in_array($this->fields[$field]['type'],['Many2one','Boolean'])){
                $widget='combo';
            }elseif($this->fields[$field]['type']=='Many2many'){
                $widget='checklist';
            }elseif($this->fields[$field]['type']=='One2many'){
                $widget='table';
            }elseif($this->fields[$field]['type']=='date'){
                $widget='date';
            }elseif($this->fields[$field]['type']=='datetime'){
                $widget='datetime';
            }else{
                $widget='text';
            }
        }
        
		
        switch($mode){
            case "edit":
            case "add":
               
                if(array_key_exists('class',$attrs)){$attrs['class'].=' form-control';}else{$attrs['class'].=' form-control ';}
                if(in_array($this->fields[$field]['type'],["Many2many" ,"One2many"])){
                     ?>
                         <table class="table table-bordered">
                             <tr><td>ID</td><td>Name</td></tr>
                            <?foreach($this->$field as $itm){?>
                                    <tr><td><?=$itm->data[$itm->col_pk]?></td><td><?=$itm->name?></td></tr>
                            <?}?>
                         </table>
                     <?
                }elseif($this->fields[$field]['type']=="Many2one" ){
                    
                    switch($widget){
                        default:

                        case 'combo':
                            
                            ?>

                            <select  name="<?=$field?>" <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>     <?if($this->fields[$field]['required']){?> required <?}?>>
															<option value="0">Select One..</option>
                                <?$class=$this->fields[$field]['relation']['class'];
                                    $class=new $class;
                                    $classid=$this->fields[$field]['relation']['classid'];
                                    if($this->fields[$field]['relation']['where']){
                                        $class->where($this->fields[$field]['relation']['where']);
                                    }
                                   
                                foreach($class->supperUser()->get() as $itm){?>
                                    <option value="<?=$itm->$classid?>" <?if($itm->$classid==$this->data[$field]){?>selected<?}?>><?=$itm->name?></option>
                                <?}?>
                            </select>

                            <?
                         
                            break;

                    }
                 }elseif(in_array($this->fields[$field]['type'],["Boolean","tinyint"])){
                    switch($widget){
                        default:
                        case 'combo':?>
                            <select name="<?=$field?>" <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>  <?if($this->fields[$field]['required']){?> required <?}?>>
                                    <option value="0" <?if($this->data[$field]==0){?>selected<?}?>>No</option>
                                    <option value="1" <?if($this->data[$field]==1){?>selected<?}?>>Yes</option
                            </select>

                            <?break;

                    }
                }elseif($this->fields[$field]['type']=="int unsigned"){
                    switch($widget){
                        default:
                            ?>
                            <?=($this->data[$field]>0)?$this->data[$field]:'(New ID)'?> <input type="hidden" name="<?=$field?>" value="<?=$this->data[$field]?>"/>
                            <?
                            break;

                    }

                }else{
                    if($this->fields[$field]['size']>=500 || in_array($this->fields[$field]['type'],['text','longtext'])){
                     ?>
                        <textarea  name="<?=$field?>"  <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>  <?if($this->fields[$field]['required']){?> required <?}?>><?=$this->data[$field]?></textarea>
                     <?
                    }elseif(in_array($this->fields[$field]['type'],['timestamp','datetime','date'])){

                     //if(array_key_exists('class',$attrs)){$attrs['class'].=' date';}else{$attrs['class'].=' datetime ';}
                     ?>
                       <input type="date" name="<?=$field?>" value="<?=$this->data[$field]?>"  <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>  <?if($this->fields[$field]['required']){?> required <?}?>/>
                     <?
                    }else{
                    ?>
                        <input type="text" name="<?=$field?>" value="<?=$this->data[$field]?>" <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>  <?if($this->fields[$field]['required']){?> required <?}?>/>
                     <?

                    }

                }
                break;
            default:
                if($this->fields[$field]['type']=='Many2one'){
                
                ?>
                        <a target="_blank" class="open-modal" href="/<?=LANG?>/<?=$this->fields[$field]['relation']['controller']?>/item/<?=$this->$field->id?>" <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>><?=$this->$field->name?></a>
                <?
                }elseif($this->fields[$field]['type']=='One2many'){
                     if(array_key_exists('class',$attrs)){$attrs['class'].=' btn-link ';}else{$attrs['class'].=' btn-link ';}
                    ?>
                    <form target="_blank" action="/<?=LANG?>/<?=$this->fields[$field]['relation']['controller']?>/search" method="post" >
                        <?=\Framework\Request::CSRF();?>
                        <input type="hidden" name="filter[]" value="<?=$this->fields[$field]['relation']['classid']?>" />
                        <input type="hidden" name="value[]" value="<?=$this->{$this->col_pk}?>" />
                        <input type="submit" name="" value="<?=count($this->$field)?>" <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>/>
                    </form>
                     <?
                }elseif( $this->fields[$field]['type']=='Many2many'){
                    switch($widget){
                        default:
                        case "tags":
                                  foreach($this->$field as $itm){?>
                                <span class="label label-warning"><?=$itm->name?></span>
                             <?}
                            break;

                       case "link":
                            if(array_key_exists('class',$attrs)){$attrs['class'].=' btn-link ';}else{$attrs['class'].=' btn-link ';}
                            ?>
                              <form target="_blank" action="/<?=LANG?>/<?=$this->fields[$field]['relation']['controller']?>/search" method="post" >
                                    <?=\Framework\Request::CSRF();?>
                                    <input type="hidden" name="filter[]" value="<?=$this->fields[$field]['relation']['classid']?>" />
                                    <input type="hidden" name="value[]" value="<?=$this->{$this->col_pk}?>" />
                                    <input type="hidden" name="relation[]" value="<?=$this->fields[$field]['relation']['table']?>.<?=$this->fields[$field]['relation']['thisid']?>" />
                                    <input type="submit" name="" value="<?=count($this->$field)?>" <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>/>
                               </form>

                              <?
                            break;
                        }
                }elseif(in_array($this->fields[$field]['type'],["Boolean","tinyint"])){
                    switch($widget){
                        default:
                                   if($this->data[$field]==0){
                                       ?>
                                     <span <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>>
                                       No
                                       </span>  <?
                                   }
                                   if($this->data[$field]==1){
                                        ?>
                                     <span <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>>
                                       Yes
                                       </span>  <?
                                   }

                             break;

                    }
                }elseif($this->fields[$field]['type']=="int unsigned"){
                    switch($widget){
                        default:
                            ?>
                            <?=($this->data[$field]>0)?$this->data[$field]:'(New ID)'?>
                            <?
                            break;

                    }
                }else{?>
                 <span <?foreach($attrs as $key=>$attr){?><?=' '.$key.'="'.$attr.'" '?><?}?>>
                        <?=$this->$field?>
                        </span>
                <?}
                break;

        }


	}
}


trait NotifyModel {


    public function Notify() {
         $TYPE=get_called_class();

        echo $TYPE . ' Was Notified!';
    }
}


trait ApprovelModel {
    //protected $workflowSteps=1;
    function __construct(){
        $this->fields['approval_request']=['name'=>'approval_request',
                                       'type'=>'int',
                                       'serialize'=>true,
                                       'visible'=>false,
                                       ];
        $this->fields['approval_at']=['name'=>'approval_at',
                                       'type'=>'datetime',
                                       'serialize'=>true,
                                       'visible'=>false,
                                       ];
        $this->fields['approval_by']=['name'=>'approval_by',
                                       'type'=>'int',
                                       'serialize'=>true,
                                       'visible'=>false,
                                       ];
        parent::__construct();
    }
   
  
     function approve() {
         global $context;
         $this->approval_by=intval($context->user->id);
		 $this->approval_request=1;
		 $this->approval_at=Date("Y-m-d H:i:s");

		 if($this->update()){
            return  $this->onApproved();
         }else{
             return false;
         }
         return true;
    }
	function reject() {
        global $context;
		$this->approval_by=intval($context->user->id);
		$this->approval_request=0;
		$this->approval_at=Date("Y-m-d H:i:s");
        if($this->update()){
            return $this->onRejected();
        }else{
            return false;
        }
        return true;
    }
    function insert() {
        global $context;
        
        $this->approval_request=-1;
        $this->approval_by=0;

       if(!parent::insert()){
           return false;
       }
       
        $approve_request=new \App\Models\Notify\Waitinglist;
        $approve_request->userId=intval($context->user->id);
        $approve_request->model_name=$this->model;
        $approve_request->model_id=$this->id;
        $approve_request->is_done=-1;
        
        if(!$approve_request->supperUser()->insert()){
            $this->error=$approve_request->error;
            
            return false;
        }
       
        return true;
    }

    function onApproved(){return true;}
    function onRejected(){return true;}
}


?>
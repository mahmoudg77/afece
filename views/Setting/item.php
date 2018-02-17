<tr><input type='hidden' name='IDs[]' value="<?=$setting->id?>"/>
<td width="180px;"  class='xtr'> <?=$setting->name?></td>
<td class='xtd'> 
 
   <?if($setting->type==1){?>
        <input class="form-control" type="text" name="value[]" value="<?=$setting->value?>"/>  
   <?}elseif($setting->type==2){?>
       <input    type="text" class="date form-control" name="value[]"  value="<?=$setting->value?>" />  
   <?}elseif($setting->type==3){?>
      <select  class="form-control"   name="value[]"  >  
      <option value="Yes" <?=(( $setting->value=="Yes")?"selected":"")?>>Yes</option>
      <option value="No" <?=(( $setting->value=="No")?"selected":"")?>>No</option>
      </select>
   <?}elseif($setting->type==4){
         $avs=null;
         if(strrpos($setting->availables,"{")===false){
             foreach(explode("|",$setting->availables) as $i){
                 $avs[]=array("key"=>$i,"value"=>$i);
             }
         }else{
             $sql="select ".str_replace("}","", str_replace("{","",$setting->availables));

              
             //$qry=Bll::query($sql);
             foreach(\Framework\Bll::query($sql) as $rec){
                 $avs[]=array("key"=>$rec->data['id'],"value"=>$rec->data['name']);
                 
             }
         }
   ?>
      <select  class="form-control" name="value[]"  >  
   <?foreach($avs as $i){?>
	      <option <?=(( $setting->value==$i['key'])?"selected":"")?> value="<?=$i['key']?>"><?=$i['value']?></option>
   <?}?>
      </select>
      
   <?}elseif($setting->type==5){
         if(strrpos($setting->availables,"{")===false){
             foreach(explode("|",$setting->availables) as $i){
                 $avs[]=array("key"=>$i,"value"=>$i);
             }
         }else{
             $sql="select ".str_replace("}","", str_replace("{","",$setting->availables));
             
             $qry=mysql_query($sql);
             while($rec=mysql_fetch_array($qry)){
                 $avs[]=array("key"=>$rec[0],"value"=>$rec[1]);
             }
             
         }
   ?>
      <ul id="chks_<?=$r[id]?>"  >  
   <?foreach($avs as $i){?>
	<li class="checkbox">
               <label>
                   <input <?=(( $setting->value==$i['key'])?"checked":"")?> name="chks_<?=$r[id]?>[]"   value="<?=$i['key']?>" type="checkbox">
                    <span class="text"><?=$i['value']?></span> 
                </label>
 
		</li>
		
		
 
	<?}?>
   </ul>
   <?}elseif($setting->type==6){
         $d=date("Y-m-d H:i:s");
   ?>
       <input   readonly type="text" class="form-control" name="value[]" value="<?=$d?>" /> 
      <?}elseif($setting->type==7){?>
       <textarea class="form-control" name="value[]" ><?=  $setting->value ?></textarea>  
     <?}elseif($setting->type==8){
         
     ?>

       <textarea class="form-control editor" id="textarea_<?=$setting->id?>" name="value[]" ><?=  $setting->value ?></textarea>  
		
    <?}?>
 
 </tr>
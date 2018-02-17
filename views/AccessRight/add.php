<?if(!$request->isAjax())include(PATH.'templates/cpheader.php');?>



     <form action="<?=actionLink('add')?>" method="post" class="ajax-form">
         <?=Framework\Request::CSRF()?>
        <table class="table" >
        	 <tr><td>Group :</td><td><?$data->DrawField("groupid")?></td></tr>
         <tr><td>Model :</td><td>
             <select name="model_name" class="form-control">
                 <?
                 $namespacess=[];
                 foreach(Framework\Models::all() as $model){
                     $split=explode("\\",$model->name);
                     $fullname='';
                     for($i =0 ;$i<count($split)-1;$i++){
                         $fullname.=($fullname==""?"":"\\").$split[$i];
                         if(!in_array($fullname."\*",$namespacess)) $namespacess[]=$fullname."\*";
                     }
                 }
                  foreach($namespacess as $space){
                     ?>
                        <option value="<?=$space?>" <?if($space==$data->model){?> selected<?}?>><?=$space?></option>
                     <?}?>
                 <?foreach(Framework\Models::all() as $model){?>
                    <option value="<?=$model->name?>" <?if($model->name==$data->model){?>selected<?}?>><?=$model->name?></option>
                 <?}?>
             </select>

             </td></tr>
        	 <tr><td>Type :</td><td><?$data->DrawField("accesstype")?></td></tr>
         <tr><td>Filter :</td><td>
        	<?=$data->DrawField("filter")?>
	 </td></tr>

            <tr><td></td><td>
                <input type="hidden" name="id" value="<?=$data->id?>"/>

            <input class="btn btn-success" type="submit" value="Save"/></td></tr>
        </table>
     </form>


<?if(!$request->isAjax())include(PATH.'templates/cpfooter.php');?>

<?if(!$request->isAjax())include(PATH.'templates/cpheader.php');?>

     <form action="<?=actionLink('edit')?>" method="post" class="ajax-form">
         <?=Framework\Request::CSRF()?>
        <table class="table" > 
        	 <tr><td>Group :</td><td><?$data->DrawField("groupid")?></td></tr>
         <tr><td>Model :</td><td>
            <select name="model_name" class="form-control">
                 
                 <?foreach(Framework\Models::all() as $model){?>
                    <option value="<?=$model->id?>" <?if($model->id==$data->model_name){?>selected<?}?>><?=$model->name?></option>
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

<?if(!$request->isAjax())include(PATH.'templates/header.php');?>
      <table class="table">
        <?foreach($data->data as $key=>$value){if($data->fields[$key]['visible']){?>
            <tr><td><?=ucwords(str_replace("_"," ",$key))?> :</td><td><?=$data->DrawField($key,'','',['style'=>'color:blue','data-id'=>$key])?></td></tr>
        <?}}?>
        
          <?if(!$context->controller->authRequired || ($context->user!=null &&  $context->user->allow($data->model,"edit"))){?>
          <tr><td></td><td> 
            <a class="btn btn-default open-modal" href="<?=actionLink('edit','',['id'=>$data->{$data->col_pk}])?>">Edit</a>
            </td></tr>
          <?}?>
    </table>

 


<?if(!$request->isAjax())include(PATH.'templates/footer.php');?>
<?if(!$request->isAjax())include(PATH.'templates/header.php');?>

      <form action="<?=actionLink('edit')?>" method="post" class="ajax-form">
       <?=Framework\Request::CSRF()?>
       	<input type="hidden" value="<?=$data->id?>" name="<?=$data->col_pk?>"/>
        <table class="table" >
             <tr><td>Title :</td><td>
                    <?$data->DrawField("title")?>
                    </td>
             </tr>
             <tr><td>Description:</td><td>
                    <?$data->DrawField("description")?>
                    </td>
             </tr>
             <tr><td>Body:</td><td>
                    <?$data->DrawField("body","editor")?>
                    </td>
             </tr>
              <tr><td>Category:</td><td>
                    <?$data->DrawField("category_id")?>
                    </td>
             </tr>
            <?if(!$context->controller->authRequired || ($context->user!=null &&  $context->user->allow($data->model,"edit"))){?>
            <tr><td></td><td><input class="btn btn-success" type="submit" value="Save"/></td></tr>
            <?}?>
        </table>
     </form>


 


<?if(!$request->isAjax())include(PATH.'templates/footer.php');?>
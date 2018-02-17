<?if(!$request->isAjax())include(PATH.'templates/header.php');?>

 

              <form action="<?=actionLink('add')?>" method="post" class="ajax-form">
                 <?=Framework\Request::CSRF()?>
                <table class="table" >
                    <?foreach($data->fields as $key=>$field){if($field['visible']){?>
                        <?if($field!=$data->col_pk){?>
                              <tr><td><?=ucwords(str_replace("_"," ",$field['name']))?> :</td><td>
                                  <?
                                  $data->DrawField($key)?>
                                  </td></tr>
                        <?}?>
                    <?}}?>
                    <?if(!$context->controller->authRequired || ($context->user!=null &&  $context->user->allow($data->model,"add"))){?>
                    <tr><td></td><td><input class="btn btn-success" type="submit" value="Save"/></td></tr>
                    <?}?>
                </table>
             </form>

 


 <?if(!$request->isAjax())include(PATH.'templates/footer.php');?>
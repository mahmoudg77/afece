<?if(!$request->isAjax())include(PATH.'templates/header.php');?>


     <form action="<?=actionLink($data->id>0?'edit':'add','Users')?>" method="post" class="ajax-form">
       <?=Framework\Request::CSRF()?>
        <table class="table" >
            <tr>
                <td>Profile :</td>
                <td>
                    <?$data->DrawField('accid')?>
                </td>
            </tr>
            <tr>
                <td>Name :</td>
                <td><?$data->DrawField('name')?></td>
            </tr>
            <tr>
                <td>Email  :</td>
                <td>
                    <?$data->DrawField('email')?>
                </td>
            </tr>
            <tr>
                <td>Password :</td>
                <td>
                    <input type="password" name="password" value="" />
                </td>
            </tr>
            <tr>
                <td>Confirm Password :</td>
                <td>
                    <input type="password" name="cpassword" value="" />
                </td>
            </tr>
            <!--<input type="hidden" name="accid" value="<?=$data->accid->id?>" />-->

            <?$data->DrawField('id')?>
            
            <tr><td></td><td><input class="btn btn-success" type="submit" value="Save"/></td></tr>
        </table>
     </form>

<?if(!$request->isAjax())include(PATH.'templates/footer.php');?>
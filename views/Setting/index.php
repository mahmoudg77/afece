<?if(!$request->isAjax())include(PATH.'templates/header.php');?>




<style>
    .borderless td, .borderless th, .borderless tr {
        border: none !important;
    }
</style>
                     <?if($groups){?>
                    <h4 style="background-color:#485158;padding:10px;color:#fff;">
                        <i class="fa fa-tasks fa-fw"></i><?=$groups[0]->setting_group?>
                    </h4>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#all_setting">
                                *
                            </a>
                        </li>
                        <?foreach($Languages as $language){?>
                        <li>
                            <a data-toggle="tab" href="#<?=$language->shortcut?>_setting">
                                <?=$language->name?>
                            </a>
                        </li>
                        <?}?>

                    </ul>

                    <div class="tab-content">

                        <div id="all_setting" class="tab-pane fade  in active">
                            <form method='POST' action="<?=actionLink("index","Setting")?>" class='ajax-form' enctype="application/x-www-form-urlencoded">
                                <?Framework\Request::CSRF()?>
                                <table class='table borderless' width='100%' id='AutoNumber15'>
                                    <?foreach(array_filtercolumn($groups,[["lang",'*']]) as $setting){
                                          echo view("Setting/item",compact('setting'));
                                      }?>
                                    <tr>
                                        <td width='100%' colspan='2' class='xtt' align='center'>
                                            <input type='submit' name="save" class='btn btn-success'
                                                value="Save" />
                                        </td>
                                    </tr>
                                </table>

                            </form>
                        </div>
                        <?foreach($Languages as $language){?>
                        <div id="<?=$language->shortcut?>_setting" class="tab-pane fade">
                            <form method='POST' action="<?=actionLink("","Setting")?>"  class='ajax-form' enctype="application/x-www-form-urlencoded">
                                <?Framework\Request::CSRF()?>
                                <table class='table borderless'>
                                    <?foreach(array_filtercolumn($groups,[["lang",$language->shortcut]]) as $setting){
                                          echo view("Setting/item",compact('setting'));
								 }?>
                                    <tr>
                                        <td width='100%' colspan='2' class='xtt' align='center'>
                                            <input type='submit' name="save" class='btn btn-success'
                                                value="Save" />
                                        </td>
                                    </tr>
                                </table>

                            </form>

                        </div>

                        <?}?>

                    </div>

                    <?}else{?>

                    <h6>
                        There are no record 
                    </h6>
                    <?}?>
 
<?if(!$request->isAjax())include(PATH.'templates/footer.php');?>
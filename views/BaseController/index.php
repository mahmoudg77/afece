<?if(!$request->isAjax())include(PATH.'templates/header.php');?>
 
<center>
    <h1>Controller : <?=$context->controller_name?></h1>
    <h1>Method: <?=$context->method?></h1>
    <h1>Paramter: <?=$context->request->get['id']?></h1>
    <a href="/<?=LANG.'/'.$context->controller_path."/all"?>">View List</a>
 
</center>

<?if(!$request->isAjax())include(PATH.'templates/footer.php');?>
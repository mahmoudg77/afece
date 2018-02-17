<?if(!$request->isAjax())include(PATH.'templates/header.php');?>

<?foreach($data as $key=>$row){
   ?>
   <a href="<?=actionLink('index',['group'=>$row->system_group])?>"><?=$row->system_group?></a> | 
   
   <?

}

?>
 

<?if(!$request->isAjax())include(PATH.'templates/footer.php');?>
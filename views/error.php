<?include(PATH.'templates/header.php');?>

 
    <h2>Error: <?=$message?></h2>
    <h3>Trace :</h3>
    <?foreach($trace as $t){ ?>
        <p><?=$t['file']?> - Line(<?=$t['line']?>) - Class: <?=$t['class']?></p>
    <?}?>
 

<?include(PATH.'templates/footer.php');?>

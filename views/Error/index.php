<?include(PATH.'templates/header.php');?>
<div class="alert alert-danger"> 
<strong>Sorry; </strong> <?=$ErrorNumber?> 
<?switch($ErrorNumber){
	case 404:
		echo "File not found";
		break;
	case 403:
		echo "Forbed file or directory";
		break;
	case 401:
		echo "Not authorized";
		break;
    default:
       echo $ErrorMessage;
        break;
}?>
 </div>
<?include(PATH.'templates/footer.php');?>
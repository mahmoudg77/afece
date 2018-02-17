<html>
    <head>
          <meta charset="utf-8">
                  <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script> 
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
       
    </head>
    <body>
        
<div class="row">
    <div class="container">
    <h1 class="col col-xs-6 ">Header</h1>
    <?if($context->user){?>
   	 <div class="col col-xs-4 ">User : <?=$context->user->name?> (<a href="/<?=LANG?>/auth.Login/logout">Logout</a>)<br/>Date : <?=Date("Y-m-d")?></div>
    <?}?>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
     <div class="container">
    <div class="col col-xs-12">
        <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/<?=LANG."/"?>">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

<?
foreach (glob(PATH."controller/*.php") as $filename)
{
    $ctr=str_replace("/",".",str_replace(PATH.'controller/',"",str_replace('.php','',$filename)));
    if(in_array($ctr,['BaseController','home'])) continue;
?>
   <li> <a href="/<?=LANG?>/<?=$ctr?>"><?=$ctr?></a> </li>
<?
}
 ?>
   <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Security <span class="caret"></span></a>
          <ul class="dropdown-menu">
 <?
foreach (glob(PATH."framework/controller/auth/*.php") as $filename)
{
    $ctr=str_replace("/",".",str_replace(PATH.'framework/controller/',"",str_replace('.php','',$filename)));
?>
    <li><a href="/<?=LANG?>/<?=$ctr?>"><?=str_replace("auth.","",$ctr)?></a></li> 
<?
}
?>
 </ul>
</li>
</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
</div>
</div>

<hr/>
<div class="row">
     <div class="container">
    <div class="col col-xs-12 table-responsive">
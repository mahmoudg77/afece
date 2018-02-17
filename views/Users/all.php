<?if(!$request->isAjax())include(PATH.'templates/header.php');?>

<div class="col-ld-6 pull-left">
    <h2> </h2>
</div>
<div class="col-ld-6 pull-right" style="padding: 10 0px;">
    <a class="btn btn-primary btn-md open-modal" href="<?=actionLink('add')?>">Create New</a>
</div>


<table class="table data-table">
<thead>
    <tr>
        <th>Profile</th>
        <th>Groups</th>
        <th>Name</th>
        <th>Email/Username</th>
        <th>View</th>
        <th>Edit</th>
       
        <th>Delete</th>
    </tr>
</thead>


<?foreach($data as $key=>$row){
    ?><tr>
        <td><?$row->DrawField('accid')?></td>
          <td>
              <?$row->DrawField('groups')?>
          </td>
          <td>
              <?$row->DrawField('name')?>
          </td>
          <td>
              <?$row->DrawField('email')?>
          </td>
          <td>
              <a class="btn btn-primary open-modal" href="<?=actionLink('item','',['id'=>$row->{$row->col_pk}])?>">View</a>
          </td>
        <td>
            <a class="btn btn-default open-modal"  href="<?=actionLink('edit','',['id'=>$row->{$row->col_pk}])?>">Edit</a>
        </td>
        
         <td>
        <?if(!$row->is_deleted){?>
           <form action="<?=actionLink('delete')?>" method="post" class="ajax-form">
             <?=Framework\Request::CSRF()?>
               <input type="hidden" name="<?=$row->col_pk?>" value="<?=$row->{$row->col_pk}?>" />
               <input type="submit" class="btn btn-danger" value="Delete"/>
           </form>
          <?}?>
           <?if($row->is_deleted){?>
            <form action="<?=actionLink('restore')?>" method="post">
              <?=Framework\Request::CSRF()?>
               <input type="hidden" name="<?=$row->col_pk?>" value="<?=$row->{$row->col_pk}?>" />
               <input type="submit" class="btn btn-info"  value="Restore"/>
           </form>
           <form action="<?=actionLink('destroy')?>" method="post">
             <?=Framework\Request::CSRF()?>
               <input type="hidden" name="<?=$row->col_pk?>" value="<?=$row->{$row->col_pk}?>" />
               <input type="submit" class="btn btn-danger" value="Delete forever"/>
           </form>
           <?}?>

        </td>


    </tr>

    <?

}

?>
</table>

<?if(!$request->isAjax())include(PATH.'templates/footer.php');?>
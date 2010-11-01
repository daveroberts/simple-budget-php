<form method="post" action="">
<input type="hidden" name="delete_id" value="<?=$account->id?>" />
<div><?=$account->name?> with <?=count($account->entries)?> entries</div>
<input type="submit" name="delete" value="Delete this account" />
</form>
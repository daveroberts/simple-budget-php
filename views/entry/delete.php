<form method="post" action="">
<input type="hidden" name="delete_id" value="<?=$entry->id?>" />
<div><?= PhpRender::render('entry/entryview', "entry", $entry) ?></div>
<input type="submit" name="delete" value="Delete this entry" />
</form>
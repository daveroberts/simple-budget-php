<? $f = new \HappyPuppy\form($entry); ?>
<?= $f->start("update") ?>
<div><?= $f->hidden("id", $entry->id) ?></div>
<div><?= PhpRender::render('entry/entry', "entry", $entry) ?></div>
<p><input type="submit" value="Update entry" /></p>
<?= $f->end() ?>
<?=link_to("Delete", "/entry/delete/".$entry->id, array("onclick"=>js_delete_confirm("Are you sure you want to delete this entry?", $entry->id)))?>
<div><?=link_to("Back to Cash Flow", "/account/cashflow/".$entry->bank_account->id)?></div>